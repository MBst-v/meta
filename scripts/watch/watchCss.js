let {src, dest} = require('gulp'),
  path = require('path'),
  fs = require('fs'),
  argv = require('yargs').argv,
  structure = require('../structure.js'),
  flatten = require('gulp-flatten'), // для складывания всех файлов в одну папку без подпапок
  destFolder = structure.destFolder,
  gulpif = require('gulp-if'),
  rename = require('gulp-rename'),
  cleancss = require('gulp-clean-css'),
  sass = require('gulp-sass')(require('sass')),
  autoprefixer = require('gulp-autoprefixer'),
  removeFiles = require('../remove-files.js'),

  buildCss = function(done) {

    src('./src/**/*.scss')
    .pipe(sass({
      errorLogToConsole: true,
      outputStyle: 'expanded'
    })).on('error', console.error.bind(console))
    .pipe(autoprefixer({
      cascade: false,
      grid: "no-autoplace"
    }))
    .pipe(gulpif(() => !argv.nocleancss, cleancss({
      level: {
        1: {
          cleanupCharsets: true,
          normalizeUrls: true,
          optimizeBackground: true,
          optimizeBorderRadius: true,
          optimizeFilter: true,
          optimizeFont: true,
          optimizeFontWeight: true,
          optimizeOutline: true,
          removeEmpty: true,
          removeNegativePaddings: true,
          removeQuotes: true,
          removeWhitespace: true,
          replaceMultipleZeros: true,
          replaceTimeUnits: true,
          replaceZeroUnits: true,
          roundingPrecision: false,
          selectorsSortingMethod: 'standard',
          specialComments: 'all',
          tidyAtRules: true,
          tidyBlockScopes: true,
          tidySelectors: true,
        },
        2: {
          mergeAdjacentRules: true,
          mergeIntoShorthands: true,
          mergeMedia: true,
          mergeNonAdjacentRules: true,
          mergeSemantically: false,
          overrideProperties: true,
          removeEmpty: true,
          reduceNonAdjacentRules: true,
          removeDuplicateFontRules: true,
          removeDuplicateMediaBlocks: true,
          removeDuplicateRules: true,
          removeUnusedAtRules: false,
          restructureRules: false,
          skipProperties: ['background']
        }
      }
    })))
    .pipe(flatten({ includeParents: 0 }))
    .pipe(dest(destFolder + '/css/'))
    done();
  };

module.exports = buildCss;