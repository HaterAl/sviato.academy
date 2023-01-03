<link rel="preload" href="{{ Vite::font('BebasNeuePro-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::font('BebasNeuePro-Italic.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::font('BebasNeuePro-Bold.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::font('BebasNeuePro-BoldItalic.woff2') }}" as="font" type="font/woff2" crossorigin>

<link rel="preload" media="(max-width: 420px)" imagesrcset="{{ Vite::image('hero-00-420px.png') }} 1x, {{ Vite::image('hero-00-420px@2x.png') }} 2x" as="image">
<link rel="preload" media="(min-width: 421px) and (max-width: 1024px)" imagesrcset="{{ Vite::image('hero-00-1024px.png') }} 1x, {{ Vite::image('hero-00-1024px@2x.png') }} 2x" as="image">
<link rel="preload" media="(min-width: 1025px)" imagesrcset="{{ Vite::image('hero-00.png') }} 1x, {{ Vite::image('hero-00@2x.png') }} 2x" as="image">
