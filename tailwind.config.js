module.exports = {
    purge: {
        mode: 'layers',
        content: ['./public/**/*.html'],
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                cwc: {
                    red: '#E84977',
                    blue: '#49AADE',
                    gray: '#222222',
                },
            },
        },
        fontFamily: {
            'sans': ['Noto Sans', 'Arial', 'sans-serif'],
            'serif': ['Georgia','Time New Roman','Cambria']
        }
    },
    variants: {
        extend: {},
    },
    plugins: [],
};