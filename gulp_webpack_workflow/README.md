# Gulp Webpack Workflow

It uses webpack, gulp, babel and webpack-dev-server to compile and serve.

### Version
0.0.1

## Usage

### Installation

Install from "package.json" dependencies

```sh
$ npm install
```

Install newest dependencies
(you should first remove devDependencies in "package.json" and the existing "node_modules" folder)

```sh
$ npm install babel-core babel-loader babel-polyfill babel-preset-env babel-preset-stage-0 webpack webpack-dev-server webpack-cli jquery node-sass gulp gulp-cli gulp-util gulp-sass gulp-concat gulp-connect gulp-open bootstrap font-awesome popper.js gulp-postcss postcss-flexbugs-fixes autoprefixer del open --save-dev
```

### Serve
To serve in the browser - Runs gulp-connect & gulp-open

```sh
$ npm start
```

### Watch
To watch module-changes in the browser - Runs webpack-watch

```sh
$ npm run watch
```

### Build
Compile and build for production

```sh
$ npm run build
```

## More Info

### Author

David Kempf