const path = require('path');

module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    main: ['./resources/js/index.js']
  },
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, './resources/js/')
  }
}