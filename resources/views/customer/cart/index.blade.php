@extends('customer.layouts.app')

@section('title', 'Shopping Cart - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:pt-32">
    <div class="text-center mb-16 relative">
        <h1 class="text-3xl md:text-4xl font-normal text-gray-900 mb-2 uppercase">Your Cart</h1>
        <div class="text-center border-t border-b border-gray-200 py-3 mt-8">
            <span class="text-gray-500 text-sm font-medium uppercase tracking-wide">{{ $cartItems->sum('quantity') }} ITEM</span>
        </div>
    </div>

    @if($cartItems->isEmpty())
        <div class="py-20 text-center">
            <p class="text-gray-400 uppercase tracking-widest text-sm mb-8">Your cart is currently empty.</p>
            <a href="{{ route('products.index') }}" class="inline-block border-b-2 border-black text-black pb-1 font-bold uppercase tracking-wide hover:text-yellow-600 hover:border-yellow-600 transition-colors">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <div class="lg:col-span-8">
                <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <li class="flex py-6 sm:py-10">
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-24 h-32 object-center object-cover sm:w-32 sm:h-40">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                    <div>
                                        <div class="flex justify-between">
                                            <h3 class="text-sm">
                                                <a href="{{ route('products.show', $item->product_id) }}" class="font-bold text-gray-900 uppercase hover:text-yellow-600 transition-colors">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mt-1 flex text-xs text-gray-500 uppercase tracking-widest">
                                            <p>{{ $item->product->category }}</p>
                                            <p class="ml-4 border-l border-gray-200 pl-4">{{ $item->size }}</p>
                                        </div>
                                        <p class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>

                                    <div class="mt-4 sm:mt-0 sm:pr-9">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="inline-flex items-center border border-gray-200">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black" onclick="item_qty_{{ $item->id }}.stepDown(); this.form.submit()">-</button>
                                            <input type="number" name="quantity" id="item_qty_{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-10 h-8 border-none text-center focus:ring-0 text-xs font-medium" readonly>
                                            <button type="button" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black" onclick="item_qty_{{ $item->id }}.stepUp(); this.form.submit()">+</button>
                                        </form>

                                        <div class="absolute top-0 right-0">
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-red-500 transition-colors">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                    <span class="font-bold text-gray-900 uppercase tracking-widest text-[10px]">Subtotal:</span>
                                    <span class="font-medium">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Summary -->
            <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-4 rounded-none">
                <h2 id="summary-heading" class="text-lg font-bold text-gray-900 uppercase tracking-tight">Order Summary</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $totalFormatted }}</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="flex items-center text-sm text-gray-600">
                            <span>Shipping estimate</span>
                        </dt>
                        <dd class="text-sm font-medium text-gray-900 text-[10px] uppercase tracking-widest">Calculated at checkout</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="text-base font-bold text-gray-900 uppercase tracking-tight">Order Total</dt>
                        <dd class="text-base font-bold text-gray-900 uppercase tracking-tight">{{ $totalFormatted }}</dd>
                    </div>
                </dl>

                <div class="mt-10">
                    <a href="{{ route('checkout.index') }}" class="w-full bg-black border border-transparent py-4 px-4 flex items-center justify-center text-base font-bold text-white uppercase tracking-widest hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Checkout
                    </a>
                </div>
            </section>
        </div>
    @endif
</div>
@endsection
