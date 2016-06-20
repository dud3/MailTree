'use strict';

/**
 * @ngdoc function
 * @name publicApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the publicApp
 */
angular.module('app.keyWordsList')
  .controller('keyWordsListCtrl', ['$scope', '$rootScope', '$http', '$q', '$compile', '$interval', '$location', '$sce', '$cookies', '$cookieStore',
  			'keyWordsListSvc', 'HelperSvc', '$modal', 'toaster',
	function ($scope, $rootScope, $http, $q, $compile, $interval, $location, $sce, $cookies, $cookieStore, keyWordsListSvc, HelperSvc, $modal, toaster) {

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
			original_content: false,
			send_automatically: true
		};

		/**
		 * Simple tooltip.
		 * @type {Object}
		 */
		$scope.tooltip = {
			settings: {
				auto: { title: 'Once the keywordEnotity is craeted, if this option is selected, emails will be sent automatically by the system.' },
				origin: { title: 'If this option slected, the system won\'t atempt to make any changes to the email whatsoever, but instead it keeps the exact same email.' }
			}
		};

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
				.getUserKeywords()
					.success(function(data){

						// From string to actual javaScript object
						angular.forEach(data.keywords, function(item) {

							item.keywords = angular.fromJson(item.keywords);
							item.original_content = parseInt(item.original_content);
							item.send_automatically = parseInt(item.send_automatically);

							// Mark emails as existing emails
							angular.forEach(item.email, function(em) {
								em.fersh = false;
							});

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
		 * Send emails automatically.
		 * @param  {[type]} keyword_id [description]
		 * @return {[type]}            [description]
		 */
		$scope.sendAutomatically = function(keyword_id) {

			var _this_element = document.getElementById("check_automatically_" + keyword_id);

			var _keywordEntity = { id: keyword_id, send_automatically: _this_element.checked };

			keyWordsListSvc
				.sendAutomatically(_keywordEntity)
					.success(function(data){
						toaster.pop('success', "Message", "Settings Saved.");
				}).error(function(data){
					toaster.pop('error', "Message", "Failed to Save, please try again.");
					_this_element.checked = false;
			});

		};

		/**
		 * Keep the original content of the email(s) associated with keywords.
		 * @param {[type]} keyword_id [description]
		 */
		$scope.keepOriginalContent = function(keyword_id) {

			var _this_element = document.getElementById("check_original_" + keyword_id);

			var _keywordEntity = { id: keyword_id, original_content: _this_element.checked };

			keyWordsListSvc
				.keepOriginalContent(_keywordEntity)
					.success(function(data){
						toaster.pop('success', "Message", "Settings Saved.");
				}).error(function(data){
					toaster.pop('error', "Message", "Failed to Save, please try again.");
					_this_element.checked = false;
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
				original_content: false,
				send_automatically: true
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
				original_content: false,
				send_automatically: true
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
			// push the state of send_automatically, if the program will send them automatically, or we decide to review nd
			// send them manually.
			_keywordEntity.send_automatically = $rootScope.keywordEntity.send_automatically;

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

		$scope.show_add_link_modal = function(id) {

			$("#id-modal-addLink_keywordList").modal('show');
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

				if(confirm("Are you sure you want to remove this item ?")) {

					$rootScope.keyWordsLists.splice(_index, 1);

					keyWordsListSvc
						.removeKeywordEntity(keyWordsLists_id)
							.success(function(data){

							// Boradcast to activeFiltersCtrl
							$rootScope.$broadcast('keyWordsList-delete', {_item: _item});

						}).error(function(data){
							toaster.pop('error', "Message", "Something went wrong, please try again.");
					});

				}

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

			if(confirm("Are you sure you want to remove this item ?")) {

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

			}

		};

		/**
		 * Add recipent
		 * @param {[type]} index [description]
		 */
		$scope.addRecipent = function(index) {

			var keyWordsLists = $rootScope.keyWordsLists[index];

			$scope.inserted = {
				keyWordsLists_id: keyWordsLists.id,
				email: '',
				full_name: '',
				fresh: true
			};

			$rootScope.keyWordsLists[index].email.push($scope.inserted);

		};

		/**
		 * Check if email already exists.
		 * @param  {[type]} data [description]
		 * @param  {[type]} id   [description]
		 * @return {[type]}      [description]
		 */
		$scope.checkEmail = function(data, id, email_list_id) {

			var _this_keyword = HelperSvc.findIntemInArr($rootScope.keyWordsLists, "id", id);
			var _this_emails = HelperSvc.findIntemInArr(_this_keyword.email, "email", data.email);

			if(data.email.length == 0 || data.full_name.length == 0) {
				return toaster.pop('error', "Message", "Empty String not allowed.");
				return false;
			}

			if(typeof _this_emails !== 'undefined' && typeof email_list_id == 'undefined') {
				return toaster.pop('error', "Message", "This user already exits, there can only be one email per Keyword Entity.");
				return false;
			}

			return true;

		}

		/**
		 * Save/update recipients.
		 * @param  {[type]} data [description]
		 * @param  {[type]} id   [description]
		 * @return {[type]}      [description]
		 */
		$scope.saveRecipient = function(data, id, $index$email) {

			var _index = HelperSvc.findIndexWithAttr($rootScope.keyWordsLists, "id", id);
			var _index_email = HelperSvc.findIndexWithAttr($rootScope.keyWordsLists[_index].email, "email", data.email);
			var _get_email = $rootScope.keyWordsLists[_index].email[_index_email];

			var _current_email_item = $rootScope.keyWordsLists[_index].email[$index$email];
			var _email_list_id = _current_email_item.email_list_id;

			var data = {
				id: null,
				email: data.email,
				full_name: data.full_name,
			};

			if(typeof _email_list_id != 'undefined') {
				data.id = _email_list_id;
			}

			if($scope.checkEmail(data, id, _email_list_id)) {

				angular.extend(data, {keyword_id: id});

				keyWordsListSvc.
					saveRecipient(data)
						.success(function(data){

							// If the email is added and note edited,
							// only then assign the email_list_id.
							if(_current_email_item.fresh) {
								_current_email_item.email_list_id = data.recipent.id;
							}

							toaster.pop('success', "Message", "Recipient Saved Successfully.");

					}).error(function(data){
						toaster.pop('error', "Message", "Something went wrong, please try again.");
				});

			} else {
				$rootScope.keyWordsLists[_index].email.splice($rootScope.keyWordsLists[_index].email.length - 1, 1);
			}

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

			var flag = true;
			$(".settings-warn").html('');

			$("#id-create-keywordList").removeAttr('disabled');
			$("#id-remove-keyword").hide();
			$("#id-remove-recipient").hide();
			$("#m_settings-dropdown").removeClass('open');

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
					flag = false;
				}
				if(recipient.email.length == 0) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
					flag = false;
				}
				if(!HelperSvc.validateEmail(recipient.email)) {
					$("#id-create-keywordList").attr('disabled', 'disabled');
					flag = false;
				}
			});

			if(flag) {
				$("#id-modal-settings").append('<span class="pull-left text-warning settings-warn" ng-show="verify" style="font-size:12px; margin-top:3px"> ( Please verify settings ! )</span>')
				$("#m_settings-dropdown").addClass('open');
			}

		}, true);

		/**
		 * Simple timeout to keep the sessions alive.
		 * @param  {[type]} ){  return        $http.post('/api/v1/auth/keepAlive'); } [description]
		 * @param  {[type]} 1000 [description]
		 * @return {[type]}      [description]
		 * Every 8h hours.
		 * The sessions are alive for 10h 20min.
		 */
		$interval(function(){ return $http.post('/api/v1/auth/keepAlive'); }, 3600000);

		//------------------------------
		// Helpers
		//------------------------------
		//
		$scope.drodownStayOpen = function(element) {
		  // Timeout is nesscecary to overwrite
		  // the function call of bootstrap.
		  setTimeout(function(){
		    $('#' + element).addClass("open");
		  }, 10);
		}

}]);
