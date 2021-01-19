const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/frontend/js/app.js', 'public/js/frontend/')
    .sass('resources/frontend/sass/app.scss', 'public/css/frontend/')
    .copy('resources/frontend/images/', 'public/images/frontend/')

    .js('resources/backend/js/app.js', 'public/js/backend/')
    .sass('resources/backend/sass/app.scss', 'public/css/backend/')
    .copy('resources/backend/images/', 'public/images/backend/')
    .version();
