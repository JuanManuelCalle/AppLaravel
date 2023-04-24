/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [ //Aca en este content se pone todo lo que va a llevar las clases css
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    /* en el caso de que vayamos a hacer paginacion para agregarle el estilo de talwind hay que decirle que nos aplique los estilos a la carpeta donde se encuentra */
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
