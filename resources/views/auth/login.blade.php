@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center p-6">
    <div class="w-full max-w-lg">
        <div class="glass-card p-12 border border-white shadow-2xl shadow-slate-200/50 bg-white/70 backdrop-blur-2xl rounded-[40px] space-y-10">
            <div class="text-center space-y-4">
                <div class="w-20 h-20 bg-indigo-600 rounded-3xl mx-auto flex items-center justify-center text-white font-black text-3xl shadow-xl shadow-indigo-100 rotate-6 shrink-0">
                    A
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Verifikasi <span class="text-indigo-600">Identitas</span></h1>
                    <p class="text-slate-500 mt-2 font-medium">Masuk ke sistem toko Anda</p>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-8">
                @csrf
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] pl-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="input-modern !py-5 !px-8 !rounded-[24px]" 
                           placeholder="operator@system.io">
                    @error('email') <p class="text-red-500 text-[10px] font-bold mt-2 pl-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center pl-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] font-black text-indigo-500 uppercase tracking-widest hover:text-indigo-700 transition-colors">Lupa Kata Sandi?</a>
                    </div>
                    <input type="password" name="password" required 
                           class="input-modern !py-5 !px-8 !rounded-[24px]"
                           placeholder="••••••••••••">
                    @error('password') <p class="text-red-500 text-[10px] font-bold mt-2 pl-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded-lg border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                        <span class="ml-3 text-xs font-bold text-slate-500 group-hover:text-slate-900 transition-colors">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full !py-5 !rounded-[24px] font-black text-lg shadow-indigo-600/20 group">
                    Masuk ke Sistem
                    <svg class="w-5 h-5 inline-block ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7-7 7"></path></svg>
                </button>
            </form>

            <div class="pt-8 border-t border-slate-50 text-center">
                <p class="text-sm font-medium text-slate-400">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-black hover:text-indigo-800 transition-colors ml-1">Buat Akun Baru</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
