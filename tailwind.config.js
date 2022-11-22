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
    colors: {
      'transparent': 'transparent',
      'gray': {
          400: '#87878d',
          900: '#0c0c0d',
      },
      'gold': {
        'light': '#ffdd64',
        'dark': '#ca9d00',
      },
    },
    extend: {
      // screens: {
      //     'sm': '640px',
      //     'md': '768px',
      //     'lg': '1024px',
      //     'xl': '1280px',
      //     '2xl': '1536px',
      // },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      },
    },
    fontFamily: {
      'app': [
        'Bebas Neue Pro',
        'ui-sans-serif',
        'system-ui',
        '-apple-system',
        'BlinkMacSystemFont',
        'sans-serif',
        'Apple Color Emoji',
        'Segoe UI Emoji',
        'Segoe UI Symbol',
        'Noto Color Emoji',
      ],
    },
  },
  plugins: [],
}
