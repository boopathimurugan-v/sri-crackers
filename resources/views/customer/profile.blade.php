@extends('layouts.customer')

@section('title', 'My Profile')

@section('customer_content')
<h1 class="text-2xl font-bold text-slate-900 mb-6">Profile Settings</h1>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 max-w-2xl">
    <form action="{{ route('customer.profile.update') }}" method="POST">
        @csrf
        
        <div class="mb-5">
            <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
            @error('name')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
            @error('email')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="bg-slate-900 hover:bg-black text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i> Save Changes
        </button>
    </form>
</div>

<div class="mt-8 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 max-w-2xl">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Password</h2>
            <p class="text-sm text-slate-500">Manage your password to secure your account.</p>
        </div>
        <a href="{{ route('customer.password') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition text-sm">
            Change Password
        </a>
    </div>
</div>
@endsection
