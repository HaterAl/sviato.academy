<header class="c-sheet pt-6 xl:pt-8">
    <div class="-mx-3 flex items-start xl:-mx-12">
        <div class="px-3 w-2/12 xl:px-4">
            <a href="#" title="{{ $config->name }}">
                <img
                src="{{ Vite::asset('resources/images/logo.svg') }}"
                width="90"
                height="90"
                alt="{{ $config->name.' logo' }}"
                >
            </a>
        </div>

        <nav class="w-8/12 flex justify-center">
            <a href="#" class="py-3 px-7 text-xl hover:text-gold-dark">About</a>
            <a href="#" class="py-3 px-7 text-xl hover:text-gold-dark">Sviato Otchenash</a>
            <a href="#" class="py-3 px-7 text-xl hover:text-gold-dark">Trainers</a>
            <a href="#" class="py-3 px-7 text-xl hover:text-gold-dark">Catalogue</a>
            <a href="#" class="py-3 px-7 text-xl hover:text-gold-dark">Contact us</a>
        </nav>

        <div class="w-2/12 flex justify-end">
            <a href="#" class="py-3 px-3 text-xl xl:px-4">@svg('viber-gold')</a>
            <a href="#" class="py-3 px-3 text-xl xl:px-4">@svg('telegram-gold')</a>
            <a href="#" class="py-3 px-3 text-xl xl:px-4">@svg('facebook-gold')</a>
        </div>
    </div>
</header>
