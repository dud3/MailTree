angular.module('app.auth')
.factory('AuthSvc', [ '$http', '$rootScope', '$sanitize', 'CSRF_TOKEN', '_pwdToken',
  function($http, $rootScope, $sanitize, CSRF_TOKEN, _pwdToken) {

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

  return {

    login: function(credentials) {
      return $http.post('/api/v1/auth/login', sanitizeCredentials(credentials));
    },

    logout: function() {
      return $http.get('/api/v1/auth/logout');
    },

    register: function(credentials) {
      return $http.post('/api/v1/auth/register', sanitizeCredentials(credentials));
    },

    resetPasswordSendToken: function(email) {
      return $http.post('/api/v1/auth/resetPasswordToken', {'email':email});
    },

    resetPassword: function(credentials) {
      return $http.post('/api/v1/auth/resetPassword', sanitizeResetCredentials(credentials));
    },

    changePassword: function(passwords){
      return $http.put('/api/v1/auth/changePassword', sanitizePasswords(passwords));
    }
  
  };

}]);