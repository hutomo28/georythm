@extends('customer.layouts.app')

@section('title', 'New Address - Georythm')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Link -->
    <div class="mb-8">
        <a href="{{ route('account.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-900 transition-colors font-bold text-sm uppercase tracking-widest">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Account
        </a>
    </div>

    <!-- Page Title -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-900 tracking-tighter uppercase">New Address</h1>
    </div>

    <!-- Form -->
    <form action="{{ route('address.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Country/Area -->
        <div>
            <label for="country" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Country/Area</label>
            <input type="text" name="country" id="country" required
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors"
                placeholder="Indonesia">
        </div>

        <!-- Name Group -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="first_name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">First Name</label>
                <input type="text" name="first_name" id="first_name" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
            <div>
                <label for="last_name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Last Name</label>
                <input type="text" name="last_name" id="last_name" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
        </div>

        <!-- No Telp -->
        <div>
            <label for="phone" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Phone Number</label>
            <input type="tel" name="phone" id="phone" required
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors"
                placeholder="08123456789">
        </div>

        <!-- Complete Address -->
        <div>
            <label for="address" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Complete Address</label>
            <textarea name="address" id="address" rows="3" required
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors"
                placeholder="Street Name, Unit, etc."></textarea>
        </div>

        <!-- Apartment/Building Number (Optional) -->
        <div>
            <label for="apartment" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Apartment/Building Number (Optional)</label>
            <input type="text" name="apartment" id="apartment"
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
        </div>

        <!-- Location Group -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="city" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">City</label>
                <input type="text" name="city" id="city" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
            <div>
                <label for="province" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Province</label>
                <input type="text" name="province" id="province" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
            <div>
                <label for="zip" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Zip Code</label>
                <input type="text" name="zip" id="zip" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
        </div>



        <!-- Submit Button -->
        <div class="pt-6">
            <button type="submit" class="w-full bg-black text-white py-4 font-bold uppercase tracking-[0.2em] hover:bg-gray-800 transition-colors">
                Add
            </button>
        </div>
    </form>
</div>
@endsection
