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
                    <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">B</div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">bagoeshutomo@gmail.com</p>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-500">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>
            </div>

            <!-- Address Section -->
            <div class="mb-10">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Alamat Pengiriman</h2>
                <div class="border border-black p-6 relative">
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

            <!-- Shipping Section -->
            <div class="mb-10">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Pengiriman</h2>
                <div class="space-y-4">
                    <!-- Option 1 -->
                    <label class="relative flex items-center justify-between border border-black p-4 cursor-pointer">
                        <div class="flex items-center">
                            <input type="radio" name="shipping" class="h-4 w-4 text-black border-gray-300 focus:ring-black" checked>
                            <div class="ml-4">
                                <span class="block text-sm font-medium text-gray-900">JNE Express</span>
                                <span class="block text-xs text-gray-500">3 sampai 6 hari kerja</span>
                                <span class="block text-xs text-gray-400">JNE Express</span>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-gray-900">Rp10.000</span>
                    </label>

                    <!-- Option 2 -->
                    <label class="relative flex items-center justify-between border border-gray-200 p-4 cursor-pointer hover:border-gray-300">
                        <div class="flex items-center">
                            <input type="radio" name="shipping" class="h-4 w-4 text-black border-gray-300 focus:ring-black">
                            <div class="ml-4">
                                <span class="block text-sm font-medium text-gray-900">JNE Next Day</span>
                                <span class="block text-xs text-gray-500">1 sampai 4 hari kerja</span>
                                <span class="block text-xs text-gray-400">JNE Express & JNE Next Day</span>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-gray-900">Rp40.000</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <a href="{{ route('order.status') }}" class="block w-full text-center bg-black text-white py-4 font-bold uppercase tracking-widest hover:bg-gray-900 transition-colors mb-4">
                Bayar Sekarang
            </a>
            <p class="text-xs text-gray-400 text-center">Upload bukti Pembayaran di halaman Akun</p>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-5 mt-10 lg:mt-0">
            <div class="bg-gray-50 p-6 rounded-none">
                <!-- Product List -->
                <div class="space-y-6 mb-8">
                    <div class="flex space-x-4">
                        <div class="h-20 w-16 bg-white overflow-hidden rounded-md border border-gray-200">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Product" class="h-full w-full object-cover object-center">
                        </div>
                        <div class="flex-1 flex justify-between text-sm">
                            <div>
                                <h3 class="font-medium text-gray-900 uppercase">NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN BLACK</h3>
                                <p class="text-gray-500 mt-1">XL</p>
                                <p class="text-gray-500">1X</p>
                            </div>
                            <p class="font-medium text-gray-900">Rp6.999.000</p>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="h-20 w-16 bg-white overflow-hidden rounded-md border border-gray-200">
                            <img src="https://images.unsplash.com/photo-1559551409-dadc959f76b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Product" class="h-full w-full object-cover object-center">
                        </div>
                        <div class="flex-1 flex justify-between text-sm">
                            <div>
                                <h3 class="font-medium text-gray-900 uppercase">NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN White</h3>
                                <p class="text-gray-500 mt-1">M</p>
                                <p class="text-gray-500">1X</p>
                            </div>
                            <p class="font-medium text-gray-900">Rp3.999.000</p>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div class="border-t border-gray-200 pt-6 space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal • 2 item</span>
                        <span class="font-bold text-gray-900">Rp10.998.000</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Pengiriman</span>
                        <span class="font-bold text-gray-900">Rp10.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <span class="text-2xl font-bold text-gray-900">Total</span>
                        <div class="text-right">
                            <span class="text-xs text-gray-500 mr-1">IDR</span>
                            <span class="text-2xl font-bold text-gray-900">11.008.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mt-8 grid grid-cols-3 gap-4">
                <!-- Mandiri -->
                <div class="border border-black rounded-lg p-4 flex flex-col items-center justify-between aspect-[3/4]">
                    <span class="font-bold text-blue-800 italic">mandiri</span>

                    <div
                        class="copy-btn w-full border border-gray-300 rounded px-2 py-1 flex justify-between items-center text-xs cursor-pointer"
                        data-copy="00123465477"
                    >
                        <span>00123465477</span>
                        📋
                    </div>

                    <p
                        class="copy-btn font-bold text-sm cursor-pointer"
                        data-copy="11008000"
                    >
                        11.008.000
                    </p>
                </div>

                <!-- BRI -->
                <div class="border border-black rounded-lg p-4 flex flex-col items-center justify-between aspect-[3/4]">
                    <span class="font-bold text-blue-600">BRI</span>

                    <div
                        class="copy-btn w-full border border-gray-300 rounded px-2 py-1 flex justify-between items-center text-xs cursor-pointer"
                        data-copy="12345432139"
                    >
                        <span>12345432139</span>
                        📋
                    </div>

                    <p
                        class="copy-btn font-bold text-sm cursor-pointer"
                        data-copy="11008000"
                    >
                        11.008.000
                    </p>
                </div>

                <!-- BCA -->
                <div class="border border-black rounded-lg p-4 flex flex-col items-center justify-between aspect-[3/4]">
                    <span class="font-bold text-blue-700">BCA</span>

                    <div
                        class="copy-btn w-full border border-gray-300 rounded px-2 py-1 flex justify-between items-center text-xs cursor-pointer"
                        data-copy="00123465477"
                    >
                        <span>00123465477</span>
                        📋
                    </div>

                    <p
                        class="copy-btn font-bold text-sm cursor-pointer"
                        data-copy="11008000"
                    >
                        11.008.000
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT COPY --}}
<script>
document.querySelectorAll('.copy-btn').forEach(el => {
    el.addEventListener('click', () => {
        const text = el.dataset.copy;
        navigator.clipboard.writeText(text);

        const original = el.innerText;
        el.innerText = 'Copied!';
        setTimeout(() => el.innerText = original, 1000);
    });
});
</script>
@endsection