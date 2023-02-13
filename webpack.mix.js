const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js').vue({ version: 2 })
    .sass('resources/sass/app.sass', 'public/css')
    .copy('public', '../../public/vendor/app')
    .options({
        processCssUrls: false
    });

mix.browserSync('reactor.test');

mix.browserSync({
    proxy: 'reactor.test',
    files: [
        'node_modules/nuclear-hierarchy-ui/js/views/**/*.vue',
        'node_modules/umomega-foundation/js/components/**/*.vue',
        'node_modules/umomega-foundation/js/components/fields/TextEditorField.vue',
        'node_modules/umomega-foundation/js/classes/media.js',
        'node_modules/umomega-foundation/js/classes/form.js',
        'node_modules/umomega-foundation/js/components/fields/RelationField.vue',
    ]
})