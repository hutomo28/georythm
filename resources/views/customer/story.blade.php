@extends('customer.layouts.app')

@section('title', 'Our Story - GEORYTHM')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 py-32 flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 to-gray-800 opacity-60"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center mix-blend-overlay opacity-40"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center">
            <span class="text-yellow-500 font-bold tracking-widest uppercase mb-4 block text-sm">Our Philosophy</span>
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-8 leading-tight">
                EXPLORE THE WORLD.<br/>WEAR THE RHYTHM.
            </h1>
            <div class="w-24 h-1 bg-yellow-500 mx-auto"></div>
        </div>
    </div>

    <!-- Story Content -->
    <section class="py-24 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg prose-yellow text-gray-600 leading-relaxed font-light">
                <p class="mb-12 text-2xl font-normal text-gray-900 leading-snug">
                    GEORYTHM is more than just an outdoor apparel store. It is a bridge between the wild and the urban, a curated destination for those who seek technical excellence without compromising on style.
                </p>

                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 uppercase tracking-tight">The Heritage</h2>
                    <p class="mb-6">
                        Born from a passion for global exploration and the rhythmic beat of urban life, GEORYTHM was founded to bring together the world's most trusted outdoor brands under one roof. We believe that every journey—whether it's hiking a remote trail or navigating city streets—deserves gear that is built to last.
                    </p>
                    <p>
                        We have meticulously selected partners like <span class="font-bold text-gray-900">National Geographic</span>, <span class="font-bold text-gray-900">The North Face</span>, <span class="font-bold text-gray-900">Columbia</span>, and <span class="font-bold text-gray-900">Arc'teryx</span> because they share our commitment to innovation, sustainability, and uncompromising quality.
                    </p>
                </div>

                <div class="relative h-96 mb-16 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1473448912268-2022ce9509d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Nature" class="w-full h-full object-cover">
                </div>

                <div class="mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 uppercase tracking-tight">The Name</h2>
                    <p class="mb-6">
                        The name <span class="italic font-bold text-yellow-600">GEORYTHM</span> comes from two core concepts:
                    </p>
                    <ul class="space-y-4 mb-8 list-none pl-0">
                        <li class="flex items-start">
                            <span class="font-bold text-gray-900 mr-2">GEO:</span> Representing the earth, geography, and the boundless spirit of exploration.
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold text-gray-900 mr-2">RHYTHM:</span> Representing the flow of daily life, movement, and the modern lifestyle.
                        </li>
                    </ul>
                    <p>
                        Combined, GEORYTHM represents the balance between function and fashion—gear that moves with you, adapts to your environment, and defines your identity.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gray-900 text-white overflow-hidden text-center">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-8">Join the Exploration.</h2>
            <p class="text-gray-400 mb-12 max-w-xl mx-auto">
                Ready to find your rhythm? Discover our latest collection of premium outdoor and lifestyle jackets.
            </p>
            <a href="{{ route('products.index') }}" class="inline-block bg-yellow-500 text-black px-12 py-5 font-bold uppercase tracking-widest hover:bg-yellow-400 transition-colors">
                Explore Products
            </a>
        </div>
    </section>
@endsection
