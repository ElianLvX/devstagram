/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php", // Direccion para que aplique estilo a la paginacion de tailwin css
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
