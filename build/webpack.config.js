const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
    const isProduction = argv.mode === 'production';
    
    return {
        entry: {
            main: './assets/js/src/main.js',
            customizer: './assets/js/src/customizer.js'
        },
        output: {
            path: path.resolve(__dirname, '../assets/js/dist'),
            filename: '[name].js',
            clean: true
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                },
                {
                    test: /\.s[ac]ss$/i,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'sass-loader'
                    ]
                }
            ]
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: '../css/dist/[name].css'
            })
        ],
        optimization: {
            minimize: isProduction
        },
        devtool: isProduction ? false : 'source-map',
        watchOptions: {
            ignored: /node_modules/
        }
    };
};
