@extends('_l.templates.base')

@php
    $config = App\Models\Layouts::config();
@endphp

@section('main')
    <main>
        <div class="c-sheet max-sm:max-w-md">
            <h1 class="sr-only">{{ $config->name }}</h1>

            <div class="flex justify-center md:px-[13%]">
                <div class="c-spotlight">
                    <img
                    src="{{ Vite::image('hero-00.png') }}"
                    width="840"
                    height="840"
                    class="c-mask-opacity-to-bottom-5 relative"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    >
                </div>
            </div>

            <section class="relative -mt-28 sm:-mt-48">
                <div class="lg:absolute lg:left-0 lg:right-0 lg:bottom-full lg:flex lg:items-center">
                    <div class="lg:w-1/3 xl:w-6/12">
                        <h2>Redefining <div class="u-text--primary italic pl-[2.47em] pr-2 -mr-2">Beauty</div></h2>
                    </div>

                    <div class="md:pt-0 sm:flex lg:w-2/3 xl:w-6/12">
                        <div class="text-sm pl-9 sm:w-1/2">
                            <p>In the four years since we started, Sviato Academy has redefined the standards of <span class="u-text--primary">the permanent makeup industry</span>. Led by one of the world’s leading permanent makeup artists, Sviatoslav Otchenash, we have become <span class="u-text--primary">the go-to institution</span> for gifted individuals seeking to perfect their craft.</p>
                        </div>

                        <div class="text-sm pl-9 sm:w-1/2">
                            <p>Our techniques and training methods are the results of over a decade of the tireless <span class="u-text--primary">pursuit of perfection</span>. We have proven time and time again that our innovative approach and constant evolution stand head and shoulders above other academies.</p>
                        </div>
                    </div>
                </div>

                <div class="mx-auto max-sm:max-w-md md:pt-28 md:flex md:justify-center">
                    <div @class([
                        'pr-[24%] mb-6',
                        'md:px-4 md:pt-28',
                    ])>
                        <img
                        src="{{ Vite::image('hero-01.jpg') }}"
                        width="640"
                        height="570"
                        class="rounded-md"
                        alt="Sviato Otchenash from {{ $config->name }}"
                        >
                    </div>

                    <div @class([
                        'pl-[24%] mb-6',
                        'md:px-4',
                    ])>
                        <img
                        src="{{ Vite::image('hero-02.jpg') }}"
                        width="640"
                        height="570"
                        class="rounded-md"
                        alt="Sviato Otchenash from {{ $config->name }}"
                        >
                    </div>
                </div>
            </section>
        </div>

        <section class="c-sheet max-sm:max-w-sm pt-20 md:pt-28">
            <div class="mb-3 mx-auto flex justify-center max-w-[30%] sm:max-w-[25%] lg:max-w-none">
                <img
                src="{{ Vite::image('logo-3d.jpg') }}"
                srcset="{{ Vite::image('logo-3d@2x.jpg').' 2x' }}"
                class="mix-blend-lighten"
                width="300"
                height="220"
                alt="{{ $config->name.' 3D logo' }}"
                >
            </div>

            <div class="mx-auto lg:max-w-none">
                <div class="relative z-10">
                    <h2 class="b-h1 mb-0 flex flex-col">
                        Sviato Academy
                        <div class="ml-auto">by <span class="inline-block u-text--primary italic px-3 -mx-3">the numbers</span></div>
                    </h2>

                    <div class="text-white text-sm flex flex-wrap justify-between md:text-lg">
                        <dl class="flex flex-col-reverse items-end">
                            <dt>Trainers</dt>
                            <dd class="b-h1 text-inherit mb-0 md:mb-1 max-sm:text-4xl">+190</dd>
                        </dl>

                        <dl class="flex flex-col-reverse items-end">
                            <dt>Students</dt>
                            <dd class="b-h1 text-inherit mb-0 md:mb-1 max-sm:text-4xl">16 000</dd>
                        </dl>

                        <dl class="flex flex-col-reverse items-end">
                            <dt>Countries</dt>
                            <dd class="b-h1 text-inherit mb-0 md:mb-1 max-sm:text-4xl">44</dd>
                        </dl>
                    </div>
                </div>

                <div class="px-[15%] mb-6 lg:px-[19%]">
                    <img
                    src="{{ Vite::image('Earth.jpg') }}"
                    class="mix-blend-screen mx-auto -mt-28 md:-mt-[34.5%]"
                    width="840"
                    height="840"
                    alt="Earth"
                    >
                </div>
            </div>

            <div class="pt-[12.5rem] mt-20 relative sm:pt-[13.5rem] md:pt-[4.5rem]">
                <img
                src="{{ Vite::image('hero-03.png') }}"
                srcset="{{ Vite::image('hero-03@2x.png').' 2x' }}"
                width="384"
                height="800"
                @class([
                    'c-mask-opacity-to-bottom-75',
                    'mx-auto max-w-[15rem] h-auto absolute left-0 right-0 top-0',
                    'sm:max-w-[16rem]',
                    'md:mx-0 md:left-[24.6rem] md:max-w-[19.9rem] md:z-10',
                ])
                alt="Sviato Otchenash from {{ $config->name }}"
                >

                <div class="mx-auto max-w-xs relative sm:max-w-md md:ml-[5%] md:mr-0 md:w-[25rem] lg:w-[59%]">
                    <p class="b-h5">In my over <span class="u-text--primary">10 years</span> working in the permanent makeup industry, I’ve held over <span class="u-text--primary">400 masterclasses worldwide</span> and trained some of the world’s top artists. But, my interest in beauty goes back much longer.</p>
                </div>
            </div>

            <div class="pt-20 mx-auto relative z-10 max-md:max-w-md md:pt-28 md:flex md:items-end lg:items-center">
                <div class="mb-6 md:mb-5 md:w-1/2 lg:pr-[7%]">
                    <img
                    src="{{ Vite::image('hero-04.jpg') }}"
                    width="560"
                    height="496"
                    class="rounded-md"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    >
                </div>

                <div class="sm:px-6 md:pl-6 md:w-1/2 lg:pl-[7%] lg:w-[26.5%]">
                    <p>Before becoming a PMU trainer, I spent years working professionally as a <span class="u-text--primary">tattoo artist</span> <span class="u-text--primary">and art educator</span>. That foundation allowed me quickly develop the skills needed for elite-level PMU. But, it was my years spent in art education that gave me the patience, people skills, and creativity needed to develop my own unique approach to training and PMU.</p>
                    <p>The techniques I’ve developed have since become industry staples and the continuous improvement of these techniques continues to drive my dedication to perfection.</p>
                </div>
            </div>

            <div class="pl-[43%] md:max-lg:pl-[50%] pt-1">
                <img
                src="{{ Vite::image('hero-05.jpg') }}"
                srcset="{{ Vite::image('hero-05@2x.jpg').' 2x' }}"
                width="192"
                height="288"
                class="rounded-md"
                alt="Sviato Otchenash from {{ $config->name }}"
                >
            </div>
        </section>

        <div class="overflow-hidden">
            <section class="c-sheet splide splide--arrows-bottom pt-20 md:pt-28 js-carousel">
                <h2 class="b-h1 md:text-center md:mb-14">Our <span class="u-text--primary italic px-2 -mx-2">trainers</span></h2>

                @php
                    $coaches = App\Models\Layouts::coaches();
                @endphp

                <div class="splide__body md:mx-6">
                    <div class="splide__arrows">
                        <button class="splide__arrow splide__arrow--prev hover:text-gold-dark">@svg('arrow-ltr', '-scale-x-1')</button>

                        <button class="splide__arrow splide__arrow--next hover:text-gold-dark">@svg('arrow-ltr')</button>
                    </div>

                    <div class="splide__track overflow-visible -mx-6 xl:-mx-8">
                        <div class="splide__list">
                            @foreach ($coaches as $coache)
                                <div class="splide__slide pl-6 md:px-6 xl:px-8 w-1/5">
                                    <article class="relative">
                                        <img
                                        src="{{ Vite::image('coach-00.jpg') }}"
                                        {{-- srcset="{{ Vite::image('hero-05@2x.jpg').' 2x' }}" --}}
                                        width=""
                                        height=""
                                        class="rounded mb-5"
                                        alt="{{ $coache['fname'] }} {{ $coache['lname'] }}"
                                        >

                                        <h3 class="b-h6 text-white mb-0">
                                            <a href="#" class="splide__slide__link">{{ $coache['fname'] }} <div class="pl-[15%]">{{ $coache['lname'] }}</div></a>
                                        </h3>
                                        <p>{{ $coache['specialty'] }}</p>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section class="c-sheet pt-20 md:pt-28">
            <h2 class="mx-auto max-w-lg mb-5 max-sm:text-4xl md:text-center md:mb-14 xl:max-w-4xl">Here are the steps how to join and advance within the <span class="inline-block u-text--primary italic px-2 -mx-2">Sviato Academy</span> team</h2>

            <div class="max-w-md px-[7%] xl:max-w-xl mx-auto">
                <p>Find and sign up for a Basic course or Masterclass on the Sviato Academy website, which includes practice on live models</p>

                <p>After the class, practice hard. Every time you have a client, take a picture of your work and send it to your Trainer. If the Trainer says that you did an excellent job, publish the work on social pages and make sure you tag your Trainer in the post. 10 works like this and you get the logo with 1 star!</p>

                <p>To become a Stylist, you need to take further training and to publish 20 high-quality works with the 1-star logo on social pages. Again, your Trainer should check your works, and you should tag her/him in the description of each post</p>

                <p>To obtain the status of a Trainer, you must post on your social media profiles at least 50 high-quality works with the Stylist logo that have been accepted by your Trainer</p>

                <p>In terms of skill, there is no difference between Trainers and Top Trainers. Becoming a Top Trainer is a matter of personality. Top Trainers must be good people, agreeable, highly professional, admired and respected by a large number of students.</p>
            </div>
        </section>

        <section class="c-sheet pt-20 md:pt-28">
            <h2 class="b-h1 text-center mb-14">Our <span class="u-text--primary px-2 -mx-2 italic">products</span></h2>

            <article class="text-center">
                <h3>S-Liner Basic</h3>

                <dl>
                    <dt class="sr-only">Price</dt>
                    <dd class="u-text--primary b-h3">€1,000.00</dd>
                </dl>
            </article>
        </section>
    </main>
@endsection

{{-- @section('beforeFooter') @parent @endsection --}}
{{-- @section('afterFooter') @parent @endsection --}}
