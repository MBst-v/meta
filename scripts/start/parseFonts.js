let fs = require('fs'),
  path = require('path'),
  structure = require('../structure.js'),
  createPath = require('../start/createPath.js'),
  parseFonts = function(filename, filedir, fileparams) {
    let fontsSrc = structure.fontsSrc,
      fontsLibs = structure.fontsLibs,
      content = '';
    // разбираем шрифты, копируем в папку из бибилотеки
    for (let font of fileparams) {
      let parsedFont = font.split('-')
        .reduce(function(prev, next, i) {
          if (i === 0) {
            prev.name = next;
          } else {
            prev.params = next;
          }
          return prev;
        }, {}),
        fontLibPath,
        fontStyle,
        fontWeight,
        fontFamily = parsedFont.name,
        fontName,
        fontSrc;

      if (parsedFont.params) {
        fontLibPath = path.normalize(fontsLibs + fontFamily + '/' + fontFamily + '-' + parsedFont.params + '.woff');

        let parsedPath = path.parse(fontLibPath),
          fontParams = parsedFont.params.toLowerCase();

        try {
          fs.accessSync(fontLibPath, fs.constants.R_OK); 
          console.log(`Файл ${fontLibPath} найден`);

          // перемещаем файл шрифтов
          let newFilePath = path.normalize(fontsSrc + parsedPath.base);
          fs.copyFileSync(fontLibPath, newFilePath);
        } catch (err) {
          console.log(`Файл ${fontLibPath} не найден`); 
        }

        if (fontParams.indexOf('semibold') !== -1) {
          fontWeight = '600';
        } else if (fontParams.indexOf('extrabold') !== -1) {
          fontWeight = '800';
        } else if (fontParams.indexOf('bold') !== -1) {
          fontWeight = 'bold';
        } else if (fontParams.indexOf('black') !== -1) {
          fontWeight = '900';
        } else if (fontParams.indexOf('medium') !== -1) {
          fontWeight = '500';
        } else if (fontParams.indexOf('extralight') !== -1) {
          fontWeight = '200';
        } else if (fontParams.indexOf('light') !== -1) {
          fontWeight = '300';
        } else if (fontParams.indexOf('thin') !== -1) {
          fontWeight = '100';
        } else {
          fontWeight = 'normal';
        }

        if (fontParams.indexOf('italic') !== -1) {
          fontStyle = 'italic';
        } else {
          fontStyle = 'normal'
        }

        fontSrc = "url('../fonts/" + parsedPath.base + "')";

      // ищем regular
      } else {
        fontLibPath = path.normalize(fontsLibs + fontFamily + '/' + fontFamily + '.woff');
        let parsedPath = path.parse(fontLibPath);
        try {
          fs.accessSync(fontLibPath, fs.constants.R_OK); 
          console.log(`Файл ${fontLibPath} найден`);

          // перемещаем файл шрифтов
          let newFilePath = path.normalize(fontsSrc + parsedPath.base);
          fs.copyFileSync(fontLibPath, newFilePath);
        } catch (err) {
          console.log(`Файл ${fontLibPath} не найден`);
          fontLibPath = fontLibPath.replace(/(\.[^.]+$)/, '-Regular$1');
          console.log(`Буду искать ${fontLibPath}`);
          try {
            fs.accessSync(fontLibPath, fs.constants.R_OK); 
            console.log(`Файл ${fontLibPath} найден`);

            // перемещаем файл шрифтов
            let newFilePath = path.normalize(fontsSrc + parsedPath.base);
            fs.copyFileSync(fontLibPath, newFilePath);
          } catch (err) {
            console.log(`Файл ${fontLibPath} не найден`); 
          }
        }
        // fontName = parsedPath.name;
        fontStyle = 'normal';
        fontWeight = 'normal';
        fontSrc = "url('../fonts/" + parsedPath.base + "')";
      }


      let fontFaceTemplate = {
        family: fontFamily,
        src: fontSrc,
        weight: fontWeight,
        style: fontStyle,
        display: 'swap'
      },
      fontFace = 
`
@font-face {
  font-family: '${fontFamily}';
  src: ${fontSrc} format('woff');
  font-weight: ${fontWeight};
  font-style: ${fontStyle};
  font-display: swap;
}
`;

      content += fontFace;
    }

    // создаем файл _fonts.scss
    let newFilePath = path.normalize('./src/scss/assets/_fonts.scss');

    createPath('./src/scss/assets/');

    fs.writeFileSync(newFilePath, content);
  };

module.exports = parseFonts;