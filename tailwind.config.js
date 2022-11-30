//# Tailwind Config

/* eslint indent: [error, 2] */

const screens = require('./screens.config.js')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  // darkMode: 'media', // or 'class'
  important: '#app',
  theme: {
    screens,
    colors: {
      'current': 'currentColor',
      'inherit': 'inherit',
      'gray': {
        100: '#d9d9d9',
        400: '#87878d',
        500: '#707077',
        900: '#0c0c0d',
      },
      'gold': {
        'light': '#ffda55', // ffdd64
        'dark': '#ca9d00',
      },
      'spotlight': {
        'blue': '#807a86c6',
      },
      'transparent': 'transparent',
      'white': '#fff',
    },
    fontFamily: {
      'app': [
        'Bebas Neue Pro', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji',
      ],
    },
    fontSize: {
      'sm': ['1rem', {
        'lineHeight': '1.125rem',
        'letterSpacing': '0.05em',
      }],
      'base': ['1.25rem', {
        'lineHeight': '1.375rem',
        'letterSpacing': '0.05em',
      }],
      'lg': ['1.5rem', 1],
      'xl': ['1.75rem', '1.75rem'],
      '2xl': ['2rem', '1.875rem'],
      '3xl': ['2.25rem', '2.0625rem'],
      '4xl': ['3rem', '2.625rem'],
      '5xl': ['3.25rem', '2.75rem'],
      '6xl': ['4rem', '3.25rem'],
      '7xl': ['5.625rem', '4.5rem'],
      '9xl': ['10.125rem', '8.125rem'],
    },

    extend: {
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'logo-glyph': "url('/resources/images/logo-glyph.svg')",
      },
      maxWidth: {
        '8xl': '90rem',
      },
    },
  },
  plugins: [],
}
