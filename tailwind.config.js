const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
                title: ['Carter One'],
            },
            colors: {
                'yellow-star': '#fabc3b',
            }
        }
    }
}
