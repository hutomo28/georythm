@extends('admin.layouts.admin')

@section('title', 'Deleted Products History')

@section('content')
@php $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer'; @endphp
<div class="mb-4 flex items-center text-sm font-bold text-gray-500">
    <a href="{{ route($routePrefix . '.products') }}" class="hover:text-black dark:hover:text-white transition-colors">Products</a>
    <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
    <span class="text-black dark:text-white">Deleted History</span>
</div>

<div class="header-actions">
    <div>
        <h2 class="page-title">Deleted Products History</h2>
        <p class="page-subtitle">View and restore products that have been removed</p>
    </div>
</div>

@if($errors->any() || session('error'))
<div style="background-color: #FEE2E2; border: 2px solid #EF4444; border-radius: 12px; padding: 15px; margin-bottom: 20px; box-shadow: 6px 6px 0px #000;">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
        <i class="fa-solid fa-circle-exclamation" style="color: #EF4444; font-size: 18px;"></i>
        <h4 style="color: #991B1B; font-weight: 800; text-transform: uppercase; font-size: 14px;">Product Update Failed</h4>
    </div>
    <ul style="margin: 0; padding-left: 25px; color: #B91C1C; font-size: 13px; font-weight: 600;">
        @if(session('error')) <li>{{ session('error') }}</li> @endif
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="table-container">
    <table class="responsive-table">
        <thead>
            <tr>
                <th>{{ __('admin.product_name') }}</th>
                <th>{{ __('admin.category') }}</th>
                <th>{{ __('admin.price') }}</th>
                <th>{{ __('admin.stock') }}</th>
                <th>{{ __('admin.status') }}</th>
                @if(auth()->user()->isAdmin() || auth()->user()->isOfficer())
                <th style="text-align: center;">{{ __('admin.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            @php
                $status = 'Deleted';
                $statusColor = '#EF4444';
            @endphp
            <tr style="border-bottom: 1px solid var(--border-color); opacity: 0.8;">
                <td style="padding: 15px 20px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ $product->image }}" alt="" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; background-color: var(--nav-hover-bg); filter: grayscale(100%);">
                        <span style="font-size: 13px; font-weight: 400; color: var(--text-main); max-width: 250px; line-height: 1.2;">{{ $product->name }}</span>
                    </div>
                </td>
                <td style="padding: 15px 20px; font-size: 14px; color: var(--text-main);">{{ $product->brand }}</td>
                <td style="padding: 15px 20px; font-size: 14px; font-weight: 400; color: var(--text-main);">{{ $product->formatted_price }}</td>
                <td style="padding: 15px 20px; font-size: 14px; font-weight: 700; color: var(--text-main);">{{ $product->stock }}</td>
                <td style="padding: 15px 20px;">
                    <span style="background-color: {{ $statusColor }}; color: #000; font-size: 10px; font-weight: 700; padding: 4px 8px; border-radius: 4px; text-transform: none;">
                        {{ $status }}
                    </span>
                </td>
                @if(auth()->user()->isAdmin() || auth()->user()->isOfficer())
                <td style="padding: 15px 20px; text-align: center;">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 15px;">
                        <form action="{{ route($routePrefix . '.products.restore', $product->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PUT')
                            <button type="submit" title="Restore Product" style="background: none; border: none; color: #4ADE80; font-size: 18px; cursor: pointer; transition: transform 0.2s; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-backward-step"></i>
                            </button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $products->links() }}
</div>


@if(session('success'))
<!-- Success Modal -->
<div id="successModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; backdrop-filter: blur(4px);">
    <div style="background: var(--bg-card); width: 400px; padding: 40px; border-radius: 20px; text-align: center; border: 2px solid var(--border-color); box-shadow: 10px 10px 0px var(--border-color); transform: translateY(0); transition: transform 0.3s ease;">
        <div style="width: 80px; height: 80px; background: #4ADE80; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 4px 4px 0px #000;">
            <i class="fa-solid fa-check" style="font-size: 40px; color: #000;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 10px; color: var(--text-title); text-transform: uppercase;">Success!</h3>
        <p style="font-size: 16px; color: var(--text-muted); margin-bottom: 30px;">{{ session('success') }}</p>
        <button onclick="closeModal()" style="background: #00D1FF; color: #fff; border: 2px solid #000; padding: 12px 40px; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 4px 4px 0px #000; transition: all 0.2s; text-transform: uppercase;">
            Great!
        </button>
    </div>
</div>

<script>
    function closeModal() {
        const modal = document.getElementById('successModal');
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        setTimeout(() => modal.remove(), 300);
    }
</script>
@endif
@endsection
