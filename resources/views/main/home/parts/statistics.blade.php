<section class="c-sheet max-sm:max-w-sm pt-20 md:pt-28" id="about">
    <div class="mb-3 mx-auto flex justify-center max-w-[30%] sm:max-w-[11rem] xl:max-w-none">
        <img
            width="300"
            height="220"
            data-src="{{ Vite::image('logo-3d.jpg') }}"
            data-srcset="{{ Vite::image('logo-3d@2x.jpg') }} 2x"
            alt="Sviato Academy"
            class="lazy aspect-[30/22] mix-blend-lighten aos-init"
            data-aos="fade-up"
        >
    </div>
    <div class="mx-auto lg:max-xl:max-w-3xl">
        <div class="relative z-10">
            <h2 class="b-h1 mb-0 flex flex-col aos-init aos-animate" data-aos="fade-up">
                {{ __('Sviato Academy') }}
                <div class="ml-auto">{{ __('by') }}&nbsp;<span class="inline-block u-text--primary italic px-3 -mx-3">{{ __('the numbers') }}</span></div>
            </h2>
            <div class="text-white text-sm flex flex-wrap justify-between md:text-lg">
                <dl class="flex flex-col-reverse items-end aos-init aos-animate" data-aos="fade-up">
                    <dt>{{ __('Trainers') }}</dt>
                    <dd class="b-h1 text-inherit mb-0 md:mb-1 max-sm:text-4xl">+96</dd>
                </dl>

                <dl class="flex flex-col-reverse items-end aos-init aos-animate" data-aos="fade-up">
                    <dt>{{ __('Students') }}</dt>
                    <dd class="b-h1 text-inherit mb-0 md:mb-1 max-sm:text-4xl">+25 703</dd>
                </dl>

                <dl class="flex flex-col-reverse items-end aos-init aos-animate" data-aos="fade-up">
                    <dt>{{ __('Countries') }}</dt>
                    <dd class="b-h1 text-inherit mb-0 md:mb-1 max-sm:text-4xl">+34</dd>
                </dl>
            </div>
        </div>
        <div class="px-[15%] mb-6 lg:px-[19%]">
            <picture>
                <source media="(max-width: 640px)" data-srcset="{{ asset('images/earth-640px.png') }} 1x, {{ asset('images/earth-640px@2x.png') }} 2x">
                <img
                    width="840"
                    height="840"
                    data-src="{{ asset('images/earth.png') }}"
                    data-srcset="{{ asset('images/earth@2x.png') }} 2x"
                    class="lazy aspect-square mix-blend-screen mx-auto -mt-28 md:-mt-[34.5%] aos-init"
                    data-aos="fade-up"
                    alt="Earth"
                >
            </picture>
        </div>
    </div>
    <div class="pt-[12.5rem] mt-20 relative sm:pt-[13.5rem] md:pt-[4.5rem]">
        <img
            width="384"
            height="800"
            data-src="{{ Vite::image('hero-03.png') }}"
            data-srcset="{{ Vite::image('hero-03@2x.png') }} 2x"
            alt="Sviatoslav Otchenash"
            @class([
                'aspect-[12/25]',
                'c-mask-opacity-to-bottom-75',
                'mx-auto max-w-[15rem] h-auto absolute left-0 right-0 top-0',
                'sm:max-w-[16rem]',
                'md:mx-0 md:left-[24.6rem] md:max-w-[19.9rem] md:z-10',
                'lg:left-[34.5rem] lg:-top-[9%]',
                'xl:max-w-none xl:left-[42.3rem] xl:top-[2%]',
                '2xl:left-[51rem] 2xl:-top-[12%]',
                '3xl:left-[51.7rem]',
                'aos-init',
                'lazy',
            ])
            data-aos="fade-up"
        >
        <div
            class="mx-auto w-full max-w-xs relative sm:max-w-md md:ml-[5%] md:mr-0 md:max-w-[25rem] lg:max-w-[34rem] xl:max-w-[40rem] xl:ml-[7%] 2xl:max-w-[49rem] aos-init" data-aos="fade-up"
        >
            <p class="b-h5">
			<span class="u-text--primary">A key figure in the history of beauty industry - Sviatoslav Otchenash</span> is an internationally recognised <span class="u-text--primary">top PMU 
			Master and Top Trainer</span> with over a decade of extensive experience in the craft of permanent makeup.
            </p>
        </div>
    </div>
    <div class="pt-20 mx-auto relative z-10 max-md:max-w-md md:pt-28 md:flex md:items-end lg:items-center">
        <div class="mb-6 md:mb-5 md:w-1/2 lg:pr-[7%]">
            <picture>
                <source media="(max-width: 420px)" data-srcset="{{ asset('images/hero-04-420px.jpg') }} 1x, {{ asset('images/hero-04-420px@2x.jpg') }} 2x">
                <img
                    width="560"
                    height="496"
                    data-src="{{ asset('images/hero-04.jpg') }}"
                    data-srcset="{{ asset('images/hero-04@2x.jpg') }} 2x"
                    class="lazy aspect-[35/31] rounded-md aos-init"
                    data-aos="fade-up"
                    alt="Sviatoslav Otchenash"
                >
            </picture>
        </div>
        <div class="sm:px-6 md:pl-6 md:w-1/2 lg:px-[3%] lg:w-[46.5%] 2xl:w-[27rem]">
            <p class="aos-init" data-aos="fade-up">
			He has started <span class="u-text--primary">his professional journey</span> from the field of art tattoo. 
			Having a higher artistic education, creative skills, and deep knowledge of both fine arts and tattoo machines operation, 
			<span class="u-text--primary">Sviatoslav has quickly moved up the career stairs</span>, and achieved the top-class results in the PMU craft within a short 
			period of time.
            </p>
            <p class="aos-init" data-aos="fade-up">
			The unique new-generation techniques he created are known and popular throughout the world. To date, 
			Sviatoslav has conducted more than 450 international masterclasses on PMU that were taking place in every part of the globe.
            </p>
        </div>
    </div>
</section>
