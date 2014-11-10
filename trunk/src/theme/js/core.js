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


function orderConfirmation() {
  var orderConfirmationInfo = "Are you really sure you want to buy all the previous Stuff? Last chance to abort!"
  result = window.confirm(orderConfirmationInfo);
    if (result){
      document.getElementById("realSubmitButton").click();
      //return true;
    }else{
      //return false;
    }

  };
