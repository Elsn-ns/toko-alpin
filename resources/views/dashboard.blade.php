@extends('layouts.app')

@section('content')
<div class="space-y-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Statistik <span class="text-indigo-600">Toko</span>
            </h1>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('products.create') }}" class="btn-primary flex items-center gap-3 group !py-4 whitespace-nowrap">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Produk
            </a>
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl px-6 py-3 flex items-center gap-3">
                <div class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
                <span class="text-indigo-800 font-bold text-sm tracking-wide uppercase">{{ now()->translatedFormat('l, d M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Revenue Card -->
        <div class="glass-card p-8 group hover:bg-slate-900 transition-all duration-500 border-b-4 border-indigo-500">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3 1.343 3 3-1.343 3-3 3m0-13a9 9 0 110 18 9 9 0 010-18zm0 0V3m0 18v-3"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-indigo-300">Pendapatan</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-hover:text-slate-500">Total Pemasukan</p>
            <p class="text-3xl font-black text-slate-900 group-hover:text-white transition-colors tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>

        <!-- Sales Card -->
        <div class="glass-card p-8 group hover:bg-slate-900 transition-all duration-500 border-b-4 border-emerald-500">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-emerald-300">Penjualan</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-hover:text-slate-500">Total Penjualan</p>
            <p class="text-3xl font-black text-slate-900 group-hover:text-white transition-colors tracking-tight">{{ $totalTransactions }}</p>
        </div>

        <!-- Products Card -->
        <div class="glass-card p-8 group hover:bg-slate-900 transition-all duration-500 border-b-4 border-purple-500">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-purple-300">Produk</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-hover:text-slate-500">Produk Aktif</p>
            <p class="text-3xl font-black text-slate-900 group-hover:text-white transition-colors tracking-tight">{{ $totalProducts }}</p>
        </div>

        <!-- Customers Card -->
        <div class="glass-card p-8 group hover:bg-slate-900 transition-all duration-500 border-b-4 border-amber-500">
            <div class="flex items-center justify-between mb-6">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 group-hover:text-amber-300">Pelanggan</span>
            </div>
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 group-hover:text-slate-500">Total Pelanggan</p>
            <p class="text-3xl font-black text-slate-900 group-hover:text-white transition-colors tracking-tight">{{ $totalCustomers }}</p>
        </div>
    </div>

    <!-- Tables & Alerts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Recent Transactions -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Transaksi <span class="text-indigo-600">Terbaru</span></h2>
                <a href="{{ route('transactions.history') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-2 group">
                    Lihat Semua 
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            
            <div class="glass-card overflow-hidden shadow-xl shadow-slate-200/40">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <th class="px-8 py-5">ID Transaksi</th>
                                <th class="px-8 py-5">Staf/Kasir</th>
                                <th class="px-8 py-5 text-right">Pemasukan</th>
                                <th class="px-8 py-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentTransactions as $transaction)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-6">
                                        <span class="font-mono text-xs font-bold text-slate-500">TX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="px-8 py-6 font-bold text-slate-800">{{ $transaction->user->name ?? 'Kasir (POS)' }}</td>
                                    <td class="px-8 py-6 text-right font-black text-slate-900">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="badge-modern bg-emerald-100 text-emerald-600">Terverifikasi</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Inventory Alerts -->
        <div class="space-y-6">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight items-center flex gap-3">
                Stock <span class="text-red-500/80">Hampir habis</span>
                @if($lowStockProducts->count() > 0)
                    <span class="flex h-3 w-3 rounded-full bg-red-400 animate-ping"></span>
                @endif
            </h2>
            <div class="glass-card p-6 space-y-4 shadow-xl shadow-red-500/5">
                @forelse($lowStockProducts as $product)
                    <div class="flex items-center justify-between p-5 bg-red-50/50 border border-red-100 rounded-[28px] group hover:bg-white hover:shadow-xl transition-all duration-300">
                        <div class="space-y-1">
                            <p class="font-bold text-slate-900 leading-none group-hover:text-indigo-600 transition-colors">{{ $product->name }}</p>
                            <p class="text-[10px] font-black uppercase tracking-widest text-red-400">Stok: <span class="text-sm font-black leading-none whitespace-nowrap">{{ $product->stock_display }}</span></p>
                        </div>
                        <a href="{{ route('products.edit', $product) }}" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                            <svg class="w-5 h-5 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-400 mx-auto mb-4 border border-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Inventori Optimal</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
