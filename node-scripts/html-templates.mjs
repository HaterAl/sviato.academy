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
        slug: '/_l/',
    },
    {
        label: 'home',
        slug: '/_l/home',
    },
]

//## Setup
if (!process.env.APP_URL) {
    console.error('HTML Pages generation ERROR: set `APP_URL` variable in your ".env" file.')
} else {
    const APP_URL = process.env.APP_URL

    const replaceSorcesPath = (html) => {
        console.log('${APP_URL}/build/:', `${APP_URL}/build/`)
        return html.replaceAll(`${APP_URL}/build/`, '../build/')
    }

    del.sync([path.join(PAGES_OUTPUT, '*')])

    if (!fse.existsSync(PAGES_OUTPUT)) fse.mkdir(PAGES_OUTPUT)

    PAGES_LIST.forEach(Page => {
        console.log('APP_URL + Page.slug:', APP_URL + Page.slug)
        getHTML(APP_URL + Page.slug).then(html => {
            const output = `${PAGES_OUTPUT}/${Page.label}.html`

            fse.writeFileSync(output, replaceSorcesPath(html))
        })
    })
}
