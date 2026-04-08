<!-- Cart Drawer -->
<div 
    class="fixed inset-0 z-[100] flex justify-end" 
    role="dialog" 
    aria-modal="true"
    x-show="cartOpen"
    style="display: none;"
>
    <!-- Overlay -->
    <div 
        class="fixed inset-0 bg-black/50 transition-opacity" 
        x-show="cartOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="cartOpen = false"
    ></div>

    <!-- Panel -->
    <div 
        class="relative w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl flex flex-col h-full transform transition-transform"
        x-show="cartOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
    >
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-6 border-b border-gray-100 dark:border-zinc-700">
            <h2 class="text-xl font-bold uppercase tracking-widest text-gray-900 dark:text-slate-100">Cart</h2>
            <button @click="cartOpen = false" class="text-gray-400 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto px-6 py-8 space-y-8">
            @php $hasStockIssue = false; @endphp
            @if(Auth::check() && Auth::user()->carts->count() > 0)
                @foreach(Auth::user()->carts as $item)
                @php 
                    $isOutOfStock = ! $item->product || $item->product->stock < $item->quantity;
                    if ($isOutOfStock) $hasStockIssue = true;
                @endphp
                <div class="flex gap-4 {{ $isOutOfStock ? 'opacity-75' : '' }}">
                    <div class="w-24 h-32 bg-gray-100 flex-shrink-0 overflow-hidden relative">
                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        @if($isOutOfStock)
                            <div class="absolute inset-0 bg-red-500/20 flex items-center justify-center">
                                <span class="bg-red-600 text-white text-[8px] font-bold px-1.5 py-0.5 uppercase tracking-widest">Incomplete</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-bold uppercase leading-relaxed text-gray-900 dark:text-slate-100 mb-1">
                                {{ $item->product->name }}
                            </h3>
                            <p class="text-red-500 font-bold text-sm mb-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 uppercase tracking-widest">{{ $item->size }}</p>
                            
                            @if($isOutOfStock)
                                <p class="text-[10px] text-red-500 font-bold mt-1 uppercase italic">Stock insufficient (Max: {{ $item->product->stock }})</p>
                            @endif
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center border {{ $isOutOfStock ? 'border-red-500' : 'border-gray-300 dark:border-zinc-700' }}">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black dark:text-zinc-400 dark:hover:text-white" onclick="item_drawer_qty_{{ $item->id }}.stepDown(); this.form.submit()">-</button>
                                <input type="number" name="quantity" id="item_drawer_qty_{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-10 h-8 border-none text-center focus:ring-0 text-xs font-medium bg-transparent dark:text-white" readonly>
                                <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black dark:text-zinc-400 dark:hover:text-white" onclick="item_drawer_qty_{{ $item->id }}.stepUp(); this.form.submit()">+</button>
                            </form>
                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-gray-400 hover:text-red-500 underline decoration-gray-300 hover:decoration-red-500 transition-colors">{{ __('admin.delete') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="h-full flex flex-col items-center justify-center text-center">
                    <p class="text-gray-400 uppercase tracking-widest text-sm mb-4">Your cart is empty</p>
                    <a href="{{ route('products.index') }}" @click="cartOpen = false" class="text-black dark:text-white font-bold border-b-2 border-black dark:border-white pb-1 text-xs uppercase uppercase tracking-widest hover:text-yellow-500 hover:border-yellow-500 transition-colors">Start Shopping</a>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-100 dark:border-zinc-700 px-6 py-6 bg-white dark:bg-zinc-900 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            @if(Auth::check() && Auth::user()->carts->count() > 0)
            <div class="flex justify-between items-center mb-6">
                <span class="text-sm font-bold uppercase tracking-widest text-gray-900 dark:text-slate-100">Subtotal</span>
                @php
                    $total = Auth::user()->carts->sum(function($item) {
                        return $item->product->price * $item->quantity;
                    });
                @endphp
                <span class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            
            <div class="space-y-3">
                @if($hasStockIssue)
                    <button disabled class="w-full bg-gray-200 dark:bg-zinc-800 text-gray-400 dark:text-zinc-600 py-4 font-bold uppercase tracking-widest cursor-not-allowed flex justify-center items-center">
                        Check Out
                    </button>
                    <p class="text-[10px] text-red-500 text-center font-bold uppercase italic mt-2">Adjust quantities to proceed</p>
                @else
                    <a href="{{ route('checkout.index') }}" class="w-full bg-black dark:bg-white text-white dark:text-black py-4 font-bold uppercase tracking-widest hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors flex justify-center items-center">
                        Check Out
                    </a>
                @endif
                <a href="{{ route('cart.index') }}" class="w-full bg-white dark:bg-zinc-800 border-2 border-black dark:border-zinc-600 text-black dark:text-white py-4 font-bold uppercase tracking-widest hover:bg-black hover:text-white dark:hover:bg-zinc-700 transition-all flex justify-center items-center">
                    View Cart
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
