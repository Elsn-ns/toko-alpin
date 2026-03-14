@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center p-6">
    <div class="w-full max-w-lg">
        <div class="glass-card p-12 border border-white shadow-2xl shadow-slate-200/50 bg-white/70 backdrop-blur-2xl rounded-[40px] space-y-10">
            <div class="text-center space-y-4">
                <div class="w-20 h-20 bg-indigo-600 rounded-3xl mx-auto flex items-center justify-center text-white font-black text-3xl shadow-xl shadow-indigo-100 -rotate-3 shrink-0">
                    N
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Pendaftaran <span class="text-indigo-600">Akun</span></h1>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 mt-2">Protokol: Pendaftaran Khusus Gmail</p>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-8">
                @csrf
                
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] pl-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus 
                           class="input-modern !py-5 !px-8 !rounded-[24px]" 
                           placeholder="Nama Lengkap Kasir/Staf">
                    @error('name') <p class="text-red-500 text-[10px] font-bold mt-2 pl-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] pl-1">Alamat Gmail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="input-modern !py-5 !px-8 !rounded-[24px]" 
                           placeholder="identitas@gmail.com">
                    @error('email') <p class="text-red-500 text-[10px] font-bold mt-2 pl-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] pl-1">Kata Sandi</label>
                        <input type="password" name="password" required 
                               class="input-modern !py-5 !px-8 !rounded-[24px]" 
                               placeholder="••••••••">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] pl-1">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" required 
                               class="input-modern !py-5 !px-8 !rounded-[24px]" 
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full !py-5 !rounded-[24px] font-black text-lg shadow-indigo-600/20 group">
                    Daftar Sekarang
                    <svg class="w-5 h-5 inline-block ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 11c0 3.517-2.109 6.541-5.093 7.718L6 21l.718-.583A8.502 8.502 0 0115.5 11c0-4.694-3.806-8.5-8.5-8.5a8.502 8.502 0 00-8.5 8.5c0 1.986.682 3.815 1.834 5.262L.5 21l4.217-1.218A8.468 8.468 0 008.5 21c4.694 0 8.5-3.806 8.5-8.5"></path></svg>
                </button>
            </form>

            <div class="pt-8 border-t border-slate-50 text-center">
                <p class="text-sm font-medium text-slate-400">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-indigo-600 font-black hover:text-indigo-800 transition-colors ml-1">Masuk ke Akun</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
