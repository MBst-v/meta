let {src, dest} = require('gulp'),
  fs = require('fs'),
  include = require('gulp-include'),
  beautify = require('gulp-beautify'),
  strip = require('gulp-strip-comments'),
  argv = require('yargs').argv,
  structure = require('../structure.js'),
  flatten = require('gulp-flatten'),
  destFolder = structure.destFolder,
  layoutsSrc = structure.layoutsSrc,
  buildHtml = function(done) {
    src('./src/index.html', {allowEmpty: true})
    .pipe(include()).on('error', console.log)
    .pipe(beautify.html({ indent_size: 2 }))
    .pipe(dest(destFolder))

    src('./src/*.php')
    .pipe(dest(destFolder))

    src('./src/inc/*.php')
    .pipe(dest(destFolder + '/inc/'));

    src(layoutsSrc)
      .pipe(strip())
      .pipe(flatten({ includeParents: 0 }))
      .pipe(dest(`${destFolder}/template-parts/`))

    done();
  };

module.exports = buildHtml;