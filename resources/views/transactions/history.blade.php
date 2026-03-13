@extends('layouts.app')

@section('content')
<div class="space-y-12 py-4">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
        <div class="max-w-xl">
            <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-tight">
                Transaction <span class="text-indigo-600">Archive</span>
            </h1>
            <p class="text-slate-500 mt-2 text-lg font-medium leading-relaxed">
                Review and manage all past sales across your store locations.
            </p>
        </div>

        <!-- Search / Filter -->
        <form action="{{ route('transactions.history') }}" method="GET" class="w-full md:w-96 relative group">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search ID, staff, or date..." 
                   class="input-modern !py-4 !pl-20">
            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @if(request('search'))
                <a href="{{ route('transactions.history') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400 hover:text-red-500 underline">Clear</a>
            @endif
        </form>
    </div>

    <!-- Results Info -->
    @if(request('search'))
        <div class="flex items-center gap-3 py-2 px-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50 w-fit">
            <div class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></div>
            <p class="text-sm font-semibold text-indigo-900">
                Found {{ $transactions->total() }} results for "<span class="text-indigo-600">{{ request('search') }}</span>"
            </p>
        </div>
    @endif

    <!-- Data Table -->
    <div class="glass-card shadow-xl shadow-slate-200/50 overflow-hidden border border-white/50 bg-white/70 backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                        <th class="px-8 py-6">Timestamp</th>
                        <th class="px-8 py-6">Transaction Node</th>
                        <th class="px-8 py-6">Operator</th>
                        <th class="px-8 py-6 text-right">Revenue</th>
                        <th class="px-8 py-6 text-center">Process</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900">{{ $transaction->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs font-semibold text-slate-400">{{ $transaction->created_at->format('H:i A') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="inline-flex items-center gap-3 px-3 py-2 bg-slate-100 rounded-xl border border-slate-200/50 group-hover:bg-indigo-50 group-hover:border-indigo-100 transition-colors">
                                    <div class="w-2 h-2 rounded-full bg-indigo-400"></div>
                                    <span class="font-mono text-xs font-bold text-slate-600 group-hover:text-indigo-600">
                                        {{ $transaction->transaction_id ?? 'TX-'.str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-2xl bg-indigo-600 flex items-center justify-center text-[11px] font-black text-white shadow-lg shadow-indigo-600/20 group-hover:rotate-6 transition-transform">
                                        {{ substr($transaction->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700">{{ $transaction->user->name ?? 'System' }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $transaction->user->role ?? 'Operator' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-lg font-black text-slate-900 tracking-tight">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-4 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('transactions.show', $transaction) }}" 
                                       class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors underline underline-offset-4 decoration-slate-200 hover:decoration-indigo-300">
                                        Verify
                                    </a>
                                    <a href="{{ route('transactions.print', $transaction) }}" 
                                       target="_blank" 
                                       class="p-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200/50 transition-all hover:scale-105 active:scale-95 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2m8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4m14 0h-2"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center">
                                <div class="max-w-xs mx-auto space-y-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-[20px] flex items-center justify-center mx-auto text-slate-300 border border-slate-100">
                                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800">No transactions yet</h3>
                                    <p class="text-slate-500 text-sm">When you process sales periodically, they'll appear here for your records.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="p-8 border-t border-slate-50 bg-slate-50/50">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
