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
                <h3 translate="no" class="notranslate text-xs font-bold text-yellow-500 uppercase tracking-widest mb-2">{{ $product->category }}</h3>
                <div class="text-base text-gray-700 space-y-4">
                    <p>{{ $product->description }}</p>
                </div>
            </div>

            <form action="{{ route('cart.store') }}" method="POST" class="mt-10">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                @php
                    $sizesList = ['S', 'M', 'L', 'XL'];
                    $hasSizedStock = $product->sizes->count() > 0;
                    
                    $sizeData = [];
                    $totalAvailableStock = 0;
                    foreach ($sizesList as $size) {
                        if ($hasSizedStock) {
                            $stock = $product->sizes->where('size', $size)->first()->stock ?? 0;
                            $sizeData[$size] = $stock;
                            $totalAvailableStock += $stock;
                        } else {
                            $sizeData[$size] = $product->stock;
                            $totalAvailableStock += $product->stock; // Fallback
                        }
                    }
                    if (!$hasSizedStock) {
                         $totalAvailableStock = $product->stock;
                    }
                @endphp

                <!-- Size picker -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Select Size</h3>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mt-4" id="size-options">
                        @foreach($sizeData as $size => $stock)
                            @php
                                $isDisabled = $stock <= 0;
                            @endphp
                            <label class="group relative py-3 px-4 flex items-center justify-center text-sm font-medium uppercase focus:outline-none bg-white text-gray-900 shadow-sm transition-colors duration-200 {{ $isDisabled ? 'opacity-50 cursor-not-allowed border-gray-100' : 'border border-gray-200 hover:bg-gray-50 cursor-pointer' }}" data-size="{{ $size }}" data-stock="{{ $stock }}">
                                <input type="radio" name="size" value="{{ $size }}" class="sr-only" required {{ $isDisabled ? 'disabled' : '' }} onchange="updateStockDisplay(this)">
                                <span>{{ $size }}</span>
                                @if($isDisabled)
                                    <svg class="absolute inset-0 h-full w-full stroke-2 text-gray-200" viewBox="0 0 100 100" preserveAspectRatio="none" stroke="currentColor">
                                        <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke"></line>
                                    </svg>
                                @else
                                    <div class="absolute -inset-px border-2 border-transparent group-has-[:checked]:border-black dark:group-has-[:checked]:border-yellow-400 pointer-events-none" aria-hidden="true"></div>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="space-y-6">
                    @if($totalAvailableStock > 0)
                        <div class="mb-8">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-4">Quantity</h3>
                            <div class="flex items-center border border-gray-200 dark:border-zinc-700 w-32 bg-white dark:bg-zinc-800">
                                <button type="button" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-black dark:hover:text-white" onclick="this.nextElementSibling.stepDown()">-</button>
                                <input id="quantity-input" type="number" name="quantity" value="1" min="1" max="1" class="w-12 h-10 border-none text-center focus:ring-0 text-sm font-medium bg-transparent text-gray-900 dark:text-white" readonly>
                                <button type="button" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-black dark:hover:text-white" onclick="this.previousElementSibling.stepUp()">+</button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400" id="stock-display">Please select a size to view stock</p>
                        </div>

                        <div class="flex space-x-4">
                            <button id="add-to-cart-btn" type="submit" disabled class="flex-1 bg-gray-400 dark:bg-zinc-700 border border-transparent py-4 px-8 flex items-center justify-center text-base font-bold text-white dark:text-gray-400 uppercase tracking-widest cursor-not-allowed transition-all">
                                Select Size
                            </button>
                        </div>
                        
                        <script>
                            function updateStockDisplay(radioElement) {
                                const stock = parseInt(radioElement.closest('label').getAttribute('data-stock'));
                                
                                // Update quantity max
                                const qtyInput = document.getElementById('quantity-input');
                                if (qtyInput) {
                                    qtyInput.max = stock;
                                    if (parseInt(qtyInput.value) > stock) {
                                        qtyInput.value = stock;
                                    }
                                }
                                
                                // Update stock text
                                const stockDisplay = document.getElementById('stock-display');
                                if (stockDisplay) {
                                    stockDisplay.innerText = `Stock available: ${stock}`;
                                }

                                // Enable Add to Cart button
                                const addToCartBtn = document.getElementById('add-to-cart-btn');
                                if (addToCartBtn) {
                                    addToCartBtn.disabled = false;
                                    addToCartBtn.innerText = 'Add to Cart';
                                    addToCartBtn.className = 'flex-1 bg-black dark:bg-white border border-transparent py-4 px-8 flex items-center justify-center text-base font-bold text-white dark:text-black uppercase tracking-widest hover:bg-gray-900 dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all cursor-pointer';
                                }
                            }
                        </script>
                    @else
                        <div class="mb-8 opacity-50">
                            <p class="text-sm font-bold text-red-500 uppercase tracking-widest">Currently Out of Stock</p>
                        </div>
                        <div class="flex space-x-4">
                            <button type="button" disabled class="flex-1 bg-gray-200 dark:bg-zinc-800 border border-transparent py-4 px-8 flex items-center justify-center text-base font-bold text-gray-400 dark:text-zinc-600 uppercase tracking-widest cursor-not-allowed">
                                Sold Out
                            </button>
                        </div>
                    @endif
                </div>
            </form>

            <!-- Reviews Section -->
            <div class="mt-16 border-t border-gray-200 pt-16">
                @if($product->reviews()->count() > 0)
                    <div class="mb-12 flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Customer Reviews</h2>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= round($product->averageRating()) ? 'solid' : 'regular' }} fa-star text-xs"></i>
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ number_format($product->averageRating(), 1) }}</span>
                            <span class="mx-2 text-gray-300">|</span>
                            <span class="text-sm text-gray-500 font-medium uppercase tracking-widest">{{ $product->reviewsCount() }} Reviews</span>
                        </div>
                    </div>

                    <div class="space-y-12">
                        @foreach($product->reviews()->latest()->take(3)->get() as $review)
                            <div class="border-b border-gray-100 dark:border-zinc-800 pb-10 last:border-0">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center font-bold text-gray-400 mr-3 uppercase">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-slate-100 uppercase">{{ $review->user->name }}</h4>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-[10px]"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="ml-auto text-[10px] text-gray-400 uppercase tracking-widest">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-zinc-400 text-sm italic leading-relaxed">"{{ $review->comment }}"</p>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-12 text-center">
                        <button class="text-xs font-bold uppercase tracking-[0.2em] text-gray-900 dark:text-white border-b-2 border-black dark:border-white pb-1 hover:text-yellow-600 hover:border-yellow-600 transition-all">Read More Reviews</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Related Products (Edge to Edge) -->
<div class="mt-24 border-t border-gray-100 bg-gray-50/50 dark:bg-zinc-900/50 pt-20 pb-32">
    <div class="px-6 md:px-16 lg:px-24 w-full">
        <div class="text-center mb-16">
            <span class="text-yellow-500 font-bold tracking-widest uppercase text-xs mb-3 block animate-fade-in-up">Recommendations</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white uppercase tracking-tight mb-4">You Might Also Like</h2>
            <div class="w-16 h-1 bg-yellow-500 mx-auto"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 gap-y-12">
            @foreach($relatedProducts as $related)
            <div class="group cursor-pointer" onclick="window.location.href='{{ route('products.show', $related->id) }}'">
                <div class="relative aspect-[3/4] bg-gray-200 dark:bg-zinc-800 overflow-hidden mb-5">
                    <img src="{{ $related->image }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 group-hover:rotate-1 transition-all duration-700 ease-in-out">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-500"></div>
                </div>
                <div class="space-y-1">
                    <h4 translate="no" class="notranslate text-[11px] font-extrabold text-yellow-600 dark:text-yellow-500 uppercase tracking-[0.2em] mb-1.5">{{ $related->category }}</h4>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100 uppercase mb-1 line-clamp-1 group-hover:text-yellow-600 transition-colors">{{ $related->name }}</h3>
                    <p class="text-sm font-medium text-gray-900 dark:text-slate-400">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
