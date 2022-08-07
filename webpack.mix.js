let mix = require('laravel-mix')
const path = require('path');

mix
    .setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .vue({version: 3})
    .webpackConfig({
        externals: {
            vue: 'Vue',
        },
        output: {
            uniqueName: 'vendor/package',
        }
    })
    .alias({
        'laravel-nova': path.join(__dirname, '../../laravel/nova/resources/js/mixins/packages.js'),
        'axios': path.join(__dirname, 'node_modules/axios'),
        'form-backend-validation': path.join(__dirname, 'node_modules/form-backend-validation'),
        'vuex': path.join(__dirname, 'node_modules/vuex'),
        '@inertiajs/inertia': path.join(__dirname, 'node_modules/@inertiajs/inertia'),
    })
