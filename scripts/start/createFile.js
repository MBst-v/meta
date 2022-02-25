let path = require('path'),
  fs = require('fs'),
  structure = require('../structure.js'),
  mainScssName = structure.mainScss,
  createFile = function(filepath, content, width) {
    if (!width || width === false) {
      width = '';
    }

    let parsedPath = path.parse(filepath),
      file = parsedPath.dir + '/' + parsedPath.name + width + parsedPath.ext;

    if (parsedPath.ext === '.scss') {
      if (parsedPath.name !== mainScssName && (file.indexOf('general') !== -1 || file.indexOf('layouts') !== -1)) {
        file = file.replace(/([^\/]*$)/, '_$1');
      }
    }
    
    try {
      let data = fs.writeFileSync(path.normalize(file), content)
    } catch (err) {
      console.error(err)
    }
  };

module.exports = createFile;