;
(function() {
  let mapSect = id('map-sect');

  if (mapSect) {
    let hightlightElement = function(e) {
      let target = e.target;
      console.log(target);
      console.log(target.classList);
      if (target && target.classList.contains('map-sect__a')) {
        let highlightedElement = q('[data-city="' + target.textContent + '"]', mapSect);
        if (highlightedElement) {
          highlightedElement.classList.toggle('hover');
        }
      }
    };

    mapSect.addEventListener('mouseover', hightlightElement);
    mapSect.addEventListener('mouseout', hightlightElement);
  }

})();