angular.module('app.auth')
.factory('AuthSvc', [ '$http', '$rootScope', '$sanitize', 'CSRF_TOKEN', /*'pwdToken',*/
  function($http, $rootScope, $sanitize, CSRF_TOKEN /*pwdToken*/) {

  var cacheSession   = function(data, status, headers, config) {
    SessionSvc.set('authenticated', true);
  };

  var uncacheSession = function() {
    SessionSvc.unset('authenticated');
    $rootScope.$broadcast('userLoggedOutEvent');
  };

  var sanitizeCredentials = function(credentials) {
    return {
      email: $sanitize(credentials.email),
      password: $sanitize(credentials.password),
      first_name: $sanitize(credentials.first_name),
      last_name: $sanitize(credentials.last_name),
      csrf_token: CSRF_TOKEN,
      remember: credentials.remember
    };
  };

  var sanitizeResetCredentials = function(reset) {
    return {
      token: reset.token,
      password: $sanitize(reset.password),
      repeatPassword: $sanitize(reset.repeatPassword),
      csrf_token: CSRF_TOKEN
    };
  };

  var sanitizePasswords = function(passwords) {
    return {
      current: $sanitize(passwords.current),
      New: $sanitize(passwords.New),
      confirm: $sanitize(passwords.confirm),
      csrf_token: CSRF_TOKEN
      
    };
  };

  var sanitizeEmail = function(udateEmailcredentials) {
    return {
      email: $sanitize(udateEmailcredentials.email),
      password: $sanitize(udateEmailcredentials.password),
     csrf_token: CSRF_TOKEN
    };
  };

  var emitUserLoggedInEvent = function(data, status, headers, config) {
    $rootScope.$emit('userLoggedInEvent', data);
    return true;
  };

  var emitUserLoggedOutEvent = function(data, status, headers, config) {
    $rootScope.$emit('userLoggedOutEvent', data);
  };

  return {

    login: function(credentials) {
      var login = $http.post('/api/v1/auth/login', sanitizeCredentials(credentials));
      login.success(cacheSession);
      login.success(FlashSvc.clear);
      login.error(loginError);
      return login;
    },

    logout: function() {
      var logout = $http.get('/api/v1/auth/logout');
      logout.success(uncacheSession);
      logout.success(emitUserLoggedOutEvent);
      return logout;
    },

    register: function(credentials) {
      var register = $http.post('/api/v1/auth/register', sanitizeCredentials(credentials));
      register.success(cacheSession);
      register.success(FlashSvc.clear);
      register.success(emitUserLoggedInEvent);
      register.error(signupError);
      
      return register;
    },

    resetPasswordSendToken: function(email) {
      var resetPasswordToken = $http.post('/api/v1/auth/resetPasswordToken', {'email':email});
      return resetPasswordToken;
    },

    resetPassword: function(credentials) {
      var resetPassword = $http.post('/api/v1/auth/resetPassword', sanitizeResetCredentials(credentials));
      return resetPassword;
    },

    checkUserGroup: function() {
      return $http.get('/api/v1/auth/checkUserGroup');
    },

    updateEmail: function(udateEmailcredentials) {
      var update = $http.put('/api/v1/auth/changeEmail', sanitizeEmail(udateEmailcredentials));
      return update;
    },

    ChangePassword: function(passwords){
      var update = $http.put('/api/v1/auth/changePassword', sanitizePasswords(passwords));
      return update;
    }
  
  };

}]);