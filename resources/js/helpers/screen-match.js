//# Screen Match
//> Define if screen match threshold
// e.x.:
//  import { ScreenMatch } from '@helper/screen-match';
//  isBoxVisible = new ScreenMatch([false, 'lg']).define();

import screenThresholds from '@screens'

export default class ScreenMatch {
    constructor(range = []) {
        this.thresholds = {}
        Object.entries(screenThresholds).map(([screenAlias, screenData]) => {
            Object.entries(screenData).map(([screenKey, screenSize]) => {
                if (Object.keys(screenData).length === 1 && screenKey === 'min') {
                    this.thresholds[screenAlias] = parseInt(screenSize)
                }
            })
        })

        this.above = range[0]
        this.below = range[1]
    }

    check(size) {
        return window.matchMedia(
            `(min-width: ${ this.thresholds[size] })`,
        ).matches
    }

    define() {
        const isAbove = this.above ? this.check(this.above) : true
        const isBelow = this.below ? !this.check(this.below) : true

        return isAbove && isBelow
    }
}
