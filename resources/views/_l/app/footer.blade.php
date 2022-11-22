<footer>
    <div class="g-sheet u-px--3">
        <div class="u-mx--n2 md:u-fx md:u-fx--j-between">
            <div class="u-px--2">
                <p class="c-nav">
                    <small class="c-nav__unit c-nav__unit--text u-events--none">&copy;&nbsp;{{ \Carbon\Carbon::now()->format('Y') }}&nbsp;{{ $config->name }}</small>
                </p>
            </div>

            <div class="u-px--2">
                <div class="c-nav">
                    <p class="c-nav__unit c-nav__unit--ideil u-text--nowrap u-pos--rel">Made in
                        <a href="https://ideil.com" class="c-nav__unit__pseudo-cover" target="_blank" rel="noopener">
                            <img
                                src="{{ Vite::asset('resources/images/app/ideil.svg') }}"
                                width="48"
                                height="16"
                                alt='ideil. — developing software, websites, online stores, and high-load media sites, as well as mobile applications for Android and iOS. Providing technical support "24/7" throughout the entire life cycle, audit, and refactoring of existing projects.'
                                {{-- alt="ideil. — розробка програмного забезпечення, вебсайтів, інтернет-магазинів та високонавантажених сайтів ЗМІ, а також мобільних додатків для Android та iOS. Надання технічної підтримки «24/7» протягом всього життєвого циклу, аудит та рефакторинг існуючих проєктів." --}}
                            >
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
