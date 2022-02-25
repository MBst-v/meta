let fs = require('fs'),
  path = require('path'),
  structure = require('../structure.js'),
  createPath = require('../start/createPath.js'),
  parseMixins = function() {
    let content = 
`
@function responsive($screenWidth, $pxs) {
  $arrow: str-index($screenWidth, '->');

  $minScreenWidth: str-slice($screenWidth, 0, $arrow - 1);
  $maxScreenWidth: str-slice($screenWidth, $arrow + 2, -1);

  $arrow: str-index($pxs, '->');

  $minPxs: str-slice($pxs, 0, $arrow - 1);
  $maxPxs: str-slice($pxs, $arrow + 2, -1);

  @return  calc((100vw - #{$minScreenWidth}px)/(#{$maxScreenWidth} - #{$minScreenWidth})*(#{$maxPxs} - #{$minPxs}) + #{$minPxs}px);
}
`;
    // создаем файл _mixins.scss
    let newFilePath = path.normalize('./src/scss/assets/_mixins.scss');

    createPath('./src/scss/assets/');

    fs.writeFileSync(newFilePath, content);
  };

module.exports = parseMixins;