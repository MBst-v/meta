let fs = require('fs'),
  path = require('path'),
  structure = require('../structure.js'),
  createPath = require('../start/createPath.js'),
  parseVariables = function() {
    let content = 
`

`;
    // создаем файл _variables.scss
    let newFilePath = path.normalize('./src/scss/assets/_variables.scss');

    createPath('./src/scss/assets/');

    fs.writeFileSync(newFilePath, content);
  };

module.exports = parseVariables;