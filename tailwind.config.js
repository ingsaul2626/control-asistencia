import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // 1. ACTIVAMOS EL MODO OSCURO POR CLASE
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // 2. TUS COLORES PERSONALIZADOS UPTAG
            colors: {
                'uptag-orange': '#f18000',
                'uptag-gray': '#606060',
                'uptag-dark': '#626161',
            },
        },
    },

    plugins: [forms],

    // 3. MANTENEMOS TU SAFELIST (Incluyendo soporte para dark:)
    safelist: [
        {
            pattern: /(bg|text|border)-(slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-(50|100|200|300|400|500|600|700|800|900|950)/,
            // Agregamos variantes para que Tailwind no borre las clases dark dinámicas
            variants: ['dark', 'hover', 'focus'],
        },
        {
            pattern: /text-(xs|sm|base|lg|xl|2xl|3xl|4xl|5xl|6xl)/,
        },
        {
            pattern: /font-(thin|light|normal|medium|semibold|bold|extrabold|black)/,
        },
        'bg-uptag-orange',
        'text-uptag-orange',
        'border-uptag-orange',
        'bg-uptag-gray',
        'text-uptag-gray',
        'bg-uptag-dark',
        // Clases específicas de estado para dark mode
        'dark:bg-slate-900',
        'dark:text-white',
        'dark:border-slate-700',
    ],
};
