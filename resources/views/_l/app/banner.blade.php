<header class="c-sheet pt-9">
    <div class="-mx-4 flex items-start">
        <div class="px-4 w-2/12">
            <a href="#" title="{{ $config->name }}">
                <img
                    src="{{ Vite::asset('resources/images/logo.svg') }}"
                    width="90"
                    height="90"
                    alt="{{ $config->name }}"
                >
            </a>
        </div>

        <nav class="w-8/12 flex justify-center">
            <a href="#" class="py-3 px-8 text-xl hover:text-gold-dark">About</a>
            <a href="#" class="py-3 px-8 text-xl hover:text-gold-dark">Sviato Otchenash</a>
            <a href="#" class="py-3 px-8 text-xl hover:text-gold-dark">Trainers</a>
            <a href="#" class="py-3 px-8 text-xl hover:text-gold-dark">Catalogue</a>
            <a href="#" class="py-3 px-8 text-xl hover:text-gold-dark">Contact us</a>
        </nav>

        <div class="w-2/12 flex justify-end">
            <a href="#" class="py-3 px-4 text-xl">@svg('viber-gold')</a>
            <a href="#" class="py-3 px-4 text-xl">@svg('telegram-gold')</a>
            <a href="#" class="py-3 px-4 text-xl">@svg('facebook-gold')</a>
        </div>
    </div>
</header>
