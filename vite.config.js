//# Vite Config

/* eslint indent: [error, 2] */

import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
// import autoprefixer from 'autoprefixer'
import path from 'path'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')
  const screensConfig = () => path.resolve(__dirname, 'screens.config.js')

  console.log('>>> `${env.APP_URL}`:', `${env.APP_URL}`)

  return {
    // css: {postcss: { plugins: [autoprefixer] }} // Is NOT compatible w/ Tailwind
    plugins: [
      laravel({
        input: [
          'resources/css/app.css',
          'resources/js/app.js',
        ],
        refresh: [
          'resources/_data/**',
          'resources/images/**',
          'app/**',
        ],
        publicDirectory: 'static',
      }),
      {
        name: 'laravel-fix',
        enforce: 'post',
        config(userConfig) {
          userConfig.base = './'
        },
      },
    ],
    resolve: {
      alias: {
        '@root': '/',
        '@js': '/resources/js',
        '@part': '/resources/js/parts',
        '@plugin': '/resources/js/plugins',
        '@helper': '/resources/js/helpers',
        '@screens': screensConfig(),
      },
    },
    optimizeDeps: {
      force: true,
      include: [
        '@screens', // required for `npm run dev`
      ],
    },
    build: {
      commonjsOptions: {
        include: [
          // resolve `import` of CommonJS plugins
          // required for `npm run build`
          path.resolve(__dirname, 'screens.config.js'),
          path.resolve(__dirname, 'node_modules/lodash.throttle/index.js'),
          path.resolve(__dirname, 'node_modules/lodash.debounce/index.js'),
        ],
      },
    },
    // server: {
    //   open: `${env.APP_URL}/_l`,
    // },
    server: {
      host: true,
      open: '/_l',
      // hmr: {
      //   host: '10.30.30.228',
      // },
      // proxy: {
      //   '/_l': `${env.APP_URL}`,
      // },
    },
  }
})
