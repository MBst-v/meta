let fs = require('fs'),
  path = require('path'),
  structure = require('../structure.js'),
  grid = structure.screenWidth,
  container = structure.containerWidth,
  createPath = require('../start/createPath.js'),
  parseGrid = function(filename, filedir) {
    let content = `
.container {
  padding: 0 ${(320 - container[0]) / 2}px;
}`;

    for (let i = 2; i < grid.length; i++) {
      content += `
@media (min-width: ${grid[i] - 0.02}px) {
  .container {
    padding: 0 calc(50% - ${container[i - 1] / 2}px);
  }
}`;
    }

    // создаем файл _grid.scss
    let newFilePath = path.normalize('./src/scss/assets/_grid.scss');

    createPath('./src/scss/assets/');

    fs.writeFileSync(newFilePath, content);
  };

module.exports = parseGrid;


// screenWidth: ['0', '420', '576', '768', '1024', '1440']
// containerWidth: ['280', '536', '686', '940', '1240']