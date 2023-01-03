{{-- # Head --}}

<meta charset="utf-8">
<title>{{ $config->name }}</title>
<meta name="description" content="{{ $config->meta['description'] }}">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- <meta property="og:title" content=""> -->
<!-- <meta property="og:type" content=""> -->
<!-- <meta property="og:url" content=""> -->
<!-- <meta property="og:image" content=""> -->

<link rel="icon" type="image/svg+xml" href="favicon.svg">

<link rel="preload" href="{{ Vite::font('BebasNeuePro-Bold.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::font('BebasNeuePro-BoldItalic.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::font('BebasNeuePro-Italic.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::font('BebasNeuePro-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>

@vite([
    'resources/css/app.css',
])

@stack('styles')
