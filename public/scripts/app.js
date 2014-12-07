'use strict';

/**
 * @ngdoc overview
 * @name mailTree
 * @description
 * #
 * # mailTree is a simple mailforwarder based on the email subject keywords.
 * #
 * # Example:
 * #
 * # List of emails: 1@xdomain.com, 2@xdomain.com, 3@xdomain.com
 * #
 * # From: someone@xdomain.com
 * # To: us@ydomain.com
 * # Subject: The `file` has been uploaded in Xcity, `dolphins` are `swiming`
 * # Body: some text on the body...
 * #
 * # Keywords from the subject are: file, dolphins, swiming
 * # Simply it will forward the same email(maybe a little modified) to the list of emails
 * # -> meantioned aboive.
 * #
 * Main module of the application.
 */
angular
  .module('mailTree', [

    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'mgcrea.ngStrap',
    'toaster',
    'xeditable',

    'utilFilters',

    'app.auth',
    'app.keyWordsList',
    'app.emailsList',
    'app.activeFilters',
    'app.search'

  ])
  .config(function ($routeProvider, $modalProvider, $tooltipProvider) {

    // Save awesomeness for later on...
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });

    angular.extend($modalProvider.defaults, {
      html: true
    });

    angular.extend($tooltipProvider.defaults, {
      html: true
    });

  });

angular.module('mailTree').run(function(editableOptions) {
  editableOptions.theme = 'bs3';
});

// Main configuration
angular.module('mailTree')
    .config(function($provide, $httpProvider, $interpolateProvider) {

// ---------------------------------------------------
// Intercept http calls.
// ---------------------------------------------------
// Interceptors help us globaly
// -> intercept the status of
// -> an http request.
//
// By by we can intercept the staus code of a request
// -> before it's sent to the server or after
// -> it has been recived from it.
//
// Bsed on status code (without having to define it
// on each http request) we can decide for action.
//
$provide.factory('MyHttpInterceptor', function ($q, $log) {

  return {

    // On request success
    request: function (config) {
      // console.log(config); // Contains the data about the request before it is sent.
      // Return the config or wrap it in a promise if blank.
      return config || $q.when(config);
    },

    // On request failure
    requestError: function (rejection) {
      // console.log(rejection); // Contains the data about the error on the request.
      $log.error("There's an error on the request.");
      // Return the promise rejection.
      return $q.reject(rejection);
    },

    // On response success
    response: function (response) {

      // console.log(response); // Contains the data from the response.
      // Return the response or promise.
      //

      if(response.status == 200) {

        // All the pages that we want to animate
        if(response.config.url == "/api/v1/keywords/get" || response.config.url == "/api/v1/emails/get_all") {

          // Just a little awesomenes
          var randomAnimation = Math.floor((Math.random()*4)+1)

          var idtoClass = {'1': "animated flipInX",
                           '2': "animated fadeInDown",
                           '3': "animated fadeInDownBig",
                           '4': "animated zoomInDown"};

          var randomClass = idtoClass[randomAnimation];

          $("#app-internal").removeClass(randomClass).addClass(randomClass).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass(randomClass);
          });

        }

        $("#g-content-loader").hide();
        $("#app-internal").show();

      }

      return response || $q.when(response);

    },

    // On response failture
    responseError: function (rejection) {

      // Only apply for internal
      // -> server errors
      if(rejection.status === 500) {

          console.warn(rejection); // Contains the data about the error.
          $log.error("Something went wrong, or either server sessions are over.");

          // Let's suppose that the error is because of sessions are over...
          // Untill we make all the methods throw proper exceptions from
          // -> the server side...

        // Return the promise rejection.
        return $q.reject(rejection);

      }

    }

  };

});

// Add the interceptor to the $httpProvider.
$httpProvider.interceptors.push('MyHttpInterceptor');

// Laravel template conflict fix
$interpolateProvider.startSymbol('<*');
$interpolateProvider.endSymbol('*>');

});

// ---------------------
// Other moodules
// ---------------------
angular.module('app.auth', ['ngSanitize', 'mgcrea.ngStrap', 'toaster', 'utilFilters']);
angular.module('app.keyWordsList', ['ngSanitize', 'mgcrea.ngStrap', 'toaster', 'xeditable', 'utilFilters', 'ngAnimate']);
angular.module('app.emailsList', ['ngSanitize', 'mgcrea.ngStrap', 'toaster', 'xeditable', 'utilFilters', 'ngAnimate']);
angular.module('app.activeFilters', ['ngSanitize']);
angular.module('app.search',  ['ngSanitize', 'mgcrea.ngStrap', 'toaster', 'xeditable', 'utilFilters', 'ngAnimate']);