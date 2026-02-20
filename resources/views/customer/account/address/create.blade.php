@extends('customer.layouts.app')

@section('title', 'Alamat Baru - Georythm')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Link -->
    <div class="mb-8">
        <a href="{{ route('account.index') }}" class="inline-flex items-center text-gray-500 hover:text-gray-900 transition-colors font-bold text-sm uppercase tracking-widest">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Akun
        </a>
    </div>

    <!-- Page Title -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-900 tracking-tighter uppercase">Alamat Baru</h1>
    </div>

    <!-- Form -->
    <form action="{{ route('address.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Negara/Area -->
        <div>
            <label for="negara" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Negara/Area</label>
            <input type="text" name="negara" id="negara" required
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors"
                placeholder="Indonesia">
        </div>

        <!-- Name Group -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="first_name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Depan</label>
                <input type="text" name="first_name" id="first_name" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
            <div>
                <label for="last_name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Belakang</label>
                <input type="text" name="last_name" id="last_name" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
        </div>

        <!-- No Telp -->
        <div>
            <label for="phone" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">No Telp</label>
            <input type="tel" name="phone" id="phone" required
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors"
                placeholder="08123456789">
        </div>

        <!-- Alamat Lengkap -->
        <div>
            <label for="alamat" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" rows="3" required
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors"
                placeholder="Nama Jalan, RT/RW, dsb"></textarea>
        </div>

        <!-- Nomor Apartemen/Gedung (Optional) -->
        <div>
            <label for="apartemen" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nomor Apartemen/Gedung (Optional)</label>
            <input type="text" name="apartemen" id="apartemen"
                class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
        </div>

        <!-- Location Group -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="kota" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Kota</label>
                <input type="text" name="kota" id="kota" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
            <div>
                <label for="provinsi" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Provinsi</label>
                <input type="text" name="provinsi" id="provinsi" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
            <div>
                <label for="zip" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Kode Pos</label>
                <input type="text" name="zip" id="zip" required
                    class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-black transition-colors">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-6">
            <button type="submit" class="w-full bg-black text-white py-4 font-bold uppercase tracking-[0.2em] hover:bg-gray-800 transition-colors">
                Tambah
            </button>
        </div>
    </form>
</div>
@endsection
