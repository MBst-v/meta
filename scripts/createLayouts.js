/*
  Создаем указанные файлы шаблонов.
  Проверяем их в phpRequire, вставляем включения, если надо.
  Проверяем их в htmlInclude, вставляем включения, если надо.
  Проверяем их в папке сниппетов, вставляем сниппеты, если надо.
*/
let {src, dest, watch, series, parallel, task} = require('gulp'),
  path = require('path'),
  fs = require('fs'),
  argv = require('yargs').argv,
  structure = require('./structure.js'),
  jsSrc = structure.jsSrc,
  pagesContent = structure.pagesContent,
  pagesSnippetsSrc = structure.pagesSnippetsSrc,
  structureLayouts = structure.layouts,
  phpRequireObject = structure.phpRequire,
  htmlIncludeObject = structure.htmlInclude,
  screenWidths = structure.screenWidth,
  wordpress = structure.wordpress,
  createPath = require('./start/createPath.js'),
  createFile = require('./start/createFile.js'),
  formingSnippets = function(filepath, filename) {
    let snippetsArray = pagesContent[filepath],
      fullPath = pagesSnippetsSrc + filename, // src/header.php
      output = '';

    try {
      fs.accessSync(fullPath, fs.constants.R_OK); 
      output += fs.readFileSync(fullPath).toString();
    } catch (err) {

    }

    if (snippetsArray !== undefined) {
      for (let snippet of snippetsArray) {
        output += fs.readFileSync(snippet).toString();
      }
    }

    if (filename === 'header.html') {
      output = formingHeaderHtml(output);
    }

    return output;
  },
  formingIncludes = function(filepath, insertObject) {
    let insertArray = insertObject[filepath],
      parsedFilePath = path.parse(filepath),
      extname = parsedFilePath.ext,
      output = '';

      // console.log(insertObject);
      // console.log(filepath);

    if (insertArray) {
      output += insertArray.reduce(function(prev, next) {
        let start = '',
          end = '',
          dir;

        next = next.replace('!', '');

        if (extname === '.html') {
          start = '\n<!--=include ';
          end = ' -->';
          if (next.indexOf('.html') === -1) {
            next += '.html';
          }
        } else if (extname === '.php') {
          start = '\nrequire \'';
          end = '\';';
          if (next.indexOf('.php') === -1) {
            next += '.php';
          }
        } else {
          return prev;
        }

        let parsedRequirePath = path.parse(next),
          relativePath = path.relative(parsedFilePath.dir, parsedRequirePath.dir);

        dir = relativePath + '/' + parsedRequirePath.base;

        return prev + start + dir.replace(/\\/g, '/') + end;

      }, '');

    }
    return output;
  },
// формирование файла header.html, вставка стилей и скриптов
  formingHeaderHtml = function(input) {
    let js = structure.js,
      scriptsArray = js.jsSrc,
      defersArray,
      // формируем link stylesheet
      output = input.replace('<!-- styles -->', function() {
        return screenWidths.reduce(function(current, total) {
          let mediaQuery = total == 0 ? '' : ` media="(min-width:${total - 0.02}px)"`,
            link = `<link rel="stylesheet"${mediaQuery} href="./css/style${total == 0 ? '' : '.' + total}.css">`;
          return current + '\n\t' + link;
        }, '<!-- styles -->');
      });

    output = output.replace('<!-- hover -->', '<link rel=\'stylesheet\' href=\'./css/hover.css\' media=\'(hover), (min-width:1024px)\' />');

    // формируем script defer src
    output = output.replace('<!-- scripts -->', function() {
      let scriptsLinks = scriptsArray.reduce(function(prev, next) {
        if (typeof next === 'string') {
          if (next.indexOf('jquery-3.4.1.min.js') !== -1) {
            return prev;
          }
          let isDefer = next.indexOf('[defer]') !== -1,
            src = `./js/${next.replace(/\s\[defer\]/, '')}`,
            scriptLink = `<script${isDefer ? ' defer' : ''} src="${src}"></script>`;
          return `${prev}\n\t${scriptLink}`;
        } else {
          return prev;
        }
      }, '<!-- scripts -->');
      return scriptsLinks;
    });

    // формируем прелоад шрифтов

      //<link rel="preload" href="..." as="font" type="font/woff" crossorigin="anonymous"/>
    return output;
  },
  createLayouts = function() {
    for (let layout of structureLayouts) {
      let normalizedPath = path.normalize(layout),
        parsedPath = path.parse(normalizedPath),
        filedir = parsedPath.dir,
        filename = parsedPath.name,
        extname = parsedPath.ext,
        insert = '';

      // по умолчанию .php
      if (extname === '') {
        parsedPath.ext = extname = '.php';
        normalizedPath += '.php';
      }

      // console.log(filedir);

      createPath(filedir);

      insert += formingSnippets(normalizedPath, parsedPath.base);

      if (extname === '.html') {
        insert += formingIncludes(normalizedPath, htmlIncludeObject);
      } else if (extname === '.php') {
        insert += formingIncludes(normalizedPath, phpRequireObject);
      }

      // переносим includes в нужное место
      if (parsedPath.base === 'footer.html') {
        let ftrIncludes;

        insert = insert.replace(/\@[\s\S]+$/, function(match) {
          ftrIncludes = match;
          return '';
        });

        insert = insert.replace(/<!-- includes -->/, '<!-- includes -->\n' + ftrIncludes);
      }

      createFile(normalizedPath, insert);

    }
  };
  


module.exports = createLayouts;