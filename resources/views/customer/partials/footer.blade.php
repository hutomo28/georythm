<footer class="bg-black text-white pt-16 pb-8 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tighter uppercase block mb-6">
                    GEO<span class="text-yellow-500">RYTHM</span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Premium outdoor apparel for the modern explorer. Designed for the rhythm of nature.
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider mb-4 text-gray-200">Shop</h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">New Arrivals</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Men</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Women</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Accessories</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider mb-4 text-gray-200">Support</h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Order Status</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Shipping & Returns</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Size Guide</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider mb-4 text-gray-200">Newsletter</h3>
                <p class="text-gray-400 text-sm mb-4">Subscribe for latest drops and exclusive offers.</p>
                <form class="flex flex-col space-y-2">
                    <input type="email" placeholder="Email address" class="bg-gray-900 border border-gray-800 text-white px-4 py-2 text-sm focus:outline-none focus:border-yellow-500 transition-colors" />
                    <button type="button" class="bg-white text-black font-semibold px-4 py-2 text-sm uppercase tracking-wide hover:bg-yellow-500 hover:text-white transition-colors">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-900 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-xs text-gray-500 uppercase tracking-wide">
                &copy; {{ date('Y') }} Georythm. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-gray-500">
                <a href="#" class="hover:text-white transition-colors text-xs uppercase">Privacy</a>
                <a href="#" class="hover:text-white transition-colors text-xs uppercase">Terms</a>
            </div>
        </div>
    </div>
</footer>
