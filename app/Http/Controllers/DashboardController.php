<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_price');
        $totalCustomers = User::where('role', 'customer')->count();

        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<', 10)->get();

        return view('dashboard', compact(
            'totalProducts', 
            'totalTransactions', 
            'totalRevenue', 
            'totalCustomers',
            'recentTransactions',
            'lowStockProducts'
        ));
    }
}
