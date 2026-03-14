@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-10 py-10">
    <div class="flex items-center gap-4">
        <a href="{{ route('transactions.history') }}" class="text-slate-400 hover:text-white transition">← Kembali</a>
        <h1 class="text-3xl font-bold">Transaksi Berhasil</h1>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-500/20 to-indigo-500/20 p-12 text-center border-b border-white/10">
            <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-500/40">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-4xl font-black italic">TRANSAKSI SELESAI</h2>
            <p class="text-slate-300 mt-2">ID Transaksi: <span class="text-indigo-400 font-mono">#{{ str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}</span></p>
        </div>

        <div class="p-10 space-y-8">
            <div class="grid grid-cols-2 gap-10">
                <div class="space-y-4">
                    <p class="text-xs font-black uppercase tracking-widest text-slate-500">Ringkasan Penjualan</p>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-medium">Subtotal</span>
                        <span class="font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-medium">Uang Diterima</span>
                        <span class="font-bold">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-white/10">
                        <span class="text-lg font-bold">Kembalian</span>
                        <span class="text-2xl font-black text-amber-400">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('transactions.print', $transaction) }}" target="_blank" class="btn-primary py-4 rounded-2xl font-bold text-center">Cetak Struk</a>
                        <a href="{{ route('pos.index') }}" class="w-full py-4 rounded-2xl border border-white/10 hover:bg-white/5 transition text-center font-bold">Transaksi Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
