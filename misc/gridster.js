(function($) {

  Drupal.behaviors.gridsterInit = {
    attach: function(context, settings) {
      $("ul.gridster", context).once('gridsterInit').each(function(){
        var admin = $(this).parent().find('> form').size() ? true : false;
        var options = {
          widget_margins: [3, 3]
          , widget_base_dimensions: [140, 140]
          , helper: 'clone'
          , resize: { enabled: admin }
        };

        console.log(options);

        $g = $(this).gridster(options).data('gridster');
        admin ? $g.enable() : $g.disable();
      });
    }
  };

})(jQuery);
