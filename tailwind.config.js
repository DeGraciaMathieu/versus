const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Noto Sans', ...defaultTheme.fontFamily.sans],
                logo: ['Bangers'],
            },
            colors: {
                'secondary-dark': '#1D2026',
                'secondary': '#272A33',
                'secondary-light': '#3D4351',
                'primary': '#FF4C29',
            }
        }
    }
}
