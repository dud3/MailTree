<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Log-in</title>

    <!-- Bootstrap core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap additional theme -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Main Animate CSS -->
    <link href="/bower_components/animate.css/animate.css" rel="stylesheet">

    <!-- Log-in style -->
    <link href="/styles/login.css" rel="stylesheet">
    <link href="/styles/main.css" rel="stylesheet">
    <link href="/bower_components/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/bower_components/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>

    <script src="/bower_components/angular/angular.min.js"></script>
    <script src="/bower_components/angular-animate/angular-animate.min.js"></script>
    <script src="/bower_components/angular-cookies/angular-cookies.min.js"></script>
    <script src="/bower_components/angular-mocks/angular-mocks.js"></script>
    <script src="/bower_components/angular-resource/angular-resource.min.js"></script>
    <script src="/bower_components/angular-route/angular-route.min.js"></script>
    <script src="/bower_components/angular-scenario/angular-scenario.js"></script>
    <script src="/bower_components/angular-touch/angular-touch.min.js"></script>
    <script src="/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="container-fluid">

        <?php if(Config::get('constant.g_currentPage') == '/' || Config::get('constant.g_currentPage') == '/login') { ?>
        <div class="container-fluid">

        <?php } else { ?>

            @include("layouts.internalNavbar")

            <div class="container-fluid background animated fadeInDownBig">

        <?php } ?>

            @yield('main')
            
        </div>
    
    </div> <!-- /container -->

    <script src="/scripts/app.js"></script>
    <script src="/scripts/controllers/authCtrl.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script>
    // ------------------------
    // Windows 8 viewport hack
    // ------------------------
    (function () {
    'use strict';
      if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
        var msViewportStyle = document.createElement('style')
        msViewportStyle.appendChild(
          document.createTextNode(
            '@-ms-viewport{width:auto!important}'
          )
        ) 
        document.querySelector('head').appendChild(msViewportStyle)
      }
    })();
    </script>


    <script type="text/javascript">

        $(document).ready(function() {
            
            $("#clickCol").click(function() {
                $('#collapseOne').collapse();
            });

            //toggle `popup` / `inline` mode
            $.fn.editable.defaults.mode = 'popup';     
            
            //make username editable
            $('#username').editable();
            
            //make status editable
            $('#status').editable({
                type: 'select',
                title: 'Select status',
                placement: 'right',
                value: 2,
                source: [
                    {value: 1, text: 'status 1'},
                    {value: 2, text: 'status 2'},
                    {value: 3, text: 'status 3'}
                ]
                /*
                //uncomment these lines to send data on server
                ,pk: 1
                ,url: '/post'
                */
            });

        });

    </script>

  </body>
</html>


