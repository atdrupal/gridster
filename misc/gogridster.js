(function($, angular) {

  var do_drag_resize = function(status) {
    for (var app_name in Drupal.settings.gridster) {
      Drupal.settings.gridster[app_name].options.draggable.enabled = status;
      Drupal.settings.gridster[app_name].options.resizable.enabled = status;
      try {
        var div_id = $('div[ng-app="'+ app_name +'"]').attr('id');
        $('#' + div_id).scope().$digest();
      }
      catch (e) {}
    }
  };

  Drupal.behaviors.gridsterGoInit_ = {
    attach: function(context, settings) {
      do_drag_resize($('#panels-ipe-save').size() ? true : false);
    }
  };

  Drupal.behaviors.gridsterGoInit = {
    attach: function(context, settings) {
      var firstModule = 0;
      var initAngular = function(app_id, settings) {
        angular.module(app_id, ['goGridster'])
          .controller('gridsterCtrl', ['$scope', function($scope) {
            $scope[app_id] = settings.gridster[app_id];
          }]);
      }

      for (var app_name in settings.gridster) {
        var div_id = $('div[ng-app="'+ app_name +'"]').attr('id');

        $('#' + div_id, context).once('gridsterGoInit').each(function(){
          $(this).append('<div grid-master="'+ app_name +'"></div>');

          initAngular(app_name, settings);

          if (firstModule >= 1) {
            angular.bootstrap($('#' + div_id).get(0), [app_name]);
          }

          firstModule++;
        });
      }
    }
  };

})(jQuery, angular);