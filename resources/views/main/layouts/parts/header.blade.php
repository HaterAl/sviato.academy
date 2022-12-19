<header class="c-sheet py-6 lg:-mb-6 xl:pt-8">
    <div class="flex items-center lg:items-start xl:-mx-12">
        <div class="lg:w-2/12 xl:px-4">
            <a href="#" title="Sviato Academy">
                <img
                    src="{{ Vite::asset('resources/images/logo.svg') }}"
                    width="90"
                    height="90"
                    class="w-20 h-auto"
                    alt="Sviato academy"
                >
            </a>
        </div>
        @include('main.layouts.parts.nav')
        <div class="ml-auto -mr-3 flex lg:-mr-4 lg:px-0 lg:w-2/12 lg:justify-end">
            <a href="https://www.instagram.com/sviatoslavotchenash" rel="nofollow noopener" target="_blank" class="py-3 px-3 text-xl lg:px-4">
                <span class="sr-only">Instagram</span>
                @svg('instagram-gold')
            </a>
            <a href="https://www.facebook.com/sviatoslav.otchenash" rel="nofollow noopener" target="_blank" class="py-3 px-3 text-xl lg:px-4">
                <span class="sr-only">Facebook</span>
                @svg('facebook-gold')
            </a>
            <a href="https://www.tiktok.com/@sviatoslavotchenash" rel="nofollow noopener" target="_blank" class="py-3 px-3 text-xl lg:px-4">
                <span class="sr-only">Tiktok</span>
                @svg('tiktok-gold')
            </a>
        </div>
    </div>
</header>
