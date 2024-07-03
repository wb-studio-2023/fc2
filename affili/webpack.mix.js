const mix = require('laravel-mix');
const glob = require('glob');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/front/sp/app.js', 'public/front/sp/js')
    .sass('resources/scss/front/pc/app.scss', 'public/css/front/pc')
    .sass('resources/scss/front/sp/app.scss', 'public/css/front/sp');

/**
 * Javascript
 */
glob.sync('**/*.js', {cwd: 'resources/js'}).map(function (file) {
    mix.babel('resources/js/' + file, 'public/js/' + file)
        .version();
});

/**
 * scss
 * adminもapp.cssに一本化する？
 */
glob.sync('**/*.scss', {cwd: 'resources/scss/admin'}).map(function (file) {
    mix.sourceMaps(true, 'source-map')
        .sass('resources/scss/admin/' + file, 'public/css/admin/' + file.split('.')[0] + '.css')
        .version();
});

/**
 * image
 */
mix.copyDirectory('resources/img/', 'public/img/')
.version();

mix.webpackConfig({
    stats: {
         children: true
    },
});