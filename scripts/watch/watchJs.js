let {src, dest} = require('gulp'),
  fs = require('fs'),
  include = require('gulp-include'),
  removeLogging = require('gulp-remove-logging'),
  gulpif = require('gulp-if'),
  babel = require('gulp-babel'),
  uglify = require('gulp-uglify'),
  argv = require('yargs').argv,
  structure = require('../structure.js'),
  componentsSrc = structure.componentsSrc,
  destFolder = structure.destFolder,
  buildJs = function(done) {
    src(componentsSrc + 'main.js')
      .pipe(include()).on('error', console.log)
      // .pipe(gulpif(() => !argv.nobabel, babel()))
      // .pipe(gulpif(() => !argv.nobabel, removeLogging()))
      // .pipe(gulpif(() => !argv.nobabel, uglify()))
      .pipe(dest(destFolder + '/js/'))

    src(componentsSrc + 'main.js')
      .pipe(include()).on('error', console.log)
      // .pipe(babel())
      // .pipe(removeLogging())
      .pipe(dest('src/js/'));
      
    done();
  };


module.exports = buildJs;