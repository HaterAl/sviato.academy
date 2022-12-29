//# Images Optimization

import path from 'path'
import del from 'del'

import DIR from './dirs.js'
import Imgopt from './imgopt-plugin.mjs'

const qaDir = '_qa'

del.sync([path.join(DIR.images.out, '*')])

const ImageOptimize = {
    views: () => {
        const sources = [
            path.resolve(DIR.images.app, '*.{jp(|e)g,png,gif,svg}'),
        ]
        const output = path.resolve(DIR.images.out)

        // del.sync([ output ])
        new Imgopt(sources, {
            output,
            callback: (Files) => {
                console.log('|', 'Imgopt > Views:')
                Files.forEach(File => {
                    console.log('|', `- ${path.basename(File.sourcePath)} ${File.data.length} B`)
                })
            },
        })
    },

    qa: () => {
        const sources = [
            path.resolve(DIR.images.in, qaDir, '*.{jp(|e)g,png,gif,svg}'),
        ]
        const output = path.resolve(DIR.images.out, qaDir)

        // del.sync([ output ])
        new Imgopt(sources, {
            output,
            callback: (Files) => {
                console.log('|', 'Imgopt > QA:')
                Files.forEach(File => {
                    console.log('|', `- ${path.basename(File.sourcePath)} ${File.data.length} B`)
                })
            },
        })
    },
}

ImageOptimize.views()
ImageOptimize.qa()
