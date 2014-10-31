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

    @include('__errors__.layout.__error_styles')
    @include('__errors__.layout.__error_scripts')

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="container-fluid">

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

  </body>
</html>