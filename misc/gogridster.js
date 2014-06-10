(function($, angular) {

  Drupal.behaviors.gridsterGoInit = {
    attach: function(context, settings) {
      for (var app_id in settings.gridster) {
        $('#' + app_id).once('gridsterGoInit').each(function(){
          $(this).append('<div grid-master="'+ app_id +'"></div>');

          console.log([app_id, settings.gridster[app_id]]);

          angular.module(app_id, [])
            .controller('gridsterCtrl', ['$scope', function($scope) {
              $scope[app_id] = settings.gridster[app_id];
            }])
          ;
        });
      }
    }
  };

})(jQuery, angular);
