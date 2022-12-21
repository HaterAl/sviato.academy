import LazyLoad from 'vanilla-lazyload'

window.loadPictures = (element) => {
    window.myLazyLoad = new LazyLoad({
        elements_selector: element,
    })
    window.myLazyLoad.update()
}

window.loadPictures('.lazy')
