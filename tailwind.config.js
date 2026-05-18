import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#FFE522',
          foreground: '#1E1E1E',
        },
        secondary: {
          DEFAULT: '#8AA5A9',
          foreground: '#FFFFFF',
        },
        complementary: {
          DEFAULT: '#EEE2A2',
          foreground: '#1E1E1E',
        },
        brand: {
          black: '#1E1E1E',
          white: '#FFFFFF',
        },
      },
      fontFamily: {
        heading: ['"Barlow Condensed"', 'sans-serif'],
        body: ['"Outfit"', 'sans-serif'],
      },
    },
  },
  plugins: [
    forms,
    typography,
  ],
};
