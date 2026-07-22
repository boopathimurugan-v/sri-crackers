@extends('layouts.store')

@section('title', 'Contact Us')

@section('content')
<div class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-4">Get in Touch</h1>
            <p class="text-lg text-slate-600">Have questions about our crackers, combo offers, or bulk orders? We're here to help you light up your celebrations!</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            {!! '<!-- Contact Info -->' !!}
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="map-pin" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Our Store</h3>
                    <p class="text-slate-600 leading-relaxed">
                        123 Crackers Street,<br>
                        Sivakasi, Tamil Nadu<br>
                        626123, India
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="phone" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Call Us</h3>
                    <p class="text-slate-600 mb-1">+91 98765 43210</p>
                    <p class="text-slate-600">+91 98765 43211</p>
                    <p class="text-sm text-slate-400 mt-2">Mon - Sat, 9am - 8pm</p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="mail" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Email Us</h3>
                    <p class="text-slate-600">support@sricrackers.com</p>
                    <p class="text-slate-600">sales@sricrackers.com</p>
                </div>
            </div>

            {!! '<!-- Contact Form -->' !!}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
                    <div class="p-8 sm:p-12">
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Send us a Message</h2>
                        
                        @if(session('success'))
                            <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3">
                                <i data-lucide="check-circle" class="w-6 h-6 shrink-0"></i>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Your Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                                    @error('name')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                                    @error('email')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Subject *</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                                @error('subject')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-8">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Message *</label>
                                <textarea name="message" required rows="5" class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition resize-none">{{ old('message') }}</textarea>
                                @error('message')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
                            </div>

                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-10 rounded-xl shadow-md transition flex items-center gap-2">
                                <i data-lucide="send" class="w-5 h-5"></i> Send Message
                            </button>
                        </form>
                    </div>
                    
                    <div class="bg-slate-100 h-64 w-full">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62908.7750867808!2d77.75549007421876!3d9.444391218559132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b06cee43b822d5d%3A0x8ce12e9dcdaa2a2c!2sSivakasi%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
