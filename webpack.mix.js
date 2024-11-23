const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/flatpickr/dist/flatpickr.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.min.js',
    'node_modules/jquery-validation/dist/localization/messages_ar-en.js'
] ,  'public/System/Assets/Lib/Libraries.js')

    .styles([
        'node_modules/flatpickr/dist/themes/dark.css'
    ],  'public/System/Assets/Lib/Libraries.css');
