angular.module('app.keyWordsList')
.factory('keyWordsListSvc', ['$http', '$sanitize', function($http, $sanitize) {
  
var services = {

    getAll: function() {
      var results = $http.get('/api/v1/keywords/get');
      return results;
    },

    create: function(keyWordsListEntity) {
      var results = $http.post('/api/v1/keywords/create', angular.toJson(keyWordsListEntity));
      return results;
    },

    removeKeywordEntity: function(id) {
      return $http.post('/api/v1/keywords/remove/' + id);
    },

    updateKeyword: function(keyword) {
      var results = $http.post('/api/v1/updateKeyword', angular.toJson(keyword));
      return results;
    },

    updateRecipient: function(user) {
      return $http.get('/api/v1/updateRecipients', angular.toJson(user));
    },

    keepOriginalContent: function(keyWordEntity) {
      return $http.post('/api/v1/keywords/keepOriginalContent', angular.toJson(keyWordEntity));
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
