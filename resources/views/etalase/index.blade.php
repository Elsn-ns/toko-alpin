@extends('layouts.app')

@section('content')
<div class="space-y-16 py-4">
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
        <div class="max-w-xl">
            <h1 class="text-3xl md:text-5xl font-black tracking-tight text-slate-900 leading-tight">
                Etalase <span class="text-indigo-600">Produk</span>
            </h1>
        </div>

        <form action="{{ route('etalase.index') }}" method="GET" class="w-full md:w-[450px] relative group">
            <div class="relative flex items-center">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari produk..." 
                       class="input-modern !py-4 md:!py-5 !pl-16 md:!pl-20 pr-12 md:pr-16 !rounded-[28px] md:!rounded-3xl shadow-xl shadow-slate-200/40 group-focus-within:shadow-indigo-600/10 transition-all duration-500">
                
                <div class="absolute left-5 md:left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-500">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-x-8 md:gap-y-12">
        @forelse($products as $product)
            <div class="group relative flex flex-col bg-white rounded-[32px] md:rounded-[40px] p-3 md:p-4 transition-premium hover:-translate-y-2 border border-slate-100/50" style="box-shadow: var(--shadow-soft); hover:box-shadow: var(--shadow-hover);">
                <!-- Image Wrapper -->
                <div class="aspect-[4/5] rounded-[24px] md:rounded-[32px] overflow-hidden bg-slate-50/50 group-hover:bg-slate-50 transition-colors duration-500 relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                             <svg class="w-12 h-12 md:w-16 md:h-16 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <!-- Category Badge (Refined Glassmorphism) -->
                    <div class="absolute top-3 left-3 md:top-4 md:left-4 z-10">
                        <span class="px-2.5 py-1.5 md:px-4 md:py-2 bg-white/60 backdrop-blur-xl border border-white/50 rounded-xl md:rounded-2xl text-[8px] md:text-[10px] font-black uppercase tracking-wider text-slate-800 shadow-sm">
                            {{ $product->category->name ?? 'Collection' }}
                        </span>
                    </div>

                    <!-- Stock Status (Bottom Right) -->
                    <div class="absolute bottom-3 right-3 md:bottom-4 md:right-4 z-10">
                        @if($product->stock > 10)
                            <div class="flex items-center gap-1 px-2 py-1 md:gap-1.5 md:px-3 md:py-1.5 bg-emerald-50/80 backdrop-blur-xl rounded-lg md:rounded-xl border border-emerald-100 shadow-sm">
                                <span class="w-1 h-1 md:w-1.5 md:h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[7px] md:text-[9px] font-black text-emerald-600 uppercase tracking-widest">Tersedia</span>
                            </div>
                        @elseif($product->stock > 0)
                            <div class="flex items-center gap-1 px-2 py-1 md:gap-1.5 md:px-3 md:py-1.5 bg-amber-50/80 backdrop-blur-xl rounded-lg md:rounded-xl border border-amber-100 shadow-sm">
                                <span class="w-1 h-1 md:w-1.5 md:h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <span class="text-[7px] md:text-[9px] font-black text-amber-600 uppercase tracking-widest">Terbatas</span>
                            </div>
                        @else
                            <div class="flex items-center gap-1 px-2 py-1 md:gap-1.5 md:px-3 md:py-1.5 bg-red-50/80 backdrop-blur-xl rounded-lg md:rounded-xl border border-red-100 shadow-sm">
                                <span class="w-1 h-1 md:w-1.5 md:h-1.5 rounded-full bg-red-500"></span>
                                <span class="text-[7px] md:text-[9px] font-black text-red-600 uppercase tracking-widest">Habis</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Content -->
                <div class="mt-4 md:mt-6 px-1 md:px-3 pb-2 space-y-3 md:space-y-4">
                    <div class="space-y-0.5 md:space-y-1">
                        <h3 class="font-black text-base md:text-xl text-slate-900 group-hover:text-indigo-600 transition-colors tracking-tight leading-tight line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-[8px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->stock }} unit</p>
                    </div>
                    
                    <div class="pt-1 md:pt-2">
                        <div class="flex flex-col">
                            <span class="font-black text-lg md:text-2xl text-slate-900 tracking-tighter leading-none">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            @if($product->price_pack)
                                <div class="mt-1.5 md:mt-2.5 flex items-center gap-1 md:gap-2">
                                    <span class="px-1.5 py-0.5 bg-indigo-50 text-[7px] md:text-[8px] font-black text-indigo-600 rounded-md border border-indigo-100 uppercase tracking-widest">Pack</span>
                                    <span class="text-[8px] md:text-[10px] font-bold text-slate-400">Rp{{ number_format($product->price_pack, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center bg-white border border-slate-200 border-dashed rounded-[40px]">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Produk tidak ditemukan</h3>
                <p class="text-slate-500 mt-2">Ubah filter Anda atau cek kembali nanti.</p>
                @if(request('search'))
                    <a href="{{ route('etalase.index') }}" class="btn-primary mt-6 !px-8">Lihat Semua Produk</a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
