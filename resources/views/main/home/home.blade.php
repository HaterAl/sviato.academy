@extends('main.layouts.base')

@section('content')
    @include('main.home.parts.hero')
    @include('main.home.parts.statistics')
    @include('main.home.parts.trainers')
    @include('main.home.parts.join')
    @include('main.home.parts.products')
@endsection

@push('modals')
    @include('main.shared.player')
@endpush
