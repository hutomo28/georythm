@extends('customer.layouts.app')

@section('title', $title . ' - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:pt-32">
    <!-- Header -->
    <div class="text-center mb-16 relative">
        <h1 class="text-3xl md:text-4xl font-normal text-gray-900 mb-2">{{ $title }}</h1>
        <div class="absolute top-0 right-0 hidden md:block">
            <!-- Optional: Any controls like sort/filter could go here -->
        </div>
        <div class="text-center border-t border-b border-gray-200 py-3 mt-8">
            <span class="text-gray-500 text-sm font-medium uppercase tracking-wide">{{ count($products) }} PRODUCT</span>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-16">
        @foreach ($products as $product)
            <a href="{{ route('products.show', $product['id']) }}" class="group cursor-pointer block">
                <!-- Image -->
                <div class="aspect-[3/4] bg-gray-50 mb-6 overflow-hidden relative">
                    <img 
                        src="{{ $product['image'] }}" 
                        alt="{{ $product['name'] }}" 
                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                        loading="lazy"
                    >
                    <!-- Optional: Add badges or quick view overlay here -->
                </div>
                
                <!-- Content -->
                <div class="text-center space-y-2 px-4">
                    <p class="text-xs font-bold text-gray-900 uppercase tracking-widest">
                        {{ $product['brand'] }}
                    </p>
                    <h3 class="text-xs text-gray-600 uppercase leading-relaxed font-medium line-clamp-2 min-h-[2.5em]">
                        {{ $product['name'] }}
                    </h3>
                    <p class="text-xs text-gray-500 font-normal mt-2">
                        {{ $product['price'] }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
    
    <!-- Pagination (Placeholder) -->
    <div class="mt-20 text-center">
        <!-- Pagination links would go here -->
    </div>
</div>
@endsection
