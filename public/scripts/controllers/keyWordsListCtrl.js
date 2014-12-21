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
  			'keyWordsListSvc', 'HelperSvc', '$modal', 'toaster',
	function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, keyWordsListSvc, HelperSvc, $modal, toaster) {

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
			recipients: [{ full_name:'', email:'' }],
			original_content: false
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
							item.original_content = parseInt(item.original_content);
						});

						$rootScope.keyWordsLists = data.keywords;

						//
						// Note the internal keywords should be
						// -> accessed like: $rootScope.keyWordsList[0].keywords["0"]
						//
						// and not like: $rootScope.keyWordsList[0].keywords.0
						//
						// The second one returns error.
						//

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
			$rootScope.keywordEntity.keywords.push({ keyword:'' });
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
			$rootScope.keywordEntity.recipients.push({ full_name:'', email:'' });
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
				$rootScope.keywordEntity.keywords.splice($rootScope.keywordEntity.keywords.length - 1, 1);
			} else {
				$rootScope.keywordEntity.keywords.splice(index, 1);
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
				$rootScope.keywordEntity.recipients.splice($rootScope.keywordEntity.recipients.length - 1, 1);
			} else {
				$rootScope.keywordEntity.recipients.splice(index, 1);
			}
		};

		/**
		 * Keep the original content of the email(s) associated with keywords.
		 * @param {[type]} keyword_id [description]
		 */
		$scope.keepOriginalContent = function(keyword_id) {

			var checked = document.getElementById("check_" + keyword_id).checked;

			var _keywordEntity = { id: keyword_id, original_content: checked };

			keyWordsListSvc
				.keepOriginalContent(_keywordEntity)
					.success(function(data){
						toaster.pop('success', "Message", "Changed Successfully.");
					}).error(function(data){
						toaster.pop('error', "Message", "Failed to Changed, please try again.");
						document.getElementById("check_" + keyword_id).checked = false;
					});

		};

		/**
		 * Show Training modal.
		 * @return {[type]} [description]
		 */
		$scope.show_create_modal = function() {
			$rootScope.keywordEntity = {
				keywords: [{ keyword:'' }],
				recipients: [{ full_name:'', email:'' }],
				original_content: false
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
				recipients: [{ full_name:'', email:'' }],
				original_content: false
			};

			$("#id-modal-create_keywordList").modal('hide');
		};

		/**
		 * Create entity.
		 * @return {[type]} [description]
		 */
		$scope.create = function() {

			$("#id-create-keywordList").button('loading');

			var _keywordEntity = { keywords: [{}], recipients: [{}] };

			// Before trun the associative array into non-associative array
			// since we can actally insert an associative array into the database
			// but we can't make it readable to backend, so take of the keys.
			_keywordEntity.keywords = HelperSvc.associative_to_array($rootScope.keywordEntity.keywords);
			// turn the non-associative array into the associative array again
			// but this time make the keys equal to non-associative array keys, like the following:
			// keywords: {"0": "dolphin", "1": "dog", "2": "fish"}.
			_keywordEntity.keywords = HelperSvc.array_to_associative(_keywordEntity.keywords);
			// and finally we can store it in this format as a string type into the database.
			// This is all because we want to make it able to store arrays into the database
			// and also make it playable/readable for the backend programming.
			_keywordEntity.keywords = HelperSvc.array_stringify(_keywordEntity.keywords);

			// push the state of original_content model, since the `original_content` column belongs to `keywods_list` table.
			_keywordEntity.original_content = $rootScope.keywordEntity.original_content;

			// Recipients
			_keywordEntity.recipients = $rootScope.keywordEntity.recipients;

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

						// Boradcast to activeFiltersCtrl
						$rootScope.$broadcast('keyWordsList-create', {});

						$("#id-create-keywordList").button('reset');
						$scope.cleanKeywordsExists();

				}).error(function(data){
					toaster.pop('error', "Message", data[0]);
					$scope.indicateKeywordsExists();
					$("#id-create-keywordList").button('reset');
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

			// find item itself.
			var _item = HelperSvc.findIntemInArr($rootScope.keyWordsLists, "id", keyWordsLists_id);

			// Since we might be filtering and deleting at the same time
			// check if by unique ID.
			var _index = HelperSvc.findIndexWithAttr($rootScope.keyWordsLists, "id", keyWordsLists_id);

			if(_index != -1) {

				$rootScope.keyWordsLists.splice(_index, 1);

				keyWordsListSvc
					.removeKeywordEntity(keyWordsLists_id)
						.success(function(data){

						// Boradcast to activeFiltersCtrl
						$rootScope.$broadcast('keyWordsList-delete', {_item: _item});

					}).error(function(data){
						toaster.pop('error', "Message", "Something went wrong, please try again.");
				});

			} else {
				// Nnothing...
			}

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

		$scope.saveRecipient = function(data, id) {
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
		 * Collapse keyword list entity.
		 * @param  {[type]} keyWordsLists_id [description]
		 * @return {[type]}                  [description]
		 */
		$scope.collapse = function(keyWordsLists_id) {
			var direction = ['fa fa-chevron-up fa-2x', 'fa fa-chevron-down fa-2x'];
			var elem = $("#collapse" + keyWordsLists_id);
			elem.collapse('toggle');
			elem.children();
			if(elem.siblings()[1].childNodes[1].className == "fa fa-chevron-up fa-2x") {
				elem.siblings()[1].childNodes[1].className = direction[1];
			} else {
				elem.siblings()[1].childNodes[1].className = direction[0];
			}
		};

		$scope.indicateKeywordsExists = function() {
			angular.forEach($("#id-keywords-container").children(), function(item) { 
				angular.forEach(item.children, function(child) { child.className = "form-control input-danger"; });
			});
		};

		$scope.cleanKeywordsExists = function() {
			angular.forEach($("#id-keywords-container").children(), function(item) { 
				angular.forEach(item.children, function(child) { child.className = "form-control"; });
			});
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
		// $scope.showModal = function() {fr
		//  myOtherModal.$promise.then(myOtherModal.show);
		// };

		//------------------------------
		// Scope Watchers
		//------------------------------
		//

		// Keywords List
		$scope.$watch('keyWordsLists', function(){

			// console.log($rootScope.keyWordsLists);

		}, true);

		// Keyword Entity
		$scope.$watch('keywordEntity', function(){

			$("#id-create-keywordList").removeAttr('disabled');
			$("#id-remove-keyword").hide();
			$("#id-remove-recipient").hide();

			if($rootScope.keywordEntity.keywords.length > 1) {
				$("#id-remove-keyword").show();
			}

			if($rootScope.keywordEntity.recipients.length > 1) {
				$("#id-remove-recipient").show();
			}

			angular.forEach($rootScope.keywordEntity.keywords, function(keyword){
				if(keyword.keyword.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
			});

			angular.forEach($rootScope.keywordEntity.recipients, function(recipient){
				if(recipient.full_name.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
				if(recipient.email.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
				if(!HelperSvc.validateEmail(recipient.email)) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
				}
			});

		}, true);

}]);