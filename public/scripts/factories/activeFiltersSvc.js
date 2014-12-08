angular.module('app.activeFilters')
.factory('activeFiltersSvc', ['$http', '$sanitize', function($http, $sanitize) {

var services = {

    populateKeywords: function(cache) {
      var results = $http.get('/api/v1/keywords/populateKeywords', {cache: cache});
      return results;
    },

    populateRootKeywords: function(cache) {
      var results = $http.get('/api/v1/keywords/populateRootKeywords', {cache: cache});
      return results;
    },

  };

  return services;

}]);
