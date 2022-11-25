@php
    $navs = App\Models\Layouts::navs();
    $socials = App\Models\Layouts::socials();
@endphp

<header class="c-sheet pt-6 xl:pt-8">
    <div class="-mx-3 lg:flex lg:items-start xl:-mx-12">
        <div class="px-3 lg:w-2/12 xl:px-4">
            <a href="#" title="{{ $config->name }}">
                <img
                src="{{ Vite::asset('resources/images/logo.svg') }}"
                width="90"
                height="90"
                alt="{{ $config->name.' logo' }}"
                >
            </a>
        </div>

        <nav class="flex flex-col lg:flex-row lg:justify-center lg:w-8/12">
            @foreach ($navs as $nav)
                <a href="#" class="py-3 px-7 text-xl hover:text-gold-dark">{{ $nav['title'] }}</a>
            @endforeach
        </nav>

        <div class="flex lg:w-2/12 lg:justify-end">
            @foreach ($socials as $social)
                <a href="#" class="py-3 px-3 text-xl xl:px-4">
                    <span class="sr-only">{{ $social['title'] }}</span>
                    @svg($social['svg'])
                </a>
            @endforeach
        </div>
    </div>
</header>
