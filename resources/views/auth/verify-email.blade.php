@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="glass-card w-full max-w-lg p-12 text-center space-y-8">
        <div class="w-24 h-24 bg-indigo-500/20 rounded-full flex items-center justify-center mx-auto border border-indigo-500/30">
            <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        
        <div>
            <h1 class="text-3xl font-bold">Check your Gmail!</h1>
            <p class="text-slate-400 mt-4 leading-relaxed">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? 
                If you didn't receive the email, we will gladly send you another.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-emerald-500/10 border border-emerald-500/20 py-3 rounded-xl text-emerald-400 font-medium">
                A new verification link has been sent to your Gmail!
            </div>
        @endif

        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary px-8 py-3 rounded-xl font-bold">Resend Verification Email</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white/5 hover:bg-white/10 px-8 py-3 rounded-xl border border-white/10 transition">Log Out</button>
            </form>
        </div>
    </div>
</div>
@endsection
