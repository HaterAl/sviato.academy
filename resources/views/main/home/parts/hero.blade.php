<div class="c-sheet max-sm:max-w-md">
    <h1 class="sr-only">
        {{ __('Sviato Academy') }}
    </h1>
    <div class="flex justify-center md:px-[13%]">
        <picture class="c-spotlight">
            <source media="(max-width: 420px)" srcset="{{ Vite::image('hero-00-420px.png') }} 1x, {{ Vite::image('hero-00-420px@2x.png') }} 2x">
            <source media="(max-width: 1024px)" srcset="{{ Vite::image('hero-00-1024px.png') }} 1x, {{ Vite::image('hero-00-1024px@2x.png') }} 2x">
            <img
                width="840"
                height="840"
                src="{{ Vite::image('hero-00.png') }}"
                srcset="{{ Vite::image('hero-00@2x.png') }} 2x"
                alt="Sviatoslav Otchenash"
                class="c-mask-opacity-to-bottom-5 relative"
            >
        </picture>
    </div>
    <section class="relative -mt-28 sm:-mt-48 lg:-mt-28 2xl:-mt-36 3xl:-mt-40">
        <div class="lg:absolute lg:left-0 lg:right-0 lg:bottom-full lg:flex 3xl:items-center">
            <div class="lg:w-1/3 xl:w-1/2 aos-init" data-aos="fade-up">
                <h2>{{ __('Redefining') }} <div class="u-text--primary italic pl-[2.47em] pr-2 -mr-2">{{ __('Beauty') }}</div></h2>
            </div>
            <div class="md:pt-0 sm:flex lg:w-2/3 xl:w-1/2">
                <div class="text-sm pl-9 sm:w-1/2 aos-init" data-aos="fade-up">
                    <p>
                        In&nbsp;the four years since we&nbsp;started, Sviato Academy has redefined the standards of&nbsp;
                        <span class="u-text--primary">the permanent makeup industry</span>. Led by&nbsp;one of&nbsp;the
                        world’s leading permanent makeup artists, Sviatoslav Otchenash, we&nbsp;have become
                        <span class="u-text--primary">the go-to institution</span> for gifted individuals seeking to
                        perfect their craft.
                    </p>
                </div>

                <div class="text-sm pl-9 sm:w-1/2 aos-init" data-aos="fade-up">
                    <p>
                        Our techniques and training methods are the results of&nbsp;over a&nbsp;decade of&nbsp;the
                        tireless <span class="u-text--primary">pursuit of&nbsp;perfection</span>. We&nbsp;have proven
                        time and time again that our innovative approach and constant evolution stand head and shoulders
                        above other academies.
                    </p>
                </div>
            </div>
        </div>
        <div class="mx-auto max-sm:max-w-md md:pt-28 md:flex md:justify-center">
            <div class="pr-[24%] mb-6 md:px-4 md:pt-28">
                <picture>
                    <source media="(max-width: 420px)" srcset="{{ asset('images/hero-02-420px.jpg') }} 1x, {{ asset('images/hero-02-420px@2x.jpg') }} 2x">
                    <source media="(max-width: 1024px)" srcset="{{ asset('images/hero-02-1024px.jpg') }} 1x, {{ asset('images/hero-02-1024px@2x.jpg') }} 2x">
                    <img
                        width="624"
                        height="556"
                        data-src="{{ asset('images/hero-02.jpg') }}"
                        data-srcset="{{ asset('images/hero-02@2x.jpg') }} 2x"
                        class="lazy rounded-md aos-init"
                        data-aos="fade-up"
                        alt="Sviatoslav Otchenash"
                    >
                </picture>
            </div>
            <div class="pl-[24%] mb-6 md:px-4">
                <picture>
                    <source media="(max-width: 420px)" srcset="{{ asset('images/hero-01-420px.jpg') }} 1x, {{ asset('images/hero-01-420px@2x.jpg') }} 2x">
                    <source media="(max-width: 1024px)" srcset="{{ asset('images/hero-01-1024px.jpg') }} 1x, {{ asset('images/hero-01-1024px@2x.jpg') }} 2x">
                    <img
                        width="624"
                        height="556"
                        data-src="{{ asset('images/hero-01.jpg') }}"
                        data-srcset="{{ asset('images/hero-01@2x.jpg') }} 2x"
                        class="lazy rounded-md aos-init"
                        data-aos="fade-up"
                        alt="Sviatoslav Otchenash"
                    >
                </picture>
            </div>
        </div>
    </section>
</div>
