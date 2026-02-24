@extends('customer.layouts.app')

@section('title', 'Checkout - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
        <!-- Left Column: Information -->
        <div class="lg:col-span-7">
            <!-- User Info -->
            <div class="mb-8 p-4 border border-gray-200 rounded-lg flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold uppercase">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-6 uppercase tracking-tight">Shipping Address</h2>
                @if($address)
                    <div class="border border-black p-6 relative bg-gray-50">
                        <div class="absolute -top-3 left-4 bg-black text-white text-[8px] px-2 py-0.5 font-bold uppercase tracking-widest">
                            Main Address
                        </div>
                        
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-bold text-sm">{{ $address->country }}</span>
                            <span class="font-bold text-sm">{{ $address->full_name }}</span>
                        </div>
                        <div class="text-right text-xs text-gray-500 mb-2">Phone No. {{ $address->phone }}</div>
                        <div class="text-xs text-gray-600 space-y-1">
                            <p>{{ $address->address }}</p>
                            <p><span class="inline-block w-20">{{ $address->apartment ?? '-' }}</span> Province: {{ $address->province }}</p>
                            <p><span class="inline-block w-20">City: {{ $address->city }}</span> Zip Code: {{ $address->zip }}</p>
                        </div>
                        <a href="{{ route('account.index') }}" class="absolute bottom-4 right-4 text-[9px] font-bold uppercase tracking-widest text-black hover:underline">Change Address</a>
                    </div>
                @else
                    <div class="border border-dashed border-gray-300 p-8 text-center flex flex-col items-center justify-center">
                        <p class="text-gray-400 text-sm mb-4">No shipping address found.</p>
                        <a href="{{ route('address.create') }}" class="bg-black text-white text-[10px] uppercase font-bold px-4 py-2 hover:bg-gray-800 transition-colors">Add Address</a>
                    </div>
                @endif
            </div>


            <!-- Submit Button Form -->
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <!-- Shipping Section -->
                <div class="mb-10">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 uppercase tracking-tight">Shipping Method</h2>
                    <div class="space-y-4">
                        <!-- JNE -->
                        <label class="relative flex items-center justify-between border border-black p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <input type="radio" name="shipping_method" value="JNE" class="h-4 w-4 text-black border-gray-300 focus:ring-black" checked>
                                <div class="ml-4">
                                    <span class="block text-sm font-bold text-gray-900 uppercase tracking-tight">JNE Express</span>
                                    <span class="block text-[10px] text-gray-500 uppercase font-medium">3 to 6 working days</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                        </label>

                        <!-- J&T -->
                        <label class="relative flex items-center justify-between border border-gray-200 p-4 cursor-pointer hover:border-black hover:bg-gray-50 transition-all">
                            <div class="flex items-center">
                                <input type="radio" name="shipping_method" value="JNT" class="h-4 w-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4">
                                    <span class="block text-sm font-bold text-gray-900 uppercase tracking-tight">J&T Express</span>
                                    <span class="block text-[10px] text-gray-500 uppercase font-medium">2 to 4 working days</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                        </label>

                        <!-- ANTERAJA -->
                        <label class="relative flex items-center justify-between border border-gray-200 p-4 cursor-pointer hover:border-black hover:bg-gray-50 transition-all">
                            <div class="flex items-center">
                                <input type="radio" name="shipping_method" value="ANTERAJA" class="h-4 w-4 text-black border-gray-300 focus:ring-black">
                                <div class="ml-4">
                                    <span class="block text-sm font-bold text-gray-900 uppercase tracking-tight">Anteraja</span>
                                    <span class="block text-[10px] text-gray-500 uppercase font-medium">2 to 5 working days</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="block w-full text-center bg-black text-white py-4 font-bold uppercase tracking-widest hover:bg-gray-900 transition-colors mb-4" {{ !$address ? 'disabled' : '' }}>
                    Place Order & Pay
                </button>
            </form>
            <p class="text-xs text-gray-400 text-center">Please upload payment proof in your Account page after ordering.</p>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-5 mt-10 lg:mt-0">
            <div class="bg-gray-50 p-6 rounded-none shadow-sm">
                <!-- Product List -->
                <div class="space-y-6 mb-8 max-h-96 overflow-y-auto pr-2">
                    @foreach($cartItems as $item)
                        <div class="flex space-x-4">
                            <div class="h-20 w-16 bg-white overflow-hidden rounded-md border border-gray-200 flex-shrink-0">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                            </div>
                            <div class="flex-1 flex justify-between text-xs">
                                <div class="pr-4">
                                    <h3 class="font-bold text-gray-900 uppercase leading-tight">{{ $item->product->name }}</h3>
                                    <p class="text-gray-500 mt-1">Size: {{ $item->size }}</p>
                                    <p class="text-gray-500">{{ $item->quantity }}x @ Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-bold text-gray-900 whitespace-nowrap">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="border-t border-gray-200 pt-6 space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal • {{ $cartItems->sum('quantity') }} items</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <span class="text-2xl font-bold text-gray-900 uppercase tracking-tight">Total</span>
                        <div class="text-right">
                            <span class="text-xs text-gray-500 mr-1">IDR</span>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection