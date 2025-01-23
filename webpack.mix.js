const mix = require('laravel-mix');
require('laravel-mix-polyfill');
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
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            host: 'localhost',
            proxy: 'cruise.test',
            open: false,
            files: [
               // 'app/**/*.php',
                'resources/views/**/*.php',
                'public/js/**/*.js',
                'public/css/**/*.css'
            ],
            watchOptions: {
                usePolling: true,
                interval: 500
            }
        },{
            injectCss: true
        })
    ]
});
mix.options({
    processCssUrls: false
});
mix.js('resources/js/app.js', 'public/js').version()
    .sass('resources/sass/app.scss', 'public/css').version()
    .polyfill({
        enabled: true,
        useBuiltIns: "usage",
        targets: "> 0.25%, not dead",
    });
