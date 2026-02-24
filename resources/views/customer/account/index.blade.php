@extends('customer.layouts.app')

@section('title', 'Account - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-400 hover:text-gray-900 transition-colors font-bold text-lg">
            <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-16 lg:items-start">
        <!-- Left Column: Profile -->
        <div class="lg:col-span-5 mb-12 lg:mb-0">
            <h1 class="text-4xl font-bold text-gray-900 mb-8 uppercase tracking-wide">ACCOUNT</h1>

            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-800 font-bold uppercase tracking-widest text-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(request('received'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-800 font-bold uppercase tracking-widest text-sm text-center">
                    Order Successfully Received and Added to History
                </div>
            @endif

            <div class="space-y-4 mb-8">
                <p class="text-xl text-gray-900">
                    <span class="font-bold italic">Hello,</span> {{ $user->name }}
                </p>
                <p class="text-xl text-gray-900">
                    <span class="font-bold italic">Your Email,</span> {{ $user->email }}
                </p>
            </div>

            <!-- Address Card -->
            <div class="border border-black p-6 relative flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Your Addresses</h3>
                    <a href="{{ route('address.create') }}" class="bg-black text-white text-[10px] uppercase font-bold px-3 py-1.5 hover:bg-gray-800 transition-colors inline-block">
                        Create New Address
                    </a>
                </div>

                <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($addresses as $addr)
                        <div class="border {{ $addr->is_default ? 'border-black bg-gray-50' : 'border-gray-200' }} p-4 relative group">
                            @if($addr->is_default)
                                <div class="absolute -top-3 left-4 bg-black text-white text-[8px] px-2 py-0.5 font-bold uppercase tracking-widest">
                                    Main Address
                                </div>
                            @endif

                            <div class="flex justify-between items-start mb-2">
                                <span class="font-bold text-sm">{{ $addr->country }}</span>
                                <span class="font-bold text-sm">{{ $addr->full_name }}</span>
                            </div>
                            <div class="text-right text-xs text-gray-500 mb-2">Phone No. {{ $addr->phone }}</div>
                            <div class="text-xs text-gray-600 space-y-1 mb-4">
                                <p>{{ $addr->address }}</p>
                                <p><span class="inline-block w-20">{{ $addr->apartment ?? '-' }}</span> Province: {{ $addr->province }}</p>
                                <p><span class="inline-block w-20">City: {{ $addr->city }}</span> Zip Code: {{ $addr->zip }}</p>
                            </div>

                            <div class="flex space-x-2 pt-2 border-t border-gray-100 mt-2">
                                @if(!$addr->is_default)
                                    <form action="{{ route('address.set-main', $addr) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-[9px] font-bold uppercase tracking-widest text-black hover:underline">
                                            Set as Main
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('address.destroy', $addr) }}" method="POST" onsubmit="return confirm('Delete this address?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[9px] font-bold uppercase tracking-widest text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="border border-gray-300 p-8 flex items-center justify-center">
                            <p class="text-gray-400 text-sm">No addresses yet. Please add a new address.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Logout Button -->
            <div class="mt-8">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to log out?');" class="w-full bg-black text-white py-4 px-6 font-bold uppercase tracking-widest hover:bg-gray-800 transition-all flex items-center justify-center group">
                        <span>Log Out</span>
                        <svg class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Orders -->
        <div class="lg:col-span-7">
            <!-- Order Status -->
            <div class="mb-16">
                <h2 class="text-2xl font-normal text-gray-900 mb-8">Order Status</h2>
                <div class="flex justify-between items-start max-w-2xl">
                    <!-- Status 1 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'waiting-payment']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['waiting-payment'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Waiting for<br>Payment</p>
                    </button>
                    <!-- Status 2 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'processing']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['processing'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Processing</p>
                    </button>
                    <!-- Status 3 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'shipped']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['shipped'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Shipping</p>
                    </button>
                    <!-- Status 4 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'arrived']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['arrived'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Order<br>Arrived</p>
                    </button>
                </div>
            </div>

            <!-- Order History -->
            <div>
                <h2 class="text-2xl font-normal text-gray-900 mb-6">Order History</h2>
                <div class="border-t border-black">
                    @forelse($completedOrders as $order)
                        @foreach($order->items as $item)
                            <div class="py-6 border-b {{ $loop->last && $loop->parent->last ? 'border-black' : 'border-gray-200' }}">
                                <div class="flex space-x-6">
                                    <div class="w-24 h-28 bg-gray-100 flex-shrink-0">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-xs text-gray-900 uppercase leading-relaxed mb-1">
                                            {{ $item->product_name }}
                                        </h3>
                                        <p class="text-red-500 font-bold text-xs mb-1">{{ $item->formatted_price }}</p>
                                        @if($item->size)
                                            <p class="text-xs text-gray-500 mb-0.5">{{ $item->size }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500">{{ $item->quantity }}x</p>
                                    </div>
                                </div>
                                @if($loop->last)
                                    <div class="text-right mt-4">
                                        <p class="text-sm font-bold text-gray-900">Total: {{ $order->formatted_total }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @empty
                        <div class="py-12 text-center">
                            <p class="text-gray-400 text-sm">No order history yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
