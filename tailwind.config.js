const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    important: true,
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/vendor/**/*.blade.php',
        './app/Domain/Order/Projections/States/*.php',
    ],

    theme: {
        colors: {
            black: "#3a1a1d",
            white: colors.white,
            gray: colors.warmGray,
            green: {
                100: "#efebff",
                200: "#c6b0f2",
                300: "#9db579",
                400: "#159f22",
                500: "#159f22",
                600: "#3a6d21",
                700: "#34521d",
                800: "#4d1f23",
                900: "#3a1a1d",
            },
            red: {
                100: "#f3ddda",
                200: "#c6b0f2",
                300: "#e6a9a1",
                400: "#d34c4c",
                500: "#d72927",
                600: "#992927",
                700: "#7a2927",
                800: "#4c2927",
                900: "#3a1a1d",
            }
        },
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Jost', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
