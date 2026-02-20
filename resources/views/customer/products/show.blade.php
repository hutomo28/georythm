@extends('customer.layouts.app')

@section('title', $product['name'] . ' - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:pt-32" x-data="{ 
    activeImage: '{{ $product['images'][0] }}',
    selectedSize: null,
    quantity: 1,
    addToCart() {
        if (!this.selectedSize) return;
        // alert('Added to cart: ' + '{{ $product['name'] }}' + ' Size: ' + this.selectedSize + ' Qty: ' + this.quantity);
        this.cartOpen = true; 
    }
}">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Left Column: Images -->
        <div class="space-y-4">
            <!-- Main Image -->
            <div class="aspect-[3/4] bg-gray-50 overflow-hidden relative">
                <img :src="activeImage" alt="{{ $product['name'] }}" class="w-full h-full object-cover object-center transition-opacity duration-300">
            </div>
            
            <!-- Thumbnails -->
            <div class="grid grid-cols-4 gap-4">
                @foreach ($product['images'] as $image)
                    <button 
                        @click="activeImage = '{{ $image }}'" 
                        class="aspect-square bg-gray-50 overflow-hidden border-2 transition-colors"
                        :class="activeImage === '{{ $image }}' ? 'border-black' : 'border-transparent hover:border-gray-200'"
                    >
                        <img src="{{ $image }}" alt="Thumbnail" class="w-full h-full object-cover object-center">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Product Info -->
        <div>
            <h1 class="text-2xl md:text-3xl font-bold uppercase text-gray-900 mb-2 leading-tight">
                {{ $product['brand'] }}- {{ $product['name'] }}
            </h1>
            <p class="text-xl md:text-2xl font-medium text-gray-500 mb-8">{{ $product['price'] }}</p>

            <!-- Size Selector -->
            <div class="mb-8">
                <p class="text-sm font-medium text-gray-900 mb-3">Size:</p>
                <div class="flex flex-wrap gap-3">
                    @foreach ($product['sizes'] as $size)
                        <button 
                            @click="selectedSize = '{{ $size }}'"
                            class="w-12 h-12 flex items-center justify-center border text-sm font-medium transition-all"
                            :class="selectedSize === '{{ $size }}' 
                                ? 'border-black bg-black text-white' 
                                : 'border-gray-300 text-gray-900 hover:border-gray-900'"
                        >
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
                <p x-show="!selectedSize" class="text-red-500 text-xs mt-2" style="display: none;">Please select a size</p>
            </div>

            <!-- Quantity Selector -->
            <div class="mb-8">
                <div class="flex items-center border border-gray-300 w-32">
                    <button @click="quantity > 1 ? quantity-- : null" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100">-</button>
                    <input type="text" x-model="quantity" class="w-12 h-10 text-center border-none focus:ring-0 text-gray-900 font-medium" readonly>
                    <button @click="quantity++" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100">+</button>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-4 mb-12">
                <button 
                    @click="addToCart"
                    :disabled="!selectedSize"
                    class="w-full py-4 text-sm font-bold uppercase tracking-widest transition-colors"
                    :class="selectedSize ? 'bg-yellow-400 text-black hover:bg-yellow-500' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                >
                    Tambah Ke Keranjang
                </button>
                <button 
                    :disabled="!selectedSize"
                    class="w-full py-4 text-sm font-bold uppercase tracking-widest border border-black transition-colors"
                    :class="selectedSize ? 'bg-black text-white hover:bg-white hover:text-black' : 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed'"
                >
                    Beli Sekarang
                </button>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-8"></div>

            <!-- Description -->
            <div class="prose prose-sm max-w-none text-gray-600">
                <h3 class="text-lg font-bold text-gray-900 uppercase mb-4">Deskripsi</h3>
                <div class="whitespace-pre-line leading-relaxed">
                    {{ $product['description'] }}
                </div>
                
                <h4 class="text-sm font-bold text-gray-900 uppercase mt-6 mb-2">Size Chart</h4>
                <div class="whitespace-pre-line text-xs">
                    {{ $product['size_chart'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js CDN for interactivity (assuming not bundled yet) -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
