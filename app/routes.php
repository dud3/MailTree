<?php

/* 
  (- ========================================= -)
		    ____              __           	 
		   / __ \____  __  __/ /____  _____  
		  / /_/ / __ \/ / / / __/ _ \/ ___/
		 / _, _/ /_/ / /_/ / /_/  __(__  )
		/_/ |_|\____/\__,_/\__/\___/____/  
	                                   	 
  (- ========================================== -)
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


Route::get('/phpinfo',			'HelpCtrl@phpinfo');
Route::get('/app',				'ListController@view_k_list');
Route::get('/keywords_list',		'');

// ------------------
// :: After log-in ::
// ------------------
Route::group(array('before' => 'auth'), function()
{
	// Route::get('/app',			'EmailListCtrl@view_emails');

});
