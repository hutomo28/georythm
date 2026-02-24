<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GEORYTHM - Explore the World, Wear the Rhythm')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <!-- Dark mode initializer — runs BEFORE page renders to avoid flash -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <!-- Global dark mode overrides — fixes all content pages at once -->
    <style>
        /* Text overrides */
        .dark .text-gray-900  { color: #f1f5f9; }
        .dark .text-gray-800  { color: #e2e8f0; }
        .dark .text-gray-700  { color: #cbd5e1; }
        .dark .text-gray-600  { color: #94a3b8; }
        .dark .text-gray-500  { color: #64748b; }
        .dark .text-gray-400  { color: #475569; }
        .dark .text-slate-900 { color: #f1f5f9; }
        .dark .text-black     { color: #f1f5f9; }

        /* Background overrides */
        .dark .bg-white       { background-color: #1e293b; }
        .dark .bg-gray-50     { background-color: #1e293b; }
        .dark .bg-gray-100    { background-color: #273549; }
        .dark .bg-gray-200    { background-color: #334155; }

        /* Border overrides */
        .dark .border-gray-200 { border-color: #334155; }
        .dark .border-gray-300 { border-color: #475569; }
        .dark .border-black    { border-color: #94a3b8; }

        /* Form input fields */
        .dark input:not([type="radio"]):not([type="checkbox"]),
        .dark textarea,
        .dark select {
            background-color: #1e293b;
            color: #f1f5f9;
            border-color: #475569;
        }
        .dark input::placeholder,
        .dark textarea::placeholder { color: #64748b; }

        /* Section backgrounds */
        .dark section.bg-white   { background-color: #0f172a; }
        .dark section.bg-gray-50 { background-color: #0f172a; }

        /* Product image placeholder */
        .dark .bg-gray-100 .text-gray-400 { color: #475569; }

        /* Cart quantity inputs */
        .dark input[type="number"] {
            background-color: #1e293b;
            color: #f1f5f9;
        }

        /* Order summary section */
        .dark section[aria-labelledby="summary-heading"] {
            background-color: #1e293b;
        }

        /* Shipping method labels */
        .dark label.hover\:bg-gray-50:hover { background-color: #273549; }

        /* Scrollbar in dark mode */
        .dark ::-webkit-scrollbar { width: 6px; }
        .dark ::-webkit-scrollbar-track { background: #1e293b; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }

        /* Checkout order summary panel */
        .dark .bg-gray-50.p-6 { background-color: #1e293b; }

        /* Address card dark background */
        .dark .border-black.bg-gray-\[50\] { background-color: #1e293b; }
    </style>

    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans text-slate-900 bg-white dark:bg-zinc-950 dark:text-slate-100 selection:bg-yellow-400 selection:text-black transition-colors duration-300" x-data="{ cartOpen: false }">
    @include('customer.partials.header')
    @include('customer.partials.cart-drawer')

    <main class="pt-32 pb-32 min-h-screen">
        @yield('content')
    </main>

    @include('customer.partials.footer')
</body>
</html>
