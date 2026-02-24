@extends('customer.layouts.app')

@section('title', $product->name . ' - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:pt-32">
    <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
        <!-- Image gallery -->
        <div class="flex flex-col">
            <div class="aspect-[3/4] w-full bg-gray-100 overflow-hidden relative mb-4">
                <img id="main-image" src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover transition-opacity duration-300">
            </div>
            
            <!-- Thumbnails -->
            <div class="grid grid-cols-3 gap-4">
                <div class="aspect-[3/4] bg-gray-100 overflow-hidden cursor-pointer border-2 border-black thumbnail" onclick="changeImage('{{ $product->image }}', this)">
                    <img src="{{ $product->image }}" class="w-full h-full object-cover">
                </div>
                @if($product->image2)
                <div class="aspect-[3/4] bg-gray-100 overflow-hidden cursor-pointer border-2 border-transparent thumbnail" onclick="changeImage('{{ $product->image2 }}', this)">
                    <img src="{{ $product->image2 }}" class="w-full h-full object-cover">
                </div>
                @endif
                @if($product->image3)
                <div class="aspect-[3/4] bg-gray-100 overflow-hidden cursor-pointer border-2 border-transparent thumbnail" onclick="changeImage('{{ $product->image3 }}', this)">
                    <img src="{{ $product->image3 }}" class="w-full h-full object-cover">
                </div>
                @endif
            </div>

            <script>
                function changeImage(src, el) {
                    const mainImg = document.getElementById('main-image');
                    mainImg.style.opacity = 0;
                    
                    setTimeout(() => {
                        mainImg.src = src;
                        mainImg.style.opacity = 1;
                    }, 300);

                    // Update borders
                    document.querySelectorAll('.thumbnail').forEach(thumb => {
                        thumb.classList.remove('border-black');
                        thumb.classList.add('border-transparent');
                    });
                    el.classList.add('border-black');
                    el.classList.remove('border-transparent');
                }
            </script>
        </div>

        <!-- Product info -->
        <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 uppercase">{{ $product->name }}</h1>
                <p class="text-2xl font-medium text-gray-900">{{ $product->formatted_price }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-bold text-yellow-500 uppercase tracking-widest mb-2">{{ $product->category }}</h3>
                <div class="text-base text-gray-700 space-y-4">
                    <p>{{ $product->description }}</p>
                </div>
            </div>

            <form action="{{ route('cart.store') }}" method="POST" class="mt-10">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <!-- Size picker -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Select Size</h3>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mt-4">
                        @foreach(['S', 'M', 'L', 'XL'] as $size)
                            <label class="group relative border border-gray-200 py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none cursor-pointer bg-white text-gray-900 shadow-sm transition-colors duration-200">
                                <input type="radio" name="size" value="{{ $size }}" class="sr-only" required>
                                <span>{{ $size }}</span>
                                <div class="absolute -inset-px border-2 border-transparent group-has-[:checked]:border-black dark:group-has-[:checked]:border-yellow-400 pointer-events-none" aria-hidden="true"></div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4">Quantity</h3>
                    <div class="flex items-center border border-gray-200 w-32">
                        <button type="button" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-black" onclick="this.nextElementSibling.stepDown()">-</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 h-10 border-none text-center focus:ring-0 text-sm font-medium" readonly>
                        <button type="button" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-black" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Stock: {{ $product->stock }}</p>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-black border border-transparent py-4 px-8 flex items-center justify-center text-base font-bold text-white uppercase tracking-widest hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Add to Cart
                    </button>
                </div>
            </form>

            <!-- Extra Info -->
            <div class="mt-10 border-t border-gray-200 pt-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                    <div>
                        <h3 class="font-bold text-gray-900 uppercase mb-2">Detailed Info</h3>
                        <ul class="text-gray-600 space-y-1 list-disc pl-4">
                            <li>100% Authentic Product</li>
                            <li>Premium Quality Materials</li>
                            <li>Official Brand Warranty</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 uppercase mb-2">Shipping & Returns</h3>
                        <p class="text-gray-600">Free shipping on orders over Rp 1.000.000. 7-day return policy for unused items.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
