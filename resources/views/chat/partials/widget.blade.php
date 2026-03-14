@auth
    <div x-data="chatWidget()" 
         class="fixed bottom-6 right-6 md:bottom-10 md:right-10 z-[100]"
         x-cloak>
        
        <!-- Modern Floating Bubble -->
        <button @click="toggle()" 
                class="w-14 h-14 md:w-16 md:h-16 bg-slate-900 rounded-[22px] md:rounded-[24px] shadow-2xl flex items-center justify-center hover:bg-black transition-all hover:scale-110 active:scale-95 group relative border border-slate-800">
            <svg x-show="!isOpen" class="w-7 h-7 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <svg x-show="isOpen" class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
            </svg>
            
            <!-- Global Counter Badge -->
            <template x-if="unreadCount > 0">
                <span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] font-black h-6 w-6 flex items-center justify-center rounded-full border-4 border-white shadow-lg animate-bounce" x-text="unreadCount"></span>
            </template>
        </button>

        <!-- Premium Chat Window -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-500 transform"
             x-transition:enter-start="opacity-0 translate-y-12 scale-90 rotate-3"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100 rotate-0"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100 rotate-0"
             x-transition:leave-end="opacity-0 translate-y-12 scale-90 rotate-3"
             class="absolute bottom-20 md:bottom-24 right-0 w-[calc(100vw-3rem)] sm:w-[420px] h-[70vh] sm:h-[650px] glass-card shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] flex flex-col overflow-hidden border border-white bg-white/95 backdrop-blur-2xl">
            
            <!-- Window Header (Dynamic) -->
            <div class="p-4 md:p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-4">
                    <template x-if="view === 'list'">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                            </div>
                            <h4 class="font-black text-slate-900 tracking-tight">Inbox Chat</h4>
                        </div>
                    </template>
                    <template x-if="view === 'chat'">
                        <div class="flex items-center gap-3">
                            <button @click="backToList()" class="p-2 hover:bg-slate-200 rounded-lg transition-colors mr-1" x-show="isStaff">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <div class="relative">
                                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg shadow-indigo-100" x-text="activeCustomer.initials"></div>
                                <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-[3px] border-white rounded-full"></div>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 tracking-tight text-sm" x-text="activeCustomer.name"></h4>
                                <p class="text-[9px] font-black uppercase tracking-widest text-emerald-500">Live</p>
                            </div>
                        </div>
                    </template>
                </div>
                <button @click="isOpen = false" class="text-slate-300 hover:text-slate-900 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- List View (Staff Only) -->
            <div x-show="view === 'list'" class="flex-1 overflow-y-auto custom-scrollbar bg-slate-50/30">
                <template x-for="conv in conversations" :key="conv.id">
                    <button @click="openChat(conv)" 
                            class="w-full text-left p-4 md:p-6 border-b border-slate-50 transition-all hover:bg-white flex justify-between items-center group">
                        <div class="flex items-center gap-4 overflow-hidden">
                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 font-black text-sm group-hover:bg-indigo-600 group-hover:text-white transition-all" x-text="conv.initials"></div>
                            <div class="overflow-hidden">
                                <p class="font-black text-slate-900 group-hover:text-indigo-600 transition-colors truncate" x-text="conv.customer_name"></p>
                                <p class="text-[10px] font-medium text-slate-400 truncate mt-0.5" x-text="conv.last_message"></p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2 shrink-0">
                            <span class="text-[8px] font-black text-slate-300 uppercase tracking-widest" x-text="conv.time"></span>
                            <template x-if="conv.unread > 0">
                                <span class="h-4 w-4 bg-indigo-600 text-white text-[8px] font-black rounded-full flex items-center justify-center" x-text="conv.unread"></span>
                            </template>
                        </div>
                    </button>
                </template>
                <template x-if="conversations.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-center p-10 opacity-30">
                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4"></path></svg>
                        <p class="text-[10px] font-black uppercase tracking-widest">No active transmissions</p>
                    </div>
                </template>
            </div>

            <!-- Chat View -->
            <div x-show="view === 'chat'" class="flex-1 flex flex-col min-h-0">
                <div id="widgetMessages" class="flex-1 overflow-y-auto p-5 md:p-8 space-y-4 md:space-y-6 bg-slate-50/30 custom-scrollbar">
                    <template x-for="msg in currentMessages" :key="msg.id">
                        <div class="flex" :class="msg.is_staff ? 'justify-end' : 'justify-start'">
                            <div class="max-w-[85%] space-y-1.5">
                                <div class="flex items-center gap-2" :class="msg.is_staff ? 'flex-row-reverse' : ''">
                                     <span class="text-[8px] font-black uppercase tracking-widest" 
                                           :class="msg.is_staff ? 'text-indigo-400' : 'text-slate-400'"
                                           x-text="msg.is_staff ? 'Staff' : 'Client'"></span>
                                     <span class="text-[8px] font-bold text-slate-300" x-text="msg.time"></span>
                                </div>
                                <div class="px-5 py-3.5 transition-all duration-300" 
                                     :class="msg.is_staff ? 'bg-slate-900 text-white rounded-[24px] rounded-tr-none border border-slate-800' : 'bg-white border border-slate-100 text-slate-700 rounded-[24px] rounded-tl-none'">
                                    <p class="text-sm font-medium leading-relaxed" x-text="msg.body"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="currentMessages.length === 0">
                        <div class="h-full flex flex-col items-center justify-center text-center p-10 opacity-20">
                            <h5 class="text-xs font-black uppercase tracking-[0.2em]">Transmission Start</h5>
                        </div>
                    </template>
                </div>

                <!-- Input Interface -->
                <div class="p-4 md:p-6 bg-white border-t border-slate-50">
                    <form @submit.prevent="sendMessage()" class="flex gap-3">
                        <div class="flex-1 relative">
                            <textarea x-model="newMessage" 
                                      @keydown.enter.prevent="sendMessage()"
                                      rows="1"
                                      placeholder="Transmit..." 
                                      class="input-modern !rounded-xl !py-4 !px-6 !text-sm !h-auto !min-h-0 resize-none max-h-24 overflow-y-auto"
                                      oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 96) + 'px'"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-white transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50 group"
                                :disabled="isLoading || !newMessage.trim()">
                            <svg class="w-5 h-5 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function chatWidget() {
            return {
                isOpen: false,
                isStaff: {{ auth()->user()->isStaff() ? 'true' : 'false' }},
                view: '{{ auth()->user()->isStaff() ? 'list' : 'chat' }}',
                conversations: @json($conversations ?? []),
                currentMessages: @json($messages ?? []),
                activeConversationId: {{ $conversation?->id ?? 'null' }},
                activeCustomer: {
                    name: '{{ $conversation?->customer?->name ?? '' }}',
                    initials: '{{ substr($conversation?->customer?->name ?? 'G', 0, 1) }}'
                },
                unreadCount: {{ $unread ?? 0 }},
                newMessage: '',
                isLoading: false,
                pollInterval: null,

                init() {
                    if (this.isStaff) {
                        this.conversations = this.conversations.map(c => ({
                            id: c.id,
                            customer_name: c.customer.name,
                            initials: c.customer.name.substring(0, 1),
                            last_message: c.messages[0]?.body || 'Start conversation...',
                            time: new Date(c.last_message_at).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' }),
                            unread: c.messages.filter(m => !m.is_read && m.sender_id != {{ auth()->id() }}).length
                        }));
                        this.unreadCount = this.conversations.reduce((acc, c) => acc + c.unread, 0);
                    }

                    // Start background polling every 5 seconds
                    this.pollInterval = setInterval(() => this.fetchUpdates(), 5000);
                },

                fetchUpdates() {
                    // 1. Always update global unread count and current chat if open
                    if (this.activeConversationId) {
                        fetch(`/api/messages/${this.activeConversationId}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    const oldLen = this.currentMessages.length;
                                    this.currentMessages = data.messages;
                                    this.unreadCount = data.unreadCount;
                                    
                                    if (this.currentMessages.length > oldLen && this.isOpen) {
                                        this.scrollToBottom();
                                    }
                                }
                            });
                    }

                    // 2. If staff is in list view, update the whole list
                    if (this.isStaff) {
                        fetch('{{ route('chat.api.conversations') }}')
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    this.conversations = data.conversations;
                                    this.unreadCount = data.unreadTotal;
                                }
                            });
                    }
                },

                toggle() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen && this.view === 'chat') {
                        this.scrollToBottom();
                    }
                },

                backToList() {
                    this.view = 'list';
                },

                openChat(conv) {
                    this.isLoading = true;
                    this.activeConversationId = conv.id;
                    this.activeCustomer = {
                        name: conv.customer_name,
                        initials: conv.initials
                    };

                    fetch(`/api/messages/${conv.id}`)
                        .then(res => res.json())
                        .then(data => {
                            this.currentMessages = data.messages;
                            this.view = 'chat';
                            this.scrollToBottom();
                            
                            // Update local unread count
                            const c = this.conversations.find(x => x.id === conv.id);
                            if (c) {
                                this.unreadCount -= c.unread;
                                c.unread = 0;
                            }
                        })
                        .finally(() => this.isLoading = false);
                },

                sendMessage() {
                    if (!this.newMessage.trim() || this.isLoading) return;

                    this.isLoading = true;
                    const body = this.newMessage;
                    const convId = this.activeConversationId;

                    fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        body: JSON.stringify({
                            body: body,
                            conversation_id: convId
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const newMsg = {
                                id: data.message.id,
                                body: data.message.body,
                                is_staff: {{ auth()->user()->isStaff() ? 'true' : 'false' }},
                                time: new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })
                            };
                            this.currentMessages.push(newMsg);
                            this.newMessage = '';
                            this.scrollToBottom();

                            // Update list view info if staff
                            if (this.isStaff) {
                                const c = this.conversations.find(x => x.id === convId);
                                if (c) {
                                    c.last_message = body;
                                    c.time = newMsg.time;
                                }
                            }
                        }
                    })
                    .finally(() => this.isLoading = false);
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('widgetMessages');
                        if (container) container.scrollTop = container.scrollHeight;
                    });
                }
            }
        }
    </script>
@endauth
