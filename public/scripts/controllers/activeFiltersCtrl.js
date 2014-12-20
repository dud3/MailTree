'use strict';

/**
 * @ngdoc function
 * @name mailTree.controller:activeFiltersCtrl
 * @description
 * # activeFiltersCtrl
 * Controller of the mailTree
 */
angular.module('app.activeFilters')
  .controller('activeFiltersCtrl', ['$scope', '$rootScope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore',
  			'activeFiltersSvc', 'HelperSvc', '$modal', 'toaster',
	function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, activeFiltersSvc, HelperSvc, $modal, toaster) {

		/**
		 * Holds the filters.
		 * @type {Object}
		 */
		$rootScope.activeFilter = {
			allKeywords: [],
			rootKeywords: []
		};

		/**
		 * Simple tooltip.
		 * @type {Object}
		 */
		$scope.tooltip = {title: 'Keep the origianl format of the email.'};

		/**
		 * Search model.
		 * @type {String}
		 */
		$scope._search = "";

		/**
		 * Get all the keywords
		 * @return {[type]} [description]
		 * @param {bool} [cache] [get cache from cache or not.]
		 */
		$rootScope.getAllKeywordFilters = function(cache) {

			if(typeof cache == 'undefined' || isNaN(cache)) {
				cache = true;
			}

			activeFiltersSvc
				.populateKeywords(cache)
					.success(function(data){

						// From string to actual javaScript object
						angular.forEach(data.keywords, function(item) {

							item.keywords = angular.fromJson(item.keywords);

							angular.forEach(item.keywords, function(_item) {
								$rootScope.activeFilter.allKeywords.push(_item);
							});

						});

						//
						// Note the internal keywords should be
						// -> accessed like: $rootScope.keyWordsList[0].keywords["0"]
						//
						// and not like: $rootScope.keyWordsList[0].keywords.0
						//
						// The second one returns error.
						//

						$rootScope.activeFilter.allKeywords = _.uniq($rootScope.activeFilter.allKeywords);

						console.log($rootScope.activeFilter.allKeywords);

				}).error(function(data){
					console.log(data);
			});

		}

		/**
		 * Get the root keywords.
		 * @param {bool} [cache] [Get data from cache or not.]
		 * @return {[type]} [description]
		 */
		$rootScope.getRootKeywordFilters = function(cache) {

			if(typeof cache == 'undefined' || isNaN(cache)) {
				cache = true;
			}

			activeFiltersSvc
				.populateRootKeywords(cache)
					.success(function(data){

						angular.forEach(data, function(item) {
							angular.fromJson(item);
							$rootScope.activeFilter.rootKeywords.push(item[0]);
						});

						$rootScope.activeFilter.rootKeywords = _.uniq($rootScope.activeFilter.rootKeywords);

				}).error(function(data){
					console.log(data);
			});

		}

		/**
		 * Open the main filters section.
		 * @return {[type]} [description]
		 */
		$rootScope.openFiltersList = function() {

			$scope.getRootKeywordFilters();
			$scope.getAllKeywordFilters();

			if(document.getElementById("id-filter-container").style.display == 'none') {
				$("#id-filter-container").slideDown("slow");
			} else {
				$("#id-filter-container").slideUp("fast");
			}

		};

		/**
		 * Slide down root keyword filters section.
		 * @return {[type]} [description]
		 */
		$rootScope.openRootKeywords = function() {

			var element = $("#id-filters-list").children()[0].childNodes[1].childNodes[0];

			if(document.getElementById("id-rootKeywords-list").style.display == 'none') {
				$("#id-rootKeywords-list").slideDown("slow");
				element.className = "fa fa-angle-down";
			} else {
				$("#id-rootKeywords-list").slideUp("fast");
				element.className = "fa fa-angle-right";
			}

		};

		/**
		 * Slide down all keyword filters.
		 * @return {[type]} [description]
		 */
		$rootScope.openAllKeywords = function() {

			var element = $("#id-filters-list").children()[2].childNodes[1].childNodes[0];

			if(document.getElementById("id-allKeywords-list").style.display == 'none') {
				$("#id-allKeywords-list").slideDown("slow");
				element.className = "fa fa-angle-down";
			} else {
				$("#id-allKeywords-list").slideUp("fast");
				element.className = "fa fa-angle-right";
			}

		};

		/**
		 * Search globaly
		 * @return {[type]} [description]
		 */
		$rootScope.activateFilter = function(param) {
			$rootScope.__G__search = param;
		};

		//------------------------------------------------------------
		// Scope Watchers
		//------------------------------------------------------------
		//

		// Keywords List
		$scope.$watch('keyWordsLists', function(){

		}, true);

		// Keyword Entity
		$scope.$watch('keywordEntity', function(){

		}, true);


		//------------------------------------------------------------
		// Global Broadcast listeners
		//------------------------------------------------------------
		// Event listeners can take arguments as param also.
		//

		$scope.$on('keyWordsList-create', function(event, arg) {
			$rootScope.getRootKeywordFilters(false);
			$rootScope.getAllKeywordFilters(false);
		});

		$scope.$on('keyWordsList-delete', function(event, arg) {

			if($rootScope.activeFilter.allKeywords.length > 0) {

				$rootScope.activeFilter.rootKeywords.splice(HelperSvc.findInArr($rootScope.activeFilter.rootKeywords, arg._item.keywords[0]) , 1);

				var _indexes = HelperSvc.findMulIndexinArr($rootScope.activeFilter.allKeywords, arg._item.keywords);

				for (var i = 0; i < _indexes.length; i++) {
					$rootScope.activeFilter.allKeywords.splice(_indexes[i], 1);
				};

			}

		});

		$scope.$on('keyWordsList-single-delete', function(event, training) {

		});

}]);