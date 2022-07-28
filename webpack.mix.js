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

mix
    .js('resources/js/modules/auth/login.js', 'public/js/modules/auth')

    .js('resources/js/modules/expenses/categories/index.js', 'public/js/modules/expenses/categories')
    .js('resources/js/modules/expenses/expenses/index.js', 'public/js/modules/expenses/expenses')

    .js('resources/js/modules/system/roles/index.js', 'public/js/modules/system/roles')
    .js('resources/js/modules/system/users/index.js', 'public/js/modules/system/users')
    .js('resources/js/modules/system/users/profile.js', 'public/js/modules/system/users')
    .js('resources/js/modules/system/settings/index.js', 'public/js/modules/system/settings')

    .js('resources/js/modules/index/dashboard.js', 'public/js/modules/index')
    .js('resources/js/modules/index/test.js', 'public/js/modules/index')

    .copy('resources/fonts', 'public/fonts')
    .copy('resources/images', 'public/images')

    .js('resources/js/app.js', 'public/js')
    .vue({ version: 3 })
    .extract()
;
