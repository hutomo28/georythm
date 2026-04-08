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

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .product-item {
                grid-template-columns: 50px 60px 1fr 120px 120px;
                padding: 15px;
            }
            .product-price, .sales-count {
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .product-item {
                grid-template-columns: 40px 60px 1fr;
                grid-template-rows: auto auto;
                gap: 10px;
            }
            .product-name {
                grid-column: 3 / 4;
            }
            .sales-count {
                grid-column: 3 / 4;
                grid-row: 2;
                text-align: left;
            }
            .product-price {
                grid-column: 3 / 4;
                grid-row: 3;
                text-align: left;
                font-size: 16px;
            }
            .product-img {
                grid-row: 1 / 3;
            }
            .rank {
                grid-row: 1 / 3;
            }
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
            <img src="{{ $item->product ? $item->product->image : 'https://placehold.co/600x800/f3f4f6/000000?text=DEL' }}" alt="{{ $item->product ? $item->product->name : 'Deleted Product' }}" class="product-img">
            <div class="product-name">{{ $item->product ? $item->product->name : 'Deleted Product' }}</div>
            <div class="sales-count">{{ $item->total_sales }} {{ __('admin.sales') }}</div>
            <div class="product-price">{{ $item->product ? $item->product->formatted_price : '-' }}</div>
        </div>
        @empty
        <div class="product-item" style="justify-content: center; color: #888;">
            {{ __('admin.no_sales_data') }}
        </div>
        @endforelse
    </div>

    <h3 class="section-title" style="margin-top: 60px;">Top Rated Products</h3>
    <div class="top-selling-container">
        @forelse($topRatedProducts as $product)
        <div class="product-item">
            <div class="rank">{{ $loop->iteration }}</div>
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-img">
            <div class="product-name">{{ $product->name }}</div>
            <div class="sales-count" style="color: #FFD700; font-weight: 800;">
                <i class="fa-solid fa-star"></i> {{ number_format($product->avg_rating, 1) }}
            </div>
            <div class="product-price">{{ $product->reviews_count }} Reviews</div>
        </div>
        @empty
        <div class="product-item" style="justify-content: center; color: #888;">
            No ratings available.
        </div>
        @endforelse
    </div>

    <style>
        .feedback-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 60px;
        }

        @media (max-width: 1024px) {
            .feedback-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .feedback-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        .review-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>

    <h3 class="section-title" style="margin-top: 60px;">Recent Customer Feedback</h3>
    <div class="feedback-grid">
        @forelse($recentReviews as $review)
        <div class="review-card">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                    <div style="max-width: 70%;">
                        <h5 style="margin: 0; font-size: 14px; font-weight: 700; color: var(--text-title); line-height: 1.2;">{{ $review->user->name }}</h5>
                        <p style="margin: 5px 0 0; font-size: 10px; color: var(--text-muted); text-transform: uppercase;">{{ $review->product->name }}</p>
                    </div>
                    <div style="color: #FFD700; font-size: 10px; white-space: nowrap;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                </div>
                <p style="font-size: 13px; color: var(--text-main); font-style: italic; line-height: 1.5;">"{{ Str::limit($review->comment, 100) }}"</p>
            </div>
            <div style="margin-top: 15px; font-size: 10px; color: var(--text-muted); text-align: right;">
                {{ $review->created_at->diffForHumans() }}
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; color: #888; padding: 40px; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px;">
            No reviews yet.
        </div>
        @endforelse
    </div>
@endsection
