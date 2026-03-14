@extends('layouts.app')

@section('content')
<div x-data="posSystem()" class="flex flex-col lg:flex-row gap-10 min-h-[calc(100vh-12rem)] py-4">
    <!-- Left: Product Selection -->
    <div class="flex-1 space-y-10">
        <!-- POS Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div class="max-w-xl">
                <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-tight">
                    Lakukan<span class="text-indigo-600">Transaksi</span>
                </h1>
                <p class="text-slate-500 mt-2 text-lg font-medium">Pilih atau cari produk untuk memulai transaksi.</p>
            </div>

            <!-- Enhanced Search -->
            <div class="w-full md:w-96 relative group">
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari produk..." 
                       class="input-modern !py-5 !pl-20 pr-16 !rounded-3xl shadow-xl shadow-slate-200/40 group-focus-within:shadow-indigo-600/10 transition-all duration-500">
                <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="relative group h-full">
                    <button 
                        class="w-full h-full glass-card p-6 flex flex-col items-center text-center space-y-4 hover:bg-white hover:-translate-y-1 hover:border-indigo-200 transition-all duration-500 border-b-4 border-slate-100 hover:shadow-2xl hover:shadow-indigo-600/10"
                        :class="{'opacity-40 grayscale': {{ $product->stock }} == 0}"
                        @click="addToCart({ 
                            id: {{ $product->id }}, 
                            name: '{{ $product->name }}', 
                            price: {{ $product->price }}, 
                            price_pack: {{ $product->price_pack ?? 'null' }}, 
                            units_per_pack: {{ $product->units_per_pack ?? 1 }},
                            stock: {{ $product->stock }} 
                        }, 'unit')"
                        x-show="'{{ strtolower($product->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($product->product_code) }}'.includes(search.toLowerCase())"
                        :disabled="{{ $product->stock }} == 0"
                    >
                        <div class="w-20 h-20 bg-slate-50 group-hover:bg-indigo-50 rounded-[28px] flex items-center justify-center text-2xl font-black text-indigo-600 transition-all duration-500 group-hover:rotate-6 shadow-sm overflow-hidden border border-slate-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($product->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="space-y-1">
                            <p class="font-black text-slate-900 group-hover:text-indigo-600 transition-colors truncate w-32 tracking-tight">{{ $product->name }}</p>
                            <div class="flex flex-col gap-0.5">
                                <p class="text-xs font-bold text-slate-400">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                @if($product->price_pack)
                                    <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest">
                                        Pack: Rp {{ number_format($product->price_pack, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="pt-2">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full group-hover:bg-indigo-50 transition-colors" 
                                :class="getStockClass({{ $product->stock }})">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>
                    </button>

                    @if($product->price_pack)
                        <button 
                            @click.stop="addToCart({ 
                                id: {{ $product->id }}, 
                                name: '{{ $product->name }}', 
                                price: {{ $product->price }}, 
                                price_pack: {{ $product->price_pack }}, 
                                units_per_pack: {{ $product->units_per_pack }},
                                stock: {{ $product->stock }} 
                            }, 'pack')"
                            class="absolute top-4 right-4 z-10 bg-indigo-600 text-white text-[9px] font-black px-3 py-2 rounded-xl border border-indigo-400 shadow-lg shadow-indigo-600/20 hover:scale-110 active:scale-95 transition-all opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0"
                            title="Tambah 1 Pack"
                        >
                            + PACK
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right: Sticky Cart Sidebar -->
    <div class="w-full lg:w-[420px] shrink-0">
        <div class="glass-card flex flex-col h-fit lg:max-h-[85vh] sticky top-28 shadow-2xl shadow-slate-200/50 border border-white overflow-hidden bg-white/80 backdrop-blur-2xl">
            <!-- Sidebar Header -->
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Keranjang <span class="text-indigo-600">Aktif</span></h2>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Node Transaksi 01</p>
                </div>
                <button @click="cart = []" class="p-3 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all active:scale-90" title="Kosongkan Keranjang">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6 min-h-[300px]">
                <template x-for="(item, index) in cart" :key="index">
                    <div class="flex items-center gap-5 p-4 bg-slate-50 rounded-[28px] border border-slate-100 hover:bg-white hover:shadow-lg hover:rotate-1 transition-all">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center font-black text-indigo-600 text-lg border border-slate-100 shadow-sm">
                            <span x-text="item.name.substring(0, 1)"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-slate-900 truncate leading-tight" x-text="item.name"></p>
                            <div class="flex items-center gap-2 mt-1">
                                <select x-model="item.unit_type" 
                                        @change="updateItemPrice(index)"
                                        class="text-[9px] font-black uppercase tracking-widest bg-slate-100 border-none rounded-lg px-2 py-1 cursor-pointer focus:ring-0">
                                    <option value="unit">Satuan</option>
                                    <option value="pack" x-show="item.price_pack !== null">Pack</option>
                                </select>
                                <p class="text-xs font-black text-indigo-500 tracking-tight" x-text="'Rp ' + formatNumber(item.display_price)"></p>
                            </div>
                        </div>
                        <div class="flex items-center bg-white rounded-2xl border border-slate-200 p-1 shadow-sm">
                            <button @click="decreaseQty(index)" class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-400 hover:text-red-500 transition-colors font-black">－</button>
                            <span class="w-8 text-center font-black text-slate-900 text-sm" x-text="item.quantity"></span>
                            <button @click="increaseQty(index)" class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-slate-50 text-slate-400 hover:text-indigo-600 transition-colors font-black">＋</button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Checkout Section -->
            <div class="p-8 space-y-8 bg-slate-50/80 border-t border-slate-100 backdrop-blur-xl">
                <div class="flex justify-between items-end">
                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Total Belanja</span>
                    <span class="text-3xl font-black text-slate-900 tracking-tight" x-text="'Rp ' + formatNumber(total)"></span>
                </div>
                
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Uang Diterima</label>
                    <div class="relative group">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-600 font-black text-xl">Rp</div>
                        <input type="number" 
                               x-model="amountPaid" 
                               class="w-full bg-white border border-slate-200 rounded-[28px] pl-16 pr-8 py-5 text-2xl font-black text-slate-900 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all placeholder-slate-200 shadow-sm"
                               placeholder="0">
                    </div>
                </div>

                <div class="flex justify-between items-center px-4 py-3 bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Kembalian</span>
                    <span class="text-xl font-black" :class="change < 0 ? 'text-red-500' : 'text-amber-500'" x-text="'Rp ' + formatNumber(change)"></span>
                </div>

                <form id="checkoutForm" action="{{ route('pos.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount_paid" :value="amountPaid">
                    <template x-for="(item, index) in cart" :key="index">
                        <div>
                            <input type="hidden" :name="'items['+index+'][id]'" :value="item.id">
                            <input type="hidden" :name="'items['+index+'][quantity]'" :value="item.quantity">
                            <input type="hidden" :name="'items['+index+'][unit_type]'" :value="item.unit_type">
                        </div>
                    </template>
                    <button 
                        type="submit" 
                        class="w-full py-5 rounded-[28px] font-black text-xl transition-all transform active:scale-[0.98] shadow-2xl shadow-indigo-600/20"
                        :class="canCheckout ? 'bg-indigo-600 text-white hover:bg-black shadow-slate-900/40' : 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none'"
                        :disabled="!canCheckout"
                    >
                        Proses Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function posSystem() {
        return {
            search: '',
            cart: [],
            amountPaid: 0,
            addToCart(product, unitType = 'unit') {
                let existing = this.cart.find(i => i.id === product.id && i.unit_type === unitType);
                if (existing) {
                    const quantityToDeduct = (unitType === 'pack') ? ((existing.quantity + 1) * product.units_per_pack) : existing.quantity + 1;
                    if (quantityToDeduct <= product.stock) {
                        existing.quantity++;
                    }
                } else {
                    const quantityToDeduct = (unitType === 'pack') ? (1 * product.units_per_pack) : 1;
                    if (quantityToDeduct <= product.stock) {
                        this.cart.push({ 
                            ...product, 
                            quantity: 1, 
                            unit_type: unitType,
                            display_price: (unitType === 'pack' && product.price_pack) ? product.price_pack : product.price 
                        });
                    }
                }
            },
            updateItemPrice(index) {
                const item = this.cart[index];
                item.display_price = (item.unit_type === 'pack' && item.price_pack) ? item.price_pack : item.price;
            },
            increaseQty(index) {
                const item = this.cart[index];
                const quantityToDeduct = (item.unit_type === 'pack') ? ((item.quantity + 1) * item.units_per_pack) : item.quantity + 1;
                
                if (quantityToDeduct <= item.stock) {
                    item.quantity++;
                }
            },
            decreaseQty(index) {
                if (this.cart[index].quantity > 1) {
                    this.cart[index].quantity--;
                } else {
                    this.cart.splice(index, 1);
                }
            },
            get total() {
                return this.cart.reduce((sum, item) => sum + (item.display_price * item.quantity), 0);
            },
            get change() {
                return (this.amountPaid || 0) - this.total;
            },
            get canCheckout() {
                return this.cart.length > 0 && this.amountPaid >= this.total;
            },
            formatNumber(n) {
                return new Intl.NumberFormat('id-ID').format(n || 0);
            },
            getStockClass(stock) {
                if (stock <= 5) return 'text-red-500 font-black';
                if (stock <= 15) return 'text-amber-500';
                return 'text-slate-400';
            }
        }
    }
</script>
@endpush
@endsection
