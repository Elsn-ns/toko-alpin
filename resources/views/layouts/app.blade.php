<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Toko Alpin') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-slate-50 text-slate-900 selection:bg-indigo-100 selection:text-indigo-700">
    <!-- Navbar -->
    <div x-data="{ mobileMenuOpen: false }" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-7xl">
        <nav class="glass-card px-8 py-4 flex items-center justify-between border-white/40 shadow-2xl shadow-indigo-500/5">
            <div class="flex items-center gap-12">
                <a href="{{ route('etalase.index') }}" class="text-xl font-black tracking-tighter flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white rotate-3 group-hover:rotate-0 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <span>TOKO<span class="text-indigo-600">ALPIN</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('etalase.index') }}" class="{{ request()->routeIs('etalase.*') ? 'nav-link nav-link-active' : 'nav-link' }}">Etalase</a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'nav-link nav-link-active' : 'nav-link' }}">Analistik</a>
                        @endif
                        @if(auth()->user()->isStaff())
                            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'nav-link nav-link-active' : 'nav-link' }}">Inventori</a>
                            <a href="{{ route('pos.index') }}" class="{{ request()->routeIs('pos.*') ? 'nav-link nav-link-active' : 'nav-link' }}">Sistem Kasir</a>
                            <a href="{{ route('transactions.history') }}" class="{{ request()->routeIs('transactions.history') ? 'nav-link nav-link-active' : 'nav-link' }}">Riwayat</a>
                            <a href="{{ route('chat.inbox') }}" class="{{ request()->routeIs('chat.inbox*') ? 'nav-link nav-link-active' : 'nav-link' }}">
                                Kotak Masuk
                                @php $unread = \App\Models\Message::where('sender_id', '!=', auth()->id())->where('is_read', false)->count(); @endphp
                                @if($unread > 0)
                                    <span class="ml-1 w-2 h-2 bg-indigo-500 rounded-full inline-block animate-pulse"></span>
                                @endif
                            </a>
                        @else
                            <a href="{{ route('chat.customer') }}" class="{{ request()->routeIs('chat.customer') ? 'nav-link nav-link-active' : 'nav-link' }}">Bantuan</a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-4">
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-3 bg-slate-100/80 hover:bg-slate-200/80 px-4 py-2 rounded-2xl transition-all border border-slate-200/50">
                            <div class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-xs font-bold font-heading">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-700 hidden lg:inline">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-3 w-56 glass-card border-slate-200/50 overflow-hidden bg-white shadow-2xl">
                            <div class="p-4 border-b border-slate-100">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Jabatan Akun</p>
                                <p class="text-xs font-bold text-indigo-600">
                                    @if(auth()->user()->role === 'admin') Admin
                                    @elseif(auth()->user()->role === 'staff') Staff
                                    @else Pelanggan
                                    @endif
                                </p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-sm font-medium text-slate-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Pengaturan Profil
                                </a>
                            </div>
                            <div class="p-2 border-t border-slate-100 bg-slate-50/50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-red-50 transition text-sm font-bold text-red-500">
                                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        </div>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="btn-primary !py-2.5 !px-5 text-sm">Masuk</a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-10 h-10 flex items-center justify-center bg-slate-100/80 rounded-xl text-slate-600 hover:bg-indigo-600 hover:text-white transition-all">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu (Slide-down) -->
        <div x-show="mobileMenuOpen" 
             @click.away="mobileMenuOpen = false"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden mt-3 glass-card border-slate-200/50 overflow-hidden bg-white/90 backdrop-blur-2xl shadow-2xl p-4">
            <div class="flex flex-col gap-2">
                <a href="{{ route('etalase.index') }}" class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('etalase.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Etalase
                </a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Analistik
                        </a>
                    @endif
                    @if(auth()->user()->isStaff())
                        <a href="{{ route('products.index') }}" class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Inventori
                        </a>
                        <a href="{{ route('pos.index') }}" class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('pos.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 00-2 2z"></path></svg>
                            Sistem Kasir
                        </a>
                        <a href="{{ route('transactions.history') }}" class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('transactions.history') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Riwayat
                        </a>
                        <a href="{{ route('chat.inbox') }}" class="flex items-center justify-between p-4 rounded-2xl {{ request()->routeIs('chat.inbox*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                Kotak Masuk
                            </div>
                            @if($unread > 0)
                                <span class="px-2.5 py-1 bg-indigo-600 text-white text-[10px] rounded-lg">{{ $unread }}</span>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('chat.customer') }}" class="flex items-center gap-3 p-4 rounded-2xl {{ request()->routeIs('chat.customer') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }} font-bold transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Bantuan
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <main class="flex-1 max-w-7xl mx-auto px-6 pt-24 md:pt-32 pb-20">
        <!-- System Alerts -->
        @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 rounded-[28px] flex items-center gap-4 animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="w-10 h-10 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600">Verifikasi Berhasil</p>
                    <p class="text-slate-700 font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-6 bg-red-50 border border-red-100 rounded-[28px] animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-red-500 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-red-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-red-600">Gagal Validasi</p>
                        <p class="text-slate-700 font-bold">Harap selesaikan masalah berikut:</p>
                    </div>
                </div>
                <ul class="space-y-1 ml-14">
                    @foreach($errors->all() as $error)
                        <li class="text-sm font-medium text-red-500">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>



    @include('chat.partials.widget')

    @stack('scripts')
</body>
</html>
