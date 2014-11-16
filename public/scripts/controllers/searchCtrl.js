'use strict';

/**
 * @ngdoc module
 * @name app.controller:searchCtrl
 * @description
 * # searchCtrl
 * Controller of the search functions
 */
angular.module('app.search')
  .controller('searchCtrl', ['$scope', '$rootScope', '$filter', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'keyWordsListSvc', 'filterFilter',
	function ($scope, $rootScope, $filter, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, keyWordsListSvc, filterFilter) {

		/**
		 * Global search variable
		 * @type {Object}
		 */
		$rootScope.__G__search = [];

		/**
		 * Search globaly
		 * @return {[type]} [description]
		 */
		$scope.search = function() {

		};

		/**
		 * Animate searched values
		 * @return {[type]} [description]
		 */
		$scope.animate = function() {

		};


		//------------------------------
		// Scope Watchers
		//------------------------------
		//
		$scope.$watch('__G__search', function(newVal, oldVal){

			console.log("new value in filter box:", newVal);

			// if(newVal.length !== 0) {
				// this is the JS equivalent of "phones | filter: newVal"
				// $rootScope.keyWordsLists = $filter('filter')($rootScope.keyWordsLists, newVal);
				$rootScope.keyWordsLists = filterFilter($rootScope.keyWordsLists, $rootScope.keyWordsLists);
			// }

			console.log($rootScope.keyWordsLists);

		}, true);

}]);