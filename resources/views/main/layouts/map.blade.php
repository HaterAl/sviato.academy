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
    <style>
        html {
            overflow-y: scroll;
        }

        body#app {
            position: relative;
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100vh;
        }

        header.c-sheet {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: transparent;
        }

        header.c-sheet::before {
            display: none;
        }

        main {
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body id="app">
    @include('main.layouts.parts.header', ['hasNavigation' => $hasNavigation ?? true])
    <main class="@yield('main-class')">
        @yield('content')
    </main>
    @stack('modals')
    @include('main.layouts.parts.scripts')
</body>
</html>
