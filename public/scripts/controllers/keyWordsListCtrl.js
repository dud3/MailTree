'use strict';

/**
 * @ngdoc function
 * @name publicApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the publicApp
 */
angular.module('app.keyWordsList')
  .controller('keyWordsListCtrl', ['$scope', '$rootScope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'keyWordsListSvc', 'toaster',
	function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, keyWordsListSvc, toaster) {

		/**
		 * Holds all keyword entities.
		 * By keyword entity we mean that it includes the keyword itself, but also the recipents
		 * @type {Object}
		 */
		$rootScope.keyWordsLists = [];

		/**
		 * Holds the data of keyword entities that is going to be created or updated.
		 * @type {Object}
		 */
		$rootScope.keywordEntity = {
			keywords: [],
			Recipients: [{}]
		};

		$scope.search = "";

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

		}();

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
		$scope.removeKeyword = function() {

		};

		/**
		 * Remove recipent
		 * @return {[type]} [description]
		 */
		$scope.removeRecipent = function(parentIndex, index) {

			var findRecipient = $rootScope.keyWordsLists[parentIndex].email[index].email_list_id;

			if(!isNaN(findRecipient)) {

				keyWordsListSvc.removeRecipent(findRecipient).success(function(data){
					$rootScope.keyWordsLists[parentIndex].email.splice(index, 1);
					toaster.pop('success', "Message", "Recipient Deleted.");
				}).error(function(data){
					toaster.pop('error', "Message", "Something went wrong, please try again.");
				});

			} else {
				$rootScope.keyWordsLists[parentIndex].email.splice(index, 1);
			}

		};

		$scope.users = [
			{id: 1, name: 'awesome user1', status: 2, group: 4, groupName: 'admin'},
			{id: 2, name: 'awesome user2', status: undefined, group: 3, groupName: 'vip'},
			{id: 3, name: 'awesome user3', status: 2, group: null}
		];

		$scope.saveUser = function(data, id) {
			//$scope.user not updated yet
			angular.extend(data, {id: id});
			return $http.post('/saveUser', data);
		};

		/**
		 * Add recipent
		 * @param {[type]} index [description]
		 */
		$scope.addRecipent = function(index) {

			var recipientList = $rootScope.keyWordsLists[index];
			console.log(recipientList);

			$scope.inserted = {
				email_list_id: recipientList.length + 1,
				email: '',
				full_name: '' 
			};

			$rootScope.keyWordsLists[index].email.push($scope.inserted);

		};

		/**
		 * Search globaly
		 * @return {[type]} [description]
		 */
		$scope.search = function() {

		};



		//------------------------------
		// Scope Watchers
		//------------------------------
		//

		$scope.$watch('keyWordsLists', function(){

			console.log($scope.keyWordsLists);

		}, true);

}]);