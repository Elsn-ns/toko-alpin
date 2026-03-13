@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-12 py-4">
    <!-- Header / Action Bar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
        <div class="flex items-center gap-6">
            <a href="{{ route('transactions.history') }}" class="w-14 h-14 bg-white hover:bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center transition-all shadow-sm group">
                <svg class="w-6 h-6 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Receipt <span class="text-indigo-600">Verification</span></h1>
                    <span class="badge-modern bg-indigo-50 text-indigo-600 border border-indigo-100">Verified Node</span>
                </div>
                <p class="text-slate-500 mt-1 font-medium italic">Referencing Entity: <span class="font-mono text-slate-900 not-italic font-black">{{ $transaction->transaction_id ?? 'TX-'.str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}</span></p>
            </div>
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
            <a href="{{ route('transactions.print', $transaction) }}" 
               target="_blank" 
               class="btn-primary !py-4 flex-1 md:flex-none flex items-center justify-center gap-3 shadow-indigo-600/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2m8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4m14 0h-2"></path></svg>
                Export PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Details Column -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card overflow-hidden shadow-2xl shadow-slate-200/40 bg-white/70 backdrop-blur-xl border border-white">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Order Manifest</h3>
                    <span class="font-black text-slate-900 text-sm">{{ $transaction->details->count() }} Registered Items</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/30">
                                <th class="px-8 py-5">Product Definition</th>
                                <th class="px-8 py-5 text-center">Volume</th>
                                <th class="px-8 py-5 text-right">Unit Value</th>
                                <th class="px-8 py-5 text-right">Net Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($transaction->details as $detail)
                                <tr class="group hover:bg-slate-50/50 transition-colors duration-500">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-[10px] text-slate-400 border border-slate-200/50 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                                {{ substr($detail->product->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-black text-slate-900 group-hover:text-indigo-600 transition-colors leading-tight">{{ $detail->product->name }}</div>
                                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $detail->product->category->name ?? 'Inventory' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="inline-block px-3 py-1 bg-slate-100 rounded-lg text-xs font-black text-slate-600 border border-slate-200/50">{{ $detail->quantity }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-right font-bold text-slate-500">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="font-black text-slate-900 tracking-tight text-lg">Rp {{ number_format($detail->subtotal ?? ($detail->price * $detail->quantity), 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div class="space-y-10">
            <!-- Payment Recap -->
            <div class="glass-card p-10 space-y-10 border-b-8 border-indigo-600 bg-slate-900 text-white shadow-2xl shadow-indigo-200">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-300/60">Financial Protocol</h3>
                
                <div class="space-y-6">
                    <div class="flex justify-between items-end border-b border-white/5 pb-4">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Gross Total</span>
                        <span class="text-xl font-bold font-mono">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-end border-b border-white/5 pb-4">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Tendered</span>
                        <span class="text-xl font-bold font-mono">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-6 flex flex-col gap-2">
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400">Balance Return</span>
                        <div class="text-4xl font-black tracking-tighter text-white">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Context Info -->
            <div class="glass-card p-10 space-y-8 bg-white border border-slate-200/50">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Meta Information</h3>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-5 group">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all border border-slate-100 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Timestamp</p>
                            <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $transaction->created_at->format('M d, Y • H:i A') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-5 group">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all border border-slate-100 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Operator</p>
                            <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $transaction->user->name ?? 'System Identity' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
