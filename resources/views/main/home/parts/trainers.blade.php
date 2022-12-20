<div class="overflow-hidden">
    <section class="c-sheet splide splide--arrows-bottom pt-20 md:pt-28" data-carousel-row>
        <h2 class="b-h1 mb-6 md:text-center md:mb-14 aos-init" data-aos="fade-up" id="trainers">
            {{ __('Our') }} <span class="u-text--primary italic px-2 -mx-2">{{ __('trainers') }}</span>
        </h2>
        <div class="splide__body md:max-xl:mx-6 aos-init" data-aos="fade-up">
            <div class="splide__arrows aos-init" data-aos="fade-up">
                <button class="splide__arrow splide__arrow--prev">
                    @svg('arrow-ltr', '-scale-x-1')
                </button>
                <button class="splide__arrow splide__arrow--next">
                    @svg('arrow-ltr')
                </button>
            </div>
            <div class="splide__track overflow-visible -mx-6">
                <div class="splide__list">
                    @foreach(config('trainers.list') as $trainer)
                        <div class="splide__slide pl-6 md:pr-6 w-1/5">
                            <article class="relative flex flex-col-reverse text-sm">
                                <div class="flex flex-col">
                                    <h3 class="b-h6 italic text-white mb-1">
                                        {{ $trainer['first_name'] }} <div class="pl-[15%]">{{ $trainer['last_name'] }}</div>
                                    </h3>
                                    <dl class="-order-1 -mt-px absolute right-0">
                                        <dt class="sr-only">Country</dt>
                                        <dd>{{ $trainer['country'] }}</dd>
                                    </dl>
                                    <dl>
                                        <dt class="sr-only">Type of courses</dt>
                                        <dd>{{ $trainer['treatment'] }}</dd>
                                    </dl>
                                    @if (count($trainer['socials']))
                                        <dl class="-mx-1 -mt-3 flex">
                                            <dt class="sr-only">Accounts in social networks</dt>
                                            @foreach($trainer['socials'] as $key => $link)
                                                <dd>
                                                    <a href="{{ $link }}" target="_blank" class="block p-1" rel="nofollow noopener">
                                                        <span class="sr-only">{{ $key }}</span>
                                                        @svg($key.'-gold')
                                                    </a>
                                                </dd>
                                            @endforeach
                                        </dl>
                                    @endif
                                </div>
                                <img
                                    width="224"
                                    height="224"
                                    data-src="{{ asset($trainer['img']['1x']) }}"
                                    data-srcset="{{ asset($trainer['img']['2x']) }} 2x"
                                    alt="{{ $trainer['first_name'] }} {{ $trainer['last_name'] }}"
                                    class="lazy rounded mb-4"
                                >
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
