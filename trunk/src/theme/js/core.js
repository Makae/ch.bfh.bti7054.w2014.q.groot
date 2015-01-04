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

    $ddn.attr('data-value', query);

    $ddn.css({
      position: 'absolute',
      left : left,
      top : top
    }).mouseleave(function() {
      self.setSearchInput($(this).attr('data-value'));
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
};

var wiki = {
  handler : null,
  offsetX : 15,
  offsetY : 15,
  lastX : null,
  lastY : null,

  init : function() {
    var self = this;
    self.registerHandler();
    $("*[data-wiki]").each(function() {
      $(this).mouseover(function(e) {
        self.lastX = e.pageX + self.offsetX;
        self.lastY = e.pageY + self.offsetY;
        $(this).addClass('loading');
        self.active = true;
        self.loadWiki($(this));
      }).mouseleave(function(e) {
        self.lastX = e.pageX + self.offsetX;
        self.lastY = e.pageY + self.offsetY;
        $(this).removeClass('loading');
        self.hideWiki();
        self.active = false;
      });
    });
  },

  loadWiki : function($element) {
    var query = $element.attr('data-wiki');
    var self = this;
    $.ajax({
      type : "POST",
      url : "?view=ajax&ajax=1&ajax_fn=wiki",
      data : {query:query},
      success : function(e) {
        if(self.active == false)
          return;
        var html = '<h4>' + e.query + '</h4><p>' + e.wiki + '</p>';
        self.showWiki(html);
        $element.removeClass('loading');
      }
    });
  },

  showWiki : function(html) {
    if($('.wiki').length == 0) {
      $wiki = $('<div class="wiki"></div>').css({
        'top' : this.lastY + 'px',
        'left' : this.lastX + 'px'
      }).appendTo('body');
    } else {
      $wiki = $('.wiki').css({
        'top' : this.lastY + 'px',
        'left' : this.lastX + 'px'
      });
    }

    $wiki.html(html);

  },

  hideWiki : function() {
    $('.wiki').remove();
  },

  registerHandler : function() {
    var self = this;
    this.handler = function(e) {
      var top = e.pageY + self.offsetY;
      var left = e.pageX + self.offsetX;
      $('.wiki').css({
        'top': top + 'px',
        'left': left + 'px',
      })
    };
    $('body').mousemove(this.handler);
  },

  unregisterHandler : function() {
    $('body').off('mousemove', this.handler);
  }

};

var core = {
  init : function() {
    search.init();
    wiki.init();
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