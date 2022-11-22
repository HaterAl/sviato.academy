{{-- Template: Base --}}

@php
    $config = App\Models\Layouts::config()
@endphp

<!DOCTYPE html>
<html lang="{{ $config->lang ?? 'uk' }}">
    <head>
        @include('_l.app.head')
    </head>

    <body id="app">
        @include('_l.app.banner')

        @yield('main')

        @section('beforeFooter')
            {{-- @include('_l.subscribe.mail') --}}
        @show

        @include('_l.app.footer')

        @section('afterFooter')
            {{-- @include('_l.misc.cookies') --}}
        @show

        @include('_l.app.scripts')
    </body>
</html>
