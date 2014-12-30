angular.module('app.user')
  .controller('UserCtrl', ['$scope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'UserSvc', 'AuthSvc', 'HelperSvc', 'toaster',
      function ($scope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, UserSvc, AuthSvc, HelperSvc, toaster) {

  $scope.user = {
      email: "",
      password: "",
      first_name: "",
      last_name: "",
  };

  $scope.createUser = function() {
    $("#id-create-users").button('loading');
    UserSvc.createUser($scope.user)
      .success(function() {
        
        toaster.pop('success', 'message', 'Cool, you just created the user');
        document.getElementById('id-email').className = "form-control";
        $("#id-create-users").button('reset');

        $scope.hide_create_modal();
      }).error(function(data) {

        toaster.pop('error', 'message', data.msg);
        document.getElementById('id-email').className = "form-control input-danger";
        $("#id-create-users").button('reset');
        
    });

  };

  $scope.hide_create_modal = function() {
    for(var key in $scope.user) {
      $scope.user[key] = "";
    }
    $("#id-modal-create_users").modal("hide");
  };

  $scope.$watch('user', function(){

    _submit_element = document.getElementById('id-create-users');
    _submit_element.disabled = false;
    var flag = false;

    if($scope.user.email.length == 0) {
      flag = true;
    }

    if($scope.user.password.length == 0) {
      flag = true;
    }

    if($scope.user.first_name.length == 0) {
      flag = true;
    }

    if($scope.user.last_name.length == 0) {
      flag = true;
    }

    if(!HelperSvc.validateEmail($scope.user.email)) {
      flag = true;
    }

    if(flag) { _submit_element.disabled = true };

  }, true);

}]);