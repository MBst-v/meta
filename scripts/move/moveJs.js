let {src, dest} = require('gulp'),
  fs = require('fs'),
  path = require('path'),
  include = require('gulp-include'),
  removeLogging = require('gulp-remove-logging'),
  gulpif = require('gulp-if'),
  babel = require('gulp-babel'),
  uglify = require('gulp-uglify'),
  argv = require('yargs').argv,
  structure = require('../structure.js'),
  destFolder = structure.destFolder,
  moveJs = function(done) {
    let jsSrc = 'src/js/*.js';

    if (argv.file) {
      jsSrc = path.normalize(argv.file);
    }

    // src(jsSrc)
      // .pipe(include()).on('error', console.log)
      // .pipe(gulpif(() => !argv.nobabel, removeLogging()))
      // .pipe(gulpif(() => !argv.nobabel, babel()))
      // .pipe(gulpif(() => !argv.nobabel, uglify()))
      // .pipe(removeLogging())
      // .pipe(dest(destFolder + '/js/'));

    src('src/js/components/main.js')
      .pipe(include()).on('error', console.log)
      .pipe(gulpif(() => !argv.nobabel, removeLogging()))
      .pipe(gulpif(() => !argv.nobabel, babel()))
      .pipe(gulpif(() => !argv.nobabel, uglify()))
      .pipe(dest(destFolder + '/js/'));

    done();
  };


module.exports = moveJs;
