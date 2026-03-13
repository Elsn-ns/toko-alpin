@extends('layouts.app')

@section('content')
<div class="space-y-12 py-4">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-tight">
                Product <span class="text-indigo-600">Inventory</span>
            </h1>
            <p class="text-slate-500 mt-2 text-lg font-medium leading-relaxed">
                Analyze and manage your store's collection, stock levels, and commercial data.
            </p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6 w-full lg:w-auto">
            <form action="{{ route('products.index') }}" method="GET" class="w-full md:w-[400px] relative group">
                <div class="relative flex items-center">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search inventory..." 
                           class="input-modern !py-4 !pl-20 pr-16 shadow-lg shadow-slate-200/30 group-focus-within:shadow-indigo-600/10 transition-all duration-500">
                    
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    @if(request('search'))
                        <a href="{{ route('products.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-slate-100 text-slate-400 hover:text-red-500 transition-all">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>
            </form>

            <a href="{{ route('products.create') }}" class="btn-primary flex items-center gap-3 group whitespace-nowrap !py-4">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add New Product
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="glass-card shadow-xl shadow-slate-200/50 overflow-hidden border border-white/50 bg-white/70 backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-8 py-6">Product Item</th>
                        <th class="px-8 py-6">Classification</th>
                        <th class="px-8 py-6 text-right">Valuation</th>
                        <th class="px-8 py-6 text-center">Availability</th>
                        <th class="px-8 py-6 text-center">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex-shrink-0 flex items-center justify-center font-black text-slate-400 text-xl border border-slate-200/30 group-hover:bg-indigo-600 group-hover:text-white group-hover:rotate-3 transition-all duration-500">
                                        {{ substr($product->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-900 text-lg group-hover:text-indigo-600 transition-colors tracking-tight">{{ $product->name }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SKU: PROD-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="badge-modern bg-slate-100 text-slate-600 border border-slate-200/50">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-lg font-black text-slate-900 tracking-tight">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-xl font-black {{ $product->stock < 10 ? 'text-red-500' : 'text-emerald-500' }}">
                                        {{ $product->stock }}
                                    </span>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-300">Units</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('products.edit', $product) }}" 
                                       class="p-3 bg-white hover:bg-indigo-50 text-slate-400 hover:text-indigo-600 border border-slate-200 rounded-2xl transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Archive this product?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                class="p-3 bg-white hover:bg-red-50 text-slate-400 hover:text-red-500 border border-slate-200 rounded-2xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="max-w-xs mx-auto space-y-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-[20px] flex items-center justify-center mx-auto text-slate-300 border border-slate-100">
                                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800">Empty Catalog</h3>
                                    <span class="text-slate-900">New Product</span>
                                    <p class="text-slate-500 text-sm">Start adding products to your store to enable sales and inventory tracking.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
