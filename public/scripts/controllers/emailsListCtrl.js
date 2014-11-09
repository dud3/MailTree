'use strict';

/**
 * @ngdoc function
 * @name publicApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the publicApp
 */
angular.module('app.emailsList')
  .controller('emailsListCtrl', ['$scope', '$rootScope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'emailsListSvc',
	function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, emailsListSvc) {
       
       	/**
       	 * Emails holder
       	 * @type {Array}
       	 */
		$rootScope.emails = [];

	
		/**
		 * Hold the data of the email to be edited or created.
		 * @type {Object}
		 */
		$rootScope.email = {
			id: null,
			keywords: [],
			subject: "",
			body: "",

		};

		/**
		 * Get all the keywords
		 * @return {[type]} [description]
		 */
		$scope.getAllKeywords = function() {

			keyWordsListSvc
				.getAll()
					.success(function(data){

						// From string to actual javaScript object
						angular.forEach(data.keywords, function(item) {
							item.keywords = angular.fromJson(item.keywords);
						})

						$rootScope.keyWordsLists = data.keywords;

						// 
						// Note the internal keywords should be 
						// -> accessed like: $rootScope.keyWordsList[0].keywords["0"]
						// 
						// and not like: $rootScope.keyWordsList[0].keywords.0
						// 
						// The second one returns error.
						// 

						console.log($rootScope.keyWordsLists);

				}).error(function(data){
					console.log(data);
			});

		};

		/**
		 * Create entity.
		 * @return {[type]} [description]
		 */
		$scope.create = function() {

			keyWordsList
				.create()
					.success(function(data){

				}).error(function(data){

			});

		};

		/**
		 * Update The whole keyword_entity
		 * Update only recipent 
		 * Update only keyword
		 * @return {[type]} [description]
		 */
		$scope.submit = function() {

		};

		/**
		 * Remove keyword
		 * @return {[type]} [description]
		 */
		$scope.remove_keyword = function() {

		};

		/**
		 * Remove recipent
		 * @return {[type]} [description]
		 */
		$scope.remove_recipent = function() {

		};

		/**
		 * Search globaly
		 * @return {[type]} [description]
		 */
		$scope.search = function() {

		}

}]);