@extends('layouts.customer')

@section('title', 'Change Password')

@section('customer_content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('customer.profile') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition shadow-sm">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Change Password</h1>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 max-w-2xl">
    <form action="{{ route('customer.password.update') }}" method="POST">
        @csrf
        
        <div class="mb-5">
            <label class="block text-sm font-bold text-slate-700 mb-2">Current Password</label>
            <input type="password" name="current_password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
            @error('current_password')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-bold text-slate-700 mb-2">New Password</label>
            <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
            @error('password')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-slate-700 mb-2">Confirm New Password</label>
            <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
        </div>

        <button type="submit" class="bg-slate-900 hover:bg-black text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition flex items-center gap-2">
            <i data-lucide="key" class="w-5 h-5"></i> Update Password
        </button>
    </form>
</div>
@endsection
