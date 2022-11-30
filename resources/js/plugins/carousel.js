//# Carousel

import '@splidejs/splide/css/core'
import Splide from '@splidejs/splide'

import ScreenMatch from '@helper/screen-match'

const screens = new ScreenMatch().thresholds // sm md lg xl 2xl 3xl

new Splide('.js-carousel', {
    // type: 'loop',
    // clones: 1,
    rewind: true,
    arrows: false,
    fixedWidth: '244px',

    mediaQuery: 'min',
    breakpoints: {
        [screens.md]: {
            fixedWidth: 0,
            perPage: 3,
            arrows: true,
        },
        [screens.lg]: {
            perPage: 4,
        },
        [screens['3xl']]: {
            perPage: 5,
        },
    },
}).mount()
