@extends('customer.layouts.app')

@section('title', 'Order Status - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ uploadModalOpen: false, receivedModalOpen: false }">
    <!-- Title -->
    <div class="text-center mb-16">
        <h1 class="text-3xl font-bold text-gray-900 uppercase tracking-wide">{{ $title }}</h1>
    </div>

    <!-- Order Details -->
    <div class="max-w-4xl mx-auto">
        <div class="border-t border-gray-200 py-12">
                @foreach ($products as $product)
                <div class="py-10 border-b border-gray-100 last:border-0">
                    <div class="flex space-x-8">
                        <div class="h-32 w-32 flex-shrink-0 overflow-hidden bg-gray-50 border border-gray-100">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover">
                        </div>
                        <div class="flex-1 flex justify-between items-start">
                            <div class="max-w-md">
                                <h3 class="text-sm font-bold text-gray-900 uppercase leading-tight">{{ $product['name'] }}</h3>
                                <p class="mt-2 text-xs text-red-500 font-bold uppercase">{{ $product['price'] }}</p>
                                <p class="mt-2 text-xs text-gray-500 font-bold uppercase">Size: {{ $product['size'] }}</p>
                                <p class="mt-1 text-xs text-gray-500 font-bold uppercase">Qty: 1x</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 uppercase">{{ $product['price'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>

        <!-- Total -->
        <div class="border-t border-gray-200 py-6 flex justify-end">
            <div class="flex items-center space-x-2">
                <span class="text-xl font-bold text-gray-900 uppercase">Total:</span>
                <span class="text-xl font-bold text-gray-900 uppercase">Rp11.008.000</span>
            </div>
        </div>

        <!-- Shipping Section (Conditional) -->
        <div class="mt-12 space-y-8">
            @if($status === 'sedang-dikirim')
            <div class="flex flex-col items-end space-y-4">
                <div class="flex items-center space-x-3 text-gray-700">
                    <span class="text-sm font-bold uppercase tracking-widest">No Resi: 1346787577</span>
                    <button class="text-gray-400 hover:text-black transition-colors" onclick="navigator.clipboard.writeText('1346787577')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </button>
                </div>
                <button class="flex items-center space-x-4 border-2 border-gray-400 px-10 py-4 text-gray-400 font-bold uppercase tracking-widest hover:border-black hover:text-black transition-all group">
                    <svg class="w-10 h-10 transition-colors group-hover:text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                    <span class="text-lg">Lacak Pesanan</span>
                </button>
            </div>
            @endif

            @if($status === 'pesanan-tiba')
            <div class="flex justify-end pt-8">
                <button @click="receivedModalOpen = true" class="bg-black text-white px-12 py-4 font-bold text-sm uppercase tracking-widest hover:bg-gray-800 transition-colors">
                    Pesanan Diterima
                </button>
            </div>
            @endif

            @if($status === 'menunggu-pembayaran')
            <div class="flex justify-end pt-8">
                <button @click="uploadModalOpen = true" class="bg-black text-white px-12 py-5 font-bold text-sm uppercase tracking-widest hover:bg-gray-800 transition-colors">
                    Upload Bukti<br>Pembayaran
                </button>
            </div>
            @endif
        </div>
        
        <!-- Bottom Divider to match design -->
        <div class="mt-16 border-t border-gray-200"></div>
    </div>

    <!-- Upload Modal -->
    <template x-if="uploadModalOpen">
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background Backdrop -->
            <div 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" 
                @click="uploadModalOpen = false">
            </div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-4xl border-2 border-black"
                >
                    <!-- Header -->
                    <div class="bg-black px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white uppercase tracking-widest leading-6" id="modal-title">
                            Upload Bukti
                        </h3>
                        <button @click="uploadModalOpen = false" class="text-white hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-8 py-10">
                        <form action="#" method="POST" class="space-y-8">
                            @csrf
                            
                            <!-- Photo Input -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-900 uppercase tracking-[0.2em] mb-4">
                                    Foto Bukti Transfer
                                </label>
                                <div class="group relative border-2 border-dashed border-gray-200 hover:border-black transition-all duration-500 bg-gray-50/50 hover:bg-white p-10 text-center cursor-pointer">
                                    <input type="file" name="payment_proof" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                                    
                                    <div class="space-y-4">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white shadow-sm border border-gray-100 group-hover:bg-black group-hover:border-black transition-all duration-500">
                                            <svg class="h-6 w-6 text-gray-400 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[11px] font-bold text-gray-900 uppercase tracking-widest">Klik untuk upload</p>
                                            <p class="text-[10px] text-gray-400 font-medium">PNG, JPG up to 10MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sender Name -->
                            <div>
                                <label for="sender_name" class="block text-[10px] font-bold text-gray-900 uppercase tracking-[0.2em] mb-4">
                                    Atas Nama Pengirim
                                </label>
                                <input type="text" name="sender_name" id="sender_name" required
                                    class="block w-full border-2 border-gray-100 bg-gray-50/50 px-5 py-4 text-sm focus:border-black focus:bg-white focus:ring-0 transition-all duration-300 placeholder-gray-300 font-medium"
                                    placeholder="MASUKKAN NAMA PEMILIK REKENING">
                            </div>

                            <!-- Action Buttons -->
                            <div class="pt-4 grid grid-cols-2 gap-4">
                                <button type="button" @click="uploadModalOpen = false" class="w-full border-2 border-gray-200 bg-white py-4 font-bold text-gray-900 uppercase tracking-widest text-[10px] hover:border-black hover:bg-black hover:text-white transition-all duration-300">
                                    Batal
                                </button>
                                <button type="submit" class="w-full bg-black border-2 border-black text-white py-4 font-bold uppercase tracking-widest text-[10px] hover:bg-white hover:text-black transition-all duration-300">
                                    Kirim Bukti
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Order Received Confirmation Modal -->
    <template x-if="receivedModalOpen">
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" 
                @click="receivedModalOpen = false">
            </div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-2xl border-2 border-black"
                >
                    <div class="bg-black px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white uppercase tracking-widest leading-6">
                            Konfirmasi Tiba
                        </h3>
                        <button @click="receivedModalOpen = false" class="text-white hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-10 py-12 text-center">
                        <div class="mb-6 flex justify-center">
                            <div class="h-16 w-16 bg-gray-50 rounded-full flex items-center justify-center border border-gray-100">
                                <svg class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xl font-bold text-gray-900 uppercase tracking-widest mb-2">
                            Pesanan Tiba?
                        </p>
                        <p class="text-sm text-gray-500 mb-10 font-medium">
                            Pastikan anda sudah menerima dan mengecek isi paket anda sebelum melakukan konfirmasi.
                        </p>
                        
                        <div class="space-y-3 max-w-sm mx-auto">
                            <a href="{{ route('account.index') }}?received=1" class="w-full bg-black border-2 border-black text-white py-4 font-bold uppercase tracking-widest text-xs hover:bg-white hover:text-black transition-all duration-500 inline-block text-center flex items-center justify-center">
                                Ya, Saya Sudah Terima
                            </a>
                            <button @click="receivedModalOpen = false" class="w-full bg-white border-2 border-gray-100 py-4 font-bold text-gray-400 uppercase tracking-widest text-xs hover:border-gray-300 hover:text-gray-900 transition-all duration-500">
                                Belum, Nanti Saja
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
