@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-4 space-y-12">
    <!-- Breadcrumbs / Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-4">
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition-colors">Inventory</a>
                <span>/</span>
                <span class="text-slate-900">Modify Entity</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Update <span class="text-indigo-600">Product</span>
            </h1>
            <p class="text-slate-500 mt-2 text-lg font-medium">Refining details for <span class="text-slate-900 font-bold tracking-tight">{{ $product->name }}</span></p>
        </div>
        <div class="w-16 h-16 rounded-3xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="glass-card overflow-hidden bg-white shadow-2xl shadow-slate-200/40 border border-white/80">
        <div class="p-10 border-b border-slate-50 bg-slate-50/30">
            <h2 class="text-xl font-bold text-slate-900">Entity Modifications</h2>
            <p class="text-slate-500 text-sm mt-1">Update the system records with the latest commercial data.</p>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST" class="p-10 space-y-10">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Product Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" required 
                           class="input-modern" 
                           placeholder="e.g. Premium Coffee Beans">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Classification</label>
                    <div class="relative">
                        <select name="category_id" required class="input-modern appearance-none cursor-pointer">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Market Valuation / Unit (Rp)</label>
                    <div class="relative group">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold group-focus-within:text-indigo-600 transition-colors">Rp</div>
                        <input type="number" name="price" value="{{ $product->price }}" required 
                               class="input-modern !pl-14" 
                               placeholder="0.00">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Wholesale Price / Pack (Rp)</label>
                    <div class="relative group">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold group-focus-within:text-indigo-600 transition-colors">Rp</div>
                        <input type="number" name="price_pack" value="{{ $product->price_pack }}" 
                               class="input-modern !pl-14" 
                               placeholder="Optional">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Units per Pack</label>
                    <input type="number" name="units_per_pack" value="{{ $product->units_per_pack }}" 
                           class="input-modern" 
                           placeholder="e.g. 12">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Live Stock Level (Units)</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required 
                           class="input-modern" 
                           placeholder="0">
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Asset Description</label>
                <textarea name="description" rows="4" 
                          class="input-modern !rounded-3xl" 
                          placeholder="Provide detailed information about this product...">{{ $product->description }}</textarea>
            </div>

            <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="btn-primary !py-5 flex-1 shadow-indigo-600/20 translate-y-0 hover:-translate-y-1 transition-all">
                    Sync Asset Data
                </button>
                <a href="{{ route('products.index') }}" class="px-10 py-5 bg-slate-100 text-slate-500 font-black text-sm uppercase tracking-widest rounded-3xl hover:bg-slate-200 transition-all text-center">
                    Return to Catalog
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
