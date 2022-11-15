/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    container: {
      center: true,
    },
    extend: {
      fontFamily: {
        oswald: ["Oswald", "sans-serif"],
      },
    },
    screens: {
      'xxs': '360px',
      'xs': '475px',
      ...defaultTheme.screens,
    }
  },
  plugins: [require("flowbite/plugin")],
};
