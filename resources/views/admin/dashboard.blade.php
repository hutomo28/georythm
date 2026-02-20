@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h2 class="page-title">Dashboard</h2>
    <p class="page-subtitle">Welcome back! Here's what's happening with your store today.</p>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 60px;
        }

        .stat-card {
            background-color: #fff;
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
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
            color: #888;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .top-selling-container {
            background-color: #fff;
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-item {
            display: grid;
            grid-template-columns: 80px 80px 1fr 150px 150px;
            align-items: center;
            padding: 15px 25px;
            border-bottom: 1px solid #e0e0e0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .rank {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            background-color: #f0f0f0;
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
        }

        .sales-count {
            color: #888;
            font-size: 18px;
        }

        .product-price {
            font-weight: 700;
            font-size: 18px;
            color: #888;
            text-align: right;
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">Rp287.525.000</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">50</div>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value">20</div>
        </div>
        @endif
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
            <div class="stat-label">Total Product</div>
            <div class="stat-value">5</div>
        </div>
    </div>

    <h3 class="section-title">Top Selling Product</h3>

    <div class="top-selling-container">
        <div class="product-item">
            <div class="rank">1</div>
            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="NATGEO" class="product-img">
            <div class="product-name">NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN BLACK</div>
            <div class="sales-count">16 Sales</div>
            <div class="product-price">Rp6.999.000</div>
        </div>
        <div class="product-item">
            <div class="rank">2</div>
            <img src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="NATGEO" class="product-img">
            <div class="product-name">NATGEO- ATLAS WINDSTOPPER BY GORE-TEX LABS SHORT GOOSE DOWN White</div>
            <div class="sales-count">9 Sales</div>
            <div class="product-price">Rp6.999.000</div>
        </div>
        <div class="product-item">
            <div class="rank">3</div>
            <img src="https://images.unsplash.com/photo-1547996160-81f9608c3a99?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="TNF" class="product-img">
            <div class="product-name">TNF- Men's DRYVENT™ Mono Mountain Jacket</div>
            <div class="sales-count">9 Sales</div>
            <div class="product-price">Rp2.550.000</div>
        </div>
        <div class="product-item">
            <div class="rank">4</div>
            <img src="https://images.unsplash.com/photo-1617137968427-85924c809a10?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="COLUMBIA" class="product-img">
            <div class="product-name">COLUMBIA- Men's Whistler Peak™ Shell Jacket</div>
            <div class="sales-count">8 Sales</div>
            <div class="product-price">Rp4.200.000</div>
        </div>
        <div class="product-item">
            <div class="rank">5</div>
            <img src="https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" alt="ARC'TERYX" class="product-img">
            <div class="product-name">Arcteryx- Beta LT Gore-Tex Jacket Mens Medium 30165</div>
            <div class="sales-count">8 Sales</div>
            <div class="product-price">Rp7.000.000</div>
        </div>
    </div>
@endsection
