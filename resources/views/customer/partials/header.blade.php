<header id="main-header"
    class="fixed top-0 left-0 w-full z-[9999999] bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-700 transition-colors duration-300">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-20">

            <!-- Mobile Menu Toggle -->
            <div class="flex md:hidden">
                <button @click="mobileMenuOpen = true" class="text-black dark:text-white p-2">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Logo -->
            <a href="{{ route('home') }}" 
               class="text-2xl font-bold tracking-tight uppercase text-black dark:text-white">
                GEO<span class="text-yellow-500">RYTHM</span>
            </a>

            <!-- Menu (Desktop) -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('products.index') }}" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 font-medium uppercase text-sm transition-colors">
                    All Products
                </a>
                <a href="{{ route('products.index', ['category' => 'natgeo']) }}" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 font-medium uppercase text-sm transition-colors">
                    NatGeo
                </a>
                <a href="{{ route('products.index', ['category' => 'tnf']) }}" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 font-medium uppercase text-sm transition-colors">
                    TNF
                </a>
                <a href="{{ route('products.index', ['category' => 'arcteryx']) }}" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 font-medium uppercase text-sm transition-colors">
                    Arcteryx
                </a>
                <a href="{{ route('products.index', ['category' => 'columbia']) }}" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 font-medium uppercase text-sm transition-colors">
                    Columbia
                </a>
            </nav>

            <!-- Icons -->
            <div class="flex items-center space-x-3 md:space-x-6">

                <!-- Search -->
                <div class="relative flex items-center">
                    <form action="{{ route('products.index') }}" method="GET" id="search-form" class="hidden md:flex items-center">
                        <input type="text" name="q" id="search-input" placeholder="Search products..." 
                               class="w-0 opacity-0 transition-all duration-300 border-b-2 border-black dark:border-white focus:outline-none focus:w-48 focus:opacity-100 px-2 py-1 text-sm uppercase font-bold bg-transparent text-black dark:text-white placeholder:text-gray-400 dark:placeholder:text-zinc-500"
                               value="{{ request('q') }}">
                    </form>
                    <button id="search-toggle" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 transition-colors ml-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Theme Toggle -->
                <button id="theme-toggle" title="Toggle tema" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 transition-colors">
                    <!-- Sun icon (shown in dark mode) -->
                    <svg id="icon-sun" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg id="icon-moon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                </button>

                <!-- Account -->
                <a href="{{ route('account.index') }}" class="text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 transition-colors" title="Account">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <!-- Cart -->
                <button @click="cartOpen = true"
                        class="relative text-black dark:text-slate-200 hover:text-yellow-500 dark:hover:text-yellow-400 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>

                    @unless(Auth::guest())
                        <span class="absolute -top-1 -right-1 bg-yellow-500 text-black text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full">
                            {{ Auth::user()->carts()->sum('quantity') }}
                        </span>
                    @endunless
                </button>

            </div>
        </div>
    </div>

    <!-- Mobile Menu Slide-over -->
    <div 
        class="fixed inset-0 z-[1000] flex md:hidden" 
        role="dialog" 
        aria-modal="true"
        x-show="mobileMenuOpen"
        style="display: none;"
    >
        <!-- Overlay -->
        <div 
            class="fixed inset-0 bg-black/60 transition-opacity backdrop-blur-sm" 
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileMenuOpen = false"
        ></div>

        <!-- Panel -->
        <div 
            class="relative w-full max-w-xs bg-white dark:bg-zinc-900 shadow-2xl flex flex-col h-full transform transition-transform"
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-gray-100 dark:border-zinc-800">
                <span class="text-xl font-bold uppercase tracking-tight text-black dark:text-white">
                    GEO<span class="text-yellow-500">RYTHM</span>
                </span>
                <button @click="mobileMenuOpen = false" class="text-gray-400 dark:text-zinc-500 hover:text-black dark:hover:text-white transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Links -->
            <nav class="flex-1 px-6 py-8 space-y-6 overflow-y-auto bg-white dark:bg-zinc-900">
                <a href="{{ route('products.index') }}" class="block text-lg font-bold uppercase tracking-widest text-gray-900 dark:text-slate-100 hover:text-yellow-500 transition-colors">
                    All Products
                </a>
                <a href="{{ route('products.index', ['category' => 'natgeo']) }}" class="block text-lg font-bold uppercase tracking-widest text-gray-900 dark:text-slate-100 hover:text-yellow-500 transition-colors">
                    NatGeo
                </a>
                <a href="{{ route('products.index', ['category' => 'tnf']) }}" class="block text-lg font-bold uppercase tracking-widest text-gray-900 dark:text-slate-100 hover:text-yellow-500 transition-colors">
                    TNF
                </a>
                <a href="{{ route('products.index', ['category' => 'arcteryx']) }}" class="block text-lg font-bold uppercase tracking-widest text-gray-900 dark:text-slate-100 hover:text-yellow-500 transition-colors">
                    Arcteryx
                </a>
                <a href="{{ route('products.index', ['category' => 'columbia']) }}" class="block text-lg font-bold uppercase tracking-widest text-gray-900 dark:text-slate-100 hover:text-yellow-500 transition-colors">
                    Columbia
                </a>
                <div class="pt-6 border-t border-gray-100 dark:border-zinc-800 space-y-4">
                    <a href="{{ route('cart.index') }}" class="block text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 hover:text-yellow-500 transition-colors">
                        Your Cart
                    </a>
                    <a href="{{ route('customer.lookbook') }}" class="block text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 hover:text-yellow-500 transition-colors">
                        Lookbook
                    </a>
                    <a href="{{ route('customer.story') }}" class="block text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-slate-400 hover:text-yellow-500 transition-colors">
                        Our Story
                    </a>
                </div>
            </nav>

            <div class="p-6 border-t border-gray-100 dark:border-zinc-800">
                <a href="{{ route('account.index') }}" class="flex items-center space-x-3 text-gray-900 dark:text-white font-bold uppercase tracking-widest text-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>My Account</span>
                </a>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchToggle = document.getElementById('search-toggle');
        const searchInput = document.getElementById('search-input');
        const searchForm = document.getElementById('search-form');

        // If there's already a search query, keep it open
        if (searchInput.value.trim() !== "") {
            searchInput.classList.remove('w-0', 'opacity-0');
            searchInput.classList.add('w-48', 'opacity-100');
        }

        searchToggle.addEventListener('click', function(e) {
            if (searchInput.classList.contains('w-0')) {
                searchInput.classList.remove('w-0', 'opacity-0');
                searchInput.classList.add('w-48', 'opacity-100');
                searchInput.focus();
            } else {
                if (searchInput.value.trim() === "") {
                    searchInput.classList.add('w-0', 'opacity-0');
                    searchInput.classList.remove('w-48', 'opacity-100');
                } else {
                    searchForm.submit();
                }
            }
        });

        // Close search on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !searchInput.classList.contains('w-0')) {
                searchInput.classList.add('w-0', 'opacity-0');
                searchInput.classList.remove('w-48', 'opacity-100');
            }
        });

        // Auto-reset when cleared
        searchInput.addEventListener('input', function() {
            if (this.value.trim() === "" && window.location.search.includes('q=')) {
                window.location.href = "{{ route('products.index') }}";
            }
        });

        // ── Theme Toggle ──────────────────────────────────────────
        const themeToggle = document.getElementById('theme-toggle');
        const iconSun  = document.getElementById('icon-sun');
        const iconMoon = document.getElementById('icon-moon');
        const html = document.documentElement;

        function applyTheme(isDark) {
            if (isDark) {
                html.classList.add('dark');
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
            } else {
                html.classList.remove('dark');
                iconSun.classList.add('hidden');
                iconMoon.classList.remove('hidden');
            }
        }

        // Sync icons with current state on load
        applyTheme(html.classList.contains('dark'));

        themeToggle.addEventListener('click', function() {
            const isDark = !html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            applyTheme(isDark);
        });
        // ──────────────────────────────────────────────────────────
    });
</script>
