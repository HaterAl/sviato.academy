@extends('_l.templates.base')

@php
    $config = App\Models\Layouts::config();
@endphp

@section('main')
    <main class="c-sheet">
        <div class="relative">
            <h1 class="sr-only">{{ $config->name }}</h1>

            <div class="px-[13%] flex justify-center">
                <div class="c-spotlight">
                    <img
                        src="{{ Vite::asset('resources/images/hero.png') }}"
                        width="840"
                        height="840"
                        class="aspect-square relative"
                        alt="Sviato Otchenash from {{ $config->name }}"
                    >
                </div>
            </div>

            <section class="absolute left-0 right-0 bottom-[20%] md:flex md:items-center">
                <div class="md:w-1/3 xl:w-6/12">
                    <h2>Redefining <br><span class="u-text--primary italic pl-[32%] pr-2">Beauty</span></h2>
                </div>

                <div class="flex md:w-2/3 xl:w-6/12">
                    <div class="text-sm pl-9 md:w-1/2">
                        <p>In the four years since we started, Sviato Academy has redefined the standards of the <span class="u-text--primary">permanent makeup industry</span>. Led by one of the world’s leading permanent makeup artists, Sviatoslav Otchenash, we have become the <span class="u-text--primary">go-to institution</span> for gifted individuals seeking to perfect their craft.</p>
                    </div>

                    <div class="text-sm pl-9 md:w-1/2">
                        <p>Our techniques and training methods are the results of over a decade of the tireless <span class="u-text--primary">pursuit of perfection</span>. We have proven time and time again that our innovative approach and constant evolution stand head and shoulders above other academies.</p>
                    </div>
                </div>
            </section>
        </div>

        {{-- <section class="py-20 relative">
            <h2 class="b-h1">Our <span class="u-text--primary italic">products</span></h2>

            <h3>S-Liner Basic</h3>

            <dl>
                <dt class="sr-only">Price</dt>
                <dd class="u-text--primary b-h3">€1,000.00</dd>
            </dl>
        </section> --}}
    </main>
@endsection

{{-- @section('beforeFooter') @parent @endsection --}}
{{-- @section('afterFooter') @parent @endsection --}}
