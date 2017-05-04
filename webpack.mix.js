const {
	mix
} = require('laravel-mix');

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

mix.copy(
	'node_modules/moment/min/moment.min.js',
	'resources/assets/js'
)


mix.sass('resources/assets/sass/app.scss',
		'public/css/app.css').version();

mix.copy('resources/assets/js/moment.min.js', 'public/js');