const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.sass', 'public/css')
    .copy('public', '../../public/vendor/app')
    .options({
        processCssUrls: false
    });

mix.browserSync('reactor.test');
