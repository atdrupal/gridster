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

  $(function(){
    Drupal.ajax.prototype.commands.insertNewPane = function(ajax, data, status) {
      IPEContainerSelector = '#panels-ipe-regionid-' + data.regionId + ' div.panels-ipe-sort-container';
      firstPaneSelector = IPEContainerSelector + ' div.panels-ipe-portlet-wrapper:first';

      if ($(firstPaneSelector).length) {
        // insertData = { 'method': 'before', 'selector': firstPaneSelector, 'data': data.renderedPane, 'settings': null }
        // Drupal.ajax.prototype.commands.insert(ajax, insertData, status);
      }

      else {
        // insertData = { 'method': 'prepend', 'selector': IPEContainerSelector, 'data': data.renderedPane, 'settings': null }
        // Drupal.ajax.prototype.commands.insert(ajax, insertData, status);
      }

      appName = 'gridsterApp__'+ data.displayId +'__' + data.regionId;
      Drupal.settings.gridster[appName].widgets[data.paneId] = {
        label: '%label'
        , title: data.paneTitle
        , content: data.renderedPane
        , options: { position: {} }
      };
    };
  });

})(jQuery, Drupal);
