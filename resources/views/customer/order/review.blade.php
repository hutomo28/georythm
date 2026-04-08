@extends('customer.layouts.app')

@section('title', 'Rate Products - Georythm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:pt-32">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 uppercase tracking-tight mb-4">Review Your Order</h2>
            <p class="text-sm text-gray-500 uppercase tracking-widest">Order #{{ $order->order_number }}</p>
            <div class="w-12 h-1 bg-yellow-500 mx-auto mt-6"></div>
        </div>

        <form action="{{ route('order.review.store', $order->id) }}" method="POST" class="space-y-12">
            @csrf
            
            @foreach($order->items as $item)
            <div class="bg-white border border-gray-100 p-8 shadow-sm">
                <div class="flex items-center space-x-6 mb-8 text-left">
                    <div class="w-16 h-20 flex-shrink-0 bg-gray-50 border border-gray-100 overflow-hidden">
                        <img src="{{ $item->product ? $item->product->image : 'https://placehold.co/600x800/f3f4f6/000000?text=DEL' }}" alt="{{ $item->product ? $item->product->name : 'Deleted Product' }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-1">{{ $item->product_name }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $item->size }}</p>
                    </div>
                </div>

                <div class="space-y-10">
                    {{-- Star Rating --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-900 uppercase tracking-[0.3em] mb-6">Your Rating</label>
                        <div class="flex items-center justify-center p-8" x-data="{ rating: 0, hover: 0 }">
                            <input type="hidden" name="ratings[{{ $item->product_id }}]" x-model="rating" required>
                            
                            {{-- Pill Container matching the example image --}}
                            <div class="bg-white px-10 py-4 rounded-full shadow-md border border-gray-100 flex items-center space-x-6">
                                {{-- Rating Number on the LEFT --}}
                                <div class="flex items-baseline">
                                    <span class="text-4xl font-bold text-gray-900 tracking-tighter" x-text="rating > 0 ? rating + '.0' : '-'"></span>
                                </div>

                                {{-- Stars on the RIGHT --}}
                                <div class="flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                        @click="rating = {{ $i }}" 
                                        @mouseenter="hover = {{ $i }}" 
                                        @mouseleave="hover = 0"
                                        class="focus:outline-none transition-all duration-200 transform hover:scale-110">
                                        <i class="fa-star text-3xl cursor-pointer" 
                                           :class="(hover || rating) >= {{ $i }} ? 'fa-solid' : 'fa-regular'"
                                           :style="(hover || rating) >= {{ $i }} ? 'color: #FFCC00;' : 'color: #E5E7EB;'"></i>
                                    </button>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Text Review --}}
                    <div>
                        <label for="comment_{{ $item->id }}" class="block text-[10px] font-bold text-gray-900 uppercase tracking-[0.3em] mb-6">Ulasan Product</label>
                        <textarea 
                            name="comments[{{ $item->product_id }}]" 
                            id="comment_{{ $item->id }}" 
                            rows="4" 
                            class="block w-full border-2 border-gray-800 bg-white px-5 py-4 text-sm focus:border-yellow-500 focus:ring-0 transition-all duration-300 placeholder-gray-400 font-medium"
                            placeholder="Tulis ulasan Anda di sini... (Contoh: Bahan bagus, sizenya pas!)"
                        ></textarea>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="pt-8">
                <button type="submit" class="w-full bg-black text-white py-5 font-bold uppercase tracking-widest text-sm hover:bg-gray-800 transition-all duration-500 shadow-lg">
                    Submit All Reviews
                </button>
                <div class="mt-4 text-center">
                    <a href="{{ route('order.status', ['status' => 'completed']) }}" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-black transition-colors">Skip for now</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
