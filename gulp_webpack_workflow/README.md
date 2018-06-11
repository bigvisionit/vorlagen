# Gulp Webpack Workflow

It uses webpack, gulp, babel and webpack-dev-server to compile and serve.

It can be used for multiple projects separated by modules.

Tasks running from gulp and webpack:

- copy all HTML files into build

- copy all IMAGE files into build

- copy BOOTSTRAP and transpile into build

- merge & transpile all SASS files into build

- copy and merge JS files into build

- generates live preview and open in a browser

- watch IMAGES, BOOTSTRAP, STYLES and JS files and serve them to browser


### Version
0.0.1

## Usage

Multiple projects must be separated by modules.

Create a new module by adding a folder (beginning with 001, 002 .. 999).

module 1: src/001

module 2: src/002

...

Just import in src/index.js the modules:

import module_001 from './001/js/module';

import module_002 from './002/js/module';

...

every module has folders:

- images/001

- js
	module.js (should be in js)
	
- style
	module.scss (should be in style)

to import custom JS files or libraries just use: import MyClass from './MyClass'; in your module.js

to import custom SASS files just use: @import "variables"; in your module.scss

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