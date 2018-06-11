const path = require('path');

module.exports = {
  entry: {
    modules: [
      'babel-polyfill',
      './src/index.js',
    ]
  },
  output: {
    path: path.resolve(__dirname, 'build/js'),
    filename: '[name].js'
    //filename: '[name].[chunkhash].js'
    //filename: '[name].[hash].js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader'
        }
      }
    ]
  }
}