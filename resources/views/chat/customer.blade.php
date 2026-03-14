@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">Obrolan dengan Staf</h1>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></span>
            <span class="text-sm text-slate-400 font-medium">Staf Online</span>
        </div>
    </div>

    <!-- Chat Messages Container -->
    <div class="glass-card shadow-xl shadow-slate-200/40 flex flex-col h-[700px] overflow-hidden border border-white">
        <div id="chatMessages" class="flex-1 overflow-y-auto p-10 space-y-8 bg-slate-50/50 custom-scrollbar">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%] space-y-2">
                        <div class="flex items-center gap-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                            @if($message->sender->isStaff())
                                <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest">{{ $message->sender->name }}</span>
                            @else
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $message->sender_id === auth()->id() ? 'Anda' : 'Pelanggan' }}</span>
                            @endif
                            <span class="text-[9px] font-bold text-slate-300">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                        <div class="px-7 py-5 shadow-sm transition-all duration-300 {{ $message->sender_id === auth()->id() ? 'bg-slate-900 text-white rounded-[32px] rounded-tr-none border border-slate-800' : 'bg-white border border-slate-200 text-slate-700 rounded-[32px] rounded-tl-none' }}">
                            <p class="text-sm font-medium leading-relaxed">{{ $message->body }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center text-center p-20 space-y-6 opacity-40">
                    <div class="w-20 h-20 bg-white rounded-[32px] flex items-center justify-center shadow-sm border border-slate-100">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div class="space-y-2">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Mulai Percakapan</p>
                        <p class="text-sm font-medium text-slate-400 max-w-[250px]">Kami selalu siap membantu Anda kapan pun diperlukan.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Chat Input -->
        <div class="p-10 border-t border-slate-50 bg-white">
            <form id="chatForm" action="{{ route('chat.send') }}" method="POST" class="flex items-center gap-6">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation->id ?? '' }}">
                <div class="flex-1">
                    <input type="text" name="body" required 
                           placeholder="Tulis pesan untuk staf..." 
                           class="input-modern !py-5 !px-8 !rounded-[32px]">
                </div>
                <button type="submit" class="btn-primary !p-6 !rounded-[32px] shadow-indigo-600/30 group">
                    <svg class="w-6 h-6 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('chatMessages').scrollTop = document.getElementById('chatMessages').scrollHeight;
    
    // Quick AJAX handling for instant feel
    document.getElementById('chatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        const input = form.querySelector('input[name="body"]');
        const body = input.value;
        if(!body.trim()) return;

        input.value = '';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                const container = document.getElementById('chatMessages');
                const msgHtml = `
                    <div class="flex justify-end">
                        <div class="max-w-[70%] space-y-2">
                            <div class="flex items-center gap-2 flex-row-reverse">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Anda</span>
                                <span class="text-[9px] font-bold text-slate-300">${data.formatted_date.split(',')[1].trim()}</span>
                            </div>
                            <div class="px-7 py-5 shadow-sm bg-slate-900 text-white rounded-[32px] rounded-tr-none border border-slate-800">
                                <p class="text-sm font-medium leading-relaxed">${data.message.body}</p>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', msgHtml);
                container.scrollTop = container.scrollHeight;
            }
        });
    });
</script>
@endpush
@endsection
