let path = require('path'),
  fs = require('fs'),
  createPath = function(elem) {
    elem.split(path.sep).reduce(function(total, current) {
      let dir = total + current + '/';
      if (!fs.existsSync(dir)){
        fs.mkdirSync(dir)
      }
      return dir;
    }, '')
  };

module.exports = createPath;