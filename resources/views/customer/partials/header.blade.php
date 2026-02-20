<header 
    style="position:fixed; top:0; left:0; width:100%; z-index:9999999; background:#ffffff; border-bottom:1px solid #e5e7eb;">

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center h-20">

            <!-- Logo -->
            <a href="{{ route('home') }}" 
               class="text-2xl font-bold tracking-tight uppercase text-black">
                GEO<span class="text-yellow-500">RYTHM</span>
            </a>

            <!-- Menu -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('products.index') }}" class="text-black hover:text-yellow-500 font-medium uppercase text-sm">
                    All Products
                </a>
                <a href="{{ route('products.index', ['category' => 'natgeo']) }}" class="text-black hover:text-yellow-500 font-medium uppercase text-sm">
                    NatGeo
                </a>
                <a href="{{ route('products.index', ['category' => 'tnf']) }}" class="text-black hover:text-yellow-500 font-medium uppercase text-sm">
                    TNF
                </a>
                <a href="{{ route('products.index', ['category' => 'arcteryx']) }}" class="text-black hover:text-yellow-500 font-medium uppercase text-sm">
                    Arcteryx
                </a>
                <a href="{{ route('products.index', ['category' => 'columbia']) }}" class="text-black hover:text-yellow-500 font-medium uppercase text-sm">
                    Columbia
                </a>
            </nav>

            <!-- Icons -->
            <div class="flex items-center space-x-6">

                <!-- Search -->
                <button class="text-black hover:text-yellow-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Account & Logout -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('account.index') }}" class="text-black hover:text-yellow-500" title="Account">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Logout">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Cart -->
                <button @click="cartOpen = true"
                        class="relative text-black hover:text-yellow-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>

                    <span class="absolute -top-1 -right-1 bg-yellow-500 text-black text-[10px] font-bold h-4 w-4 flex items-center justify-center rounded-full">
                        2
                    </span>
                </button>

            </div>
        </div>
    </div>
</header>
