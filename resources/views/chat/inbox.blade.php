@extends('layouts.app')

@section('content')
<div class="space-y-12 py-4">
    <!-- Header -->
    <div class="max-w-2xl">
        <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-tight">
            Kotak <span class="text-indigo-600">Masuk</span>
        </h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-10 h-[750px] lg:h-[800px]">
        <!-- Left: Conversation Selection -->
        <div class="w-full lg:w-[400px] shrink-0 h-full">
            <div class="glass-card flex flex-col h-full border border-white shadow-xl shadow-slate-200/50 overflow-hidden bg-white/70 backdrop-blur-xl">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Pesan Aktif</h3>
                    <span class="badge-modern bg-indigo-50 text-indigo-600 border border-indigo-100">{{ $conversations->count() }} Percakapan</span>
                </div>
                
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    @forelse($conversations as $conv)
                        <a href="{{ route('chat.inbox.show', $conv) }}" 
                           class="block p-8 border-b border-slate-50 transition-all duration-300 group {{ isset($conversation) && $conversation->id === $conv->id ? 'bg-indigo-50 border-l-4 border-l-indigo-600 shadow-inner' : 'hover:bg-slate-50' }}">
                            <div class="flex justify-between items-start">
                                <div class="space-y-2 max-w-[200px]">
                                    <p class="font-black text-slate-900 group-hover:text-indigo-600 transition-colors tracking-tight truncate">{{ $conv->customer->name ?? 'Pengguna Tamu' }}</p>
                                    <p class="text-xs font-medium text-slate-400 truncate">{{ $conv->messages->first()->body ?? 'Memulai percakapan...' }}</p>
                                </div>
                                <div class="text-right flex flex-col items-end gap-2">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ $conv->updated_at->diffForHumans(null, true) }}</span>
                                    @php $unread = $conv->messages()->where('sender_id', '!=', auth()->id())->where('is_read', false)->count(); @endphp
                                    @if($unread > 0)
                                        <span class="flex h-5 w-5 items-center justify-center bg-indigo-600 text-white text-[9px] font-black rounded-full shadow-lg shadow-indigo-200 animate-pulse">{{ $unread }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full p-10 text-center space-y-4 opacity-30">
                            <div class="w-16 h-16 bg-slate-100 rounded-[24px] flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4"></path></svg>
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Tidak ada percakapan aktif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Chat Window -->
        <div class="flex-1 min-w-0 h-full">
            <div class="glass-card flex flex-col h-full border border-white shadow-2xl shadow-slate-200/40 overflow-hidden bg-white w-full">
                @if(isset($conversation))
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-100 rotate-3">
                                {{ substr($conversation->customer->name ?? 'G', 0, 1) }}
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-slate-900 tracking-tight">{{ $conversation->customer->name ?? 'Pengguna Tamu' }}</h2>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em]">Online</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="p-3 bg-white border border-slate-100 rounded-2xl text-slate-300 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div id="chatMessages" class="flex-1 overflow-y-auto p-10 space-y-8 custom-scrollbar bg-slate-50/30">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender->isStaff() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[70%] space-y-2">
                                    <div class="flex items-center gap-2 {{ $message->sender->isStaff() ? 'flex-row-reverse' : '' }}">
                                        @if($message->sender->isStaff())
                                            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">{{ $message->sender->name }}</span>
                                        @else
                                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Client</span>
                                        @endif
                                        <span class="text-[9px] font-bold text-slate-300">{{ $message->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="px-7 py-5 shadow-sm transition-all duration-300 {{ $message->sender->isStaff() ? 'bg-slate-900 text-white rounded-[32px] rounded-tr-none border border-slate-800' : 'bg-white border border-slate-200 text-slate-700 rounded-[32px] rounded-tl-none' }}">
                                        <p class="text-sm font-medium leading-relaxed">{{ $message->body }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-10 border-t border-slate-50 bg-white">
                        <form action="{{ route('chat.send') }}" method="POST" class="flex items-end gap-6">
                            @csrf
                            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                            <div class="flex-1">
                                <textarea name="body" required rows="1" 
                                          placeholder="Ketik balasan..." 
                                          class="input-modern !py-5 !px-8 !rounded-[32px] resize-none overflow-y-auto max-h-32 transition-all duration-200"
                                          oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 128) + 'px'"></textarea>
                            </div>
                            <button type="submit" class="btn-primary !p-6 !rounded-[32px] shadow-indigo-600/30 group">
                                <svg class="w-6 h-6 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-center p-10 space-y-6 opacity-40">
                        <div class="w-24 h-24 bg-slate-50 rounded-[40px] flex items-center justify-center">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Pilih Percakapan</h3>
                            <p class="text-sm font-medium text-slate-500">Pilih percakapan untuk mulai berinteraksi dengan pelanggan.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(isset($conversation))
@push('scripts')
<script>
    const container = document.getElementById('chatMessages');
    if (container) container.scrollTop = container.scrollHeight;
</script>
@endpush
@endif
@endsection
