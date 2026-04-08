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
            --bg-page:      #f4f6f8;
            --bg-sidebar:   #ffffff;
            --bg-topbar:    #ffffff;
            --bg-content:   #f4f6f8;
            --bg-card:      #ffffff;
            --border-color: #e5e7eb;
            --text-main:    #374151;
            --text-title:   #111827;
            --text-muted:   #6b7280;
            --nav-hover-bg: #f3f4f6;
            --accent-yellow: #FFEA00;
        }
        html.dark {
            --bg-page:      #0f172a;
            --bg-sidebar:   #1e293b;
            --bg-topbar:    #1e293b;
            --bg-content:   #0f172a;
            --bg-card:      #1e293b;
            --border-color: #334155;
            --text-main:    #cbd5e1;
            --text-title:   #f1f5f9;
            --text-muted:   #94a3b8;
            --nav-hover-bg: #334155;
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

        /* ── Global Dark Mode Refinements ── */
        .dark .status-badge, .dark [style*="background-color: #dcfce7"] { background-color: #064e3b !important; color: #34d399 !important; }
        .dark .status-completed, .dark [style*="background-color: #4ADE80"] { background-color: #064e3b !important; color: #34d399 !important; }
        .dark .status-processing, .dark [style*="background-color: #dbeafe"] { background-color: #1e3a8a !important; color: #93c5fd !important; }
        .dark .status-shipped, .dark [style*="background-color: #3B82F6"] { background-color: #1e3a8a !important; color: #93c5fd !important; }
        .dark [style*="background-color: #fee2e2"] { background-color: #7f1d1d !important; color: #fca5a5 !important; }
        .dark [style*="background-color: #fef9c3"] { background-color: #713f12 !important; color: #fde047 !important; }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            box-sizing: border-box;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 12px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 700;
            font-size: 15px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 18px;
        }

        .nav-link:hover {
            background-color: var(--nav-hover-bg);
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: var(--accent-yellow);
            color: #000;
            box-shadow: 0 4px 15px rgba(255, 234, 0, 0.3);
        }

        .logout-btn {
            margin-top: auto;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 16px;
            transition: color 0.3s;
            border-top: 1px solid var(--border-color);
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
            min-width: 0; /* Fix flexbox overflow */
            transition: margin-left 0.3s ease;
        }

        .top-bar {
            height: 80px;
            background-color: var(--bg-topbar);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 900;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .menu-toggle {
            display: none;
            position: absolute;
            left: 20px;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 24px;
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 950;
            backdrop-filter: blur(2px);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .menu-toggle {
                display: block;
            }
            .sidebar-overlay.active {
                display: block;
            }
            .top-bar {
                padding: 0 60px;
            }
            .admin-profile {
                right: 20px;
            }
            .admin-profile span:not(.role-label) {
                display: none; /* Hide name on small mobile if needed */
            }
        }

        @media (max-width: 640px) {
            .logo {
                font-size: 20px;
            }
            .admin-profile {
                gap: 8px;
            }
            .content-area {
                padding: 20px;
            }
            h2.page-title {
                font-size: 24px;
            }
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
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 12px;
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
            min-height: calc(100vh - 80px);
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

        /* Utility Classes for Responsiveness */
        .table-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow-x: auto;
            margin-top: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .responsive-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 800px; /* Force scroll on mobile */
        }

        .responsive-table th, .responsive-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .responsive-table th {
            font-weight: 700;
            color: var(--text-title);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: var(--nav-hover-bg);
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 20px;
            gap: 20px;
        }

        @media (max-width: 640px) {
            .header-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .modal-container {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
            padding: 20px;
        }

        .modal-content {
            background: var(--bg-card);
            width: 100%;
            max-width: 500px;
            padding: 30px;
            border-radius: 20px;
            position: relative;
            border: 2px solid var(--border-color);
            box-shadow: 10px 10px 0px var(--border-color);
            max-height: 90vh;
            overflow-y: auto;
        }

        @media (max-width: 480px) {
            .modal-content {
                padding: 20px;
                box-shadow: 5px 5px 0px var(--border-color);
            }
        }
    </style>
</head>
<body>
    @php
        $routePrefix = auth()->user()->isAdmin() ? 'admin' : 'officer';
        $pageTitle = auth()->user()->isAdmin() ? 'Admin Page' : 'Officer Page';
    @endphp

    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <div id="admin-sidebar" class="sidebar">
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
            <button id="sidebar-toggle" class="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
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

            // ── Sidebar Toggle ──────────────────────────────────────
            const sidebar       = document.getElementById('admin-sidebar');
            const overlay       = document.getElementById('sidebar-overlay');
            const toggleBtn     = document.getElementById('sidebar-toggle');
            const navLinks      = sidebar.querySelectorAll('.nav-link');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            toggleBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Close sidebar on navigation (useful for mobile)
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 1024) {
                        toggleSidebar();
                    }
                });
            });
        })();
    </script>
</body>
</html>

