<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('main.layouts.parts.seo')
    @include('main.layouts.parts.favicon')
    @include('main.layouts.parts.preload')
    @include('main.layouts.parts.styles')
    @include('main.layouts.parts.tagmanager')
</head>
<body id="app">
    @include('main.layouts.parts.header', ['hasNavigation' => $hasNavigation ?? true])
    <main class="@yield('main-class')">
        @yield('content')
    </main>
    @stack('modals')
    @include('main.layouts.parts.footer')
    @include('main.layouts.parts.scripts')
</body>
</html>
