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
    'app.search'

  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
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
      console.log(config); // Contains the data about the request before it is sent.
       
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

        // Just a little awesomenes
        // -> To let users know what's going on the background
        var randomAnimation = Math.floor((Math.random()*9)+1)

        var idtoClass = {'1': "animated bounce",
                         '3': "animated pulse",
                         '5': "animated bounceIn",
                         '6': "animated rollIn",
                         '7': "animated flipInX",
                         '8': "animated flipInY",
                         '9': "animated bounceInDown",
                         '10': "animated fadeInDown",
                         '11': "animated fadeInDownBig"};

        var randomClass = idtoClass[randomAnimation];

        $("#g-content-loader").hide();
        $("#app-internal").show();

        $("#app-internal").removeClass(randomClass).addClass(randomClass).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass(randomClass);
        });

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
angular.module('app.keyWordsList', ['ngSanitize', 'mgcrea.ngStrap', 'toaster', 'xeditable', 'utilFilters']);
angular.module('app.emailsList', ['ngSanitize', 'mgcrea.ngStrap', 'toaster', 'xeditable', 'utilFilters']);
angular.module('app.search',  ['ngSanitize', 'mgcrea.ngStrap', 'toaster', 'xeditable', 'utilFilters']);