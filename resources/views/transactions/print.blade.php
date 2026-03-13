<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page { size: 80mm 200mm; margin: 0; }
        body { font-family: 'Courier New', Courier, monospace; width: 80mm; padding: 10mm; font-size: 12px; line-height: 1.4; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .separator { border-top: 1px dashed #000; margin: 5mm 0; }
        .flex { display: flex; justify-content: space-between; }
        .mt-5 { margin-top: 5mm; }
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <h2 class="bold">TOKO ALPIN</h2>
        <p>Jl. Inpres No. 25, Jakarta<br>HP: 0812-3456-7890</p>
    </div>

    <div class="separator"></div>

    <div class="flex">
        <span>ID: #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
        <span>{{ $transaction->created_at->format('d/m/y H:i') }}</span>
    </div>
    <p>Staff: {{ $transaction->user->name ?? '-' }}</p>

    <div class="separator"></div>

    @foreach($transaction->details as $detail)
        <div class="bold">{{ $detail->product->name }}</div>
        <div class="flex">
            <span>{{ $detail->quantity }} x {{ number_format($detail->price, 0) }}</span>
            <span>{{ number_format($detail->quantity * $detail->price, 0) }}</span>
        </div>
    @endforeach

    <div class="separator"></div>

    <div class="flex bold">
        <span>TOTAL</span>
        <span>{{ number_format($transaction->total_price, 0) }}</span>
    </div>
    <div class="flex">
        <span>Bayar</span>
        <span>{{ number_format($transaction->amount_paid, 0) }}</span>
    </div>
    <div class="flex">
        <span>Kembali</span>
        <span>{{ number_format($transaction->change_amount, 0) }}</span>
    </div>

    <div class="separator"></div>

    <div class="center mt-5">
        <p>Terima Kasih Atas Kunjungan Anda!<br>Barang yang sudah dibeli tidak dapat ditukar.</p>
    </div>
</body>
</html>
