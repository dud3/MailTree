'use strict';

/**
 * @ngdoc function
 * @name publicApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the publicApp
 */
angular.module('app.emailsList')
  .controller('emailsListCtrl', ['$scope', '$rootScope', '$interval', '$timeout', '$http', '$q', '$compile', '$location', '$sce', '$cookies', '$cookieStore', 
  				'emailsListSvc', 'HelperSvc', 'toaster', '$tooltip',
	function ($scope, $rootScope, $interval, $timeout, $http, $q, $compile, $location, $sce, $cookies, $cookieStore, emailsListSvc, HelperSvc, toaster, $tooltip) {

		/**
		 * Mail related config.
		 * @type {Object}
		 */
		$scope.__mailCfg = { listen_delay: 10000, cache: false };

		$scope.tooltip = { view: {title: '<small>View email</small>'}, edit: {title: '<small>Edit email</small>'}, resent: { title: '<small>Resent email</small>'} };

	    /**
	    * Emails holder
	    * @type {Array}
	    */
		$rootScope.emails = [];
		
		/**
		 * Currently selected items.
		 * @type {Array}
		 */
		$rootScope.selected_emails = [];

		/**
		 * Single email
		 * @type {Object}
		 */
		$rootScope.email = {
			full_name: "",
			email: "",
			message_subject: "",
			message_body: "",
			x_uid: null
		};

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
		$scope.getAllEmails = function() {

			emailsListSvc
				.getByUser()
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

			// If nothing, get eveyrhting.
			if($rootScope.emails.length == 0) {
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
					}).error(function(){});
				return null;
			}

			emailsListSvc
				.getUnsent()
					.success(function(data){

						if(data.emails.length > 0) {

							angular.forEach(data.emails, function(item) {

								// From string to actual javaScript object
								item.keywords = angular.fromJson(item.keywords);
								item.sent = parseInt(item.sent);

								if(item.sent) {
									$scope.count_sent_emails++;
								}

								item.id = parseInt(item.id);
								// Simply compare the last item of the current array
								// to the all items from the unsent emails.
								if( parseInt($rootScope.emails[0].id) < item.id ) {
									$rootScope.emails.unshift(item);
								}

							});


					}

				}).error(function(data){
					toaster.pop('error', "Message", "Something went wrong, please try again");
			});

		}; $interval($scope.mailListener, $scope.__mailCfg.listen_delay);


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
		 * Toggle selected item.
		 * @param  {[type]} email [description]
		 * @return {[type]}           [description]
		 */
		$scope.toggleSelection = function(email) {

			$scope.toggleAll = false;

			var idx = HelperSvc.findIndexWithAttr($scope.selected_emails, "x_uid", email.x_uid);

			// is currently selected
			if (idx > -1) {
				$scope.selected_emails.splice(idx, 1);
			}

			// is newly selected
			else {
				$scope.selected_emails.push(email);
			}

			console.log($scope.selected_emails);

		};

		/**
		 * Toggle select all the items.
		 * @return {[type]} [description]
		 */
		$scope.toggleSelectionAll = function() {

			$scope.toggleAll = !$scope.toggleAll;

			if($scope.toggleAll) {

				angular.forEach($scope.emails, function(item) {
					document.getElementById('check-email' + item.id).checked = true;
					if(item.sent == 0) {
						$scope.selected_emails.push(item);
					}
				});

			} else {
				angular.forEach($scope.emails, function(item) {
					document.getElementById('check-email' + item.id).checked = false;
				});
				$scope.selected_emails = [];
			}

			console.log($scope.selected_emails);

		};

		/**
		 * View email.
		 * @return {[type]} [description]
		 */
		$scope.viewEmail = function(email_id) {

			email_id = parseInt(email_id);
			emailsListSvc
				.getEmailByid(email_id)
					.success(function(data){

						var this_data = data.emails[0];
						$rootScope.email.full_name = this_data.full_name;
						$rootScope.email.email = this_data.email;
						$rootScope.email.message_subject = this_data.message_subject;
						$rootScope.email.message_body = this_data.message_body;

						$("#id-modal-view_single_email").modal("show");

				}).error(function(data){
					// Do nothing for now...
			});

		};

		/**
		 * Edit the email.
		 * The emails are multiple instances of a single email,
		 * such as, on the database there are multiple copies of them,
		 * but only the instance is showed on emails page.
		 * If the instance of the email is edited all it's copies are edited as well.
		 * @param  {[type]} email_id [description]
		 * @return {[type]}          [description]
		 */
		$scope.editEmail = function(email_id) {

			email_id = parseInt(email_id);
			emailsListSvc
				.getEmailByid(email_id)
					.success(function(data){

					$rootScope.email.x_uid = data.emails[0].x_uid;
					$rootScope.email.message_subject = data.emails[0].message_subject;
					$rootScope.email.message_body = data.emails[0].message_body;

					$("#id-modal-edit_single_email").modal({ backdrop:'static', keyboard:false, show:true });

				}).error(function(data){
					// Do nothing for now...
			});

		};

		/**
		 * Save the email content after changing it.
		 * @param  {int} x_uid uniquer id of the email.
		 * @return {[type]}       [description]
		 */
		$scope.saveEmail = function() {

			$("#id-save-edit_single_email").button('loading');

			var _email = {
				x_uid: $rootScope.email.x_uid,
				message_body: $rootScope.email.message_body
			};

			emailsListSvc
				.saveEmail(_email)
					.success(function(data){

					$("#id-modal-edit_single_email").modal("hide");
					$("#id-save-edit_single_email").button('reset');

					toaster.pop('success', "Message", "Email Saved Successfully, now you might view it.");

				}).error(function(data){
					$("#id-save-edit_single_email").button('reset');
					// Do nothing for now...
			});

		};

		/**
		 * Send email
		 * @return {[type]} [description]
		 */
		$scope.sendEmail = function(email_id, email_x_uid) {

			var _this_tr = $("#id-email" + email_id),
			_this_button = _this_tr.children()[_this_tr.children().length - 1].childNodes[3];

			_this_button.className = "btn btn-info btn-sm disabled";
			_this_button.innerHTML = "sending...";

			emailsListSvc
				.reSendEmail(email_x_uid)
					.success(function(data){

						$scope.count_sent_emails++;
						$scope.emails[HelperSvc.findIndexWithAttr($rootScope.emails, "x_uid", email_x_uid)].sent = 1;
						document.getElementById('id-send-message-coll').innerHTML = "send <span class='fa fa-paper-plane' style='font-size:13px'></span>";

					toaster.pop('success', "Message", "Email sent Successfully.");
				}).error(function(data){
					toaster.pop('error', "Message", "Sorry Something went wrong, please try again later on...");
			});

		};

		/**
		 * Send the email manually.
		 * @param  {[type]} email_x_uid [description]
		 * @return {[type]}             [description]
		 */
		$scope.reSendEmail = function(email_x_uid) {

			var _this_elem = document.getElementById('id-fa-resend-email' + email_x_uid);
			_this_elem.parentNode.disabled = true;
			_this_elem.className = "fa fa-refresh fa-spin";

			emailsListSvc
				.reSendEmail(email_x_uid)
					.success(function(data){

					toaster.pop('success', "Message", "Email resent Successfully.");

					_this_elem.className = "fa fa-refresh";
					_this_elem.parentNode.disabled = false;

					$scope.count_sent_emails++;

				}).error(function(data){
					_this_elem.className = "fa fa-refresh";
					_this_elem.parentNode.disabled = false;
					toaster.pop('error', "Message", "Sorry Something went wrong, please try again later on...");
			});
			
		};

		/**
		 * Send multiple message at the same time
		 * @return {[type]} [description]
		 */
		$scope.sendCollective = function() {
			document.getElementById('id-send-message-coll').innerHTML = "sending....";
			angular.forEach($scope.selected_emails, function(item) {
				$scope.sendEmail(item.id, item.x_uid);
				document.getElementById('check-email' + item.id).checked = false;
				document.getElementById('check-email' + item.id).disabled = true;
			});
			$scope.selected_emails = [];
		};

		/**
		 * Search globaly
		 * @return {[type]} [description]
		 */
		$scope.search = function() {

		};
		
}]);


$('#id-modal-view_single_email').on('hidden.bs.modal', function(){
       $(this).find('.modal-body').css({
              width:'auto', //probably not needed
              height:'auto', //probably not needed 
              'max-height':'100%'
       });
});