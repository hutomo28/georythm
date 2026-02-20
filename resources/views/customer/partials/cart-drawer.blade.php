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
        class="relative w-full max-w-md bg-white shadow-xl flex flex-col h-full transform transition-transform"
        x-show="cartOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
    >
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-6 border-b border-gray-100">
            <h2 class="text-xl font-bold uppercase tracking-widest text-gray-900">Keranjang</h2>
            <button @click="cartOpen = false" class="text-gray-400 hover:text-gray-900 transition-colors">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto px-6 py-6 space-y-8">
            <!-- Item 1 -->
            <div class="flex gap-4">
                <div class="w-24 h-32 bg-gray-100 flex-shrink-0 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Product" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold uppercase leading-relaxed text-gray-900 mb-1">
                            NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN BLACK
                        </h3>
                        <p class="text-red-500 font-bold text-sm mb-1">Rp6.999.000</p>
                        <p class="text-xs text-gray-500 uppercase">XL</p>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center border border-gray-300">
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-50">-</button>
                            <span class="w-8 h-8 flex items-center justify-center text-xs font-medium">1</span>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-50">+</button>
                        </div>
                        <button class="text-xs text-gray-400 hover:text-red-500 underline decoration-gray-300 hover:decoration-red-500 transition-colors">Hapus</button>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex gap-4">
                <div class="w-24 h-32 bg-gray-100 flex-shrink-0 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1559551409-dadc959f76b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Product" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold uppercase leading-relaxed text-gray-900 mb-1">
                            NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN White
                        </h3>
                        <p class="text-red-500 font-bold text-sm mb-1">Rp3.999.000</p>
                        <p class="text-xs text-gray-500 uppercase">M</p>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center border border-gray-300">
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-50">-</button>
                            <span class="w-8 h-8 flex items-center justify-center text-xs font-medium">1</span>
                            <button class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-50">+</button>
                        </div>
                        <button class="text-xs text-gray-400 hover:text-red-500 underline decoration-gray-300 hover:decoration-red-500 transition-colors">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-100 px-6 py-6 bg-white">
            <div class="mb-4">
                <label for="order-note" class="block text-sm font-medium text-gray-900 mb-2">Tulis Catatan</label>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500 mb-4">Belum Termasuk Biaya Pengiriman</p>
                <a href="{{ route('checkout.index') }}" class="w-full bg-black text-white py-4 font-bold uppercase tracking-widest hover:bg-gray-900 transition-colors flex justify-between px-8">
                    <span>Checkout</span>
                    <span>•</span>
                    <span>10.998.000</span>
                </a>
            </div>
        </div>
    </div>
</div>
