//# HTML Templates

//## Packages
import getHTML from './html-provider.mjs'
import fse from 'fs-extra'

import del from 'del'
import path from 'path'

import dotenv from 'dotenv'
dotenv.config()

//## Config
const PAGES_OUTPUT = 'static/html/'
const PAGES_LIST = [
    {
        label: 'index',
        slug: '/',
    },
]

//## Setup
if (!process.env.APP_URL) {
    console.error('HTML Pages generation ERROR: set `APP_URL` variable in your ".env" file.')
} else {
    const APP_URL = process.env.APP_URL

    const replaceSorcesPath = (html) => {
        return html.replaceAll(`${APP_URL}/static`, '..')
    }

    del.sync([path.join(PAGES_OUTPUT, '*')])

    if (!fse.existsSync(PAGES_OUTPUT)) fse.mkdir(PAGES_OUTPUT)

    PAGES_LIST.forEach(Page => {
        getHTML(APP_URL + Page.slug).then(html => {
            const output = `${PAGES_OUTPUT}/${Page.label}.html`

            fse.writeFileSync(output, replaceSorcesPath(html))
        })
    })
}
