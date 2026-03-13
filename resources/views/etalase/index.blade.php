@extends('layouts.app')

@section('content')
<div class="space-y-16 py-4">
    <!-- Hero / Header -->
    <div class="max-w-3xl">
        <h1 class="text-5xl font-black tracking-tight text-slate-900 leading-tight">
            Curated <span class="text-indigo-600">Collection</span>
        </h1>
        <p class="text-slate-500 mt-4 text-xl font-medium leading-relaxed">
            Essential objects for your daily lifestyle, designed for performance and aesthetic.
        </p>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-2 p-1.5 bg-slate-200/50 rounded-2xl border border-slate-200/60 w-full md:w-auto">
            <a href="{{ route('etalase.index') }}" class="px-5 py-2 rounded-xl text-sm font-bold bg-white shadow-sm text-indigo-600 border border-slate-100">All Items</a>
            <button class="px-5 py-2 rounded-xl text-sm font-semibold text-slate-500 hover:text-slate-800 transition">Popular</button>
            <button class="px-5 py-2 rounded-xl text-sm font-semibold text-slate-500 hover:text-slate-800 transition">New Arrival</button>
        </div>

        <form action="{{ route('etalase.index') }}" method="GET" class="w-full md:w-[450px] relative group">
            <div class="relative flex items-center">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search objects..." 
                       class="input-modern !py-5 !pl-20 pr-16 !rounded-3xl shadow-xl shadow-slate-200/40 group-focus-within:shadow-indigo-600/10 transition-all duration-500">
                
                <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <div class="absolute right-4 flex items-center gap-2">
                    @if(request('search'))
                        <a href="{{ route('etalase.index') }}" 
                           class="p-2 rounded-full bg-slate-100 text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all active:scale-90"
                           title="Clear search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                    <button type="submit" class="p-2.5 bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
        @forelse($products as $product)
            <div class="group relative flex flex-col">
                <!-- Image Wrapper -->
                <div class="aspect-[4/5] rounded-[32px] overflow-hidden bg-white border border-slate-200/50 shadow-sm group-hover:shadow-indigo-600/5 group-hover:border-indigo-200 transition-all duration-500 relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                             <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <!-- Category Badge -->
                    <div class="absolute top-5 left-5">
                        <span class="px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest text-slate-900 border border-slate-200/50">
                            {{ $product->category->name ?? 'Essentials' }}
                        </span>
                    </div>

                    <!-- Add Button Overlay -->
                    <div class="absolute inset-0 bg-indigo-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                        <div class="translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <button class="bg-white text-indigo-600 px-6 py-3 rounded-2xl font-bold shadow-2xl flex items-center gap-2 hover:bg-slate-50 active:scale-95 transition-all">
                                <span>Preview</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="mt-6 px-2 space-y-2">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $product->name }}</h3>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-black text-slate-900 text-xl tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest border-l border-slate-200 pl-3">
                            {{ $product->stock }} in stock
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center bg-white border border-slate-200 border-dashed rounded-[40px]">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">No products found</h3>
                <p class="text-slate-500 mt-2">Adjust your filters or check back later.</p>
                @if(request('search'))
                    <a href="{{ route('etalase.index') }}" class="btn-primary mt-6 !px-8">View All Items</a>
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection
