/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/**/*.{html,js,php}',
    './app/views/**/*.{html,js,php}',
    './app/views/home/login.php',
    './public/*.{html,js,php}',
    '*/*/public/*.{html,js,php}',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}