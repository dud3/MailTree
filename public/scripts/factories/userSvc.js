angular.module('app.user')
.factory('UserSvc', [ '$http', '$rootScope', '$sanitize',
  function($http, $rootScope, $sanitize) {

  var sanitizeUser = function(credentials) {
    return {
      email: $sanitize(credentials.email),
      password: $sanitize(credentials.password),
      first_name: $sanitize(credentials.first_name),
      last_name: $sanitize(credentials.last_name)
    };
  };

  return {

    createUser: function(credentials) {
      return $http.post('/api/v1/user/create', sanitizeUser(credentials));
    }
  
  };

}]);