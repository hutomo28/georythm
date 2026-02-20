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
                    <span class="font-bold italic">Hallo,</span> Bagoes Hutomo
                </p>
                <p class="text-xl text-gray-900">
                    <span class="font-bold italic">Email Kamu,</span> bagoeshutomo@gmail.com
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

                <div class="border border-gray-300 p-4 flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-bold text-sm">Indonesia</span>
                        <span class="font-bold text-sm">Bagoes Hutomo</span>
                    </div>
                    <div class="text-right text-xs text-gray-500 mb-2">No Telp.09998887776891</div>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p>Jl.Biru,RT03/RW06,No 20,Kel.Merah,Kec.Oren,Kota Pelangi</p>
                        <p><span class="inline-block w-20">No.20</span> Prov: Gradasi</p>
                        <p><span class="inline-block w-20">Kota: Pelangi</span> Kode Pos: 11223</p>
                    </div>
                </div>
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
                            <span class="text-3xl font-bold">2</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Menunggu<br>Pembayaran</p>
                    </button>
                    <!-- Status 2 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'sedang-dikemas']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">0</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Sedang<br>Dikemas</p>
                    </button>
                    <!-- Status 3 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'sedang-dikirim']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">1</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Sedang<br>Dikirim</p>
                    </button>
                    <!-- Status 4 -->
                    <button class="text-center group cursor-pointer focus:outline-none transition-transform hover:scale-105" onclick="window.location.href='{{ route('order.status', ['status' => 'pesanan-tiba']) }}'">
                        <div class="w-20 h-20 rounded-full border-2 border-black flex items-center justify-center mb-3 mx-auto transition-colors group-hover:bg-black group-hover:text-white">
                            <span class="text-3xl font-bold">0</span>
                        </div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">Pesanan<br>Tiba</p>
                    </button>
                </div>
            </div>

            <!-- Order History -->
            <div>
                <h2 class="text-2xl font-normal text-gray-900 mb-6">Riwayat Pemesanan</h2>
                <div class="border-t border-black">
                    <!-- Order Item 1 -->
                    <div class="py-6 border-b border-gray-200">
                        <div class="flex space-x-6">
                            <div class="w-24 h-28 bg-gray-100 flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Product" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-xs text-gray-900 uppercase leading-relaxed mb-1">
                                    NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN BLACK
                                </h3>
                                <p class="text-red-500 font-bold text-xs mb-1">RP6.999.000</p>
                                <p class="text-xs text-gray-500 mb-0.5">XL</p>
                                <p class="text-xs text-gray-500">1x</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Item 2 -->
                    <div class="py-6 border-b border-black">
                        <div class="flex space-x-6">
                            <div class="w-24 h-28 bg-gray-100 flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Product" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-xs text-gray-900 uppercase leading-relaxed mb-1">
                                    NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN White
                                </h3>
                                <p class="text-red-500 font-bold text-xs mb-1">RP3.999.000</p>
                                <p class="text-xs text-gray-500 mb-0.5">M</p>
                                <p class="text-xs text-gray-500">1x</p>
                            </div>
                        </div>
                        <div class="text-right mt-4">
                            <p class="text-sm font-bold text-gray-900">Total: Rp11.008.000</p>
                        </div>
                    </div>

                    <!-- Order Item 3 (History) -->
                    <div class="py-6">
                        <div class="flex space-x-6">
                            <div class="w-24 h-28 bg-gray-100 flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1547996160-81f9608c3a99?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Product" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-xs text-gray-900 uppercase leading-relaxed mb-1">
                                    Arcteryx- Beta LT Gore-Tex Jacket Mens Medium 30165
                                </h3>
                                <p class="text-red-500 font-bold text-xs mb-1">RP5.390.000</p>
                                <p class="text-xs text-gray-500 mb-0.5">M</p>
                                <p class="text-xs text-gray-500">1x</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
