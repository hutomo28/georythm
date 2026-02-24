<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Page') - GEORYTHM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Dark mode no-flash initializer -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <style>
        /* ── CSS Variables ── */
        :root {
            --bg-page:      #f8f9fa;
            --bg-sidebar:   #ffffff;
            --bg-topbar:    #ffffff;
            --bg-content:   #f8f9fa;
            --bg-card:      #ffffff;
            --border-color: #e0e0e0;
            --text-main:    #333;
            --text-title:   #1a1a1a;
            --text-muted:   #888;
            --nav-hover-bg: #f0f0f0;
            --input-bg:     transparent;
        }
        html.dark {
            --bg-page:      #111827;
            --bg-sidebar:   #1f2937;
            --bg-topbar:    #1f2937;
            --bg-content:   #111827;
            --bg-card:      #1f2937;
            --border-color: #374151;
            --text-main:    #e5e7eb;
            --text-title:   #ffffff;
            --text-muted:   #9ca3af;
            --nav-hover-bg: #374151;
        }

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-page);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 40px 20px;
            position: fixed;
            height: 100vh;
            box-sizing: border-box;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .sidebar h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 50px;
            padding-left: 10px;
            color: var(--text-main);
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
            color: var(--text-main);
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
            background-color: var(--nav-hover-bg);
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
            color: var(--text-muted);
            font-weight: 700;
            font-size: 18px;
            transition: color 0.3s;
        }

        .logout-btn i {
            margin-right: 10px;
        }

        .logout-btn:hover {
            color: var(--text-main);
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
            background-color: var(--bg-topbar);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 40px;
            position: relative;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .logo .geo   { color: var(--text-main); }
        .logo .rythm { color: #FFEA00; }

        .admin-profile {
            position: absolute;
            right: 40px;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-profile span {
            font-style: italic;
            font-weight: 400;
            color: var(--text-main);
        }

        /* Theme toggle button */
        #admin-theme-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-main);
            font-size: 20px;
            transition: color 0.3s, transform 0.3s;
            padding: 4px;
            display: flex;
            align-items: center;
        }
        #admin-theme-toggle:hover {
            color: #FFEA00;
            transform: rotate(20deg);
        }

        .content-area {
            padding: 40px;
            background-color: var(--bg-content);
            flex-grow: 1;
            transition: background-color 0.3s;
        }

        h2.page-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-title);
        }

        .page-subtitle {
            color: var(--text-muted);
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 700;">GEO<span style="color: #FFD700;">RYTHM</span></h1>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('set-locale', 'en') }}" style="font-size: 11px; font-weight: 700; text-decoration: none; color: {{ App::getLocale() == 'en' ? 'var(--text-title)' : 'var(--text-muted)' }}; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; background: {{ App::getLocale() == 'en' ? 'var(--nav-hover-bg)' : 'transparent' }};">EN</a>
                <a href="{{ route('set-locale', 'id') }}" style="font-size: 11px; font-weight: 700; text-decoration: none; color: {{ App::getLocale() == 'id' ? 'var(--text-title)' : 'var(--text-muted)' }}; border: 1px solid var(--border-color); padding: 2px 6px; border-radius: 4px; background: {{ App::getLocale() == 'id' ? 'var(--nav-hover-bg)' : 'transparent' }};">ID</a>
            </div>
        </div>

        <ul class="nav-links">
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.dashboard') }}" class="nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-table-cells-large"></i> {{ __('admin.dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.products') }}" class="nav-link {{ request()->routeIs('*.products*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> {{ __('admin.products') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.orders') }}" class="nav-link {{ request()->routeIs('*.orders') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list"></i> {{ __('admin.orders') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.finance-report') }}" class="nav-link {{ request()->routeIs('*.finance-report') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i> {{ __('admin.finance_report') }}
                </a>
            </li>
            @if(auth()->user()->isAdmin())
            <li class="nav-item">
                <a href="{{ route($routePrefix . '.users') }}" class="nav-link {{ request()->routeIs('*.users') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> {{ __('admin.users') }}
                </a>
            </li>
            @endif
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-chevron-left" style="font-size: 14px;"></i> {{ __('admin.logout') }}
        </a>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="logo">
                <span class="geo">GEO</span><span class="rythm">RYTHM</span>
            </div>
            <div class="admin-profile">
                <!-- Theme Toggle Button -->
                <button id="admin-theme-toggle" title="Toggle tema">
                    <i id="admin-icon-sun" class="fa-solid fa-sun" style="display:none;"></i>
                    <i id="admin-icon-moon" class="fa-solid fa-moon"></i>
                </button>
                <span style="font-style: italic; font-weight: 400;">{{ ucfirst(auth()->user()->role) }}:</span>{{ auth()->user()->name }}
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script>
        (function() {
            const btn      = document.getElementById('admin-theme-toggle');
            const iconSun  = document.getElementById('admin-icon-sun');
            const iconMoon = document.getElementById('admin-icon-moon');
            const html     = document.documentElement;

            function applyAdminTheme(isDark) {
                if (isDark) {
                    html.classList.add('dark');
                    iconSun.style.display  = 'inline';
                    iconMoon.style.display = 'none';
                } else {
                    html.classList.remove('dark');
                    iconSun.style.display  = 'none';
                    iconMoon.style.display = 'inline';
                }
            }

            // Sync icon on load
            applyAdminTheme(html.classList.contains('dark'));

            btn.addEventListener('click', function() {
                const isDark = !html.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                applyAdminTheme(isDark);
            });
        })();
    </script>
</body>
</html>

