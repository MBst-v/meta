;
(function() {
  let filter = id('filter'),
    doubleFormSect = id('double-form-sect');

  if (filter) {
    initTabs(
      q('.filter__buttons', filter),
      q('.filter__categories', filter)
    );
  }

  if (doubleFormSect) {
    initTabs(
      q('.double-form-headings', doubleFormSect),
      qa('.double-form-wrap', doubleFormSect, true)
    );
  }
})();