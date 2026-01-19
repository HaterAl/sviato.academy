//# Carousel

import '@splidejs/splide/css/core'
import Splide from '@splidejs/splide'

import ScreenMatch from '@helper/screen-match'

const screens = new ScreenMatch().thresholds // sm md lg xl 2xl 3xl


//## Row

document.querySelectorAll('[data-carousel-row]').forEach(element => {
    new Splide(element, {
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
})


//## Showcase

import { EventInterface } from '@splidejs/splide'

const transitionClassname = 'splide--transition'

export function MyTransition( Splide, Components ) {
    const { bind } = EventInterface( Splide )
    const { Move } = Components
    const { list } = Components.Elements

    let endCallback

    let indexCurrent = Splide.index
    let isIndexChanged = false

    function mount() {
        bind( list, 'transitionend', e => {
            if ( e.target === list && endCallback ) {
                if (isIndexChanged) {
                    isIndexChanged = false

                    Splide.root.classList.remove(transitionClassname)
                }

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

        // Applies the CSS transition
        list.style.transition = 'transform 300ms cubic-bezier(.44,.65,.07,1.01)'

        isIndexChanged = indexCurrent !== index
        if (isIndexChanged) {
            indexCurrent = index

            Splide.root.classList.add(transitionClassname)
        }

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

new Splide( '[data-carousel-showcase]', {
    type: 'loop',
    clones: 2,
    arrows: false,

    mediaQuery: 'min',
    breakpoints: {
        [screens.md]: {
            arrows: true,
            pagination: false,
        },
    },
} ).mount( {}, MyTransition )
