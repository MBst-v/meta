let fs = require('fs'),
  path = require('path'),
  {src, dest} = require('gulp'),
  beautify = require('gulp-beautify'),
  structure = require('../structure.js'),
  createPath = require('../start/createPath.js'),

  parseFonts = require('./parseFonts.js'),
  parseColors = require('./parseColors.js'),
  parseGrid = require('./parseGrid.js'),
  parseMixins = require('./parseMixins.js'),
  parseReset = require('./parseReset.js'),
  parseVariables = require('./parseVariables.js'),
  parseAnimations = require('./parseAnimations.js'),

  parse = function(filename, filedir, fileparams) {
    if (filename.indexOf('fonts') !== -1) {
      parseFonts(filename, filedir, fileparams);
    } else if (filename.indexOf('colors') !== -1) {
      parseColors(filename, filedir, fileparams);
    } else if (filename.indexOf('grid') !== -1) {
      parseGrid();
    } else if (filename.indexOf('mixins') !== -1) {
      parseMixins();
    } else if (filename.indexOf('reset') !== -1) {
      parseReset();
    } else if (filename.indexOf('variables') !== -1) {
      parseVariables();
    } else if (filename.indexOf('animations') !== -1) {
      parseAnimations(fileparams);
    }

    src('./src/scss/assets/*.scss')
    .pipe(beautify.css({indent_size: 2}))
    .pipe(dest('./src/scss/assets/'))
  };

module.exports = parse;