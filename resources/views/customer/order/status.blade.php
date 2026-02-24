@extends('customer.layouts.app')

@section('title', 'Order Status - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Title -->
    <div class="text-center mb-16">
        <h1 class="text-3xl font-bold text-gray-900 uppercase tracking-wide">{{ $title }}</h1>
    </div>

    <!-- Order List -->
    <div class="max-w-4xl mx-auto space-y-16">
@forelse($orders as $order)
            <div class="border border-gray-200 p-8 shadow-sm bg-white relative" x-data="{ localUploadModalOpen: false, localReceivedModalOpen: false }">
                <!-- Order Header Info -->
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order Number</p>
                        <h2 class="text-sm font-bold text-gray-900 uppercase">{{ $order->order_number }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</p>
                        <p class="text-xs font-bold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Items -->
                <div class="space-y-6">
                    @foreach($order->items as $item)
                        <div class="flex space-x-6 items-center">
                            <!-- Product image -->
                            <div class="w-20 h-28 bg-gray-50 flex-shrink-0 border border-gray-100 overflow-hidden">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-full h-full object-center object-cover">
                            </div>

                            <!-- Product info -->
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-1">{{ $item->product_name }}</h4>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $item->size }}</p>
                                        <p class="mt-1 text-[10px] text-gray-500 font-bold uppercase">Qty: {{ $item->quantity }}x</p>
                                    </div>
                                    <p class="text-xs font-bold text-red-500 uppercase tracking-widest">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer / Actions -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-end sm:items-center space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-gray-900 uppercase">Total:</span>
                        <span class="text-lg font-bold text-gray-900 uppercase">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex flex-col items-end space-y-3">
                        @if($status === 'shipped')
                            <div class="flex items-center space-x-3 text-gray-700" x-data="{ copied: false }">
                                <span class="text-[11px] font-bold uppercase tracking-widest">Receipt: {{ $order->receipt_number }}</span>
                                <button 
                                    @click="navigator.clipboard.writeText('{{ $order->receipt_number }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="text-gray-400 hover:text-black transition-all focus:outline-none flex items-center space-x-1 group/copy"
                                    title="Copy Receipt Number"
                                >
                                    <svg x-show="!copied" class="w-4 h-4 transition-transform group-hover/copy:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                    </svg>
                                    <svg x-show="copied" x-cloak class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span x-show="copied" x-cloak class="text-[10px] text-green-500 font-bold uppercase tracking-widest">Copied!</span>
                                </button>
                            </div>
                            <a href="{{ $order->tracking_link }}" target="_blank" class="flex items-center space-x-3 bg-black text-white px-6 py-3 font-bold uppercase tracking-widest text-[10px] hover:bg-gray-800 transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                </svg>
                                <span>Track Order</span>
                            </a>
                        @elseif($status === 'arrived')
                            <button @click="localReceivedModalOpen = true" class="bg-black text-white px-8 py-3 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-800 transition-colors">
                                Order Received
                            </button>
                        @elseif($status === 'waiting-payment')
                            <button @click="localUploadModalOpen = true" class="bg-black text-white px-8 py-3 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-800 transition-colors">
                                Upload Payment Proof
                            </button>
                        @endif
                    </div>
                </div>

                @if($status === 'waiting-payment')
                {{-- Bank Transfer Info --}}
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Transfer to one of the following accounts:</p>
                    <div class="space-y-3">

                        {{-- Mandiri --}}
                        <div class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-lg px-5 py-4 hover:border-black dark:hover:border-zinc-400 transition-all group">
                            <div class="flex items-center space-x-4 min-w-[90px]">
                                <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[9px] font-black text-yellow-900 uppercase leading-none text-center">MDR</span>
                                </div>
                                <span class="text-xs font-black text-blue-800 dark:text-blue-400 uppercase tracking-tight">Mandiri</span>
                            </div>
                            <div class="flex-1 text-center px-4">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-0.5">Account Number</p>
                                <div class="copy-btn flex items-center justify-center space-x-2 cursor-pointer group/copy" data-copy="00123465477">
                                    <code class="text-sm font-bold text-gray-900 dark:text-slate-100 tracking-widest group-hover/copy:text-yellow-600 transition-colors">001 2346 5477</code>
                                    <span class="text-gray-300 dark:text-zinc-600 group-hover/copy:text-yellow-500 transition-colors text-xs">📋</span>
                                </div>
                            </div>
                            <div class="text-right min-w-[110px]">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-0.5">Total Transfer</p>
                                <p class="copy-btn text-sm font-bold text-gray-900 dark:text-slate-100 cursor-pointer hover:text-yellow-600 transition-colors" data-copy="{{ $order->total }}">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- BRI --}}
                        <div class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-lg px-5 py-4 hover:border-black dark:hover:border-zinc-400 transition-all group">
                            <div class="flex items-center space-x-4 min-w-[90px]">
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[9px] font-black text-white uppercase leading-none">BRI</span>
                                </div>
                                <span class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-tight">BRI</span>
                            </div>
                            <div class="flex-1 text-center px-4">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-0.5">Account Number</p>
                                <div class="copy-btn flex items-center justify-center space-x-2 cursor-pointer group/copy" data-copy="12345432139">
                                    <code class="text-sm font-bold text-gray-900 dark:text-slate-100 tracking-widest group-hover/copy:text-yellow-600 transition-colors">1234 5432 139</code>
                                    <span class="text-gray-300 dark:text-zinc-600 group-hover/copy:text-yellow-500 transition-colors text-xs">📋</span>
                                </div>
                            </div>
                            <div class="text-right min-w-[110px]">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-0.5">Total Transfer</p>
                                <p class="copy-btn text-sm font-bold text-gray-900 dark:text-slate-100 cursor-pointer hover:text-yellow-600 transition-colors" data-copy="{{ $order->total }}">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- BCA --}}
                        <div class="flex items-center justify-between border border-gray-200 dark:border-zinc-700 rounded-lg px-5 py-4 hover:border-black dark:hover:border-zinc-400 transition-all group">
                            <div class="flex items-center space-x-4 min-w-[90px]">
                                <div class="w-8 h-8 rounded-full bg-blue-700 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[9px] font-black text-white uppercase leading-none">BCA</span>
                                </div>
                                <span class="text-xs font-black text-blue-700 dark:text-blue-400 uppercase tracking-tight">BCA</span>
                            </div>
                            <div class="flex-1 text-center px-4">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-0.5">Account Number</p>
                                <div class="copy-btn flex items-center justify-center space-x-2 cursor-pointer group/copy" data-copy="00123465477">
                                    <code class="text-sm font-bold text-gray-900 dark:text-slate-100 tracking-widest group-hover/copy:text-yellow-600 transition-colors">001 2346 5477</code>
                                    <span class="text-gray-300 dark:text-zinc-600 group-hover/copy:text-yellow-500 transition-colors text-xs">📋</span>
                                </div>
                            </div>
                            <div class="text-right min-w-[110px]">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-0.5">Total Transfer</p>
                                <p class="copy-btn text-sm font-bold text-gray-900 dark:text-slate-100 cursor-pointer hover:text-yellow-600 transition-colors" data-copy="{{ $order->total }}">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                    </div>
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-3 text-center">Click any number or amount to copy it</p>
                </div>
                @endif


                {{-- Script copy (hanya aktif jika ada elemen .copy-btn) --}}
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

                <!-- Upload Modal -->
                <template x-if="localUploadModalOpen">
                    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" @click="localUploadModalOpen = false"></div>
                        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                            <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-4xl border-2 border-black">
                                <div class="bg-black px-6 py-4 flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-white uppercase tracking-widest leading-6">Upload Proof - {{ $order->order_number }}</h3>
                                    <button @click="localUploadModalOpen = false" class="text-white hover:text-gray-300 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                <div class="px-8 py-10">
                                    <form action="{{ route('order.upload-payment', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                                        @csrf
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-900 uppercase tracking-[0.2em] mb-4">Transfer Proof Photo</label>
                                            <div class="group relative border-2 border-dashed border-gray-200 hover:border-black transition-all duration-500 bg-gray-50/50 hover:bg-white p-10 text-center cursor-pointer">
                                                <input type="file" name="payment_proof" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                                                <div class="space-y-4">
                                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white shadow-sm border border-gray-100 group-hover:bg-black group-hover:border-black transition-all duration-500">
                                                        <svg class="h-6 w-6 text-gray-400 group-hover:text-white transition-colors duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    </div>
                                                    <div class="space-y-1">
                                                        <p class="text-[11px] font-bold text-gray-900 uppercase tracking-widest">Click to upload</p>
                                                        <p class="text-[10px] text-gray-400 font-medium">PNG, JPG up to 10MB</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="sender_name" class="block text-[10px] font-bold text-gray-900 uppercase tracking-[0.2em] mb-4">Sender Account Name</label>
                                            <input type="text" name="sender_name" id="sender_name" required class="block w-full border-2 border-gray-100 bg-gray-50/50 px-5 py-4 text-sm focus:border-black focus:bg-white focus:ring-0 transition-all duration-300 placeholder-gray-300 font-medium" placeholder="ENTER ACCOUNT HOLDER NAME">
                                        </div>
                                        <div class="pt-4 grid grid-cols-2 gap-4">
                                            <button type="button" @click="localUploadModalOpen = false" class="w-full border-2 border-gray-200 bg-white py-4 font-bold text-gray-900 uppercase tracking-widest text-[10px] hover:border-black hover:bg-black hover:text-white transition-all duration-300">Cancel</button>
                                            <button type="submit" class="w-full bg-black border-2 border-black text-white py-4 font-bold uppercase tracking-widest text-[10px] hover:bg-white hover:text-black transition-all duration-300">Submit Proof</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Received Modal -->
                <template x-if="localReceivedModalOpen">
                    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" @click="localReceivedModalOpen = false"></div>
                        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                            <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-2xl border-2 border-black">
                                <div class="bg-black px-6 py-4 flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-white uppercase tracking-widest leading-6">Arrival Confirmation - {{ $order->order_number }}</h3>
                                    <button @click="localReceivedModalOpen = false" class="text-white hover:text-gray-300 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                <div class="px-10 py-12 text-center">
                                    <div class="mb-6 flex justify-center">
                                        <div class="h-16 w-16 bg-gray-50 rounded-full flex items-center justify-center border border-gray-100">
                                            <svg class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                        </div>
                                    </div>
                                    <p class="text-xl font-bold text-gray-900 uppercase tracking-widest mb-2">Order Arrived?</p>
                                    <p class="text-sm text-gray-500 mb-10 font-medium">Ensure you have received and checked your package before confirming.</p>
                                    <div class="space-y-3 max-w-sm mx-auto">
                                        <form action="{{ route('order.confirm-received', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-black border-2 border-black text-white py-4 font-bold uppercase tracking-widest text-xs hover:bg-white hover:text-black transition-all duration-500 flex items-center justify-center">
                                                Yes, I Received It
                                            </button>
                                        </form>
                                        <button @click="localReceivedModalOpen = false" class="w-full bg-white border-2 border-gray-100 py-4 font-bold text-gray-400 uppercase tracking-widest text-xs hover:border-gray-300 hover:text-gray-900 transition-all duration-500">
                                            Not Yet, Later
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        @empty
            <div class="py-20 text-center">
                <p class="text-gray-400 font-bold uppercase tracking-widest text-sm mb-6">No orders in this status yet</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-black text-white px-10 py-4 font-bold uppercase tracking-widest text-[10px] hover:bg-gray-900 transition-colors">
                    Start Shopping
                </a>
            </div>
        @endforelse
    </div>
    </div>
@endsection
