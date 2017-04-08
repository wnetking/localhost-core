var webpack = require('webpack');
var path = require('path');
var ExtractTextPlugin = require("extract-text-webpack-plugin");

var plugins = [];

var production = true;

if (production) {
  plugins.push(
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    })
  );
}
plugins.push(
  new ExtractTextPlugin(
    path.join(
      '..', 'css', 'main.css'
    )
  )
);

module.exports = {
  entry: [
    './js/main.js',
    './css/main.scss'
  ],
  output: {
    path: '../_core/js',
    filename: 'main.js'
  },
  module: {
    loaders: [{
      test: /\.js$/,
      exclude: /node_modules/,
      loaders: ['babel-loader']
    }, {
      test: /\.scss$/,
      loader: ExtractTextPlugin.extract(
        "style",
        "css?sourceMap!postcss!sass?sourceMap"
      )
    }, {
      test: /.(png|woff(2)?|eot|ttf|svg)(\?[a-z0-9=\.]+)?$/,
      loader: 'file-loader?name=../css/[hash].[ext]'
    }, {
      test: /\.css$/,
      loader: "style-loader!css-loader!postcss-loader"
    }]
  },
  postcss: function() {
    return [require('postcss-flexibility')];
  },
  watch: true,
  devtool: 'source-map',
  plugins: plugins,
  resolve: {
    extensions: ['', '.js', '.scss']
  }
};
