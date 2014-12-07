'use strict';

/**
 * @ngdoc function
 * @name publicApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the publicApp
 */
angular.module('app.emailsList')
  .controller('emailsListCtrl', ['$scope', '$rootScope', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 'emailsListSvc', 'toaster', '$tooltip',
	function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, emailsListSvc, toaster, $tooltip) {

		/**
		 * Mail related config.
		 * @type {Object}
		 */
		$scope.__mailCfg = { listen_delay: 200000, cache: false };

		$scope.tooltip = {title: '<small>View email</small>'};

	    /**
	    * Emails holder
	    * @type {Array}
	    */
		$rootScope.emails = [];

		/**
		 * Sent emails counter.
		 * @type {Number}
		 */
		$scope.count_sent_emails = 0;

		/**
		 * Hold the data of the email to be edited or created.
		 * @type {Object}
		 */
		$rootScope.email = {

			id: null,
			keywords: [],

			subject: "",
			body: "",

			x_message_id: null,
			x_date: null,
			x_size: null,
			x_uid: null,
			x_msgno: null,
			x_recent: 0,
			x_flagged: 0,
			x_answered: 0,
			x_deleted: 0,
			x_seen: 0,
			x_draft: 0,
			x_udate: 0

		};

		/**
		 * filters
		 * @type {Object}
		 */
		$rootScope.filter = {

			subject: "",
			body: "",
			date: null,
			sent: false

		};

		/**
		 * Get all the keywords
		 * @return {[type]} [description]
		 */
		$scope.getAllKeywords = function() {

			emailsListSvc
				.getAll()
					.success(function(data){

						// From string to actual javaScript object
						angular.forEach(data.emails, function(item) {

							item.keywords = angular.fromJson(item.keywords);
							item.sent = parseInt(item.sent);

							if(item.sent) {
								$scope.count_sent_emails++;
							}

						});

						$rootScope.emails = data.emails;

						//
						// Note the internal keywords should be
						// -> accessed like: $rootScope.keyWordsList[0].keywords["0"]
						//
						// and not like: $rootScope.keyWordsList[0].keywords.0
						//
						// The second one returns error.
						//

						console.log($rootScope.emails);

				}).error(function(data){
					toaster.pop('error', "Message", "Something went wrong, please try again");
			});

		}();

		/**
		 * mailListener basically check constantly if
		 * new mails appear, if so it pushes it on to of the
		 * mails array.
		 * @return {[type]} [description]
		 */
		$scope.mailListener = function() {

			// Let's try to get everything at the same time
			// and compare to the current array
			emailsListSvc
				.getAll()
					.success(function(data){

						angular.forEach(data.emails, function(item) {

							// Get email id
							/*
							var email_id = parseInt(item.id);

							// From string to actual javaScript object
							item.keywords = angular.fromJson(item.keywords);
							item.id = parseInt(item.id);

							// The current listed emails
							angular.forEach($rootScope.emails, function(_item) {

								var _email_id = parseInt(_item.id);
								// if the upcoming email has bigger id than the current
								// emails, then push to the array
								if(email_id > _email_id) {
									$rootScope.emails.push(_item);
								}

							});
							*/

						});

						// $rootScope.emails = data.emails;

						//
						// Note the internal keywords should be
						// -> accessed like: $rootScope.keyWordsList[0].keywords["0"]
						//
						// and not like: $rootScope.keyWordsList[0].keywords.0
						//
						// The second one returns error.
						//

						console.log($rootScope.emails);

				}).error(function(data){
					toaster.pop('error', "Message", "Something went wrong, please try again");
			});

		};
		// setInterval($scope.mailListener, $scope.__mailCfg.listen_delay);


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
		 * Compose new email.
		 * @return {[type]} [description]
		 */
		$scope.composeEmail = function() {

		};

		/**
		 * Forward emails collectively.
		 * @return {[type]} [description]
		 */
		$scope.fwdCollective = function() {

		};


		/**
		 * Search globaly
		 * @return {[type]} [description]
		 */
		$scope.search = function() {

		};

}]);
