let mix = require('laravel-mix');

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

mix.webpackConfig({
    resolve: {
        alias: {
            'styles': path.resolve(__dirname, './resources/assets/sass/')
        }
    }
})
   .js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/admin.js', 'public/js')
   .sass('resources/assets/sass/frontend/app.scss', 'public/css')
   .sass('resources/assets/sass/frontend/ltr-style.scss', 'public/css/ltr-style.css')
   .sass('resources/assets/sass/admin/dashboard-rtl.scss', 'public/css/dashboard')
   .sass('resources/assets/sass/admin/dashboard.scss', 'public/css/dashboard')
   .version();
/*.sourceMaps()
   .browserSync({
       target: 'http://awan.test',
       proxy : 'awan.test'
 });*/