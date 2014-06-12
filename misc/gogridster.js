(function($, angular) {

  var do_drag_resize = function(status) {
    for (var app_name in Drupal.settings.gridster) {
      Drupal.settings.gridster[app_name].options.draggable.enabled = status;
      Drupal.settings.gridster[app_name].options.resizable.enabled = status;
      try {
        $('#' + app_name).scope().$digest();
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

      for (var app_id in settings.gridster) {
        $('#' + app_id, context).once('gridsterGoInit').each(function(){
          $(this).append('<div grid-master="'+ app_id +'"></div>');

          initAngular(app_id, settings);

          if (firstModule >= 1) {
            angular.bootstrap($('#' + app_id).get(0), [app_id]);
          }

          firstModule++;
        });
      }
    }
  };

})(jQuery, angular);