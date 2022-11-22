//# Scroll Controls
//
// todo: add tracking "Space" w/ "Shift" pressed

// import { ScrollControls } from '@helper/scroll-controls'
// isBoxVisible = new ScrollControls(true)

import defaults from 'lodash/defaults'

export class ScrollControls {
    constructor(config = {}) {
        this.config = defaults(config, {
            controls: [
                ' ',
                'ArrowDown',
                'ArrowUp',
                'ArrowRight',
                'ArrowLeft',
                'PageDown',
                'PageUp',
                'End',
                'Home',
            ],
        })

        this.isEnabled = true
        this.wheelConfig = { passive: false }

        this.preventScrollControls = this.preventScrollControls.bind(this)
    }

    preventDefault(evt) {
        evt.preventDefault()
    }

    preventScrollControls(evt) {
        if (this.config.controls.includes(evt.key)) {
            this.preventDefault(evt)

            return false
        }
    }

    // Disable Scroll
    disable() {
        this.isEnabled = false
        // console.log('Scroll Controls is Disable')

        window.addEventListener('touchmove', this.preventDefault, this.wheelConfig)
        window.addEventListener('wheel', this.preventDefault, this.wheelConfig)
        if (this.config.controls.length) {
            window.addEventListener('keydown', this.preventScrollControls, false)
        }
    }

    // Enable Scroll
    enable() {
        // console.log('Scroll Controls is Enable')
        this.isEnabled = true

        window.removeEventListener('touchmove', this.preventDefault, this.wheelConfig)
        window.removeEventListener('wheel', this.preventDefault, this.wheelConfig)
        if (this.config.controls.length) {
            window.removeEventListener('keydown', this.preventScrollControls, false)
        }
    }
}
