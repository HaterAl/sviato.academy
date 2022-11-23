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
      'current': 'currentColor',
      'gray': {
          100: '#d9d9d9',
          400: '#87878d',
          900: '#0c0c0d',
      },
      'gold': {
        'light': '#ffdd64',
        'dark': '#ca9d00',
      },
      'spotlight': {
        'blue': '#7a86c6',
        // 'blue': '#00ffff',
      },
      'transparent': 'transparent',
      'white': '#fff',
    },
    'fontFamily': {
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
    fontSize: {
      'sm': ['1rem', {
        'lineHeight': '1.125rem',
        'letterSpacing': '0.05em',
      }],
      'base': ['1.25rem', 1],
      '4xl': ['2.25rem', '2rem'],
      '5xl': ['3.25rem', '2.75rem'],
      '6xl': ['4rem', '3.25rem'],
      '7xl': ['5.625rem', '4.5rem'],
      '9xl': ['10.125rem', '8.125rem'],
    },

    extend: {
      'backgroundImage': {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      },
      'maxWidth': {
        '8xl': '90rem',
      },
      'screens': {
          // 'sm': '640px',
          // 'md': '768px',
          // 'lg': '1024px',
          // 'xl': '1280px',
          // '2xl': '1536px',
          '2xl': '1440px',
          '3xl': '1536px',
      },
    },
  },
  plugins: [],
}

// 'xs':     ['0.75rem', '1rem']        /* 12px, 16px */
// 'sm':     ['0.875rem', '1.25rem']    /* 14px, 20px */
// 'base':   ['1rem', '1.5rem']         /* 16px, 24px */
// 'lg':     ['1.125rem', '1.75rem']    /* 18px, 28px */
// 'xl':     ['1.25rem', '1.75rem']     /* 20px, 28px */
// '2xl':    ['1.5rem', '2rem']         /* 24px, 32px */
// '3xl':    ['1.875rem', '2.25rem']    /* 30px, 36px */
// '4xl':    ['2.25rem', '2.5rem']      /* 36px, 40px */
// '5xl':    '3rem'                     /* 48px */
// '6xl':    '3.75rem'                  /* 60px */
// '7xl':    '4.5rem'                   /* 72px */
// '8xl':    '6rem'                     /* 96px */
// '9xl':    '8rem'                     /* 128px */
