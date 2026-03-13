@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-12 py-4">
    <!-- Header -->
    <div class="flex items-center justify-between bg-white p-8 rounded-[32px] border border-slate-200/60 shadow-sm">
        <div>
            <h1 class="text-4xl font-black tracking-tight text-slate-900 leading-tight">
                Account <span class="text-indigo-600">Settings</span>
            </h1>
            <p class="text-slate-500 mt-2 text-lg font-medium leading-relaxed">
                Manage your profile information and security.
            </p>
        </div>
        <div class="w-16 h-16 rounded-3xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="glass-card overflow-hidden bg-white shadow-xl shadow-slate-200/40">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Basic Information</h2>
                <p class="text-slate-500 text-sm mt-1">Update your account's display name and contact email.</p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}" class="p-8 space-y-8">
            @csrf
            @method('patch')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="input-modern" placeholder="e.g. Alpin Store Admin">
                    @error('name') <p class="mt-2 text-sm text-red-500 font-bold italic">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="input-modern" placeholder="alpin@example.com">
                    @error('email') <p class="mt-2 text-sm text-red-500 font-bold italic">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
                <button type="submit" class="btn-primary">
                    Update Profile
                </button>

                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-emerald-600 font-black flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Saved successfully
                    </p>
                @endif
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="glass-card overflow-hidden bg-white shadow-xl shadow-slate-200/40 border-l-8 border-indigo-600">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Security & Privacy</h2>
                <p class="text-slate-500 text-sm mt-1">Ensure your account is protected with a strong, complex password.</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 border border-indigo-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="p-8 space-y-8">
            @csrf
            @method('put')

            <div class="max-w-xl space-y-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Current Password</label>
                    <input type="password" name="current_password" required autocomplete="current-password"
                           class="input-modern" placeholder="••••••••">
                    @error('current_password') <p class="mt-2 text-sm text-red-500 font-bold italic">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">New Secure Password</label>
                    <input type="password" name="password" required autocomplete="new-password"
                           class="input-modern" placeholder="Minimum 8 characters">
                    @error('password') <p class="mt-2 text-sm text-red-500 font-bold italic">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2 border-l-2 border-indigo-100 pl-6">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Confirm New Password</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                           class="input-modern" placeholder="Repeat your new password">
                </div>
            </div>

            <div class="flex items-center gap-6 pt-6 border-t border-slate-50">
                <button type="submit" class="btn-primary">
                    Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <p class="text-sm text-emerald-600 font-black flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Security updated successfully
                    </p>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
