//# Carousel

import '@splidejs/splide/css/core'
import Splide from '@splidejs/splide'

import ScreenMatch from '@helper/screen-match'

const screens = new ScreenMatch().thresholds // sm md lg xl 2xl 3xl

new Splide('[data-carousel-row]', {
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





import { EventInterface } from '@splidejs/splide'

export function MyTransition( Splide, Components ) {
    const { bind } = EventInterface( Splide )
    const { Move } = Components
    const { list } = Components.Elements

    let endCallback

    function mount() {
        bind(list, 'transitionend', e => {
            if ( e.target === list && endCallback ) {
                // Removes the transition property
                cancel()

                // Calls the `done` callback
                endCallback()
            }
        })
    }

    function start( index, done ) {
        // Converts the index to the position
        const destination = Move.toPosition( index, true )
        console.log('>>> index:', index)

        // Applies the CSS transition
        list.style.transition = 'transform 800ms cubic-bezier(.44,.65,.07,1.01)'

        // Moves the carousel to the destination.
        Move.translate( destination )

        // Keeps the callback to invoke later.
        endCallback = done
    }

    function cancel() {
        list.style.transition = ''
    }

    return {
        mount,
        start,
        cancel,
    }
}

new Splide('[data-carousel-showcase]', {
    type: 'loop',
    clones: 2,

    // mediaQuery: 'min',
    // breakpoints: {
    //     [screens.md]: {
    //         perPage: 3,
    //     },
    // },
}).mount({}, MyTransition).on('move', (newIndex, prevIndex, destIndex) => {
    console.log('>>> newIndex, prevIndex, destIndex:', newIndex, prevIndex, destIndex)
})
