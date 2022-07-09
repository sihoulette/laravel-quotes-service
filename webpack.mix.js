const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({
    path: '../../.env'/*, debug: true*/
}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.webpackConfig(require('./webpack.config'));
mix.setPublicPath('public').mergeManifest();
mix.js(__dirname + '/resources/js/app.js', 'build/js/app.js');
mix.sass(__dirname + '/resources/sass/app.scss', 'build/css/app.css');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}
