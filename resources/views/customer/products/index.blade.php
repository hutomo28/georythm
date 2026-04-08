@extends('customer.layouts.app')

@section('title', $title . ' - Georythm')

@section('content')
@php
    $activeProducts = $products->filter(fn($p) => $p['stock'] > 0);
    $soldOutProducts = $products->filter(fn($p) => $p['stock'] <= 0);
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:pt-12">
    <!-- Header -->
    <div class="text-center mb-16 relative">
        <h1 class="text-3xl md:text-4xl font-normal text-gray-900 dark:text-white mb-2">{{ $title }}</h1>
        <div class="text-center border-t border-b border-gray-200 dark:border-zinc-700 py-3 mt-8">
            <span class="text-gray-500 dark:text-zinc-400 text-sm font-medium uppercase tracking-wide">{{ count($products) }} PRODUCT</span>
        </div>
    </div>

    <!-- Active Products Grid -->
    @if($activeProducts->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-16">
        @foreach ($activeProducts as $product)
            <a href="{{ route('products.show', $product['id']) }}" class="group cursor-pointer block">
                <!-- Image -->
                <div class="aspect-[3/4] bg-gray-50 dark:bg-zinc-800 mb-6 overflow-hidden relative">
                    <img 
                        src="{{ $product['image'] }}" 
                        alt="{{ $product['name'] }}" 
                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-all duration-700 ease-out @if($product['image2']) group-hover:opacity-0 @endif"
                        loading="lazy"
                    >
                    @if($product['image2'])
                        <img 
                            src="{{ $product['image2'] }}" 
                            alt="{{ $product['name'] }}" 
                            class="absolute inset-0 w-full h-full object-cover object-center opacity-0 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700 ease-out"
                            loading="lazy"
                        >
                    @endif
                </div>
                
                <!-- Content -->
                <div class="text-center space-y-2 px-4">
                    <p translate="no" class="notranslate text-xs font-bold text-gray-900 dark:text-slate-100 uppercase tracking-widest">
                        {{ $product['brand'] }}
                    </p>
                    <h3 class="text-xs text-gray-600 dark:text-zinc-400 uppercase leading-relaxed font-bold line-clamp-2 min-h-[2.5em] group-hover:text-black dark:group-hover:text-white transition-colors">
                        {{ $product['name'] }}
                    </h3>
                    
                    @if($product['reviews_count'] > 0)
                    <div class="flex items-center justify-center space-x-1 mt-1">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= round($product['rating']) ? 'solid' : 'regular' }} fa-star text-[10px]"></i>
                            @endfor
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">({{ $product['reviews_count'] }})</span>
                    </div>
                    @endif

                    <p class="text-[13px] text-gray-900 dark:text-slate-200 font-bold mt-2">
                        {{ $product['price'] }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
    @endif

    <!-- No Products at all -->
    @if($products->count() === 0)
        <div class="py-20 text-center">
            <p class="text-gray-400 dark:text-zinc-500 uppercase tracking-widest text-sm">No products found in this category.</p>
        </div>
    @endif

    <!-- Sold Out Products Section -->
    @if($soldOutProducts->count() > 0)
    <div class="mt-24 pt-16 border-t border-gray-200 dark:border-zinc-700">
        <div class="text-center mb-12">
            <span class="text-[10px] font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-[0.3em]">Currently Unavailable</span>
            <h2 class="text-2xl font-normal text-gray-400 dark:text-zinc-500 mt-2">Sold Out</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-16 opacity-60">
            @foreach ($soldOutProducts as $product)
                <a href="{{ route('products.show', $product['id']) }}" class="group cursor-pointer block">
                    <!-- Image -->
                    <div class="aspect-[3/4] bg-gray-50 dark:bg-zinc-800 mb-6 overflow-hidden relative">
                        <img 
                            src="{{ $product['image'] }}" 
                            alt="{{ $product['name'] }}" 
                            class="w-full h-full object-cover object-center grayscale"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 flex items-center justify-center bg-black/10">
                            <span class="bg-black/80 dark:bg-white/80 text-white dark:text-black text-[10px] font-bold px-4 py-2 uppercase tracking-[0.3em] backdrop-blur-sm">Sold Out</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="text-center space-y-2 px-4">
                        <p translate="no" class="notranslate text-xs font-bold text-gray-400 dark:text-zinc-500 uppercase tracking-widest">
                            {{ $product['brand'] }}
                        </p>
                        <h3 class="text-xs text-gray-400 dark:text-zinc-600 uppercase leading-relaxed font-bold line-clamp-2 min-h-[2.5em]">
                            {{ $product['name'] }}
                        </h3>

                        <p class="text-[13px] text-gray-400 dark:text-zinc-500 font-bold mt-2 line-through">
                            {{ $product['price'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Pagination (Placeholder) -->
    <div class="mt-20 text-center">
        <!-- Pagination links would go here -->
    </div>
</div>
@endsection
