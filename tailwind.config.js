/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/**/*.{html,js,php}',
    './view/**/*.{html,js,php}',
    './public/*.{html,js,php}',
    '*/*/public/*.{html,js,php}',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}