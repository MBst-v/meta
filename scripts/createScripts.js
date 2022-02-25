let fs = require('fs'),
  path = require('path'),
  // { src, dest } = require('gulp'),
  structure = require('./structure.js'),
  screenWidths = structure.screenWidth,
  structureJs = structure.js,
  libsSrc = structure.jsLibsSrc,
  snippetsSrc = structure.jsSnippetsSrc,
  polyfillsLibsSrc = structure.jsPolyfillsSrc,
  polyfills = structureJs['polyfills'],
  jsSrc = structure.jsSrc,
  componentsSrc = structure.componentsSrc,
  jsComponents = structureJs.componentsSrc,
  jsScripts = structureJs.jsSrc,
  createPath = require('./start/createPath.js'),
  createFile = require('./start/createFile.js'),
  createScripts = function() {
    moveLibs();
    createComponents();
  },
  /*
    Проверяем существование скрипта в библиотеке
    Если он есть, то копируем
    Если нет, то создаем
  */
  moveLibs = function() {
    for (let script of jsScripts) {
      let scriptName = script.replace(/\s.*/, ''),
        scriptLibPath = path.normalize(libsSrc + scriptName),
        parsedPath = path.parse(scriptLibPath),
        filedir = parsedPath.dir,
        filename = parsedPath.name,
        extname = parsedPath.ext,
        basename = parsedPath.base;

      try {
        fs.accessSync(scriptLibPath, fs.constants.R_OK | fs.constants.W_OK);
        createPath(jsSrc);

        let newFilePath = path.normalize(jsSrc + basename);
        fs.copyFileSync(scriptLibPath, newFilePath);

      } catch (err) {
        console.error('Нет доступа к: ' + scriptLibPath);
      }
    }
  },
  createComponents = function() {
    let insertPolyfills = function(filepath) {
      let includes = '';

      for (let polyfill of polyfills) {
        let polyfillLibPath = path.normalize(polyfillsLibsSrc + polyfill),
          parsedPath = path.parse(polyfillLibPath),
          filedir = parsedPath.dir,
          filename = parsedPath.name,
          extname = parsedPath.ext,
          basename = parsedPath.base,
          newFilePath = path.normalize(componentsSrc + basename);

        // переносим полифиллы в папку компонентов
        try {
          fs.accessSync(polyfillLibPath, fs.constants.R_OK | fs.constants.W_OK);
          createPath(componentsSrc);

          fs.copyFileSync(polyfillLibPath, newFilePath);
        } catch (err) {
          console.error('Нет доступа к: ' + polyfillLibPath);
        }
        includes += `//=include ${polyfill}\n`;
      }

      return includes;
    },
    formingIncludes = function() {
      let components = jsComponents.filter(el => !(el.indexOf('!') !== -1) && el.indexOf('utils') === -1),
        componentIncludes = '';

      for (let component of components) {
        componentIncludes += `//=include ${component}\n`;
      }

      return componentIncludes;
    };

    for (let script of jsComponents) {
      let isMain = script.indexOf('!') !== -1,
        scriptName = script.replace('!', ''),
        scriptSnippetPath = path.normalize(snippetsSrc + scriptName),
        parsedPath = path.parse(scriptSnippetPath),
        filedir = parsedPath.dir,
        filename = parsedPath.name,
        extname = parsedPath.ext,
        basename = parsedPath.base,
        newFilePath = path.normalize(componentsSrc + basename),
        mainContent;

      // сначала перенесем из библиотеки или создадим файлы
      try {
        fs.accessSync(scriptSnippetPath, fs.constants.R_OK | fs.constants.W_OK);
        createPath(componentsSrc);
        mainContent = fs.readFileSync(scriptSnippetPath).toString();
        fs.copyFileSync(scriptSnippetPath, newFilePath);

      } catch (err) {
        console.error('Нет доступа к: ' + scriptSnippetPath);
        // создаем файл
        fs.writeFileSync(newFilePath, '');
      }

      // в главный файл вставим полифиллы из библтотеки и инклюды
      if (isMain) {
        let polyfillsIncludes = insertPolyfills(newFilePath);
        polyfillsIncludes += '//=include utils.js\n';
        let includes = formingIncludes();

        mainContent = mainContent.replace('//polyfills', '//polyfills\n' + polyfillsIncludes)
          .replace('//includes', '//includes\n' + includes);

        fs.writeFileSync(newFilePath, mainContent);
      }
    }
  };


module.exports = createScripts;