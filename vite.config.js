//# Vite Config

/* eslint indent: [error, 2] */

import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
// import autoprefixer from 'autoprefixer'
import path from 'path'

export default defineConfig({
  // css: {postcss: { plugins: [autoprefixer] }} // Is NOT compatible w/ Tailwind
  plugins: [
    laravel({
      input: [
        'resources/css/tailwind.css',
        'resources/js/app.js',
      ],
      refresh: [
        'resources/_data/**',
        'resources/images/**',
      ],
      publicDirectory: 'static',
    }),
  ],
  resolve: {
    alias: {
      '@root': '/',
      '@js': '/resources/js/parts',
      '@part': '/resources/js/parts',
      '@plugin': '/resources/js/plugins',
      '@helper': '/resources/js/helpers',
      '@screens': path.resolve(__dirname, 'screens.config.js'),
    },
  },
  optimizeDeps: {
    include: [
      '@screens', // required for `npm run dev`
    ],
  },
  build: {
    commonjsOptions: {
      include: [
        'screens.config.js', // required for `npm run build`
      ],
    },
  },
})
