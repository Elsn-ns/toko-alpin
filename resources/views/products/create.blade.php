@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-4 space-y-12">
    <!-- Breadcrumbs / Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-4">
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition-colors">Inventori</a>
                <span>/</span>
                <span class="text-slate-900">Produk Baru</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Tambah <span class="text-indigo-600">Produk</span>
            </h1>
            <p class="text-slate-500 mt-2 text-lg font-medium">Definisikan item produk baru untuk katalog toko Anda.</p>
        </div>
        <div class="w-16 h-16 rounded-3xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        </div>
    </div>

    <!-- Creation Form -->
    <div class="glass-card overflow-hidden bg-white shadow-2xl shadow-slate-200/40 border border-white/80">
        <div class="p-10 border-b border-slate-50 bg-slate-50/30">
            <h2 class="text-xl font-bold text-slate-900">Spesifikasi Item</h2>
            <p class="text-slate-500 text-sm mt-1">Harap berikan detail yang akurat untuk pelacakan inventori.</p>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                               class="input-modern @error('name') border-red-500 bg-red-50/30 @enderror" 
                               placeholder="e.g. Premium Coffee Beans">
                    @error('name') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Kode Produk (SKU)</label>
                    <input type="text" name="product_code" value="{{ old('product_code') }}" required 
                               class="input-modern @error('product_code') border-red-500 bg-red-50/30 @enderror" 
                               placeholder="e.g. PRD-001">
                    @error('product_code') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Klasifikasi</label>
                    <div class="relative">
                        <select name="category_id" required class="input-modern appearance-none cursor-pointer @error('category_id') border-red-500 bg-red-50/30 @enderror">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Harga Jual / Unit (Rp)</label>
                    <div class="relative group">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold group-focus-within:text-indigo-600 transition-colors">Rp</div>
                        <input type="number" name="price" value="{{ old('price') }}" required 
                               class="input-modern !pl-14 @error('price') border-red-500 bg-red-50/30 @enderror" 
                               placeholder="0.00">
                        @error('price') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Harga Grosir / Pack (Rp)</label>
                    <div class="relative group">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold group-focus-within:text-indigo-600 transition-colors">Rp</div>
                        <input type="number" name="price_pack" value="{{ old('price_pack') }}" 
                               class="input-modern !pl-14 @error('price_pack') border-red-500 bg-red-50/30 @enderror" 
                               placeholder="Opsional">
                        @error('price_pack') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Isi per Pack (Qty)</label>
                    <input type="number" name="units_per_pack" value="{{ old('units_per_pack', 1) }}" 
                           class="input-modern @error('units_per_pack') border-red-500 bg-red-50/30 @enderror" 
                           placeholder="e.g. 12">
                    @error('units_per_pack') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Stok Saat Ini (Unit)</label>
                    <input type="number" name="stock" value="{{ old('stock') }}" required 
                           class="input-modern @error('stock') border-red-500 bg-red-50/30 @enderror" 
                           placeholder="0">
                    @error('stock') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Deskripsi Produk (Opsional)</label>
                    <textarea name="description" rows="4" 
                              class="input-modern !rounded-3xl" 
                              placeholder="Berikan informasi detail mengenai produk ini...">{{ old('description') }}</textarea>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Foto Produk</label>
                    <input type="file" name="image" 
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all border border-slate-200 rounded-3xl p-4">
                    <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold">Maks. 2MB (JPG, PNG, WEBP)</p>
                    @error('image') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex flex-col sm:flex-row gap-4">
                <button type="submit" class="btn-primary !py-5 flex-1 shadow-indigo-600/20 translate-y-0 hover:-translate-y-1 transition-all">
                    Simpan Data Produk
                </button>
                <a href="{{ route('products.index') }}" class="px-10 py-5 bg-slate-100 text-slate-500 font-black text-sm uppercase tracking-widest rounded-3xl hover:bg-slate-200 transition-all text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
