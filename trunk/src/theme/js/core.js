var search = {
  query_input : null,
  cat_input : null,
  init : function() {
    var self = this;
    this.query_input = $('#search input[name="query"]');
    this.cat_input = $('#search select[name="cat"]');

    var updateAutocomplete = (function() {
      var timeout;
      var min_length = 2;
      var threshold = 150;
      return function() {
        if(timeout)
          window.clearTimeout(timeout);

        if(self.query_input.val().length < min_length)
          return;

        timeout = window.setTimeout(function() {
          self.loadAutocomplete();
        }, threshold);
      };
    })();

    this.query_input.blur(function() {
      self.hideAutocomplete();
    }).keyup(updateAutocomplete)
      .focus(updateAutocomplete);

    this.cat_input.change(function() {
      self.hideAutocomplete();
    });

  },

  hideAutocomplete : function() {
    $('body #ac-dropdown').remove();
  },

  loadAutocomplete : function() {
    var self = this;
    var query = this.query_input.val();
    var category = this.cat_input.val();
    $.ajax({
      type : "POST",
      url : "?view=search&ajax=1&ajax_fn=autocomplete",
      data : {query:query, cat: category},
      success : function(e) {
        var suggestions = [];
        for(var i in e.books)
          suggestions.push(e.books[i].title);
        self.showSuggestions(suggestions, query);
      }
    });
  },

  showSuggestions : function(entries, query) {
    var self = this;
    $ddn = $('<ul id="ac-dropdown" class="ac-dropdown" /></ul>');
    for(var i in entries) {
      var entry = entries[i];
      $ddn.append($('<li>' + entry + '</li>'))
    }
    var left = this.query_input.offset().left;
    var top = this.query_input.offset().top + this.query_input.innerHeight();

    $ddn.css({
      position: 'absolute',
      left : left,
      top : top
    }).find('li').click(function() {
      self.setSearchInput($(this).html());
      self.hideAutocomplete();
    }).hover(function() {
      self.setSearchInput($(this).html());
    });
    self.hideAutocomplete();
    $('body').append($ddn);
  },

  setSearchInput : function(str) {
    var str = str.replace(/(<([^>]+)>)/ig, '');
    this.query_input.val(str);
  }
}

var core = {
  init : function() {
    search.init();
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

$(document).ready(function() {
  core.init();
});