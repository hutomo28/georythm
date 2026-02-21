<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Page') - GEORYTHM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background-color: #fff;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            padding: 40px 20px;
            position: fixed;
            height: 100vh;
            box-sizing: border-box;
        }

        .sidebar h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 50px;
            padding-left: 10px;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 20px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: #333;
            font-weight: 700;
            font-size: 18px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .nav-link i {
            margin-right: 15px;
            width: 25px;
            text-align: center;
            font-size: 22px;
        }

        .nav-link:hover {
            background-color: #f0f0f0;
        }

        .nav-link.active {
            background-color: #FFEA00;
            color: #000;
        }

        .logout-btn {
            margin-top: auto;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: #888;
            font-weight: 700;
            font-size: 18px;
            transition: color 0.3s;
        }

        .logout-btn i {
            margin-right: 10px;
        }

        .logout-btn:hover {
            color: #000;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            height: 80px;
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 40px;
            position: relative;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .logo .geo { color: #000; }
        .logo .rythm { color: #FFEA00; }

        .admin-profile {
            position: absolute;
            right: 40px;
            font-size: 16px;
            font-weight: 700;
        }

        .admin-profile span {
            font-style: italic;
            font-weight: 400;
            color: #000;
        }

        .content-area {
            padding: 40px;
        }

        h2.page-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: #888;
            font-style: italic;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    @php
        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer';
        $pageTitle = auth()->user()->isAdmin() ? 'Admin Page' : 'Officer Page';
    @endphp
    <div class="sidebar">
        <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 60px;">{{ $pageTitle }}</h1>
        <ul class="nav-links">
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.dashboard') }}" class="nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-table-cells-large"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.products') }}" class="nav-link {{ request()->routeIs('*.products') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> Product
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.orders') }}" class="nav-link {{ request()->routeIs('*.orders') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list"></i> Order
                </a>
            </li>
            @if(auth()->user()->isAdmin())
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.users') }}" class="nav-link {{ request()->routeIs('*.users') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Users
                </a>
            </li>
            @endif
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-chevron-left" style="font-size: 14px;"></i> Logout
        </a>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="logo">
                <span class="geo" style="color: #000;">GEO</span><span class="rythm" style="color: #FFEA00;">RYTHM</span>
            </div>
            <div class="admin-profile">
                <span style="font-style: italic; font-weight: 400;">{{ ucfirst(auth()->user()->role) }}:</span>{{ auth()->user()->name }}
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>
</body>
</html>
