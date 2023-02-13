const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');

module.exports = [
    {
        entry: './client/src/js/bundles/bundle.js',
        output: {
            filename: 'bundle.js',
            path: path.resolve(__dirname, 'client/dist/js')
        }
    },
    {
        entry: './client/src/js/bundles/bundle-cms.js',
        output: {
            filename: 'bundle-cms.js',
            path: path.resolve(__dirname, 'client/dist/js')
        },
        externals: {
            jquery: 'jQuery'
        }
    },
    {
        entry: {
            cms: './client/src/styles/cms.scss'
        },
        output: {
            filename: 'cms.js',
            path: path.resolve(__dirname, 'client/dist/styles')
        },
        plugins: [new MiniCssExtractPlugin()],
        module: {
            rules: [
                {
                    test: /\.s[ac]ss$/i,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'sass-loader'
                    ]
                }
            ]
        }
    }
];
