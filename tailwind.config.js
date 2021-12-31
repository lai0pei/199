const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'applyImage': "url('/199/images/info_bg.png')",
                'eventBg' : "url('/199/images/navi_bg.png')",
                'eventInfo' : "url('/199/images/icon02.png')", 
                'eventBtn' :  "url('/199/images/btn_bg.png')", 
                'bgImg' :  "url('/199/images/body_bg.jpg')", 
                
              }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
