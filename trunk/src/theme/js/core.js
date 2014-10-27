function core(data) {
  return this;
};

core.prototype.contructor = function(data) {
    if(typeof data == 'string') {
      var entries = core.find(data);
    } else if(typeof data == 'object') {
      if(data._entry !== true) {
        this._entry = data;
        return this;
      } else
        return this;
    }
  };