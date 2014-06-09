(function($) {

  var gridster_admin = function() {
    var $wrapper = $(this).parent();
    var $form = $(this).parent().find('form').hide();

    $form
      .submit(function() {
        var json = {};
        $wrapper.find('> ul > li').each(function() {
          json[$(this).data('id')] = {
            'row': $(this).attr('data-row')
            , 'col': $(this).attr('data-col')
            , 'sizex': $(this).attr('data-sizex')
            , 'sizey': $(this).attr('data-sizey')
          };
        });

        $('[name="widget_settings"]', $form).val(JSON.stringify(json));
    });

    $wrapper.click(function(){
      $form.show();
    });
  };

  Drupal.behaviors.gridsterRegionAdmin = {
    attach: function(context, settings) {
      $('ul.gridster', context).once('gridsterRegionAdmin').each(gridster_admin);
    }
  };

})(jQuery);