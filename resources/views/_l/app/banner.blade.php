@php
    $navs = App\Models\Layouts::navs();
    $socials = App\Models\Layouts::socials();
@endphp

<header class="c-sheet py-6 lg:-mb-6 xl:pt-8">
    <div @class([
        '-mx-6 flex items-center',
        'lg:items-start',
        'xl:-mx-12',
    ])>
        <div class="px-6 lg:w-2/12 xl:px-4">
            <a href="#" title="{{ $config->name }}">
                <img
                src="{{ Vite::asset('resources/images/logo.svg') }}"
                width="90"
                height="90"
                class="w-20 h-auto"
                alt="{{ $config->name.' logo' }}"
                >
            </a>
        </div>

        <nav class="hidden lg:flex lg:justify-center lg:w-8/12">
            @foreach ($navs as $nav)
                <a href="#" class="px-6 py-3 text-xl hover:text-gold-dark lg:px-7">{{ $nav['title'] }}</a>
            @endforeach
        </nav>

        <div @class([
            'px-3 ml-auto flex',
            'lg:px-0 lg:w-2/12 lg:justify-end'
        ])>
            @foreach ($socials as $social)
                <a href="#" class="py-3 px-3 text-xl lg:px-4">
                    <span class="sr-only">{{ $social['title'] }}</span>
                    @svg($social['svg'])
                </a>
            @endforeach
        </div>
    </div>
</header>
