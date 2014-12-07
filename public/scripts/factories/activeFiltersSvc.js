angular.module('app.activeFilters')
.factory('activeFiltersSvc', ['$http', '$sanitize', function($http, $sanitize) {

var services = {

    populateKeywords: function() {
      var results = $http.get('/api/v1/keywords/populateKeywords');
      return results;
    },

    populateRootKeywords: function() {
      var results = $http.get('/api/v1/keywords/populateRootKeywords');
      return results;
    },

  };

  return services;

}]);
