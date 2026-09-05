import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ['selector', '[light-mode="dark"]'],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './public/backend/assets/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Valley Sans"', '"Baloo Da 2"', ...defaultTheme.fontFamily.sans],
                english: ['"Valley Sans"', 'sans-serif'],
                bangla: ['"Baloo Da 2"', 'sans-serif'],
            },
            colors: {
                brand: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    DEFAULT: '#15803d',
                },
            },
        },
    },
    plugins: [],
    corePlugins: {
        preflight: false,
    },
};
