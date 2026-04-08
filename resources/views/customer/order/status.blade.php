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
            <div class="border border-gray-200 p-8 shadow-sm bg-white relative" x-data="{ localUploadModalOpen: false, localCancelModalOpen: false }">
                <!-- Order Header Info -->
                <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('customer.order_number') }}</p>
                        <h2 class="text-sm font-bold text-gray-900 uppercase">{{ $order->order_number }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('customer.date') }}</p>
                        <p class="text-xs font-bold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                        
                        @if($status === 'waiting-payment')
                            <div class="mt-2" x-data="{ 
                                deadline: new Date('{{ $order->created_at->addHours(24)->toIso8601String() }}').getTime(),
                                timeBox: 'Loading...',
                                init() {
                                    this.updateTime();
                                    setInterval(() => this.updateTime(), 1000);
                                },
                                updateTime() {
                                    const now = new Date().getTime();
                                    const distance = this.deadline - now;
                                    
                                    if (distance < 0) {
                                        this.timeBox = 'EXPIRED';
                                        return;
                                    }
                                    
                                    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    const s = Math.floor((distance % (1000 * 60)) / 1000);
                                    
                                    this.timeBox = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
                                }
                            }">
                                <p class="text-[9px] font-bold text-red-500 uppercase tracking-widest mb-1">{{ __('customer.time_remaining') }}</p>
                                <p class="text-xs font-black text-red-600 bg-red-50 py-1 px-3 inline-block" x-text="timeBox"></p>
                            </div>
                        @elseif($status === 'arrived' && $order->arrived_at)
                            <div class="mt-2" x-data="{ 
                                deadline: new Date('{{ $order->arrived_at->addHours(48)->toIso8601String() }}').getTime(),
                                timeBox: 'Loading...',
                                init() {
                                    this.updateTime();
                                    setInterval(() => this.updateTime(), 1000);
                                },
                                updateTime() {
                                    const now = new Date().getTime();
                                    const distance = this.deadline - now;
                                    
                                    if (distance < 0) {
                                        this.timeBox = 'COMPLETING...';
                                        window.location.reload();
                                        return;
                                    }
                                    
                                    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    const s = Math.floor((distance % (1000 * 60)) / 1000);
                                    
                                    this.timeBox = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
                                }
                            }">
                                <p class="text-[9px] font-bold text-green-500 uppercase tracking-widest mb-1">{{ __('customer.auto_complete_label') }}</p>
                                <p class="text-xs font-black text-green-600 bg-green-50 py-1 px-3 inline-block" x-text="timeBox"></p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Items -->
                <div class="space-y-6">
                    @foreach($order->items as $item)
                        <div class="flex space-x-6 items-center">
                            <!-- Product image -->
                            <div class="w-20 h-28 bg-gray-50 flex-shrink-0 border border-gray-100 overflow-hidden">
                                <img src="{{ $item->product ? $item->product->image : 'https://placehold.co/600x800/f3f4f6/000000?text=DELETED' }}" alt="{{ $item->product_name }}" class="w-full h-full object-center object-cover">
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

                @if($status === 'cancelled' && $order->cancellation_reason)
                <div class="mt-6 pt-4 border-t border-red-100 bg-red-50/50 -mx-8 px-8 py-4 -mb-2">
                    <p class="text-[10px] font-bold text-red-400 uppercase tracking-widest mb-2">Cancellation Reason</p>
                    <p class="text-sm text-red-600 font-medium italic">"{{ $order->cancellation_reason }}"</p>
                </div>
                @endif

                <!-- Footer / Actions -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-end sm:items-center space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-gray-900 uppercase">Total:</span>
                        <span class="text-lg font-bold text-gray-900 uppercase">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex flex-col items-end space-y-3">
                        @if($status === 'shipped')
                            <div class="flex items-center space-x-3 text-gray-700" x-data="{ copied: false }">
                                <span class="text-[11px] font-bold uppercase tracking-widest">Shipping Number: {{ $order->receipt_number }}</span>
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
                                    <span x-show="copied" x-cloak class="text-[10px] text-green-500 font-bold uppercase tracking-widest">OK!</span>
                                </button>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ $order->tracking_link ?? '#' }}" target="_blank" class="flex items-center space-x-3 border-2 border-black text-black px-6 py-3 font-bold uppercase tracking-widest text-[10px] hover:bg-black hover:text-white transition-all transition-all duration-300">
                                    {{ __('customer.track_order') }}
                                </a>
                            </div>
                        @elseif($status === 'arrived')
                            {{-- Button removed as per user request --}}
                        @elseif($status === 'completed')
                            <a href="{{ route('order.review', $order->id) }}" class="bg-black text-white px-8 py-3 font-bold text-[10px] uppercase tracking-widest border-2 border-black hover:bg-white hover:text-black transition-all duration-300">
                                {{ __('customer.give_review') }}
                            </a>
                        @elseif($status === 'waiting-payment')
                            <div class="flex space-x-3">
                                <button @click="localCancelModalOpen = true" class="border-2 border-red-500 text-red-500 px-6 py-3 font-bold text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all duration-300">
                                    {{ __('customer.cancel_order') }}
                                </button>
                                <button @click="localUploadModalOpen = true" class="bg-black text-white px-8 py-3 font-bold text-[10px] uppercase tracking-widest hover:bg-gray-800 transition-colors">
                                    {{ __('customer.upload_payment') }}
                                </button>
                            </div>
                        @elseif($status === 'processing')
                            <button @click="localCancelModalOpen = true" class="border-2 border-red-500 text-red-500 px-6 py-3 font-bold text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all duration-300">
                                Cancel Order
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
                                <p class="copy-btn text-sm font-bold text-gray-900 dark:text-slate-100 cursor-pointer hover:text-yellow-600 transition-colors" data-copy="{{ intval($order->total) }}">
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
                                <p class="copy-btn text-sm font-bold text-gray-900 dark:text-slate-100 cursor-pointer hover:text-yellow-600 transition-colors" data-copy="{{ intval($order->total) }}">
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
                                <p class="copy-btn text-sm font-bold text-gray-900 dark:text-slate-100 cursor-pointer hover:text-yellow-600 transition-colors" data-copy="{{ intval($order->total) }}">
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
                        
                        // Don't replace content, show a temporary badge instead
                        if (el.querySelector('.copied-badge')) return; // prevent duplicates
                        
                        const badge = document.createElement('span');
                        badge.className = 'copied-badge';
                        badge.innerText = '✓ Copied!';
                        badge.style.cssText = 'position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#000;color:#fff;font-size:10px;font-weight:800;padding:4px 12px;border-radius:4px;z-index:10;letter-spacing:1px;text-transform:uppercase;pointer-events:none;animation:fadeInOut 2s ease forwards;';
                        
                        el.style.position = 'relative';
                        el.appendChild(badge);
                        
                        setTimeout(() => {
                            badge.remove();
                        }, 2000);
                    });
                });
                </script>
                <style>
                @keyframes fadeInOut {
                    0% { opacity: 0; transform: translate(-50%,-50%) scale(0.8); }
                    15% { opacity: 1; transform: translate(-50%,-50%) scale(1); }
                    75% { opacity: 1; transform: translate(-50%,-50%) scale(1); }
                    100% { opacity: 0; transform: translate(-50%,-50%) scale(0.8); }
                }
                </style>

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

                </template>

                <!-- Cancel Order Modal -->
                <template x-if="localCancelModalOpen">
                    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" @click="localCancelModalOpen = false"></div>
                        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                            <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-2xl border-2 border-red-500">
                                <div class="bg-red-500 px-6 py-4 flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-white uppercase tracking-widest leading-6">Cancel Order - {{ $order->order_number }}</h3>
                                    <button @click="localCancelModalOpen = false" class="text-white hover:text-red-200 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                <div class="px-8 py-10">
                                    <div class="mb-6 flex justify-center">
                                        <div class="h-16 w-16 bg-red-50 rounded-full flex items-center justify-center border border-red-100">
                                            <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                                        </div>
                                    </div>
                                    <p class="text-center text-xl font-bold text-gray-900 uppercase tracking-widest mb-2">Cancel This Order?</p>
                                    <p class="text-center text-sm text-gray-500 mb-8 font-medium">Please provide a reason for cancellation. This will be sent to the admin.</p>
                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="space-y-6">
                                        @csrf
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-900 uppercase tracking-[0.2em] mb-3">Cancellation Reason <span class="text-red-500">*</span></label>
                                            <textarea name="cancellation_reason" rows="4" required
                                                class="block w-full border-2 border-gray-100 bg-gray-50/50 px-5 py-4 text-sm focus:border-red-500 focus:bg-white focus:ring-0 transition-all duration-300 placeholder-gray-300 font-medium resize-none"
                                                placeholder="Example: I changed my mind, ordered wrong size, found a better price, etc."></textarea>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <button type="button" @click="localCancelModalOpen = false" class="w-full border-2 border-gray-200 bg-white py-4 font-bold text-gray-900 uppercase tracking-widest text-[10px] hover:border-black hover:bg-black hover:text-white transition-all duration-300">Keep Order</button>
                                            <button type="submit" class="w-full bg-red-500 border-2 border-red-500 text-white py-4 font-bold uppercase tracking-widest text-[10px] hover:bg-red-600 hover:border-red-600 transition-all duration-300">Confirm Cancel</button>
                                        </div>
                                    </form>
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
