import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
         "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],

   safelist: [
    {
      // Genera todos los colores para fondo, texto y bordes
      pattern: /(bg|text|border)-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900|950)/,
    },
    {
      // Genera todos los tamaños de texto comunes
      pattern: /text-(xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|6xl)/,
    },
    {
      // Genera grosores de fuente
      pattern: /font-(thin|light|normal|medium|semibold|bold|extrabold|black)/,
    },
  ],
  theme: {
    extend: {},
  },
  plugins: [],

};
