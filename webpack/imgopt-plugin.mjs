//# Webpack Images

import defaultsDeep from 'lodash/defaultsDeep.js'

import imagemin from 'imagemin'

import imageminGifsicle from 'imagemin-gifsicle'
import imageminJpegtran from 'imagemin-jpegtran'
import imageminOptipng from 'imagemin-optipng'
import imageminSvgo from 'imagemin-svgo'

function imgoptPlugin(input, config) {
    const Config = defaultsDeep(config, {
        output: '',
        svgo: {
            plugins: [
                {
                    name: 'removeViewBox',
                    active: false,
                },

                {
                    name: 'removeAttrs',
                    params: {
                        attrs: '*:(stroke|fill):none',
                    },
                },

                {
                    name: 'removeXMLNS',
                    active: true,
                },

                {
                    name: 'addAttributesToSVGElement',
                    params: {
                        attributes: [{ xmlns: 'http://www.w3.org/2000/svg' }],
                    },
                },
            ],
        },
        callback: null,
    })

    ;(async () => {
        const files = await imagemin(
            input,
            {
                destination: Config.output,
                plugins: [
                    imageminJpegtran(),
                    imageminOptipng(),
                    imageminGifsicle(),
                    imageminSvgo(Config.svgo),
                ],
            },
        )

        if (Config.callback) {
            Config.callback(files)
        }
    })()
}

export default imgoptPlugin
