@extends('main.layouts.base', ['hasNavigation' => false])

@section('main-class', 'c-spotlight flex items-center pt-20 md:pt-28')

@section('content')
    <div class="c-sheet before:content-[attr(data-text)] before:b-d1 md:before:text-center md:flex md:before:grow md:before:px-5" data-text="500">
        <div class="pt-3 md:w-2/5 2xl:w-1/3">
            <h1 class="b-h2">
                {{ __('Server error') }}!</h1>
            <p>
                {{ __('Go to the') }} <a href="{{ route('home') }}" class="underline text-gold-light">{{ __('homepage') }}</a>
            </p>
        </div>
    </div>
@endsection
