/*
  Создаем указанные файлы стилей.
  Проверяем каждый файл в библиотеке сниппетов.
  Если в сниппетах ничего нет, то проверяем импорты.
  Вставляем импорты и создаем файлы.
*/
let fs = require('fs'),
  path = require('path'),
  structure = require('./structure.js'),
  createPath = require('./start/createPath.js'),
  createFile = require('./start/createFile.js'),

  screenWidths = structure.screenWidth,
  mainScssFilename = structure.mainScss,
  scssFiles = structure.scss.concat(structure.generalCss),

  scssAssets = structure.scssAssets,
  structureLayouts = structure.layouts,
  scssBlocks = structure.generalCss,
  scssImports = structure.scssImports,

  parseAssets = require('./start/parseAssets.js'),

  wordpress = structure.wordpress,
  fullAssetsImports = scssImports['fullAssets'],
  semiAssetsImports = scssImports['semiAssets'],

  formingAssetsImports = function(filepath, filename, width) {
    let assets = filename === mainScssFilename && width == 0 ? fullAssetsImports : semiAssetsImports,
      output = assets.map(function(assetPath) {
        assetPath = path.normalize(assetPath);
        let relativePath = path.relative(filepath, assetPath);
        return `@import '${relativePath}';`;
      });

    return output.reduce((prev, next) => prev + next + '\n', '// assets import\n');
  },

  formingSnippets = function(filepath, width) {
    if (!width || width === false) {
      width = '';
    }
    let parsedPath = path.parse(filepath),
      file = structure.cssSnippetsSrc + parsedPath.name + width + parsedPath.ext,
      fullPath = path.normalize(file),
      output = '';

    try {
      fs.accessSync(fullPath, fs.constants.R_OK); 
      output += fs.readFileSync(fullPath).toString();
    } catch (err) {

    }

    return output;
  },

  formingImports = function(filedir, filename, width) {
    let imports = Object.keys(scssImports).find(function(el) {
      let normalizedPath = path.normalize(el),
        parsedPath = path.parse(normalizedPath),
        dir = parsedPath.dir,
        name = parsedPath.name,
        ext = parsedPath.ext,
        base = parsedPath.base;

      if (filename === base) {
        return el;
      }
    }),
    output = '';

    if (imports) {
      /*
        Делаем массив импортов.
        Элементы с ! оставляем только в безразмерном scss файле.
      */
      let importsArray = scssImports[imports].map(function(importPath) {

        importPath = path.normalize(importPath);

        let relativePath = path.relative(filedir, importPath);

        return `@import '${relativePath + width}';`;
      }).filter(function(element) {
        if (width === false) { 
          return true;
        } else {
          if (width == 0) {
            return true;
          } else {
            return element.indexOf('!') === -1;
          }
        }
      }).map(el => el.replace('!', ''));

      return importsArray.reduce((prev, next) => prev + next + '\n', '\n// blocks import\n');
    }

    return output;

  },

  createAssets = function() {
    for (let asset in scssAssets) {
      let assetPath = path.normalize(asset),
        parsedPath = path.parse(assetPath),
        assetDir = parsedPath.dir,
        assetName = parsedPath.name; // fonts, colors and etc

      parseAssets(assetName, assetDir, scssAssets[asset]);
    }
  },

  createStyles = function() {
    let scssLayouts = structureLayouts.filter(el => el.indexOf('!') === -1).map(el => el.replace(/\.[^.]+$/, ''));

    scssFiles = scssFiles.concat(scssLayouts);
    scssFiles = scssFiles.map(el => el.replace(/\s.*/, ''));


    for (let scssFile of scssFiles) {

      let noWidths = scssFile.indexOf('!') !== -1;

      if (scssFile.indexOf('.scss') === -1) {
        scssFile += '.scss';
      }

      scssFile = scssFile.replace('!', '');

      let normalizedPath = path.normalize(scssFile),
        parsedPath = path.parse(normalizedPath),
        filedir = parsedPath.dir,
        filename = parsedPath.name,
        extname = parsedPath.ext,
        filebase = parsedPath.base,
        content = '';

      createPath(filedir);

      if (noWidths) {
        content += formingAssetsImports(filedir, filename, false);
        content += formingSnippets(normalizedPath, false);
        content += formingImports(filedir, filename, false);
        createFile(normalizedPath, content, false);
      } else {
        for (let width of screenWidths) {
          let currentWidth = width == 0 ? '' : '.' + width,
            currentContent = formingAssetsImports(filedir, filename, width);

          currentContent += formingImports(filedir, filename, currentWidth);
          currentContent += formingSnippets(normalizedPath, currentWidth);
          createFile(normalizedPath, currentContent, currentWidth);
        }
      }
    }

    createAssets();
  };
  
module.exports = createStyles;