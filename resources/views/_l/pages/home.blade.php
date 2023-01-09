@extends('_l.templates.base')

@php
    $config = App\Models\Layouts::config();
    $coaches = App\Models\Layouts::coaches();
    $products = App\Models\Layouts::products();
@endphp

@section('main')
    <main>
        <div class="c-sheet max-sm:max-w-md">
            <h1 class="sr-only">{{ $config->name }}</h1>

            <div class="flex justify-center md:px-[13%]">
                <div class="max-w-full c-spotlight">
                    <img
                        src="{{ Vite::image('hero-00.png') }}"
                        width="840"
                        height="840"
                        alt="Sviato Otchenash from {{ $config->name }}"
                        class="relative c-mask-opacity-to-bottom-5 aspect-square"
                    >
                </div>
            </div>

            <section class="relative -mt-28 sm:-mt-48 lg:-mt-28 2xl:-mt-36 3xl:-mt-40">
                <div class="lg:absolute lg:left-0 lg:right-0 lg:bottom-full lg:flex 3xl:items-center">
                    <div class="lg:w-1/3 xl:w-1/2 aos-init" data-aos="fade-up">
                        <h2>Redefining <div class="u-text--primary italic pl-[2.47em] pr-2 -mr-2">Beauty</div></h2>
                    </div>

                    <div class="md:pt-0 sm:flex lg:w-2/3 xl:w-1/2">
                        <div class="text-sm pl-9 sm:w-1/2 aos-init" data-aos="fade-up">
                            <p>In the four years since we started, Sviato Academy has redefined the standards of <span class="u-text--primary">the permanent makeup industry</span>. Led by one of the world’s leading permanent makeup artists, Sviatoslav Otchenash, we have become <span class="u-text--primary">the go-to institution</span> for gifted individuals seeking to perfect their craft.</p>
                        </div>

                        <div class="text-sm pl-9 sm:w-1/2 aos-init" data-aos="fade-up">
                            <p>Our techniques and training methods are the results of over a decade of the tireless <span class="u-text--primary">pursuit of perfection</span>. We have proven time and time again that our innovative approach and constant evolution stand head and shoulders above other academies.</p>
                        </div>
                    </div>
                </div>

                <div class="mx-auto max-sm:max-w-md md:pt-28 md:flex md:justify-center">
                    <div class="pr-[24%] mb-6 md:w-1/2 md:px-4 md:pt-28">
                        <button class="c-play" data-player-open="76979871">
                            <img
                                src="{{ Vite::image('hero-01.jpg') }}"
                                width="640"
                                height="570"
                                alt="Sviato Otchenash from {{ $config->name }}"
                                class="aspect-[64/57] rounded-md aos-init"
                                data-aos="fade-up"
                            >
                        </button>
                    </div>

                    <div class="pl-[24%] mb-6 md:w-1/2 md:px-4">
                        <button class="c-play" data-player-open="787594424">
                            <img
                                src="{{ Vite::image('hero-02.jpg') }}"
                                width="640"
                                height="570"
                                alt="Sviato Otchenash from {{ $config->name }}"
                                class="aspect-[64/57] rounded-md aos-init"
                                data-aos="fade-up"
                            >
                        </button>
                    </div>
                </div>
            </section>
        </div>

        <section class="pt-20 c-sheet max-sm:max-w-sm md:pt-28">
            <div class="mb-3 mx-auto flex justify-center max-w-[30%] sm:max-w-[11rem] xl:max-w-none">
                <img
                    src="{{ Vite::image('logo-3d.jpg') }}"
                    srcset="{{ Vite::image('logo-3d@2x.jpg').' 2x' }}"
                    width="300"
                    height="220"
                    alt="{{ $config->name.' 3D logo' }}"
                    class="aspect-[30/22] mix-blend-lighten aos-init"
                    data-aos="fade-up"
                >
            </div>

            <div class="mx-auto lg:max-xl:max-w-3xl">
                <div class="relative z-10">
                    <h2 class="flex flex-col mb-0 b-h1 aos-init" data-aos="fade-up">
                        Sviato Academy
                        <div class="ml-auto">by <span class="inline-block px-3 -mx-3 italic u-text--primary">the numbers</span></div>
                    </h2>

                    <div class="flex flex-wrap justify-between text-sm text-white md:text-lg">
                        <dl class="flex flex-col-reverse items-end aos-init" data-aos="fade-up">
                            <dt>Trainers</dt>
                            <dd class="mb-0 b-h1 text-inherit md:mb-1 max-sm:text-4xl">+190</dd>
                        </dl>

                        <dl class="flex flex-col-reverse items-end aos-init" data-aos="fade-up">
                            <dt>Students</dt>
                            <dd class="mb-0 b-h1 text-inherit md:mb-1 max-sm:text-4xl">16 000</dd>
                        </dl>

                        <dl class="flex flex-col-reverse items-end aos-init" data-aos="fade-up">
                            <dt>Countries</dt>
                            <dd class="mb-0 b-h1 text-inherit md:mb-1 max-sm:text-4xl">44</dd>
                        </dl>
                    </div>
                </div>

                <div class="px-[15%] mb-6 lg:px-[19%]">
                    <img
                    src="{{ Vite::image('Earth.jpg') }}"
                    width="840"
                    height="840"
                    alt="Earth"
                    class="aspect-square mix-blend-screen mx-auto -mt-28 md:-mt-[34.5%] aos-init"
                    data-aos="fade-up"
                    >
                </div>
            </div>

            <div class="pt-[12.5rem] mt-20 relative sm:pt-[13.5rem] md:pt-[4.5rem]">
                <img
                    src="{{ Vite::image('hero-03.png') }}"
                    srcset="{{ Vite::image('hero-03@2x.png').' 2x' }}"
                    width="384"
                    height="800"
                    alt="Sviato Otchenash from {{ $config->name }}"
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
                    ])
                    data-aos="fade-up"
                >

                <div
                @class([
                    'mx-auto w-full max-w-xs relative',
                    'sm:max-w-md',
                    'md:ml-[5%] md:mr-0 md:max-w-[25rem]',
                    'lg:max-w-[34rem]',
                    'xl:max-w-[40rem] xl:ml-[7%]',
                    '2xl:max-w-[49rem]',
                    'aos-init',
                ])
                data-aos="fade-up"
                >
                    <p class="b-h5">In my over <span class="u-text--primary">10 years</span> working in the permanent makeup industry, I’ve held over <span class="u-text--primary">400 masterclasses worldwide</span> and trained some of the world’s top artists. But, my interest in beauty goes back much longer.</p>
                </div>
            </div>

            <div class="relative z-10 pt-20 mx-auto max-md:max-w-md md:pt-28 md:flex md:items-end lg:items-center">
                <div class="mb-6 md:mb-5 md:w-1/2 lg:pr-[7%]">
                    <img
                    src="{{ Vite::image('hero-04.jpg') }}"
                    width="560"
                    height="496"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    class="aspect-[35/31] rounded-md aos-init"
                    data-aos="fade-up"
                    >
                </div>

                <div class="sm:px-6 md:pl-6 md:w-1/2 lg:px-[3%] lg:w-[46.5%] 2xl:w-[27rem]">
                    <p class="aos-init" data-aos="fade-up">Before becoming a PMU trainer, I spent years working professionally as a <span class="u-text--primary">tattoo artist</span> <span class="u-text--primary">and art educator</span>. That foundation allowed me quickly develop the skills needed for elite-level PMU. But, it was my years spent in art education that gave me the patience, people skills, and creativity needed to develop my own unique approach to training and PMU.</p>
                    <p class="aos-init" data-aos="fade-up">The techniques I’ve developed have since become industry staples and the continuous improvement of these techniques continues to drive my dedication to perfection.</p>
                </div>
            </div>

            <div class="pl-[43%] md:max-lg:pl-[50%] pt-1">
                <img
                src="{{ Vite::image('hero-05.jpg') }}"
                srcset="{{ Vite::image('hero-05@2x.jpg').' 2x' }}"
                width="192"
                height="288"
                alt="Sviato Otchenash from {{ $config->name }}"
                class="aspect-[2/3] rounded-md aos-init"
                data-aos="fade-up"
                >
            </div>
        </section>

        <div class="overflow-hidden">
            <section class="pt-20 c-sheet splide splide--arrows-bottom md:pt-28" data-carousel-row>
                <h2 class="mb-6 b-h1 md:text-center md:mb-14 aos-init" data-aos="fade-up">Our <span class="px-2 -mx-2 italic u-text--primary">trainers</span></h2>

                <div class="splide__body md:max-xl:mx-6 aos-init" data-aos="fade-up">
                    <div class="splide__arrows aos-init" data-aos="fade-up">
                        <button class="splide__arrow splide__arrow--prev">@svg('arrow-ltr', '-scale-x-1')</button>

                        <button class="splide__arrow splide__arrow--next">@svg('arrow-ltr')</button>
                    </div>

                    <div class="-mx-6 overflow-visible splide__track">
                        <div class="splide__list">
                            @foreach ($coaches as $coache)
                                <div class="w-1/5 pl-6 splide__slide md:pr-6">
                                    <article class="relative flex flex-col-reverse text-sm">
                                        <div class="flex flex-col">
                                            <h3 class="mb-1 italic text-white b-h6">
                                                {{-- <a href="#" class="splide__slide__link">{{ $coache['fname'] }} <div class="pl-[15%]">{{ $coache['lname'] }}</div></a> --}}
                                                {{ $coache['fname'] }} <div class="pl-[15%]">{{ $coache['lname'] }}</div>
                                            </h3>

                                            <dl class="absolute right-0 -mt-px -order-1">
                                                <dt class="sr-only">Country</dt>
                                                <dd>{{ $coache['country'] }}</dd>
                                            </dl>

                                            <dl>
                                                <dt class="sr-only">Type of courses</dt>
                                                <dd>{{ $coache['specialty'] }}</dd>
                                            </dl>

                                            <dl class="flex -mx-1 -mt-3">
                                                <dt class="sr-only">Accounts in social networks</dt>
                                                @foreach ($coache['socials'] as $social)
                                                    <dd>
                                                        <a href="#" class="block p-1">
                                                            <span class="sr-only">{{ $social }}</span>
                                                            @svg($social.'-gold')
                                                        </a>
                                                    </dd>
                                                @endforeach
                                            </dl>
                                        </div>

                                        <img
                                        src="{{ Vite::image($coache['img']) }}"
                                        width="252"
                                        height="252"
                                        alt="{{ $coache['fname'] }} {{ $coache['lname'] }}"
                                        class="mb-4 rounded aspect-square"
                                        >
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section class="max-w-xl px-6 pt-20 mx-auto sm:max-w-xl md:pt-28 md:max-w-2xl xl:max-w-4xl">
            <h2 class="max-w-lg mb-5 max-sm:text-4xl sm:text-center md:mb-9 md:max-w-none xl:mb-14 aos-init" data-aos="fade-up">Here are the steps how to join and advance within the <span class="inline-block px-2 -mx-2 italic u-text--primary">Sviato Academy</span> team</h2>

            <div class="px-[7%] sm:px-[14%] md:[&>*]:mb-7 xl:[&>*]:mb-12">
                <p class="aos-init" data-aos="fade-up">Find and sign up for a Basic course or Masterclass on the Sviato Academy website, which includes practice on live models</p>

                <p class="aos-init" data-aos="fade-up">After the class, practice hard. Every time you have a client, take a picture of your work and send it to your Trainer. If the Trainer says that you did an excellent job, publish the work on social pages and make sure you tag your Trainer in the post. 10 works like this and you get the logo with 1 star!</p>

                <p class="aos-init" data-aos="fade-up">To become a Stylist, you need to take further training and to publish 20 high-quality works with the 1-star logo on social pages. Again, your Trainer should check your works, and you should tag her/him in the description of each post</p>

                <p class="aos-init" data-aos="fade-up">To obtain the status of a Trainer, you must post on your social media profiles at least 50 high-quality works with the Stylist logo that have been accepted by your Trainer</p>

                <p class="aos-init" data-aos="fade-up">In terms of skill, there is no difference between Trainers and Top Trainers. Becoming a Top Trainer is a matter of personality. Top Trainers must be good people, agreeable, highly professional, admired and respected by a large number of students.</p>
            </div>
        </section>

        <div class="overflow-hidden">
            <section class="pt-20 c-sheet splide splide--arrows-center splide--branded md:pt-28" data-carousel-showcase>
                <h2 class="mb-20 text-center b-h1 aos-init" data-aos="fade-up">Our <span class="px-2 -mx-2 italic u-text--primary">products</span></h2>

                <div class="relative aos-init" data-aos="fade-up">
                    <div class="splide__arrows aos-init" data-aos="fade-up">
                        <button class="splide__arrow splide__arrow--prev">@svg('arrow-ltr', '-scale-x-1')</button>

                        <button class="splide__arrow splide__arrow--next">@svg('arrow-ltr')</button>
                    </div>

                    <div class="mx-auto overflow-visible splide__track md:w-3/5">
                        <div class="splide__list">
                            @foreach ($products as $product)
                                <article class="text-center splide__slide md:px-12">
                                    <h3 class="mb-8">
                                        <a href="#" class="splide__slide__link">{{ $product['name'] }}</a>
                                    </h3>

                                    <div class="mb-16 splide__slide__img">
                                        <img
                                        src="{{ Vite::image($product['img']) }}"
                                        width="358"
                                        height="358"
                                        alt="{{ $product['name'] }}"
                                        class="relative aspect-square">
                                    </div>

                                    <dl>
                                        <dt class="sr-only">Price</dt>
                                        <dd class="u-text--primary b-h3">{{ $product['price'] }}</dd>
                                    </dl>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div class="c-player" data-player>
        <button class="c-player__close" data-player-close>
            @svg('close')
        </button>

        <div class="c-player__inner" data-player-inner></div>
    </div>
@endsection

{{-- @section('beforeFooter') @parent @endsection --}}
{{-- @section('afterFooter') @parent @endsection --}}
