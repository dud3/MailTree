<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});



/*
|--------------------------------------------------------------------------
| Exception handlers
|--------------------------------------------------------------------------
|
| These are general exception handlers
| http://net.tutsplus.com/tutorials/javascript-ajax/combining-laravel-4-and-backbone/
|
*/
App::error( function(Symfony\Component\HttpKernel\Exception\HttpException $e, $code)
{

  $headers = $e->getHeaders();
  // Else go here
  switch($code)
  {
    case 401:
      $default_message = 'Invalid API key';
      $headers['WWW-Authenticate'] = 'Basic realm="CRM REST API"';
    break;
 
    case 403:
      $default_message = 'Insufficient privileges to perform this action';
    break;

    case 404:
      $default_message = 'The API route not found';
    break;
 
    default:
      $default_message = 'An error was encountered';
  }

  return Response::json(array(
    'error' => $e->getMessage() ?: $default_message
  ), $code, $headers);

});
 


/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Page not found
|--------------------------------------------------------------------------
|
| The exception handler when on route not found.
|
*/

App::missing(function($exception)
{
    return Response::view('__errors__.__error__404', array(), 404);
});