angular.module('app.auth')
  .controller('AuthCtrl', ['$rootScope', '$scope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'AuthSvc', 'HelperSvc', 'toaster', '_userSessions', '_pwdToken',
      function ($rootScope, $scope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, AuthSvc, HelperSvc, toaster, _userSessions, _pwdToken) {

  /**
   * Cookies holder.
   * @type {Object}
   */
  var authCookies = {
    getRemembner : $cookieStore.get('rememberMe'),
    getRedirect : $cookieStore.get('redirect')
  };

  /**
   * Login Credentials
   * @type {[type]}
   */
  $scope.loginCredentials = {
    email: $("#id-email").val(),
    password: $("#id-password").val(),
    remember: authCookies.getRemembner
  };

  /**
   * Resend passwod credentials.
   * @type {Object}
   */
  $scope.resetPwdCredentials = {
    token: _pwdToken,
    password: "",
    repeatPassword: ""
  };


  /**
   * Login function.
   * @return {[type]} [description]
   */
  $scope.login = function() {

    $("#id-submit").button('loading');

    if(typeof $scope.loginCredentials.remember == 'undefined') $scope.loginCredentials.remember = false;
    ($scope.loginCredentials.remember) ? $cookieStore.put('rememberMe', true) : $cookieStore.remove('rememberMe');
    
    if($scope.loginCredentials.email === undefined) {
        alert("Please Enter A valid Email");
        return;
    }
    
    AuthSvc.login($scope.loginCredentials)
        .success(function(data) {
          return HelperSvc.redirect('/app');
          $("#id-submit").button('reset');
        }).error(function(data) {
          toaster.pop('error', 'Message', data.msg);
          $("#id-submit").button('reset');
    });

  };

  /**
   * Logout function.
   * @return {[type]} [description]
   */
  $rootScope.logout = function() {
    AuthSvc.logout()
      .success(function() {
       return HelperSvc.redirect('/');
      })
      .error(function(){
        return HelperSvc.redirect('/app');
    });
  };

  /**
   * Reset password send function.
   * @return {[type]} [description]
   */
  $scope.resetPasswordSendToken = function() {
    AuthSvc.resetPasswordSendToken($scope.credentials.email)
      .success(function(msg){
        toaster.pop('success', 'Message', 'We Just sent you an email with the reset code, please check your email.');
      }).error(function(msg){
        if(msg.error) { (msg.error.type == "Swift_TransportException") ? msg = "Mail Server is Down, please try again later." : msg; }
        toaster.pop('error', 'Message', msg);
      });
  };

  /**
   * Reset password function.
   * @return {[type]} [description]
   */
  $scope.resetPassword = function() {
    AuthSvc
      .resetPassword($scope.resetPwdCredentials)
        .success(function(data){
          toaster.pop('success', 'Message', 'Reset Password successed, please wait we are fixing stuff for you...');
          $('#resetToken').attr('disabled','disabled');
          setInterval(function() { return HelperSvc.redirect('/'); }, 5000);
      }).error(function(msg){
          toaster.pop('error', 'Message', msg);
    });
      
  };

  $scope.$watch('loginCredentials', function() {

    $("#id-submit").removeAttr('disabled');
     $(".text-danger").html('');

    if($scope.loginCredentials.email.length == 0) {
      $("#id-submit").attr('disabled', 'disabled');
    }

    if($scope.loginCredentials.password.length == 0) {
      $("#id-submit").attr('disabled', 'disabled');
    }

    if($scope.loginCredentials.email.length > 3) {
      if(!HelperSvc.validateEmail($scope.loginCredentials.email)) {
        $("#id-form-gr-email").append("<span class='text-danger'>Wrong email format.</span>");
        $("#id-submit").attr('disabled', 'disabled');
      }
    }
    
  }, true);

}]).directive("ngLoginSubmit", function() {
    return {
        restrict: "A",
        scope: {
            onSubmit: "=ngLoginSubmit"
        },
        link: function(scope, element, attrs) {
            $(element)[0].onsubmit = function() {
                $("#login-login").val($("#email", element).val());
                $("#login-password").val($("#password", element).val());

                scope.onSubmit(function() {
                    $("#login-form")[0].submit();
                });
                return false;
            };
        }
    }
});
