import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue', // Agregado para soporte Vue si lo usas
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'uptag-orange': '#f18000',
                 'uptag-gray': '#606060',
                    'uptag-dark': '#626161',
                },
        },
    },

    plugins: [forms],

    // Mantenemos tu safelist para que las clases dinámicas no desaparezcan
    safelist: [
        {
            pattern: /(bg|text|border)-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900|950)/,
        },
        {
            pattern: /text-(xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|6xl)/,
        },
        {
            pattern: /font-(thin|light|normal|medium|semibold|bold|extrabold|black)/,
        },
        // Agregamos tus colores personalizados a la safelist para usarlos dinámicamente
        'bg-uptag-orange',
        'text-uptag-orange',
        'border-uptag-orange',
        'bg-uptag-gray',
        'text-uptag-gray',
        'bg-uptag-dark',
    ],
};
