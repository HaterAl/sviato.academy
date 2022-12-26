@extends('_l.templates.base')

@php
    $config = App\Models\Layouts::config();
    $coaches = App\Models\Layouts::coaches();
    $products = App\Models\Layouts::products();
@endphp

@section('main')
    <main class="c-spotlight flex items-center pt-20 md:pt-28">
        <div class="c-sheet before:content-[attr(data-text)] before:b-d1 md:before:text-center md:flex md:before:grow md:before:px-5" data-text="OOPS">
            <div class="pt-3 md:w-2/5 2xl:w-1/3">
                <h1 class="b-h2">There is no page here!</h1>

                <p>Go to the <a href="{{ route('_l.error') }}" class="underline text-gold-light">homepage</a></p>
            </div>
        </div>
    </main>
@endsection

{{-- @section('beforeFooter') @parent @endsection --}}
{{-- @section('afterFooter') @parent @endsection --}}
