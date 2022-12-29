//# HTML provider

// [Node.js HTTP](https://nodejs.org/api/http.html)
// const http = require('http')
import * as http from 'http'

// const pageURL = 'http://www.shuba.test/layouts/homepage'

export default (pageURL) => {
    return new Promise(resolve => {
        http.get(pageURL, res => {
            let rawData = ''

            res.setEncoding('utf8')
            res.on('data', (chunk) => {
                rawData += chunk
            })

            res.on('end', () => {
                try {
                    resolve(rawData)
                } catch (evt) {
                    resolve(evt.message)
                }
            })
        })
    })
}
