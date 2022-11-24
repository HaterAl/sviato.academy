//# Vite Config

import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
// import autoprefixer from 'autoprefixer'

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
});
