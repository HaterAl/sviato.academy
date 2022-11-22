//# Screen Match
//
//> Define if screen match threshold

// import { ScreenMatch } from '@helper/screen-match';
// isBoxVisible = new ScreenMatch([false, 'lg']).define();

export class ScreenMatch {
    constructor(range = []) {
        this.threshold = {
            xxs: 360,
            xs: 412,
            sm: 480,
            md: 768,
            lg: 1024,
            xl: 1280,
            xxl: 1440,
            xxxl: 1600,
        }
        this.above = range[0]
        this.below = range[1]
    }

    check(size) {
        return window.matchMedia(
            `(min-width: ${ this.threshold[size] }px)`,
        ).matches
    }

    define() {
        const isAbove = this.above ? this.check(this.above) : true
        const isBelow = this.below ? !this.check(this.below) : true

        return isAbove && isBelow
    }
}
