//# Carousel

import '@splidejs/splide/css/core'
import Splide from '@splidejs/splide'

import ScreenMatch from '@helper/screen-match'

const screens = new ScreenMatch().thresholds // sm md lg xl 2xl 3xl

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
