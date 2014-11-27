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
			$rootScope.keywordEntity = {
				keywords: [{ keyword:'' }],
				recipients: [{ full_name:'', email:'' }]
			};

			$("#id-modal-create_keywordList").modal('show');
		};

		/**
		 * Show Training modal.
		 * @return {[type]} [description]
		 */
		$scope.hide_create_modal = function() {
			$rootScope.keywordEntity = {
				keywords: [{ keyword:'' }],
				recipients: [{ full_name:'', email:'' }]
			};

			$("#id-modal-create_keywordList").modal('hide');
		};

		/**
		 * Create entity.
		 * @return {[type]} [description]
		 */
		$scope.create = function() {

			var _keywordEntity = { keywords: [{}], recipients: [{}] };

			// Before trun the associative array into non-associative array 
			// since we can actally insert an associative array into the database
			// but we can't make it readable to backend, so take of the keys.
			_keywordEntity.keywords = $scope.associative_to_array($scope.keywordEntity.keywords);
			// turn the non-associative array into the associative array again
			// but this time make the keys equal to non-associative array keys, like the following:
			// keywords: {"0": "dolphin", "1": "dog", "2": "fish"}.
			_keywordEntity.keywords = $scope.array_to_associative(_keywordEntity.keywords);
			// and finally we can store it in this format as a string type into the database.
			// This is all because we want to make it able to store arrays into the database
			// and also make it playable/readable for the backend programming.
			_keywordEntity.keywords = $scope.array_stringify(_keywordEntity.keywords);
			// Recipients
			_keywordEntity.recipients = $scope.keywordEntity.recipients;

			keyWordsListSvc
				.create(_keywordEntity)
					.success(function(data){

						// From string to actual javaScript object
						data.ketwordsList.keywords = angular.fromJson(data.ketwordsList.keywords);

						// Push it back the the items array						
						$rootScope.keyWordsLists.push(data.ketwordsList);
						toaster.pop('success', "Message", "Keyword List Created Successfully.");
						$scope.hide_create_modal();

						// Scroll to the bottom
						setTimeout(function(){

							$('html, body').scrollTop( $(document).height() - $(window).height() );

							// Indicate a new added item
							$("#accordion" + data.ketwordsList.id).removeClass('animated zoomIn').addClass('animated zoomIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
								$(this).removeClass('animated zoomIn');
							});

						}, 300);



				}).error(function(data){
					toaster.pop('error', "Message", "Something went wrong, please try again.");
					$scope.hide_create_modal();
			});

		};

		/**
		 * Update The whole keywordEntity
		 * Update only recipent 
		 * Update only keyword
		 * @return {[type]} [description]
		 */
		$scope.submit = function() {

		};

		/**
		 * Remove keyword entity
		 * @param  {[type]} index [description]
		 * @return {[type]}       [description]
		 */
		$scope.removeKeywordEntity = function(index, keyWordsLists_id) {
			console.log(index);
			console.log(keyWordsLists_id);
			$scope.keyWordsLists.splice(index, 1);

			keyWordsListSvc
				.removeKeywordEntity(keyWordsLists_id)
					.success(function(data){
						
				}).error(function(data){
					toaster.pop('error', "Message", "Something went wrong, please try again.");
			});
				
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

		//------------------------------
		// Scope Watchers
		//------------------------------
		//

		// Keywords List
		$scope.$watch('keyWordsLists', function(){

			// console.log($scope.keyWordsLists);

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
				console.log(recipient);
				if(recipient.full_name.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
				if(recipient.email.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
				if(!$scope.validateEmail(recipient.email)) {
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

		//------------------------------
		// Helper Functions
		//------------------------------
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