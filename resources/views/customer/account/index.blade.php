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
                    Pesanan Berhasil Diterima dan Masuk ke Riwayat
                </div>
            @endif

            <div class="space-y-4 mb-8">
                <p class="text-xl text-gray-900">
                    <span class="font-bold italic">Hallo,</span> {{ $user->name }}
                </p>
                <p class="text-xl text-gray-900">
                    <span class="font-bold italic">Email Kamu,</span> {{ $user->email }}
                </p>
            </div>

            <!-- Address Card -->
            <div class="border border-black p-6 relative min-h-[250px] flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Alamat Kamu</h3>
                    <a href="{{ route('address.create') }}" class="bg-black text-white text-[10px] uppercase font-bold px-3 py-1.5 hover:bg-gray-800 transition-colors inline-block">
                        Buat Alamat Baru
                    </a>
                </div>

                @if($address)
                    <div class="border border-gray-300 p-4 flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-bold text-sm">{{ $address->country }}</span>
                            <span class="font-bold text-sm">{{ $address->full_name }}</span>
                        </div>
                        <div class="text-right text-xs text-gray-500 mb-2">No Telp.{{ $address->phone }}</div>
                        <div class="text-xs text-gray-600 space-y-1">
                            <p>{{ $address->address }}</p>
                            <p><span class="inline-block w-20">{{ $address->apartment ?? '-' }}</span> Prov: {{ $address->province }}</p>
                            <p><span class="inline-block w-20">Kota: {{ $address->city }}</span> Kode Pos: {{ $address->zip }}</p>
                        </div>
                    </div>
                @else
                    <div class="border border-gray-300 p-4 flex-1 flex items-center justify-center">
                        <p class="text-gray-400 text-sm">Belum ada alamat. Silakan tambahkan alamat baru.</p>
                    </div>
                @endif
            </div>

            <!-- Logout Button -->
            <div class="mt-8">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda ingin log out?');" class="w-full bg-black text-white py-4 px-6 font-bold uppercase tracking-widest hover:bg-gray-800 transition-all flex items-center justify-center group">
                        <span>Keluar Akun</span>
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
                <h2 class="text-2xl font-normal text-gray-900 mb-8">Status Pemesanan</h2>
                <div class="flex justify-between items-start max-w-2xl">
                    <!-- Status 1 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'menunggu-pembayaran']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['menunggu-pembayaran'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Menunggu<br>Pembayaran</p>
                    </button>
                    <!-- Status 2 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'sedang-dikemas']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['sedang-dikemas'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Sedang<br>Dikemas</p>
                    </button>
                    <!-- Status 3 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'sedang-dikirim']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['sedang-dikirim'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Sedang<br>Dikirim</p>
                    </button>
                    <!-- Status 4 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'pesanan-tiba']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">{{ $statusCounts['pesanan-tiba'] }}</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Pesanan<br>Tiba</p>
                    </button>
                </div>
            </div>

            <!-- Order History -->
            <div>
                <h2 class="text-2xl font-normal text-gray-900 mb-6">Riwayat Pemesanan</h2>
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
                            <p class="text-gray-400 text-sm">Belum ada riwayat pemesanan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
