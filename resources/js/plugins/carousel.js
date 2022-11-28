//# Carousel

import '@splidejs/splide/css/core'
import Splide from '@splidejs/splide'

import ScreenMatch from '@helper/screen-match'

const screens = Object.fromEntries( // sm md lg xl 2xl 3xl
    Object.entries(new ScreenMatch().thresholds).map(
        ([k, v]) => [k, parseInt(v)],
    ),
)

new Splide('.js-carousel', {
    type: 'loop',
    perPage: 1,
    // rewind: true,
    clones: 1,

    mediaQuery: 'min',
    breakpoints: {
        [screens.sm]: {
            perPage: 2,
            // clones: 2,
        },
        [screens.md]: {
            perPage: 3,
            // clones: 3,
        },
        [screens.lg]: {
            perPage: 4,
            // clones: 4,
        },
        [screens['xl']]: {
            perPage: 5,
            // clones: 5,
        },
    },
}).mount()
