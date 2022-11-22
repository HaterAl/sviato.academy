{{-- # Head --}}

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>{{ $config->name }}</title>
<meta name="description" content="{{ $config->meta['description'] }}">

{{-- ## Favicon --}}
<link rel="icon" type="image/svg+xml" href="favicon.svg">

{{-- ## Open Graph --}}
{{-- <meta property="og:title" content="">
<meta property="og:type" content="">
<meta property="og:url" content="">
<meta property="og:image" content=""> --}}

{{-- ## Styles --}}
@vite([
    'resources/css/tailwind.css',
])

@stack('styles')
