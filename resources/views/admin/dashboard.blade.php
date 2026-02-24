@extends('admin.layouts.admin')

@section('title', __('admin.dashboard'))

@section('content')
    <h2 class="page-title">{{ __('admin.dashboard') }}</h2>
    <p class="page-subtitle">{{ __('admin.welcome_back') }} {{ __('admin.store_summary') }}</p>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 60px;
        }

        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: all 0.3s;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            border-radius: 4px;
        }

        .stat-card:nth-child(1) .stat-icon { background-color: #90ee90; color: #000; }
        .stat-card:nth-child(2) .stat-icon { background-color: #add8e6; color: #000; }
        .stat-card:nth-child(3) .stat-icon { background-color: #e6e6fa; color: #000; }
        .stat-card:nth-child(4) .stat-icon { background-color: #ffdead; color: #000; }

        .stat-label {
            font-size: 14px;
            color: var(--text-muted);
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-title);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-title);
        }

        .top-selling-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .product-item {
            display: grid;
            grid-template-columns: 80px 80px 1fr 150px 150px;
            align-items: center;
            padding: 15px 25px;
            border-bottom: 1px solid var(--border-color);
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .rank {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            background-color: var(--nav-hover-bg);
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 4px;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product-name {
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            padding-right: 20px;
            color: var(--text-main);
        }

        .sales-count {
            color: var(--text-muted);
            font-size: 18px;
        }

        .product-price {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-muted);
            text-align: right;
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-money-bill-trend-up"></i></div>
            <div class="stat-label">{{ __('admin.revenue') }}</div>
            <div class="stat-value">Rp{{ number_format($moneyIn, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <div class="stat-label">{{ __('admin.total_orders') }}</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #e6e6fa;"><i class="fa-solid fa-box"></i></div>
            <div class="stat-label">{{ __('admin.total_products') }}</div>
            <div class="stat-value">{{ $totalProducts }}</div>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #add8e6;"><i class="fa-solid fa-users"></i></div>
            <div class="stat-label">{{ __('admin.total_users') }}</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
        @endif
    </div>

    <h3 class="section-title">{{ __('admin.top_selling_products') }}</h3>

    <div class="top-selling-container">
        @forelse($topSellingItems as $item)
        <div class="product-item">
            <div class="rank">{{ $loop->iteration }}</div>
            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="product-img">
            <div class="product-name">{{ $item->product->name }}</div>
            <div class="sales-count">{{ $item->total_sales }} {{ __('admin.sales') }}</div>
            <div class="product-price">{{ $item->product->formatted_price }}</div>
        </div>
        @empty
        <div class="product-item" style="justify-content: center; color: #888;">
            {{ __('admin.no_sales_data') }}
        </div>
        @endforelse
    </div>
@endsection
