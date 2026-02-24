@extends('customer.layouts.app')

@section('title', 'Lookbook - GEORYTHM')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 py-24 flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 to-gray-800 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center mix-blend-overlay opacity-40"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center">
            <span class="text-yellow-500 font-bold tracking-widest uppercase mb-4 block">Seasonal Inspiration</span>
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">25FW LOOKBOOK</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Explore our latest collection through the lens of adventure. Technical excellence meets urban style.
            </p>
        </div>
    </div>

    <!-- Lookbook Grid -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Look 1 -->
                <div class="group">
                    <div class="relative aspect-[4/5] overflow-hidden bg-gray-100 mb-6">
                        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Mountain Expedition" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-500 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <a href="{{ route('products.index') }}" class="bg-white text-black px-6 py-3 font-bold uppercase text-xs tracking-widest hover:bg-yellow-500 transition-colors">Shop this Look</a>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <span class="text-xs font-bold text-yellow-600 uppercase tracking-widest">Look 01</span>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">Mountain Peak Expedition</h3>
                        </div>
                    </div>
                </div>

                <!-- Look 2 -->
                <div class="group">
                    <div class="relative aspect-[4/5] overflow-hidden bg-gray-100 mb-6">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Urban Explorer" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-500 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <a href="{{ route('products.index') }}" class="bg-white text-black px-6 py-3 font-bold uppercase text-xs tracking-widest hover:bg-yellow-500 transition-colors">Shop this Look</a>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <span class="text-xs font-bold text-yellow-600 uppercase tracking-widest">Look 02</span>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">Modern Urban Explorer</h3>
                        </div>
                    </div>
                </div>

                <!-- Look 3 -->
                <div class="group md:col-span-2">
                    <div class="relative aspect-[21/9] overflow-hidden bg-gray-100 mb-6">
                        <img src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="Wilderness Journey" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-500 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <a href="{{ route('products.index') }}" class="bg-white text-black px-10 py-4 font-bold uppercase tracking-widest hover:bg-yellow-500 transition-colors">Shop this Look</a>
                        </div>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-yellow-600 uppercase tracking-widest">Look 03</span>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1">Infinite Wilderness Journey</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Navigation -->
    <section class="py-12 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-10 py-4 font-bold uppercase tracking-widest hover:bg-gray-800 transition-colors">
                Shop the Collection
            </a>
        </div>
    </section>
@endsection
