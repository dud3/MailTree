angular.module('app.user')
  .controller('UserCtrl', ['$scope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'AuthSvc', 'HelperSvc', '_userSessions', '_pwdToken', 'toaster',
      function ($scope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, AuthSvc, HelperSvc, _userSessions, _pwdToken, toaster) {

  $scope.user = {
      email: $("#email").val(),
      password: $("#password").val(),
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
  };

  $scope.createUser = function() {
    AuthSvc.register($scope.user)
      .success(function() {
        toaster.pop('success', 'message', 'Cool, you just created the user');
      }).error(function(msg) {
        toaster.pop('error', 'message', msg);
    });
  };

}]);