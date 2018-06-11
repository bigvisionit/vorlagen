const path = require('path'),
  os = require('os'),
  gulp = require('gulp'),
  gulputil = require('gulp-util'), //.on('error', gulputil.log)
  concat = require('gulp-concat'),
  connect = require('gulp-connect'),
  open = require('gulp-open'),
  sass = require('gulp-sass'),
  postcss = require('gulp-postcss'),
  flexbugsfixes = require('postcss-flexbugs-fixes'),
  autoprefixer = require('autoprefixer'),
  del = require('del');

const browser = os.platform() === 'linux'? 'google-chrome' : (os.platform() === 'darwin' ? 'google chrome' : (os.platform() === 'win32' ? 'chrome' : 'firefox'));

//ToDo: Get module IDs
const modules = [1, 2];
Number.prototype.pad = function(size) {
  var s = String(this);
  while(s.length < (size || 2)) { s = '0' + s; }
  return s;
};
const moduleImagePaths = modules.map(id => 'src/' + id.pad(3) + '/images/**/*');
const moduleSassPaths = modules.map(id => 'src/' + id.pad(3) + '/style/**/*.scss');

// copy ALL HTML files
gulp.task('html', function() {
  gulputil.log('...copy ALL HTML files...');
  return gulp
  .src('src/*.html')
  .pipe(gulp.dest('build'))
  .pipe(connect.reload());
});

// copy MODULE IMAGE files
gulp.task('images', function() {
  gulputil.log('...copy MODULE IMAGE files...');
  return gulp
  .src(moduleImagePaths)
  .pipe(gulp.dest('build/images'))
  .pipe(connect.reload());
});

// copy BOOTSTRAP SASS CUSTOM VARS file
gulp.task('bootstrap-vars', function() {
  gulputil.log('...copy BOOTSTRAP SASS CUSTOM VARS file...');
  return gulp
  .src('src/style/_custom-vars.scss')
  .pipe(gulp.dest('node_modules/bootstrap/scss'));
});

// copy BOOTSTRAP SASS CUSTOM file
gulp.task('bootstrap-custom', function() {
  gulputil.log('...copy BOOTSTRAP SASS CUSTOM file...');
  return gulp
  .src('src/style/_custom.scss')
  .pipe(gulp.dest('node_modules/bootstrap/scss'));
});

// transpile BOOTSTRAP SASS file
gulp.task('bootstrap', ['bootstrap-vars', 'bootstrap-custom'], function() {
  gulputil.log('...transpile BOOTSTRAP SASS file...');
  gulp
  .src(['node_modules/bootstrap/scss/bootstrap.scss'])
  .pipe(sass({ errLogToConsole: true, outputStyle: process.env.production == 1? 'compressed' : 'expanded' }))
  .pipe(postcss([ flexbugsfixes, autoprefixer({ browsers: ['last 2 versions', '> 0.1%'] }) ]))
  .pipe(gulp.dest('build/style'))
  .pipe(connect.reload());
});

// merge & transpile MODULE SASS files
gulp.task('style', function() {
  gulputil.log('...merge & transpile MODULE SASS files...');
  return gulp
  .src(moduleSassPaths)
  .pipe(sass({ errLogToConsole: true, outputStyle: process.env.production == 1? 'compressed' : 'expanded' }))
  .pipe(concat('modules.css'))
  .pipe(postcss([flexbugsfixes, autoprefixer({browsers: ['last 2 versions', '> 0.1%']})]))
  .pipe(gulp.dest('build/style'))
  .pipe(connect.reload());
});

// copy PLUGIN JS files
gulp.task('js', function() {
  gulputil.log('...copy PLUGIN JS files...');
  return gulp.src(['node_modules/bootstrap/dist/js/bootstrap.min.js', 'node_modules/jquery/dist/jquery.min.js', 'node_modules/popper.js/dist/umd/popper.min.js']).pipe(gulp.dest('build/js'));
});

// copy FONTAWESOME files
gulp.task('fontawesome', function() {
  gulputil.log('...copy FONTAWESOME files...');
  return gulp.src(['src/plugins/fontawesome/**/*']).pipe(gulp.dest('build/style/fontawesome'));
});

// live preview
const port = 8090;
gulp.task('connect', function() {
  gulputil.log('...starting LIVE SERVER...');
  connect.server({
    root: 'build',
    livereload: true,
    port: port
  });
});
gulp.task('open', function() {
  const options = {
    uri: 'http://localhost:' + port,
    app: browser
  };
  gulp.src(__filename).pipe(open(options));
});
gulp.task('liveserver', ['connect', 'open']);

// live preview WEBPACK MODULES JS files
gulp.task('modules-js', function() {
  gulputil.log('...changing MODULES JS files...');
  return gulp.src(['build/js/modules.js']).pipe(connect.reload());
});

// watch IMAGE, BOOTSTRAP, STYLE AND MODULES JS files
gulp.task('watch', function() {
  gulputil.log('...starting WATCHING...');
  const imageWatcher = gulp.watch(moduleImagePaths, ['images']);
  imageWatcher.on('change', function (event) {
    if(event.type === 'deleted') {
      const filePathFromSrc = path.relative(path.resolve('src'), event.path);
      const destFilePath = path.resolve('build', filePathFromSrc).replace(/\\\d{3}\\/, '\\');
      del.sync(destFilePath);
    }
  });
  gulp.watch(['src/style/_custom-vars.scss', 'src/style/_custom.scss'], ['bootstrap']);
  gulp.watch(moduleSassPaths, ['style']);
  gulp.watch(['build/js/modules.js'], ['modules-js']);
});

// generate WORKFLOW
gulp.task('default', ['html', 'images', 'bootstrap', 'style', 'fontawesome', 'js']);

// generate WORKFLOW and start LIVE SERVER and WATCH
gulp.task('server', ['html', 'images', 'bootstrap', 'style', 'fontawesome', 'js', 'liveserver', 'watch']);