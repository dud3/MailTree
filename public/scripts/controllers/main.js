'use strict';

/**
 * @ngdoc function
 * @name publicApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the publicApp
 */
angular.module('mainCtrl')
  .controller('MainCtrl',['$scope', '$rootScope', '$http', '$q', '$compile', '$location', '$sce', '$tooltip',
                          '$cookies', '$cookieStore',
                          function ($scope, $rootScope, $http, $q, $compile, $location, $sce, $tooltip,
                          			$cookies, $cookieStore) {

    /**
     * Cookies holder.
     * @type {Object}
     */
    $rootScope.cookies = {

    };

	/**
	* Notifications holder.
	* @type {Object}
	*/
	$rootScope.notify = {
		
		fire: {

			mainNav: function(msg, className, autoHide) {
				$(".navbar-brand").notify(
				  msg,
				  { 
				      className: (typeof className !== 'undefined') ? className : 'error',
				      position: 'right right',
				      style: 'bootstrapSession',
				      showAnimation: 'slideDown',
				      hideAnimation: 'slideUp',
				      clickToHide: true,
				      autoHide: (typeof autoHide !=='undefined') ? autoHide : true,
				      autoHideDelay: 6000
				  }
				);
			},
			specificElem: function(element, msg, className, position, clickToHide, autoHide) {
				$(element).notify(
				  msg,
				  { 
				      className: (typeof className !== 'undefined') ? className : 'error',
				      position: (typeof position !== 'undefined') ? position : 'right right',
				      style: 'bootstrapSession',
				      showAnimation: 'slideDown',
				      hideAnimation: 'slideUp',
				      clickToHide: (clickToHide) ? clickToHide : true,
				      autoHide: (autoHide) ? autoHide : true,
				      autoHideDelay: 6000
				  }
				);
			}

		}

	};

}]);