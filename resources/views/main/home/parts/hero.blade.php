<div class="c-sheet max-sm:max-w-md">
    <h1 class="sr-only">
        {{ __('Sviato Academy') }}
    </h1>
    <div class="flex justify-center md:px-[13%]">
        <picture class="c-spotlight max-w-full">
            <source media="(max-width: 420px)" srcset="{{ Vite::image('hero-00-420px.png') }} 1x, {{ Vite::image('hero-00-420px@2x.png') }} 2x">
            <source media="(max-width: 1024px)" srcset="{{ Vite::image('hero-00-1024px.png') }} 1x, {{ Vite::image('hero-00-1024px@2x.png') }} 2x">
            <img
                width="840"
                height="840"
                src="{{ Vite::image('hero-00.png') }}"
                srcset="{{ Vite::image('hero-00@2x.png') }} 2x"
                alt="Sviatoslav Otchenash"
                class="c-mask-opacity-to-bottom-5 relative aspect-square"
            >
        </picture>
    </div>
    <section class="relative -mt-28 sm:-mt-48 lg:-mt-28 2xl:-mt-36 3xl:-mt-40">
        <div class="lg:absolute lg:left-0 lg:right-0 lg:bottom-full lg:flex 3xl:items-center">
            <div class="lg:w-1/3 xl:w-1/2 aos-init" data-aos="fade-up">
                <h2>{{ __('PMU FOR ALL,') }} <div class="u-text--primary italic pl-[2.4em] pr-2 -mr-2">{{ __('ALL FOR PMU') }}</div></h2>
            </div>
            <div class="md:pt-0 sm:flex lg:w-2/3 xl:w-1/2">
                <div class="text-sm pl-9 sm:w-1/2 aos-init" data-aos="fade-up">
                    <p>
					Leaders in the beauty industry's permanent makeup, 
					 <span class="u-text--primary">Sviato Academy</span> values exceptional mastery. 
					We've set  <span class="u-text--primary">new standards</span>, and our place is where talented artists refine their skills.
                        
                    </p>
                </div>

                <div class="text-sm pl-9 sm:w-1/2 aos-init" data-aos="fade-up">
                    <p>
					We've spent a decade perfecting <span class="u-text--primary">our techniques</span>, standing out through innovation and continuous improvement.
					That's why we're <span class="u-text--primary">the top choice among academies.</span>

                    </p>
                </div>
            </div>
        </div>
        <div class="mx-auto max-sm:max-w-md md:pt-28 md:flex md:justify-center">
            <div class="pr-[24%] mb-6 md:w-1/2 md:px-4 md:pt-28">
                <picture>
                    <source media="(max-width: 420px)" data-srcset="{{ asset('images/hero-02-420px.jpg') }} 1x, {{ asset('images/hero-02-420px@2x.jpg') }} 2x">
                    <source media="(max-width: 1024px)" data-srcset="{{ asset('images/hero-02-1024px.jpg') }} 1x, {{ asset('images/hero-02-1024px@2x.jpg') }} 2x">
                    <img
                        width="624"
                        height="556"
                        data-src="{{ asset('images/hero-02.jpg') }}"
                        data-srcset="{{ asset('images/hero-02@2x.jpg') }} 2x"
                        class="lazy aspect-[64/57] rounded-md aos-init"
                        data-aos="fade-up"
                        alt="Sviatoslav Otchenash"
                    >
                </picture>
            </div>
            <div class="pl-[24%] mb-6 md:w-1/2 md:px-4">
                <picture>
                    <source media="(max-width: 420px)" data-srcset="{{ asset('images/hero-01-420px.jpg') }} 1x, {{ asset('images/hero-01-420px@2x.jpg') }} 2x">
                    <source media="(max-width: 1024px)" data-srcset="{{ asset('images/hero-01-1024px.jpg') }} 1x, {{ asset('images/hero-01-1024px@2x.jpg') }} 2x">
                    <img
                        width="624"
                        height="556"
                        data-src="{{ asset('images/hero-01.jpg') }}"
                        data-srcset="{{ asset('images/hero-01@2x.jpg') }} 2x"
                        class="lazy aspect-[64/57] rounded-md aos-init"
                        data-aos="fade-up"
                        alt="Sviatoslav Otchenash"
                    >
                </picture>
            </div>
        </div>
    </section>
</div>
