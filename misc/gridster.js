(function($) {

  Drupal.behaviors.gridster = {
    attach: function(context, settings) {
      $("ul.gridster", context).once().gridster({
        widget_margins: [10, 10],
        widget_base_dimensions: [140, 140],
        helper: 'clone',
        resize: {enabled: true}
      }).find('li').css({cursor: 'pointer', border: '1px #000 solid', 'list-style-type': 'none'});

    }
  };

})(jQuery);
