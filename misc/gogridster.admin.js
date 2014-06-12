(function($, Drupal){

  Drupal.behaviors.gridsterGoAdmin = {
    attach: function(context, settings) {
      $('#panels-ipe-save', context)
        // .once('gridsterGoAdmin')
        .hover(
          function() {
            var config = {};

            $('.panels-ipe-editing .panel-display div[ng-app]').each(function(){
              var id = $(this).attr('ng-app');
              config[id] = Drupal.settings.gridster[id];

              for (i in config[id].widgets) {
                delete config[id].widgets[i].title;
                delete config[id].widgets[i].content;
                // delete config[id].widgets[i].options;
              }
            });

            $('input[name="display_settings"]').val(JSON.stringify(config));
          },
          function() {}
        )
      ;
    }
  };

})(jQuery, Drupal);
