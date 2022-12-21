<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('main.layouts.parts.seo')
    @include('main.layouts.parts.favicon')
    @include('main.layouts.parts.styles')
</head>
<body id="app">
    @include('main.layouts.parts.header')
    <main>
        @yield('content')
    </main>
    @include('main.layouts.parts.footer')
    @include('main.layouts.parts.scripts')
</body>
</html>
