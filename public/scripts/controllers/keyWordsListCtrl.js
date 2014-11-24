'use strict';

/**
 * @ngdoc function
 * @name publicApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the publicApp
 */
angular.module('app.keyWordsList')
  .controller('keyWordsListCtrl', ['$scope', '$rootScope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 
  			'keyWordsListSvc', '$modal', 'toaster', 
	function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, keyWordsListSvc, $modal, toaster) {

		/**
		 * Holds all keyword entities.
		 * By keyword entity we mean that it includes the keyword itself, but also the recipents
		 * @type {Object}
		 */
		$rootScope.keyWordsLists = [{}];

		/**
		 * Holds the data of keyword entities that is going to be created or updated.
		 * @type {Object}
		 */
		$rootScope.keywordEntity = {
			keywords: [{ keyword:'' }],
			recipients: [{ full_name:'', email:'' }]
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
		* Add keywords inputs.
		* Assign multiple keywords to the users on the fly.
		*
		* @note: This is used on the `Create Keyword List` modal.
		*/
		$scope.addKeywordInput = function(){
			$scope.keywordEntity.keywords.push({ keyword:'' });
			setTimeout(function(){
				$("#id-keywords-container").children()[$("#id-keywords-container").children().length - 1].children[0].focus();
			}, 300);
		};

		/**
		* Add recipient inputs.
		* Assign multiple recipients to the users on the fly.
		* 
		* @note: This is used on the `Create Keyword List` modal.
		*/
		$scope.addRecipentInput = function(index){
			$scope.keywordEntity.recipients.push({ full_name:'', email:'' });
			setTimeout(function(){
				$("#id-recipients-container").children()[$("#id-recipients-container").children().length - 1].children[0].children[0].focus();
			}, 300);
		};

		/**
		* Remove keywords inputs.
		* Remove multiple keywords to the users on the fly.
		*
		* @note: This is used on the `Create Keyword List` modal.
		*/
		$scope.removeKeywordInput = function(index){
			if(isNaN(index)) {
				$scope.keywordEntity.keywords.splice($scope.keywordEntity.keywords.length - 1, 1);
			} else {
				$scope.keywordEntity.keywords.splice(index, 1);
			}
		};

		/**
		* Remove recipient inputs.
		* Remove multiple recipients to the users on the fly.
		* 
		* @note: This is used on the `Create Keyword List` modal.
		*/
		$scope.removeRecipentInput = function(index){
			if(isNaN(index)) {
				$scope.keywordEntity.recipients.splice($scope.keywordEntity.recipients.length - 1, 1);
			} else {
				$scope.keywordEntity.recipients.splice(index, 1);
			}
		};

		/**
		 * Show Training modal.
		 * @return {[type]} [description]
		 */
		$scope.show_create_modal = function() {
			$("#id-modal-create_keywordList").modal('show');
		};

		/**
		 * Show Training modal.
		 * @return {[type]} [description]
		 */
		$scope.hide_create_modal = function() {
			$("#id-modal-create_keywordList").modal('hide');
		};

		/**
		 * Create entity.
		 * @return {[type]} [description]
		 */
		$scope.create = function() {

			console.log($scope.keywordEntity);

			keyWordsList
				.create()
					.success(function(data){

				}).error(function(data){

			});

		};


		  // $modal({title: 'My Title', content: tmpl, show: true});
		  // Pre-fetch an external template populated with a custom scope
		  // 
		  // This templade way doesn't work, let's go with usual pattern first until we figure out what's wrong with this one.
		  // 
		  // var myOtherModal = $modal({scope: $scope, template: '/scripts/templates/create_keywordsList.tpl.html', show: false});
		  // Show when some event occurs (use $promise property to ensure the template has been loaded)
		  // $scope.showModal = function() {
		  //  myOtherModal.$promise.then(myOtherModal.show);
		  // };

		/**
		 * Update The whole keywordEntity
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

		// Keywords List
		$scope.$watch('keyWordsLists', function(){

			console.log($scope.keyWordsLists);

		}, true);

		// Keyword Entity
		$scope.$watch('keywordEntity', function(){

			console.log($scope.keywordEntity);

			$("#id-create-keywordList").removeAttr('disabled');
			$("#id-remove-keyword").hide();
			$("#id-remove-recipient").hide();

			if($scope.keywordEntity.keywords.length > 1) {
				$("#id-remove-keyword").show();
			}

			if($scope.keywordEntity.recipients.length > 1) {
				$("#id-remove-recipient").show();
			}

			angular.forEach($scope.keywordEntity.keywords, function(keyword){
				if(keyword.keyword.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
			});

			angular.forEach($scope.keywordEntity.recipients, function(recipient){
				if(recipient.full_name.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
				if(recipient.email.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
			});

		}, true);


		$scope.$watch('keywordEntity.keywords', function(){

			setTimeout(function(){

				// console.log($("#id-keywords-container").children());
				// console.log($("#id-keywords-container").children()[$("#id-keywords-container").children().length - 1].children);
				// $("#id-keywords-container").children()[$("#id-keywords-container").children().length - 1].children[0].focus();

			}, 300)

		}, true);

		$scope.$watch('keywordEntity.recipients', function(){

			setTimeout(function(){
				// console.log($("#id-recipients-container").children()[$("#id-recipients-container").children().length - 1].children[0].children[0].focus());
			}, 300);

		}, true);

}]);