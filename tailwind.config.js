const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Noto Sans', ...defaultTheme.fontFamily.sans],
                title: ['Bangers'],
            },
            colors: {
                'prussian-blue': '#082032',
                'charcoal': '#334756',
                'portland-orange': '#FF4C29',
            }
        }
    }
}
