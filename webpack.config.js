const webpack = require('webpack');
const path = require('path');
// const env = process.env.NODE_ENV;

const PATHS = {
    source: path.join(__dirname, 'src/'),
    build: path.join(__dirname, 'dist/')
}

module.exports = {
    entry: {
        main: PATHS.source + 'index.js'
    },
    output: {
        path: PATHS.build,
        filename: 'main.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.less$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: 'main.css'
                        }
                    },
                    {
                        loader: 'extract-loader',
                    },
                    {
                        loader: "css-loader",
                        options: {
                            minimize: false
                            // minimize: env === 'production' ? true : false
                        }
                    },
                    'postcss-loader',
                    {
                        loader: 'less-loader'
                    },
                ]
            },
            {
                test: /\.html$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]'
                        }
                    },
                    {
                       loader: 'extract-loader'
                    },
                    {
                       loader: 'html-loader'
                    }
                ]
            },
            {
                test: /\.(png|jpg|gif|svg|webm|mp4|ogg|ogv)/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]?[hash]',
                            outputPath: 'img/'
                        }
                    }
                ]
            },
            {
                test: /\.(eot|woff|woff2|ttf|otf)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]?[hash]',
                            outputPath: 'fonts/'
                        }
                    }
                ]
            }
        ]
    },
    /*plugins: [
      new webpack.ProvidePlugin({
        $: "jquery/dist/jquery.min.js",
        jQuery: "jquery/dist/jquery.min.js",
        "window.jQuery": "jquery/dist/jquery.min.js",
        "window.$": "jquery/dist/jquery.min.js"
      })
    ]*/
};