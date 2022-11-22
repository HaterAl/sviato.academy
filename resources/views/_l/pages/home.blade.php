@extends('_l.templates.base')

@php
    $config = App\Models\Layouts::config();
@endphp

@section('main')
    <main class="sheet">
        <h1 class="sr-only">{{ $config->name }}</h1>

        {{-- <div class="bg-gradient-radial from-gray-400 via-transparent to-transparent py-28 -my-28"> --}}
        <div class="flex aspect-[6/2] relative">
            <img
                src="{{ Vite::asset('resources/images/hero.png') }}"
                width="888"
                height="860"
                class="mx-auto absolute left-0 right-0 top-0"
                alt="Sviato Otchenash from {{ $config->name }}"
            >
        </div>

        <section class="relative">
            <h2>Redefining <br><span class="italic pl-52 pr-1  text-transparent bg-clip-text bg-gradient-to-r from-gold-light to-gold-dark">Beauty</span></h2>

            <p>In the four years since we started, Sviato Academy has redefined the standards of the permanent makeup industry. Led by one of the world’s leading permanent makeup artists, Sviatoslav Otchenash, we have become the go-to institution for gifted individuals seeking to perfect their craft.</p>

            <p>Our techniques and training methods are the results of over a decade of the tireless pursuit of perfection. We have proven time and time again that our innovative approach and constant evolution stand head and shoulders above other academies.</p>
        </section>
    </main>
@endsection

{{-- @section('beforeFooter') @parent @endsection --}}
{{-- @section('afterFooter') @parent @endsection --}}
