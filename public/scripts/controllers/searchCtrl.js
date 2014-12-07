'use strict';

/**
 * @ngdoc module
 * @name app.controller:searchCtrl
 * @description
 * # searchCtrl
 * Controller of the search functions
 */
angular.module('app.search')
  .controller('searchCtrl', ['$scope', '$rootScope', '$filter', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'filterFilter',
	function ($scope, $rootScope, $filter, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, filterFilter) {

		/**
		 * Global search variable
		 * @type {Object}
		 */
		$rootScope.__G__search = "";


		$rootScope.__G__clean_search = function() {
			$rootScope.__G__search = "";
		};

		//------------------------------
		// Scope Watchers
		//------------------------------
		//
		$scope.$watch('__G__search', function(newVal, oldVal){

			console.log($rootScope.__G__search);

			// if(newVal.length !== 0) {
				// this is the JS equivalent of "phones | filter: newVal"
				// $rootScope.keyWordsLists = $filter('filter')($rootScope.keyWordsLists, newVal);
				// $rootScope.keyWordsLists = filterFilter($rootScope.keyWordsLists, $rootScope.keyWordsLists);
			// }

		}, true);

}]);