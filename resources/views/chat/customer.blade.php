@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold">Chat with Staff</h1>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></span>
            <span class="text-sm text-slate-400 font-medium">Staff Online</span>
        </div>
    </div>

    <!-- Chat Messages Container -->
    <div class="glass-card flex flex-col h-[600px] overflow-hidden">
        <div id="chatMessages" class="flex-1 overflow-y-auto p-8 space-y-6 bg-slate-900/40">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%] space-y-1">
                        @if($message->sender->isStaff())
                            <p class="text-[10px] text-slate-400 text-left font-bold">{{ $message->sender->name }}</p>
                        @endif
                        <div class="px-5 py-3 rounded-2xl {{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white/10 text-slate-200 rounded-tl-none' }}">
                            {{ $message->body }}
                        </div>
                        <p class="text-[10px] text-slate-500 {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                             {{ $message->created_at->format('M d, Y g:i A') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <p class="text-lg">Start a conversation with our staff. We are here to help!</p>
                </div>
            @endforelse
        </div>

        <!-- Chat Input -->
        <div class="p-6 bg-white/5 border-t border-white/10">
            <form id="chatForm" action="{{ route('chat.send') }}" method="POST" class="flex gap-4">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation->id ?? '' }}">
                <input type="text" name="body" required placeholder="Type your message here..." class="flex-1 bg-slate-900/50 border border-white/10 rounded-2xl px-6 py-4 focus:ring-indigo-500 focus:border-indigo-500">
                <button type="submit" class="btn-primary px-8 rounded-2xl font-bold">Send</button>
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
                        <div class="max-w-[70%] space-y-1">
                            <div class="px-5 py-3 rounded-2xl bg-indigo-600 text-white rounded-tr-none">
                                ${data.message.body}
                            </div>
                            <p class="text-[10px] text-slate-500 text-right">
                                ${data.formatted_date}
                            </p>
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
