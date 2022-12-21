<title>{{ $data['title'] }}</title>
<link rel="canonical" href="{{ $data['links']['canonical'] }}">
@if (!empty($data['meta']['robots']))
<meta name="robots" content="{{ $data['meta']['robots'] }}">
@endif
@if (!empty($data['links']['alternates']))
@foreach ($data['links']['alternates'] as $hreflang => $value)
@if ($hreflang == config('app.fallback_locale'))
<link rel="alternate" href="{{ $value }}" hreflang="x-default" />
@endif
@endforeach
@endif
<meta name="description" content="{{ $data['meta']['description'] }}">
<meta property="og:title" content="{{ $data['opengraph']['title'] }}" />
<meta property="og:description" content="{{ $data['opengraph']['description'] }}" />
<meta property="og:type" content="{{ $data['opengraph']['type'] }}" />
<meta property="og:url" content="{{ $data['opengraph']['url'] }}" />
<meta property="og:image" content="{{ $data['opengraph']['image']['url'] }}" />
<meta property="og:image:url" content="{{ $data['opengraph']['image']['url'] }}" />
<meta property="og:image:width" content="{{ $data['opengraph']['image']['width'] }}" />
<meta property="og:image:height" content="{{ $data['opengraph']['image']['height'] }}" />
<meta property="og:site_name" content="{{ $data['opengraph']['site_name'] }}" />
<meta name="twitter:title" content="{{ $data['twitter']['title'] }}">
<meta name="twitter:description" content="{{ $data['twitter']['description'] }}">
<meta name="twitter:card" content="{{ $data['twitter']['card'] }}">
<meta name="twitter:image" content="{{ $data['twitter']['image'] }}">
<meta name="twitter:site" content="{{ $data['twitter']['site'] }}">
@if (!empty($data['opengraph']['article']['author']))
<meta property="og:article:author" content="{{ $data['opengraph']['article']['author'] }}" />
@endif
@if (!empty($data['opengraph']['article']['published_time']))
<meta property="og:article:published_time" content="{{ $data['opengraph']['article']['published_time'] }}" />
@endif
