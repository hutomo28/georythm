@extends('customer.layouts.app')

@section('title', 'GEORYTHM - Premium Outdoor Apparel')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 h-[calc(100vh-8rem)] max-h-[800px] flex items-center overflow-hidden">
        <!-- Placeholder for Hero Image -->
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 to-gray-800 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center mix-blend-overlay opacity-50"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl">
                <span class="text-yellow-500 font-bold tracking-widest uppercase mb-4 block animate-fade-in-up">25FW Collection</span>
                <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight mb-6 animate-fade-in-up delay-100">
                    GEAR UP FOR <br/>
                    A NEW SEASON
                </h1>
                <p class="text-xl text-gray-300 mb-8 max-w-xl animate-fade-in-up delay-200">
                    Discover our latest arrival of premium outdoor jackets designed for the extreme, styled for the city.
                </p>
                <div class="flex flex-wrap gap-4 animate-fade-in-up delay-300">
                    <a href="{{ route('products.index') }}" class="bg-yellow-500 text-black px-8 py-4 font-bold uppercase tracking-wide hover:bg-yellow-400 transition-colors">
                        Shop Now
                    </a>
                    <a href="{{ route('customer.lookbook') }}" class="border border-white text-white px-8 py-4 font-bold uppercase tracking-wide hover:bg-white hover:text-black transition-colors">
                        View Lookbook
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Logos Section -->
    <div class="bg-black py-12 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm uppercase tracking-widest mb-8">Trusted by Explorers</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center justify-items-center opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <!-- Using text representations for logos as placeholders -->
                <span class="text-white text-xl font-bold font-serif">NATIONAL GEOGRAPHIC</span>
                <span class="text-white text-xl font-black italic">THE NORTH FACE</span>
                <span class="text-white text-xl font-medium tracking-tight">ARC'TERYX</span>
                <span class="text-white text-xl font-bold">Columbia</span>
            </div>
        </div>
    </div>

    <!-- New Arrivals Section -->
    <section class="py-24 bg-white dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-slate-100 uppercase tracking-tight mb-4">New Arrivals</h2>
                <div class="w-20 h-1 bg-yellow-500 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($newArrivals as $product)
                <!-- Product Card -->
                <div class="group cursor-pointer" onclick="window.location.href='{{ route('products.show', $product->id) }}'">
                    <div class="relative bg-gray-100 aspect-[3/4] overflow-hidden mb-4">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-all duration-700 ease-in-out @if($product->image2) group-hover:opacity-0 @endif">
                            @if($product->image2)
                                <img src="{{ $product->image2 }}" alt="{{ $product->name }}" class="absolute inset-0 h-full w-full object-cover opacity-0 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700 ease-in-out">
                            @endif
                        @else
                            <div class="absolute inset-0 bg-gray-200 flex items-center justify-center text-gray-400 group-hover:scale-105 transition-transform duration-500">
                                <span class="uppercase tracking-widest text-sm">{{ $product->name }}</span>
                            </div>
                        @endif
                        
                        @if($loop->first)
                            <div class="absolute top-4 left-4 bg-black text-white text-xs font-bold px-2 py-1 uppercase">New</div>
                        @elseif($loop->iteration == 2)
                            <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-2 py-1 uppercase">Best Seller</div>
                        @endif
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase mb-1">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500 mb-2">{{ $product->category }} - {{ $product->size }}</p>
                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="inline-block border-b-2 border-black dark:border-slate-400 text-black dark:text-slate-200 pb-1 font-bold uppercase tracking-wide hover:text-yellow-600 hover:border-yellow-600 transition-colors">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Description Section with Parallax Effect -->
    <section class="relative py-24 bg-gray-50 dark:bg-zinc-900 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="black" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="mb-10">
                <span class="text-yellow-500 font-bold tracking-widest uppercase text-sm">Our Philosophy</span>
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-slate-100 mb-8 leading-tight">
                EXPLORE THE WORLD. <br/> WEAR THE RHYTHM.
            </h2>
            <div class="space-y-6 text-gray-600 dark:text-slate-400 leading-relaxed font-light text-lg">
                <p>
                    GEORYTHM is an apparel store focused on premium outdoor and lifestyle jackets, presenting a curated collection from world-renowned brands like National Geographic, The North Face, Columbia, and Arc'teryx.
                </p>
                <p>
                    We are here to meet the needs of adventure lovers, urban explorers, and daily users who prioritize quality, comfort, and classy design in every activity.
                </p>
                <p>
                    The name GEORYTHM is inspired by the combination of "Geo" (earth, world, exploration) and "Rhythm" (rhythm, lifestyle, movement). This philosophy reflects the balance between technical function and modern style—where every jacket is not just protection from extreme weather, but also part of the identity and rhythm of its user's life.
                </p>
            </div>
            
            <div class="mt-12">
                <a href="{{ route('customer.story') }}" class="text-sm font-bold uppercase tracking-widest text-gray-900 dark:text-slate-200 hover:text-yellow-500 transition-colors">
                    Read Our Full Story &rarr;
                </a>
            </div>
        </div>
    </section>
@endsection
