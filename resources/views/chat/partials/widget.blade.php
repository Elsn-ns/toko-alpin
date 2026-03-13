@auth
    @if(auth()->user()->role === 'customer')
        <div x-data="chatWidget()" 
             class="fixed bottom-10 right-10 z-[100]"
             x-cloak>
            
            <!-- Modern Floating Bubble -->
            <button @click="toggle()" 
                    class="w-16 h-16 bg-slate-900 rounded-[24px] shadow-2xl flex items-center justify-center hover:bg-black transition-all hover:scale-110 active:scale-95 group relative border border-slate-800">
                <svg x-show="!isOpen" class="w-7 h-7 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <svg x-show="isOpen" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
                
                <!-- Counter Badge -->
                @php 
                    $unread = $conversation ? $conversation->messages()->where('sender_id', '!=', auth()->id())->where('is_read', false)->count() : 0;
                @endphp
                @if($unread > 0)
                    <span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] font-black h-6 w-6 flex items-center justify-center rounded-full border-4 border-white shadow-lg animate-bounce">
                        {{ $unread }}
                    </span>
                @endif
            </button>

            <!-- Premium Chat Window -->
            <div x-show="isOpen" 
                 x-transition:enter="transition ease-out duration-500 transform"
                 x-transition:enter-start="opacity-0 translate-y-12 scale-90 rotate-3"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100 rotate-0"
                 x-transition:leave="transition ease-in duration-300 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100 rotate-0"
                 x-transition:leave-end="opacity-0 translate-y-12 scale-90 rotate-3"
                 class="absolute bottom-24 right-0 w-[420px] h-[600px] glass-card shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] flex flex-col overflow-hidden border border-white bg-white/95 backdrop-blur-2xl">
                
                <!-- Window Header -->
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-indigo-100">SA</div>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-4 border-white rounded-full"></div>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 tracking-tight">Store Assistant</h4>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500">Live Protocol Active</p>
                        </div>
                    </div>
                    <button @click="isOpen = false" class="text-slate-300 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Messages Stream -->
                <div id="widgetMessages" class="flex-1 overflow-y-auto p-8 space-y-6 bg-slate-50/30 custom-scrollbar">
                    @if($conversation)
                        @foreach($messages as $msg)
                            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[80%] space-y-1.5">
                                    <div class="flex items-center gap-2 {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                                         <span class="text-[9px] font-black {{ $msg->sender_id === auth()->id() ? 'text-indigo-400' : 'text-slate-400' }} uppercase tracking-widest">
                                            {{ $msg->sender_id === auth()->id() ? 'You' : $msg->sender->name }}
                                         </span>
                                    </div>
                                    <div class="px-6 py-4 transition-all duration-300 {{ $msg->sender_id === auth()->id() ? 'bg-slate-900 text-white rounded-[24px] rounded-tr-none border border-slate-800 shadow-md shadow-slate-200' : 'bg-white border border-slate-100 text-slate-700 rounded-[24px] rounded-tl-none shadow-sm' }}">
                                        <p class="text-sm font-medium leading-relaxed">{{ $msg->body }}</p>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-300 {{ $msg->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                        {{ $msg->created_at->format('g:i A') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-center p-10 space-y-6 opacity-40">
                            <div class="w-20 h-20 bg-slate-50 rounded-[32px] flex items-center justify-center border border-slate-100">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div class="space-y-1">
                                <h5 class="text-lg font-black text-slate-900 tracking-tight">System Ready</h5>
                                <p class="text-xs font-medium text-slate-500">Initialize a transmission to connect with our support nodes.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Response Interface -->
                <div class="p-8 bg-white border-t border-slate-50">
                    <form @submit.prevent="sendMessage()" id="widgetChatForm" action="{{ route('chat.send') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $conversation->id ?? '' }}">
                        <div class="flex-1">
                            <input type="text" 
                                   name="body" 
                                   x-model="newMessage"
                                   required 
                                   placeholder="Transmit message..." 
                                   class="input-modern !rounded-2xl !py-4 !px-6 !text-sm">
                        </div>
                        <button type="submit" 
                                class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50 shadow-lg shadow-indigo-100 group"
                                :disabled="isLoading || !newMessage.trim()">
                            <svg class="w-6 h-6 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function chatWidget() {
                return {
                    isOpen: false,
                    newMessage: '',
                    isLoading: false,
                    
                    toggle() {
                        this.isOpen = !this.isOpen;
                        if (this.isOpen) {
                            this.$nextTick(() => {
                                const container = document.getElementById('widgetMessages');
                                container.scrollTop = container.scrollHeight;
                            });
                        }
                    },

                    sendMessage() {
                        if (!this.newMessage.trim() || this.isLoading) return;

                        this.isLoading = true;
                        const form = document.getElementById('widgetChatForm');
                        const formData = new FormData(form);
                        
                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                const container = document.getElementById('widgetMessages');
                                
                                // Remove empty state if present
                                if (container.querySelector('.h-full')) {
                                    container.innerHTML = '';
                                }

                                const msgHtml = `
                                    <div class="flex justify-end">
                                        <div class="max-w-[80%] space-y-1.5">
                                            <div class="flex items-center gap-2 flex-row-reverse">
                                                <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">You</span>
                                            </div>
                                            <div class="px-6 py-4 bg-slate-900 text-white rounded-[24px] rounded-tr-none border border-slate-800 shadow-md shadow-slate-200">
                                                <p class="text-sm font-medium leading-relaxed">${data.message.body}</p>
                                            </div>
                                            <p class="text-[9px] font-bold text-slate-300 text-right">
                                                ${new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })}
                                            </p>
                                        </div>
                                    </div>
                                `;
                                container.insertAdjacentHTML('beforeend', msgHtml);
                                container.scrollTop = container.scrollHeight;
                                this.newMessage = '';
                            }
                        })
                        .finally(() => {
                            this.isLoading = false;
                        });
                    }
                }
            }
        </script>
    @endif
@endauth
