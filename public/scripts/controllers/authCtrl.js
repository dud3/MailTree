'use strict';

angular.module('app.auth')
  .controller('AuthCtrl', ['$scope', '$http', '$q', '$compile', '$location', '$sce', '$tooltip',
                          '$cookies', '$cookieStore', '$analytics', '$aside', 'AuthSvc', 'pwdToken', 
                          'cfpLoadingBar', '_userSessions', 
              function ($scope, $http, $q, $compile, $location, $sce, $tooltip, $cookies, $cookieStore, 
                        $analytics, $aside, AuthSvc, pwdToken, cfpLoadingBar, _userSessions) {

  $scope.notify = {
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


  // ====================
  // Auth Cookies Holder
  // ====================
  // Auth JS cookies
  var authCookies = {
    getRemembner : $cookieStore.get('rememberMe'),
    getRedirect : $cookieStore.get('redirect'),
    getUserSession : $cookieStore.get('sessions')
  }

  // ==============
  // LogIn Section
  // ==============
  /**
   * Login Function
   * @return {[Atuh]} [Simple Log in the user, redirect to the "Dashboard".]
   */
  $scope.email = null;
  $scope.loginCredentials = { 
    email: $("#email").val(), 
    password: $("#password").val(),
    remember: authCookies.getRemembner
  };

  // Error Aside
  var Aside_UserNotFound_or_Technician = $aside({
    title: 'User Not Found or Not a Free Account', 
    content: '<p>You are seeing this message because: <br>Either the account does not <font color="red">"exist"</font>'
             +', or you are not a <b>"free"</b> user.</p>'
             +'<br>'
             +'<p>If you are sure that your user account exists, then please click <b><a href="http://app.mymxlog.com"> here </a></b> to continue.'
             +'<p>If not, please click: <b><a href="/signup">Register me</a>.</b>'
             +'<p><i>Thank you!</i></p>',
    show: false
  });

  var gCounter = 0;
  $scope.login = function() {
    var l = Ladda.create(document.querySelector('.lading-btn')); // Ladda loading button
    l.start();

    // Set the default
    if(typeof authCookies.getUserSession === 'undefined') {
      $cookieStore.put('sessions', true);
    } 
    else if(authCookies.getUserSession){
          $cookieStore.put('sessions', true);
    }

     // For funny angular/browser issues
     $scope.loginCredentials.password = $("#password").val();

    // Little cookies fun
    ($scope.loginCredentials.remember) ? $cookieStore.put('rememberMe', true) : $cookieStore.remove('rememberMe');
     AuthSvc.login($scope.loginCredentials) 

        .success(function(data) {

          var group = {
              info: data.group,
              id: data.group_id
          };

          l.setProgress(1);

          return $scope.redirect('/app');
        
        }).error(function(msg) {
        
          console.log(msg);
         
          // Clean up message`
          var clean_msg = msg.replace(/"/g, "");
          
          // Increment the aouthCounter
          gCounter++;
          var timesLeft = 6 - gCounter;

          // Trun it into a simple function
          function animate() {
            $("#form-signin").removeClass('animated swing').addClass('animated swing').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
              $(this).removeClass('animated swing');
            });
            l.stop();
          }


          // Run this only once if fields are empty
          // Before that check if email undefined
          if($scope.loginCredentials.email === undefined) {
            alert("Please Enter A valid Email");
            l.stop();
            return;
          }

          ($scope.loginCredentials.email.length === 0 && $scope.loginCredentials.password.length === 0) ?
                 (gCounter === 1) ? animate() : showError() : showError();
                 if(gCounter == 2) {

                 }
                  // After once showing the first condition
                  // Show us error messages
                  function showError() {
                    $("#form-signin").notify(
                        (clean_msg == 'code.0') ? Aside_UserNotFound_or_Technician.show() : clean_msg,
                      { position:"top left",
                        className: 'error',
                        style: 'bootstrap'
                      });
                      l.stop();
                    }

                if(clean_msg == 1) {
                  if(gCounter > 2 && timesLeft > 0) {
                      $("#form-signin").notify(
                        "Be carefull you only have " + timesLeft + " times left to enter the wrong password",
                      { position:"top right",
                        className: 'error',
                        style: 'bootstrap',
                        autoHideDelay: 20000
                      });
                    } else { 
                      showError();
                  } 
              }
              
        });
  };

  // ===============
  // LogOut section
  // ===============
  /**
   * Logs current user out
   * @return {[Auth]} [Simple log out the user, destroy sessions, redirect to the "Login".]
   */
  $scope.logout = function() {
    AuthSvc.logout()
      .success(function() {
        if($scope.settings.leftFromInit){
          // console.log($scope.settings.flag);
          if(typeof $cookieStore.get('redirect') !== 'undefined') {
              $cookieStore.remove('redirect'); $cookieStore.put('redirect', $scope.settings.leftFromPage);
              $cookieStore.put('sessions', true);
          }
        }
        window.location.href = '/login';
        //$location.path('/login');
      })
      .error(function(){
        window.location.href = '/dashboard';
        // $location.path('/dashboard'););
    });
  };

  $scope.redirect = function(url) {
    window.location.href = url;
  };


// =================
// Register Section
// =================
/**
 * Signs a user up for a new account.
 * @return {[type]} [description]
 */
  // Register Credentials
  $scope.credentials = { 
      email: $("#email").val(), 
      password: $("#password").val(),
      first_name: $("#first_name").val(), 
      last_name: $("#last_name").val(),
      terms: false
  };
  $scope.register = function() {

  var l = Ladda.create(document.querySelector('.lading-btn'));
  l.start();

  if($scope.credentials.terms === false) {
    $scope.notify.fire.specificElem("#terms", "Please accept our terms to proceed", "error", "left left", true, true);
    l.stop();
    return;
  }

  AuthSvc.register($scope.credentials)
    .success(function() {

        l.setProgress(1);
        window.location.href = '/dashboard';
    
    }).error(function(msg) {

        // Just in case if the email contains non-english chars
        if($scope.credentials.email === undefined) {
          alert("Please Enter A valid Email");
          l.stop();
          return;
        }

        if(msg && typeof msg === 'object') {
          for(var key in msg) {
            $("#"+key).notify(
                  msg[key],
                { position:"right left",
                  className: 'error',
                  style: 'bootstrap',
                  showAnimation: 'slideDown',
                  hideAnimation: 'slideUp'
                }
              );
       
            $("#"+key).removeClass('animated bounce').addClass('animated bounce').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
              $(this).removeClass('animated bounce');
            });
            l.stop();
          }

        } else {
          $("#form-signin").notify(
                msg,
                {
                  position:"left left",
                  className: 'error',
                  style: 'bootstrap',
                  showAnimation: 'slideDown',
                  hideAnimation: 'slideUp',
                  autoHideDelay: 20000
                }
            );
          l.stop();
        }

    });
  };

  var gFlag = false;
  $scope.resetPasswordSendToken = function() {
    // Check the model value
    // console.log($scope.credentials.email); 
    var l = Ladda.create(document.querySelector('.lading-btn'));
    if($scope.credentials.email.length === 0) {
      if(gCounter < 1) { 
            $("#email").removeClass('animated bounce').addClass('animated bounce').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass('animated bounce');
        });
        } else {
          $("#email").notify(
            "Email Field is Required.",
            {
              position:"right right",
              className: 'error',
              style: 'bootstrap',
              showAnimation: 'slideDown',
              hideAnimation: 'slideUp',
              autoHideDelay: 5000
            }
          );
        }
        gCounter++;
        return;
        } else {
          // Simple Progress bar while The message is beeing send to the 
          var progress = 0;
          l.start();
          var interval = setInterval(function() {
              progress = Math.min( progress + Math.random() * 0.1, 1); // Icrement slowely
              l.setProgress(progress);
              // console.log(progress); // See my progress
          }, 200);
          AuthSvc.resetPasswordSendToken($scope.credentials.email)
            .success(function(msg){
              console.log("We Just sent you the email.");
              console.log(msg);
                // Can Be customized if the user didn't get the reset password 
                // -> at the first time.
                $("#form-reset").notify(
                "We Just sent you an email with the reset code, please check your email.",
                {
                  position:"top right",
                  className: 'success',
                  style: 'bootstrap',
                  showAnimation: 'slideDown',
                  hideAnimation: 'slideUp',
                  clickToHide: true,
                  autoHide: false
                }
              );
              clearInterval(interval); // Clear my interval
              l.stop();
            }).error(function(msg){
                // console.log(msg);
                // Check if the mail server is down
                if(msg.error) { (msg.error.type == "Swift_TransportException") ? msg = "Mail Server is Down, please try again later." : msg; }
                $("#email").notify(
                  msg,
                {
                  position:"left left",
                  className: 'error',
                  style: 'bootstrap',
                  showAnimation: 'slideDown',
                  hideAnimation: 'slideUp',
                  autoHide: false
                }
              );
              clearInterval(interval);
              l.stop();  
              // $scope.analyse.d_EventTrack('Password Token send - Failed', 'Authentication', 'Password Token send - Failed');
          });
        }
  };
 
  // =======================
  // Reset Password Section
  // =======================
  // Credentials for "Rset Password" page
  $scope.credentials_pwd = {
    // email: $("#email").val(),
    token: pwdToken,
    password: "",
    repeatPassword: ""
  };
  $scope.resetPassword = function() {
    var l = Ladda.create(document.querySelector('.lading-btn'));
    // console.log(pwdToken);
    // console.log($scope.credentials_pwd);
    l.start();
    AuthSvc.resetPassword($scope.credentials_pwd)
      .success(function(msg){
        // console.log(msg);
        $("#form-resetPassword").notify(
            'Reset Password successed, please wait we are fixing stuff for you...',
          {
            position:"top right",
            className: 'success',
            style: 'bootstrap',
            showAnimation: 'slideDown',
            hideAnimation: 'slideUp',
            clickToHide: false,
            autoHide: false
          }
        );
        $('#resetToken').attr('disabled','disabled');
        // $scope.analyse.d_EventTrack('Reset password - Success', 'Authentication', 'Reset Password - Successfully');
        setInterval(function(){ window.location.href = "/"}, 5000);
        // l.stop();
        // If success just route them to the login page
      }).error(function(msg){
        // If failed show them failure message(s)
        console.log(msg);
        if(msg && typeof msg === 'object') {
          for(var key in msg) {
            //console.log(key);
            //console.log(msg[key]);
            //console.log(msg);
            $("#"+key).notify(
                  msg[key],
                { position:"right left",
                  className: 'error',
                  style: 'bootstrap',
                  showAnimation: 'slideDown',
                  hideAnimation: 'slideUp'
                }
              );
            l.stop();
            $("#"+key).removeClass('animated bounce').addClass('animated bounce').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
              $(this).removeClass('animated bounce');
            });
          }
        } else {
          msg = msg.replace(/"/g, "");
          $("#form-resetPassword").notify(
                msg,
                {
                  style: 'wrongToken',
                  className: 'warn',
                  clickToHide: false,
                  autoHide: false,
                  position:"top right",
                  showAnimation: 'slideDown',
                  hideAnimation: 'slideUp'
                }
            );
          }
          l.stop();
          // $scope.analyse.d_EventTrack('Reset password - Failed', 'Authentication', 'Reset Password - Failure');
      });
  };

  angular.module('app.auth').directive("ngLoginSubmit", function(){
  return {
      restrict: "A",
      scope: {
          onSubmit: "=ngLoginSubmit"
      },
      link: function(scope, element, attrs) {
          $(element)[0].onsubmit = function() {
              $("#login-login").val($("#email", element).val());
              $("#login-password").val($("#password", element).val());

              scope.onSubmit(function() {
                  $("#login-form")[0].submit();
              });
              return false;
          };
      }
};

});
