//# Vue Mount

import { createApp, createVNode, render } from 'vue'
// import translate from '@helpers/translate'

const globalApp = () => {
    return window.vueApp ? window.vueApp : registerApp()
}

const registerApp = () => {
    const app = createApp({})

    // app.mixin({
    //     methods: {
    //         _t: translate,
    //     },
    // })

    // app.directive('name', Class)

    return window.vueApp = app
}

export default (component, selector, props = {}, removeHtml = true) => {
    const app = globalApp()

    let els

    if (typeof selector == 'string') {
        els = document.querySelectorAll(selector)
    } else {
        els = [selector]
    }

    els.forEach(el => {
        if (removeHtml) el.innerHTML = ''

        const vnode = createVNode(component, props)
        vnode.appContext = app._context
        render(vnode, el)
    })
}
