let {src, dest} = require('gulp'),
  sass = require('gulp-sass'),
  path = require('path'),
  gulpif = require('gulp-if'),
  argv = require('yargs').argv,
  autoprefixer = require('gulp-autoprefixer'),
  cleancss = require('gulp-clean-css'),
  destFolder = require('../structure.js').destFolder,
  moveCss = function(done) {
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
    .pipe(dest(function(file) {
      file.dirname = '';
      // return path.normalize(destFolder) + '/css/';
      return path.normalize(destFolder + /css/) + '/css/';
    }));
    console.log(`scss files was compiled, autoprefixed, minified and moved to \"${destFolder}css/\"`);
    done();
  }



module.exports = moveCss;