<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GEORYTHM - Explore the World, Wear the Rhythm')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans text-slate-900 bg-white selection:bg-yellow-400 selection:text-black" x-data="{ cartOpen: false }">
    @include('customer.partials.header')
    @include('customer.partials.cart-drawer')

    <main class="pt-32 pb-32 min-h-screen">
        @yield('content')
    </main>

    @include('customer.partials.footer')
</body>
</html>
