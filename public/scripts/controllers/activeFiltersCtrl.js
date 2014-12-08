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
  			'activeFiltersSvc', '$modal', 'toaster',
	function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, activeFiltersSvc, $modal, toaster) {

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

			console.log(cache);
			console.log(typeof cache);
			console.log(isNaN(cache));

			if(typeof cache == 'undefined' || isNaN(cache)) {
				cache = true;
			}

			console.log(cache);



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

			// console.log($rootScope.keyWordsLists);

		}, true);

		// Keyword Entity
		$scope.$watch('keywordEntity', function(){

		}, true);


		//------------------------------------------------------------
		// Global Broadcast listeners
		//------------------------------------------------------------
		// Event listeners can take arguments as param also.
		//

		$scope.$on('keyWordsList-create', function(event, args) {
			$rootScope.getRootKeywordFilters(false);
			$rootScope.getAllKeywordFilters(false);
		});

		$scope.$on('keyWordsList-delete', function(event, training) {

		});

		$scope.$on('keyWordsList-single-delete', function(event, training) {

		});


		//------------------------------------------------------------
		// Helper Functions
		//------------------------------------------------------------
		//

		/**
		 * Turn associative array to an array.
		 * @param  {[type]} object [description]
		 * @return {[type]}        [description]
		 */
		$scope.associative_to_array = function(object) {
			var array = [];
			for(var item in object){
				if(object[item].hasOwnProperty('keyword')) {
					array.push(object[item].keyword);
				} else {
					array.push(object[item]);
				}
			}
			return array;
		};

		/**
		 * Oposite of associative_to_array.
		 * @param  {[type]} array [description]
		 * @return {[type]}       [description]
		 */
		$scope.array_to_associative = function(array) {
			var obj = {};
			for(var i = 0; i < array.length; i++) {
			    obj[i] = array[i];   	// Assign the next element as a value of the object,
			                             // using the current value as key
			}
			return obj;
		};

		/**
		 * Stringify the object/associative array.
		 * @param  {[type]} object [description]
		 * @return {[type]}        [description]
		 */
		$scope.array_stringify = function(object) {
			return JSON.stringify(object);
		};

		/**
		 * Validate email.
		 * @param  {[type]} email [description]
		 * @return {[type]}       [description]
		 */
		$scope.validateEmail = function(email) {
		    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		    return re.test(email);
		};

		/**
		 * Find object by it's attribute value.
		 * @param  {[type]} array [description]
		 * @param  {[type]} attr  [description]
		 * @param  {[type]} value [description]
		 * @return {[type]}       [description]
		 */
		$scope.findWithAttr = function(array, attr, value) {
			for(var i = 0; i < array.length; i += 1) {
				if(array[i][attr] === value) {
				    return i;
				}
			}
		}

}]);