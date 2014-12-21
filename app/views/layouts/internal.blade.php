<!DOCTYPE html>
<html lang="en" ng-app="mailTree">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo (Config::get('constant.g_currentPage')) == '/' ? 'Welcome' : Config::get('constant.g_currentPage'); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap additional theme -->
    <!-- link href="/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" -->

    <!-- Main Animate CSS -->
    <link href="/bower_components/animate.css/animate.css" rel="stylesheet">

    <!-- Log-in style -->
    <link href="/styles/login.css" rel="stylesheet">
    <link href="/styles/main.css" rel="stylesheet">
    <link href="/styles/animationsExtend.css" rel="stylesheet">
    <link href="//mgcrea.github.io/angular-strap/styles/libraries.min.css" rel="stylesheet">
    <link href="/bower_components/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/bower_components/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <link href="/bower_components/angular-xeditable/dist/css/xeditable.css">
    <link href="/bower_components/AngularJS-Toaster/toaster.css" rel="stylesheet">
    <!-- lnik href="/bower_components/angular-bootstrap-toggle-switch/style/bootstrap3/angular-toggle-switch-bootstrap-3.css" rel="stylesheet" -->

    <link href='http://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed|PT+Sans|Titillium+Web' rel='stylesheet' type='text/css'>

    <link rel='stylesheet' href='/bower_components/textAngular/src/textAngular.css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body class="body-background">

    <div id="wrapper" class="toggled">

        <div class="container-fluid">

            <?php if(Config::get('constant.g_currentPage') == '/' || Config::get('constant.g_currentPage') == 'login') { ?>

            <div class="container-fluid">

                <?php } else { ?>

                    @include("layouts.internalNavbar")
                    @include("layouts.internalSideBar")

                    {{-- System Messages --}}
                    <toaster-container
                    toaster-options="{'position-class': 'toast-top-right',
                                      'showDuration': '300',
                                      'hideDuration': '1000',
                                      'timeOut': '1000',
                                      'extendedTimeOut': '1000',
                                      'showEasing': 'swing',
                                      'hideEasing': 'linear',
                                      'showMethod': 'fadeIn',
                                      'hideMethod': 'fadeOut'}">
                    </toaster-container>

                    {{-- System loading anim --}}
                    <div id="g-content-loader">
                        <span class="col-md-12 fa fa-refresh fa-spin"></span>
                    </div>

                    {{-- App container --}}
                    <div id="app-internal" ng-cloak class="container-fluid app-background g-internal-container" style="display:none;">

                <?php } ?>

                    @yield('main')

                    </div>

            </div> <!-- /container -->

    </div>  <!-- /container -->

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/scripts/main.js"></script>

    <script src="/bower_components/bootstrap/js/affix.js"></script>
    <script src="/bower_components/bootstrap/js/alert.js"></script>
    <script src="/bower_components/bootstrap/js/button.js"></script>
    <script src="/bower_components/bootstrap/js/carousel.js"></script>
    <script src="/bower_components/bootstrap/js/collapse.js"></script>
    <script src="/bower_components/bootstrap/js/dropdown.js"></script>
    <script src="/bower_components/bootstrap/js/modal.js"></script>
    <script src="/bower_components/bootstrap/js/tooltip.js"></script>
    <script src="/bower_components/bootstrap/js/popover.js"></script>
    <script src="/bower_components/bootstrap/js/scrollspy.js"></script>
    <script src="/bower_components/bootstrap/js/tab.js"></script>
    <script src="/bower_components/bootstrap/js/transition.js"></script>
    <script src="/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <!-- Assets -->
    <script src="/bower_components/angular/angular.min.js"></script>
    <script src="/bower_components/angular-animate/angular-animate.min.js"></script>
    <script src="/bower_components/angular-cookies/angular-cookies.min.js"></script>
    <script src="/bower_components/angular-mocks/angular-mocks.js"></script>
    <script src="/bower_components/angular-resource/angular-resource.min.js"></script>
    <script src="/bower_components/angular-route/angular-route.min.js"></script>
    <script src="/bower_components/angular-scenario/angular-scenario.js"></script>
    <script src="/bower_components/angular-touch/angular-touch.min.js"></script>
    <script src="/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script src="/bower_components/angular-strap/dist/angular-strap.min.js"></script>
    <script src="/bower_components/angular-strap/dist/angular-strap.tpl.min.js"></script>
    <script src="/bower_components/AngularJS-Toaster/toaster.js"></script>
    <script src="/bower_components/angular-xeditable/dist/js/xeditable.js"></script>
    <script src="/bower_components/underscore/underscore-min.js"></script>
    <script src='/bower_components/textAngular/dist/textAngular-rangy.min.js'></script>
    <script src='/bower_components/textAngular/dist/textAngular.min.js'></script>
    <!-- script src="/bower_components/angular-bootstrap-toggle-switch/angular-toggle-switch.min.js"></script -->

    <!-- app -->
    <script src="/scripts/app.js"></script>

    <script>

        // Send token
        angular.module("app.auth").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
        //
        // User session to null for now
        // Probably will just handle sessions through PHP better
        angular.module("app.auth").constant("_userSessions", null);
        //
        // Password token to null as well
        angular.module("app.auth").constant("_pwdToken", null);

    </script>

    <script src="/scripts/controllers/authCtrl.js"></script>

    <script src="/scripts/controllers/searchCtrl.js"></script>
    <script src="/scripts/controllers/keyWordsListCtrl.js"></script>
    <script src="/scripts/controllers/emailsListCtrl.js"></script>
    <script src="/scripts/controllers/activeFiltersCtrl.js"></script>

    <script src="/scripts/services/helperSvc.js"></script>
    <script src="/scripts/factories/keyWordsListSvc.js"></script>
    <script src="/scripts/factories/emailsListSvc.js"></script>
    <script src="/scripts/factories/authSvc.js"></script>
    <script src="/scripts/factories/activeFiltersSvc.js"></script>

    <script src="/scripts/filters/filters.js"></script>

  </body>
</html>


