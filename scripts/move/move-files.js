let {src, dest} = require('gulp'),
  structure = require('../structure.js'),
  path = require('path'),
  flatten = require('gulp-flatten'),
  destFolder = path.normalize(structure.destFolder),
  htmlSrc = structure.htmlSrc,
  layoutsSrc = structure.layoutsSrc,
  imagesSrc = structure.imagesSrc,
  fontsSrc = structure.fontsSrc,
  jsonSrc = structure.jsonSrc,
  removeLogging = require('gulp-remove-logging'),
  babel = require('gulp-babel'),
  uglify = require('gulp-uglify'),
  cleancss = require('gulp-clean-css'),
  wordpress = structure.wordpress,
  htmlmin = require('gulp-html-minifier'),
  strip = require('gulp-strip-comments'),
  include = require('gulp-include'),
  moveLayouts = function(done) {
    src(layoutsSrc)
    .pipe(strip())
    .pipe(flatten({ includeParents: 0 }))
    .pipe(dest(`${destFolder}/template-parts/`))
    done();
  },
  moveHtml = function(done) {
    if (wordpress) {
      src('src/*.php')
      .pipe(dest(destFolder));

      src('src/inc/*.php')
      .pipe(dest(destFolder + '/inc/'));
    } else {
      src(htmlSrc)
      .pipe(babel())
      .pipe(include()).on('error', console.log)
      .pipe(htmlmin({
        collapseWhitespace: true,
        removeComments: true,
        minifyCSS: cleancss({
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
        }),
        minifyJS: true
      }))
      .pipe(dest(destFolder));
    }
    done();
  },
  moveFonts = function(done) {
    src(fontsSrc)
    .pipe(dest(`${destFolder}/fonts/`));
    done();
  },
  moveImages = function(done) {
    src(imagesSrc)
    .pipe(dest(`${destFolder}/img/`));
    done();
  },
  moveFavicons = function(done) {
    src([
      './src/android-chrome-192x192.png',
      './src/android-chrome-512x512.png',
      './src/apple-touch-icon.png',
      './src/browserconfig.xml',
      './src/favicon-16x16.png',
      './src/favicon-32x32.png',
      './src/favicon.ico',
      './src/mstile-150x150.png',
      './src/safari-pinned-tab.svg',
      './src/site.webmanifest'
      ], {allowEmpty: true})
     .pipe(dest(destFolder));
    done();
  },
  moveJSON = function(done) {
    src(jsonSrc, {allowEmpty: true})
    .pipe(dest(destFolder));
    done();
  };


module.exports = {moveImages, moveFonts, moveHtml, moveLayouts, moveFavicons, moveJSON};