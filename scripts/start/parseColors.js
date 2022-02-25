let fs = require('fs'),
  path = require('path'),
  structure = require('../structure.js'),
  createPath = require('../start/createPath.js'),
  parseColors = function(filename, filedir, palette) {
    let content = '',
      arr = [];

    for (let colorName in palette) {
      let colorValue = palette[colorName];
      arr.push(`$${colorName}: ${colorValue.toLowerCase()};`);
    }

    content = arr.join('\n');

    // создаем файл _colors.scss
    let newFilePath = path.normalize('./src/scss/assets/_colors.scss');

    createPath('./src/scss/assets/');

    fs.writeFileSync(newFilePath, content);
  };

module.exports = parseColors;