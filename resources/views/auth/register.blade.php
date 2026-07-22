@extends('layouts.store')

@section('title', 'Register')

@section('content')
<div class="bg-slate-50 py-16 min-h-[70vh] flex items-center justify-center">
    <div class="max-w-md w-full px-4">
        
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            <div class="bg-slate-900 py-6 px-8 text-center text-white">
                <h1 class="text-2xl font-bold">Create Account</h1>
                <p class="text-slate-400 text-sm mt-1">Join Sri Crackers today</p>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>
                    
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-3.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                        <i data-lucide="user-plus" class="w-5 h-5"></i> Register
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-slate-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-red-600 hover:text-red-700 transition">Login here</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
