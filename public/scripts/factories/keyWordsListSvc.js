angular.module('app.keyWordsList')
.factory('keyWordsListSvc', ['$http', '$sanitize', function($http, $sanitize) {

var services = {

    getAll: function() {
      var results = $http.get('/api/v1/keywords/get');
      return results;
    },

    getUserKeywords: function() {
      return $http.get('/api/v1/keywords/getUserKeywords');
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

    sendAutomatically: function(keyWordEntity) {
      return $http.post('/api/v1/keywords/sendAutomatically', angular.toJson(keyWordEntity));
    },

    keepOriginalContent: function(keyWordEntity) {
      return $http.post('/api/v1/keywords/keepOriginalContent', angular.toJson(keyWordEntity));
    },

    delete: function(id) {
      return $http({ method: 'DELETE', url: '/api/v1/deleteKeyword/' + id});
    },

    saveRecipient: function(data) {
      return $http.post('/api/v1/keywords/saveRecipient', angular.toJson(data));
    },

    removeRecipent: function(id) {
      return $http.post('/api/v1/keywords/removeRecipent/' + id);
    },

    search: function(param) {
      return $http.get('/api/v1/search', angular.toJson(param));
    }

  };

  return services;

}]);
