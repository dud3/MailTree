angular.module('app.keyWordsList')
.factory('keyWordsListSvc', ['$http', '$sanitize', function($http, $sanitize) {
  
var services = {

    getAll: function() {
      var results = $http.get('/api/v1/keywords/get');
      return results;
    },

    create: function(data) {
      var results = $http.post('/api/v1/keywords/create', angular.toJson(training));
      return results;
    },

    updateKeyword: function(keyword) {
      var results = $http.post('/api/v1/updateKeyword', angular.toJson(training));
      return results;
    },

    updateRecipient: function(user) {
      return $http.get('/api/v1/updateRecipients', angular.toJson(user));
    },

    delete: function(id) {
      return $http({ method: 'DELETE', url: '/api/v1/deleteKeyword/' + id});
    },

    removeRecipent: function(id) {
      return $http.post('/api/v1/emails/removeRecipent/' + id);
    },

    search: function(param) {
      return $http.get('/api/v1/search', angular.toJson(param));
    }

  };

  return services;

}]);
