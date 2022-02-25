let fs = require('fs'),
  path = require('path'),
  structure = require('../structure.js'),
  createPath = require('../start/createPath.js'),
  animationsList = {
    'spin': `@keyframes spin {from {transform: rotate(0deg);}to {transform: rotate(360deg);}}`,
    'fadeIn': `@keyframes fadeIn {from {opacity: 0;}to {opacity: 1;}}`,
    'fadeOut': `@keyframes fadeOut {from {opacity: 1;}to {opacity: 0;}}`,
    'translateToBottom': `@keyframes translateToBottom {from {transform: translateY(-100%);}to {transform: translateY(0%);}}`,
    'translateToRight': `@keyframes translateToRight {from {transform: translateX(-100%);}to {transform: translateX(0%);}}`,
    'translateToLeft': `@keyframes translateToLeft {from {transform: translateX(100%);}to {transform: translateX(0%);}}`,
    'searching': `@keyframes searching {0% {transform: rotate(0deg) translateX(2.5px) rotate(0deg);}100% {transform: rotate(360deg) translateX(2.5px) rotate(-360deg);}}`
  },
  parseAnimations = function(animationsArray) {
    let content = '';

    for (let i = 0; i < animationsArray.length; i++) {
      let anim = animationsList[animationsArray[i]];
      if (anim) {
        content += anim;
      }
    }

    // создаем файл _animations.scss
    let newFilePath = path.normalize('./src/scss/assets/_animations.scss');

    createPath('./src/scss/assets/');

    fs.writeFileSync(newFilePath, content);
  };

module.exports = parseAnimations;