<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('pos.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'amount_paid' => 'required|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            $totalPrice = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                $unitType = $item['unit_type'] ?? 'unit';
                $price = ($unitType === 'pack' && $product->price_pack) ? $product->price_pack : $product->price;
                $quantityToDeduct = ($unitType === 'pack') ? ($item['quantity'] * $product->units_per_pack) : $item['quantity'];

                $totalPrice += $price * $item['quantity'];
                
                if ($product->stock < $quantityToDeduct) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }
            }

            $transaction = Transaction::create([
                'transaction_id' => 'TRX-' . strtoupper(\Illuminate\Support\Str::random(10)),
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'amount_paid' => $request->amount_paid,
                'change_amount' => $request->amount_paid - $totalPrice,
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                $unitType = $item['unit_type'] ?? 'unit';
                $price = ($unitType === 'pack' && $product->price_pack) ? $product->price_pack : $product->price;
                $quantityToDeduct = ($unitType === 'pack') ? ($item['quantity'] * $product->units_per_pack) : $item['quantity'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_type' => $unitType,
                    'price' => $price,
                    'subtotal' => $price * $item['quantity'],
                ]);

                $product->decrement('stock', $quantityToDeduct);
            }

            return redirect()->route('transactions.success', $transaction);
        });
    }

    public function history(Request $request)
    {
        $search = $request->input('search');
        
        $transactions = Transaction::with('user')
            ->when($search, function ($query, $search) {
                $query->where('transaction_id', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.history', compact('transactions'));
    }

    public function success(Transaction $transaction)
    {
        return view('transactions.success', compact('transaction'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');
        return view('transactions.show', compact('transaction'));
    }

    public function printInvoice(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');
        return view('transactions.print', compact('transaction'));
    }
}
