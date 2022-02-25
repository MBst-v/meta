/*
  Создание только php/html файлов
  Заполняем functions.php полностью
  Заполнение их сниппетами
  Заполнение их requires
*/
let { src, dest, watch, series, parallel, task } = require('gulp'),
  path = require('path'),
  fs = require('fs'),
  argv = require('yargs').argv,
  structure = require('./structure.js'),
  jsSrc = structure.js.jsSrc,
  pages = structure.pages,
  pagesContent = structure.pagesContent,
  pagesSnippetsSrc = structure.pagesSnippetsSrc,
  phpRequireObject = structure.phpRequire,
  htmlIncludeObject = structure.htmlInclude,
  screenWidths = structure.screenWidth,
  wordpress = structure.wordpress,
  createPath = require('./start/createPath.js'),
  createFile = require('./start/createFile.js'),
  /*
   Формируем внутренности файла
   сначала ищем файл по имени в сниппетах, читаем и вставляем
   затем ищем сниппеты в массиве structure
   ищем файлы в сниппетах и вставляем
   В файлах header.html и functions.php подключаем стили и скрипты
  */
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

    if (filename === 'functions.php') {
      // output = formnigFunctionsPhp(output);
    } else if (filename === 'header.html') {
      output = formingHeaderHtml(output);
    }

    return output;
  },
  formingIncludes = function(filepath, insertObject) {
    let insertArray = insertObject[filepath],
      parsedFilePath = path.parse(filepath),
      extname = parsedFilePath.ext,
      output = '';

    if (insertArray) {
      if (parsedFilePath.base === 'header.php') {
        output += '<?php';
      } else if (parsedFilePath.base === 'footer.php') {
        output += '<?php\nwp_footer();\n';
      } else if (extname === '.php' && wordpress) {
        output += '<?php\nget_header();\n';
      }

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

        // dir = relativePath + '/' + parsedRequirePath.base;
        dir = parsedRequirePath.dir + '/' + parsedRequirePath.base;

        return prev + start + dir.replace(/\\/g, '/') + end;

      }, '');

      if (parsedFilePath.base === 'header.php') {
        output += '\n?>';
      } else if (parsedFilePath.base === 'footer.php') {
        output += '\n\n?>\n\t</body>\n</html>';
      } else if (extname === '.php' && wordpress) {
        output += '\nget_footer();';
      }
    }
    return output;
  },
  // формирование файла functions.php, вставка стилей и скриптов
  formnigFunctionsPhp = function(input) {
    let js = structure.js,
      clearScriptRegExp = /\s\[defer\]|\.js/g,
      scriptsArray = jsSrc.map(el => el.replace(clearScriptRegExp, '')),
      defersArray = jsSrc.filter(el => el.indexOf('[defer]') !== -1).map(el => el.replace(clearScriptRegExp, '')),
      formingScriptsArray = function(scriptsVar, scriptsName) {
        return scriptsName + ' = [\n\t' +
          scriptsVar.reduce(function(prev, next) {
            if (typeof next !== 'string') {
              return prev;
            }
            return `${prev},\n\t\t\t'${next}'`;
          }, 0).slice(3) + '\n\t\t];';
      },
      screenWidthsVar = '$screen_widths = [' + screenWidths.reduce((prev, next) => `${prev}, '${next}'`, 0).slice(3) + '];',
      scriptsVar = formingScriptsArray(scriptsArray, '$scripts'),
      deferScriptsVar = formingScriptsArray(defersArray, '$defer_scripts'),
      output = '<?php' + input.replace(/#!!!screen_widths/, screenWidthsVar)
      .replace(/#!!!scripts/, scriptsVar)
      .replace(/#!!!defer_scripts/, deferScriptsVar)
      .replace(/\<\?/g, ''),
      scssArray = structure.scss,
      enqueueStyles = '';

    scssArray.forEach(function(style) {
      let onPages = '',
        conditions = '';

      style = style.replace(/\s.*/, function(match) {
        if (match) {
          onPages = match.replace(/\s|\(|\)/g, '').split(',');
        }
        return '';
      });

      if (onPages) {

        if (enqueueStyles) {
          conditions += ' else if ( ';
        } else {
          conditions += 'if ( ';
        }

        let length = onPages.length,
          stylename = style.match(/[^\/]+$/)[0];
        i = 1;

        for (let page of onPages) {
          if (page.indexOf('.php') === -1) {
            page += '.php';
          }

          if (page === '404.php') {
            conditions += 'is_404() ';
          } else if (page === 'single.php') {
            conditions += 'is_single() ';
          } else if (page === 'front.php') {
            conditions += 'is_front_page() ';
          } else if (page === 'category.php') {
            conditions += 'is_category() ';
          } else if (page.indexOf('single-') !== -1) {
            page = page.replace(/.*-|\.php+/g, '');
            conditions += 'is_singular( \'' + page + '\' ) ';
          } else {
            conditions += 'is_page_template( \'' + page + '\' ) ';
          }

          if (i === length) {
            conditions += ') {'
          } else {
            conditions += '|| ';
          }

          i++;
        }

        conditions += `\n\t\tenqueue_style( '${stylename}', $screen_widths );\n\t}`;
      }

      enqueueStyles += conditions;
    });

    if (enqueueStyles) {
      output = output.replace('#!!!styles', enqueueStyles);
    }

    return output;
  },
  // формирование файла header.html, вставка стилей и скриптов
  formingHeaderHtml = function(input) {
    let js = structure.js,
      scriptsArray = js.scripts,
      defersArray = js.defer,
      // формируем link stylesheet
      output = input.replace('<!-- styles -->', function() {
        return screenWidths.reduce(function(current, total) {
          let mediaQuery = total == 0 ? '' : ` media="(min-width:${total - 0.02}px)"`,
            link = `<link rel="stylesheet"${mediaQuery} href="./css/style${total == 0 ? '' : '.' + total}.css">`;
          return current + '\n\t' + link;
        }, '<!-- styles -->');
      });

    // формируем script defer src
    output = output.replace('<!-- scripts -->', function() {
      let scriptsLinks = scriptsArray.reduce(function(prev, next) {
        if (typeof next === 'string') {
          let isDefer = defersArray.includes(next),
            src = `./js/${next}.js`,
            scriptLink = `<script${isDefer ? ' defer' : ''} src="${src}"></script>`;
          return `${prev}\n\t${scriptLink}`;
        } else {
          return prev;
        }
      }, '<!-- scripts -->');
      return scriptsLinks;
    });
    return output;
  },
  createInc = function() {
    let phpInc = structure.phpInc;

    createPath('src/inc/');

    for (let inc of phpInc) {
      let normalizedPath = path.normalize(inc),
        parsedPath = path.parse(normalizedPath),
        filedir = parsedPath.dir,
        filename = parsedPath.name,
        extname = parsedPath.ext,
        fileContent = '';

      try {
        fs.accessSync(normalizedPath, fs.constants.R_OK);
        fileContent += fs.readFileSync(normalizedPath).toString();
      } catch (err) {
        console.log(err);
      }

      if (filename.indexOf('enqueue') !== -1) {
        fileContent = formnigFunctionsPhp(fileContent);
      }

      createFile('src/inc/'+filename+extname, fileContent);
    }
  },
  createPages = function() {
    for (let page of pages) {
      let normalizedPath = path.normalize(page),
        parsedPath = path.parse(normalizedPath),
        filedir = parsedPath.dir,
        filename = parsedPath.name,
        extname = parsedPath.ext,
        insert = '';

      // по умолчанию .html
      if (extname === '') {
        extname = '.html';
      }

      /*
        1. Создаем все папки на пути к файлу
        2. Формируем сниппеты из папки snippets
        3. Формируем require и includes
        4. Создаем файл и записываем в него
      */
      createPath(filedir);
      insert += formingSnippets(normalizedPath, parsedPath.base);

      if (extname === '.html') {
        insert += formingIncludes(normalizedPath, htmlIncludeObject);
      } else if (extname === '.php') {
        insert += formingIncludes(normalizedPath, phpRequireObject);
      }

      createFile(normalizedPath, insert);

    }

    createInc();

  };

module.exports = createPages;