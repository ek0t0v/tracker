const webpack = require('webpack');
const merge = require('webpack-merge');
const common = require('./webpack.common.js');

module.exports = merge(common, {
    mode: 'development',
    devServer: {
        contentBase: './public',
        compress: true,
        host: '0.0.0.0',
        port: 8080,
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.js',
            'vue$': 'vue/dist/vue.esm.js',
        },
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': JSON.stringify('development'),
                'API_URL': JSON.stringify('http://localhost/api'),
            },
        }),
    ],
});