/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#20C997',
          50: '#D4F7EC',
          100: '#C1F4E3',
          200: '#9DEFD2',
          300: '#78EAC0',
          400: '#54E4AF',
          500: '#20C997',
          600: '#19A278',
          700: '#137B5A',
          800: '#0C543B',
          900: '#062D1D',
        },
        secondary: {
          DEFAULT: '#FF6B35',
          50: '#FFE8E0',
          100: '#FFD9CC',
          200: '#FFB8A3',
          300: '#FF987B',
          400: '#FF8152',
          500: '#FF6B35',
          600: '#FF4600',
          700: '#CC3800',
          800: '#942900',
          900: '#5C1A00',
        },
      },
    },
  },
  plugins: [],
}
