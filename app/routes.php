<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// -------------------
// :: Before log-in ::
// -------------------
Route::group(array('before' => 'guest'), function() 
{
	Route::get('/', 			'AuthCtrl@view_login');
	Route::get('/login',		'AuthCtrl@view_login');
	Route::post('/login',		'AuthCtrl@login');
});

// ------------------
// :: After log-in ::
// ------------------
Route::group(array('before' => 'auth'), function()
{
	Route::get('/app',			'AppCtrl@index');

});
