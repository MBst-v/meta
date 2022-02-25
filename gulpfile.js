// npm i -D yargs fs path gulp gulp-cli gulp-sourcemaps gulp-sass gulp-clean-css gulp-autoprefixer gulp-html-minifier gulp-include gulp-remove-logging gulp-uglify gulp-rename gulp-strip-comments gulp-tap gulp-beautify gulp-if gulp-flatten

let { src, dest, watch, series, parallel, task } = require('gulp'),
  path = require('path'),
  fs = require('fs'),
  argv = require('yargs').argv,
  structure = require('./scripts/structure.js'),
  destFolder = structure.destFolder,
  componentsSrc = structure.componentsSrc,

  cleancss = require('gulp-clean-css'),
  sass = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),

  removeLogging = require('gulp-remove-logging'),
  babel = require('gulp-babel'),
  uglify = require('gulp-uglify'),

  removeFiles = require('./scripts/remove-files.js'),

  createPages = require('./scripts/createPages.js'),
  createLayouts = require('./scripts/createLayouts.js'),
  createStyles = require('./scripts/createStyles.js'),
  createScripts = require('./scripts/createScripts.js'),

  moveJs = require('./scripts/move/moveJs.js'),
  moveCss = require('./scripts/move/moveCss.js'), {
    moveImages,
    moveFonts,
    moveHtml,
    moveLayouts,
    moveFavicons,
    moveJSON
  } = require('./scripts/move/move-files.js'),
  layoutsSrc = structure.layoutsSrc,
  imagesSrc = structure.imagesSrc,
  fontsSrc = structure.fontsSrc,
  jsonSrc = structure.jsonSrc,

  buildHtml = require('./scripts/watch/watchHtml.js'),
  buildJs = require('./scripts/watch/watchJs.js'),
  buildCss = require('./scripts/watch/watchCss.js');

task('start', function(done) {
  fs.mkdir('src', { recursive: true }, err => { if (err) throw err });
  fs.mkdir('src/img', { recursive: true }, err => { if (err) throw err });
  fs.mkdir('src/fonts', { recursive: true }, (err) => { if (err) throw err });
  createPages();
  createLayouts();
  createStyles();
  createScripts();

  done();
});

task('default', function(done) {
  if (argv.babel) {
    if (argv.file) {
      let filepath = path.normalize(argv.file);
      src(filepath)
        .pipe(babel())
        .pipe(removeLogging())
        .pipe(uglify())
        .pipe(dest(destFolder + '/js/'))
      // console.log('babel, removelogging, uglify and move ' + filepath);
      done();
    }
  } else {
    watch(componentsSrc + '*.js', buildJs).on('unlink', path => removeFiles(path, 'unlink'));
    watch('src/**/*.scss', buildCss).on('unlink', path => removeFiles(path, 'unlink'));
    watch(['src/**/*.html', 'src/*.php', 'src/inc/*.php'], buildHtml).on('unlink', path => removeFiles(path, 'unlink'));
    watch(imagesSrc, moveImages).on('unlink', path => removeFiles(path, 'unlink'));
    watch(fontsSrc, moveFonts).on('unlink', path => removeFiles(path, 'unlink'));
    watch(layoutsSrc, moveLayouts).on('unlink', path => removeFiles(path, 'unlink'));
    watch(jsonSrc, moveJSON).on('unlink', path => removeFiles(path, 'unlink'));
  }
});

task('movejs', moveJs);
task('movecss', moveCss);
task('moveimages', moveImages);
task('movefonts', moveFonts);
task('movelayouts', moveLayouts);
task('movefavicons', moveFavicons);
task('movejson', moveJSON);
task('movehtml', moveHtml);

task('moveall', parallel('movecss', 'movejs', 'moveimages', 'movefonts', 'movelayouts', 'movefavicons', 'movejson', 'movehtml'));

task('buildjs', buildJs);
task('buildcss', buildCss);
task('buildhtml', buildHtml);


task('criticalcss', function(cb) {
  src('src/layouts/index-critical-css.scss').pipe(sass({
      errorLogToConsole: true,
      outputStyle: 'expanded'
    })).on('error', console.error.bind(console))
    .pipe(autoprefixer({
      cascade: false,
      grid: "no-autoplace"
    }))
    .pipe(cleancss({
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
    }))
    .pipe(dest('./test/'))
  cb();
});