var core = (function() {
  var core = {
    find : function(selector) {
      return document.querySelectorAll(selector);
    }
  };
  return core;
})();