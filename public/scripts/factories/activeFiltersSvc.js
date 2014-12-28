angular.module('app.activeFilters')
.factory('activeFiltersSvc', ['$http', '$sanitize', function($http, $sanitize) {

var services = {

    populateKeywords: function(cache) {
      return $http.get('/api/v1/keywords/populateKeywords', {cache: cache});
    },

    populateUserKeywords: function(cache) {
      return $http.get('/api/v1/keywords/populateUserKeywords', {cache: cache});
    },

    populateRootKeywords: function(cache) {
      return $http.get('/api/v1/keywords/populateRootKeywords', {cache: cache});
    },

    populateUserRootKeywords: function(cache) {
      return $http.get('/api/v1/keywords/populateUserRootKeywords', {cache: cache})
    }

  };

  return services;

}]);
