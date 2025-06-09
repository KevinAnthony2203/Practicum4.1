const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/css/app.scss', 'public/css')
   .sourceMaps()
   .version();

// Configuración de desarrollo
if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'source-map'
    })
    .browserSync({
        proxy: 'localhost:8000',
        open: false
    });
}
