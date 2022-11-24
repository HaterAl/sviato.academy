@extends('_l.templates.base')

@php
    $config = App\Models\Layouts::config();
@endphp

@section('main')
    <main class="c-sheet">
        <h1 class="sr-only">{{ $config->name }}</h1>

        <div class="px-[13%] flex justify-center">
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

        <section class="relative">
            <div class="mb-28 absolute left-0 right-0 bottom-full md:flex md:items-center">
                <div class="md:w-1/3 xl:w-6/12 flex">
                    <h2>Redefining <br><span class="u-text--primary italic pl-[68.5%] pr-2">Beauty</span></h2>
                </div>

                <div class="flex md:w-2/3 xl:w-6/12">
                    <div class="text-sm pl-9 md:w-1/2">
                        <p>In the four years since we started, Sviato Academy has redefined the standards of <span class="u-text--primary">the permanent makeup industry</span>. Led by one of the world’s leading permanent makeup artists, Sviatoslav Otchenash, we have become <span class="u-text--primary">the go-to institution</span> for gifted individuals seeking to perfect their craft.</p>
                    </div>

                    <div class="text-sm pl-9 md:w-1/2">
                        <p>Our techniques and training methods are the results of over a decade of the tireless <span class="u-text--primary">pursuit of perfection</span>. We have proven time and time again that our innovative approach and constant evolution stand head and shoulders above other academies.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="px-4 pt-28">
                    <img
                    src="{{ Vite::image('hero-01.jpg') }}"
                    width="640"
                    height="570"
                    class="rounded-md"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    >
                </div>

                <div class="px-4">
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

        <section class="pt-28">
            <div class="flex justify-center mb-3">
                <img
                src="{{ Vite::image('logo-3d.jpg') }}"
                srcset="{{ Vite::image('logo-3d@2x.jpg').' 2x' }}"
                class="mix-blend-lighten"
                width="300"
                height="220"
                alt="{{ $config->name.' 3D logo' }}"
                >
            </div>

            <div class="relative z-10">
                <h2 class="b-h1 mb-0">Sviato Academy <div class="pl-[32.3%]">by <span class="u-text--primary italic pr-2">the numbers</span></div></h2>

                <div class="flex justify-between text-white text-lg">
                    <dl class="flex flex-col-reverse">
                        <dt class="self-end">Trainers</dt>
                        <dd class="b-h1 mb-1">+190</dd>
                    </dl>

                    <dl class="flex flex-col-reverse">
                        <dt class="self-end">Students</dt>
                        <dd class="b-h1 mb-1">16 000</dd>
                    </dl>

                    <dl class="flex flex-col-reverse">
                        <dt class="self-end">Countries</dt>
                        <dd class="b-h1 mb-1">44</dd>
                    </dl>
                </div>
            </div>

            <div class="px-[19%]">
                <img
                src="{{ Vite::image('Earth.jpg') }}"
                class="mix-blend-screen mx-auto -mt-[34.5%]"
                width="840"
                height="840"
                alt="Earth"
                >
            </div>

            <div class="flex">
                <div class="pt-28 ml-[5%] w-[56%] relative">
                    <p class="b-h5">In my over <span class="u-text--primary">10 years</span> working in the permanent makeup industry, I’ve held over <span class="u-text--primary">400 masterclasses worldwide</span> and trained some of the world’s top artists. But, my interest in beauty goes back much longer.</p>
                </div>

                <div>
                    <img
                    src="{{ Vite::image('hero-03.png') }}"
                    srcset="{{ Vite::image('hero-03@2x.png') }}"
                    width="384"
                    height="800"
                    class="c-mask-opacity-to-bottom-75 -ml-[9.5%] -mb-[74%]"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    >
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-1/2 pr-[9%]">
                    <img
                    src="{{ Vite::image('hero-04.jpg') }}"
                    width="560"
                    height="496"
                    class="rounded-md"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    >
                </div>

                <div class="w-[23%] ml-4">
                    <p>Before becoming a PMU trainer, I spent years working professionally as a <span class="u-text--primary">tattoo artist</span> <span class="u-text--primary">and art educator</span>. That foundation allowed me quickly develop the skills needed for elite-level PMU. But, it was my years spent in art education that gave me the patience, people skills, and creativity needed to develop my own unique approach to training and PMU.</p>
                    <p>The techniques I’ve developed have since become industry staples and the continuous improvement of these techniques continues to drive my dedication to perfection.</p>
                </div>
            </div>

            <div class="ml-[41%]">
                <img
                src="{{ Vite::image('hero-05.jpg') }}"
                srcset="{{ Vite::image('hero-05@2x.jpg') }}"
                width="192"
                height="288"
                class="rounded-md"
                alt="Sviato Otchenash from {{ $config->name }}"
                >
            </div>
        </section>

        <section class="py-28">
            <h2 class="b-h1 text-center mb-14">Our <span class="u-text--primary italic pr-2">trainers</span></h2>

            <div class="-mx-8 flex">
                <div class="px-8 w-1/5">
                    <img
                    src="{{ Vite::image('coach-00.jpg') }}"
                    {{-- srcset="{{ Vite::image('hero-05@2x.jpg') }}" --}}
                    width=""
                    height=""
                    class="rounded mb-7"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    >

                    <h3 class="b-h6 text-white mb-2">
                        <a href="#" class="hover:text-gold-dark">Maja <div class="pl-[15%]">Granic</div></a>
                    </h3>
                    <p>Permanent makeup</p>
                </div>

                <div class="px-8 w-1/5">
                    <img
                    src="{{ Vite::image('coach-00.jpg') }}"
                    {{-- srcset="{{ Vite::image('hero-05@2x.jpg') }}" --}}
                    width=""
                    height=""
                    class="rounded mb-7"
                    alt="Sviato Otchenash from {{ $config->name }}"
                    >

                    <h3 class="b-h6 text-white mb-2">
                        <a href="#" class="hover:text-gold-dark">Chris <div class="pl-[15%]">Barrows</div></a>
                    </h3>
                    <p>Makeup</p>
                </div>
            </div>
        </section>

        <section class="py-28">
            <h2 class="text-center max-w-4xl mx-auto mb-14">Here are the steps how to join and advance within the <span class="u-text--primary italic pr-2">Sviato Academy</span> team</h2>

            <div class="max-w-xl mx-auto">
                <p>Find and sign up for a Basic course or Masterclass on the Sviato Academy website, which includes practice on live models</p>

                <p>After the class, practice hard. Every time you have a client, take a picture of your work and send it to your Trainer. If the Trainer says that you did an excellent job, publish the work on social pages and make sure you tag your Trainer in the post. 10 works like this and you get the logo with 1 star!</p>

                <p>To become a Stylist, you need to take further training and to publish 20 high-quality works with the 1-star logo on social pages. Again, your Trainer should check your works, and you should tag her/him in the description of each post</p>

                <p>To obtain the status of a Trainer, you must post on your social media profiles at least 50 high-quality works with the Stylist logo that have been accepted by your Trainer</p>

                <p>In terms of skill, there is no difference between Trainers and Top Trainers. Becoming a Top Trainer is a matter of personality. Top Trainers must be good people, agreeable, highly professional, admired and respected by a large number of students.</p>
            </div>
        </section>

        <section class="py-20 relative">
            <h2 class="b-h1 text-center mb-14">Our <span class="u-text--primary italic">products</span></h2>

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
