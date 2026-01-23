<header class="c-sheet py-6 lg:-mb-6 xl:pt-8">
    <div class="flex items-center lg:items-start xl:-mx-12">
        <div class="lg:w-2/12 xl:px-4">
            <a href="{{ route('home') }}" title="Sviato Academy">
                <img
                    src="{{ Vite::asset('resources/images/logo.svg') }}"
                    width="90"
                    height="90"
                    class="w-20 h-auto"
                    alt="Sviato academy"
                >
            </a>
        </div>
        @includeWhen($hasNavigation, 'main.layouts.parts.nav')
        <div class="ml-auto -mr-3 flex items-center lg:-mr-4 lg:px-0 lg:w-2/12 lg:justify-end">
            <a href="https://www.instagram.com/sviato_academy" rel="nofollow noopener" target="_blank" class="py-3 px-3 text-xl lg:px-4">
                <span class="sr-only">Instagram</span>
                @svg('instagram-gold')
            </a>
            <!--<a href="https://www.facebook.com/sviatoslav.otchenash" rel="nofollow noopener" target="_blank" class="py-3 px-3 text-xl lg:px-4">
                <span class="sr-only">Facebook</span>
                @svg('facebook-gold')
            </a>-->
            <a href="https://www.tiktok.com/@sviatoacademy" rel="nofollow noopener" target="_blank" class="py-3 px-3 text-xl lg:px-4">
                <span class="sr-only">Tiktok</span>
                @svg('tiktok-gold')
            </a>
            <a href="{{ route('map.index') }}" id="map-toggle" class="py-3 px-3 text-xl lg:px-4" title="Sviato Map">
                <span class="sr-only">Map</span>
                @svg('map-gold')
            </a>

            <!-- Mobile Menu Button -->
            @if($hasNavigation)
            <button
                id="mobile-menu-button"
                type="button"
                class="lg:hidden py-3 px-3 text-xl focus:outline-none"
                aria-label="Toggle menu"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            @endif
        </div>
    </div>

    <!-- Mobile Menu -->
    @if($hasNavigation)
    <div
        id="mobile-menu"
        class="lg:hidden fixed right-0 top-0 bottom-0 w-64 z-50 transform translate-x-full transition-transform duration-300 ease-in-out bg-white shadow-xl"
        style="display: none;"
    >
        <!-- Menu Panel -->
        <div class="h-full">
            <div class="flex flex-col h-full">
                <!-- Close Button -->
                <div class="flex justify-end p-4">
                    <button
                        id="mobile-menu-close"
                        type="button"
                        class="text-gray-600 hover:text-gray-900 focus:outline-none"
                        aria-label="Close menu"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Menu Items -->
                <nav class="flex-1 px-4 py-2">
                    <a href="{{ route('about.index') }}" class="block py-3 px-4 hover:bg-gray-100 rounded-lg transition-colors">
                        {{ __('About') }}
                    </a>
                    <a href="{{ route('community.index') }}" class="block py-3 px-4 hover:bg-gray-100 rounded-lg transition-colors">
                        {{ __('Sviato Community') }}
                    </a>
                    <a href="{{ route('events.index') }}" class="block py-3 px-4 hover:bg-gray-100 rounded-lg transition-colors">
                        {{ __('Events') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="block py-3 px-4 hover:bg-gray-100 rounded-lg transition-colors">
                        {{ __('Products') }}
                    </a>
                    <a href="{{ route('contact-us.index') }}" class="block py-3 px-4 hover:bg-gray-100 rounded-lg transition-colors">
                        {{ __('Contact us') }}
                    </a>
                </nav>
            </div>
        </div>
    </div>
    @endif
</header>

@if($hasNavigation)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuClose = document.getElementById('mobile-menu-close');

        function openMenu() {
            mobileMenu.style.display = 'block';
            setTimeout(() => {
                mobileMenu.classList.remove('translate-x-full');
            }, 10);
        }

        function closeMenu() {
            mobileMenu.classList.add('translate-x-full');
            setTimeout(() => {
                mobileMenu.style.display = 'none';
            }, 300);
        }

        if (menuButton) {
            menuButton.addEventListener('click', openMenu);
        }

        if (menuClose) {
            menuClose.addEventListener('click', closeMenu);
        }

        // Close menu when clicking on a link
        const menuLinks = mobileMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapToggle = document.getElementById('map-toggle');

        if (mapToggle) {
            mapToggle.addEventListener('click', function(e) {
                // Check if we're currently on the map page
                if (window.location.pathname === '/map') {
                    e.preventDefault();
                    window.history.back();
                }
            });
        }
    });
</script>
