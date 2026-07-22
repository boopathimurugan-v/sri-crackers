@extends('layouts.customer')

@section('title', 'Add New Address')

@section('customer_content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('customer.addresses.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition shadow-sm">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <h1 class="text-2xl font-bold text-slate-900">Add New Address</h1>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8 max-w-3xl">
    <form action="{{ route('customer.addresses.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                @error('name')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Phone Number *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                @error('phone')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-slate-700 mb-2">Full Address *</label>
                <textarea name="address" required rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">{{ old('address') }}</textarea>
                @error('address')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Town / City *</label>
                <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                @error('city')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">State *</label>
                <input type="text" name="state" value="{{ old('state') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                @error('state')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">PIN Code *</label>
                <input type="text" name="pincode" value="{{ old('pincode') }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                @error('pincode')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Address Type *</label>
                <select name="type" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                    <option value="home" {{ old('type') == 'home' ? 'selected' : '' }}>Home (All day delivery)</option>
                    <option value="work" {{ old('type') == 'work' ? 'selected' : '' }}>Work (Delivery between 10 AM - 5 PM)</option>
                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('type')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="mb-8">
            <label class="flex items-center gap-3 cursor-pointer select-none">
                <input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }} class="w-5 h-5 text-red-600 rounded focus:ring-red-500 border-slate-300">
                <span class="font-bold text-slate-800">Make this my default address</span>
            </label>
        </div>

        <button type="submit" class="bg-slate-900 hover:bg-black text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition flex items-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i> Save Address
        </button>
    </form>
</div>
@endsection
