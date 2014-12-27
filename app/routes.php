<?php

#													   #
########################################################
##		    ____              __ 					  ##
##		   / __ \____  __  __/ /____  _____ 		  ##
##		  / /_/ / __ \/ / / / __/ _ \/ ___/ 		  ##
##		 / _, _/ /_/ / /_/ / /_/  __(__  ) 			  ##
##		/_/ |_|\____/\__,_/\__/\___/____/ 			  ##
## 													  ##
########################################################
# All nescecary routes reide here 					   #

/**-------------------------------------
 * :: Before log-in ::
 * -------------------------------------
 *
 * Everything before authentication
 * goes here.
 *
 */
Route::group(array('before' => 'guest'), function()
{
    Route::resource('/', 			'AuthCtrl');
    Route::resource('/login',		'AuthCtrl');
});

/**------------------------------------
 * :: After log-in ::
 * ------------------------------------
 *
 * All the routes after authentication
 * goes here.
 *
 */
Route::group(array('before' => 'auth'), function()
{
    Route::get('/app',				'ListController@view_k_list');
    Route::get('/app/emails',		'EmailListCtrl@index');
    Route::get('/logout',			'AuthCtrl@logout');
});


/**------------------------------------
 * :: API ::
 * ------------------------------------
 *
 * All JSON calls goes here.
 *
 */
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::group(array('prefix' => 'auth'), function() 
    {
        Route::post('/login',			'AuthCtrl@login');
        Route::post('/createUser',		'AuthCtrl@logout');
        Route::post('/changePassword', 	'AuthCtrl@changePassword');
    });

    Route::group(array('prefix' => 'user'), function()
    {
        Route::post('/create',		'UserController@create');
    });

    Route::group(array('prefix' => 'keywords'), function()
    {
        Route::get('get', 					'ListController@get_all_keywords');
        Route::post('create', 				'ListController@create_keywords_list');
        Route::post('remove/{id}',			'ListController@remove_keywords_list');
        Route::post('sendAutomatically',	'ListController@sendAutomatically');
        Route::post('keepOriginalContent',	'ListController@keepOriginalContent');
        Route::post('saveRecipient',		'ListController@saveRecipient');
        Route::post('removeRecipent/{id}',	'ListController@removeRecipent');

        Route::get('populateKeywords',		'APIActiveFilterList@populateKeywords');
        Route::get('populateRootKeywords',	'APIActiveFilterList@populateRootKeywords');
    });

    Route::group(array('prefix' => 'emails'), function()
    {
        Route::get('get_all',				'EmailListCtrl@get_all');
        Route::get('get_unsent',			'EmailListCtrl@get_unsent');
        Route::post('get_collection',		'EmailListCtrl@get_collection');
        Route::post('saveEmail',			'EmailListCtrl@saveEmail');
        Route::post('reSendEmail',			'EmailListCtrl@reSendEmail');
        Route::get('get/{id}',				'EmailListCtrl@get');
        Route::post('create',				'EmailListCtrl@create');
        Route::post('update',				'EmailListCtrl@update');
        Route::post('delete/{id}',			'EmailListCtrl@delete');
        Route::post('search',				'EmailListCtrl@search');
    });
});

/**------------------------------------
 * :: Helpers ::
 * ------------------------------------
 *
 * All JSON calls goes here.
 *
 */
Route::group(array('prefix' => 'help'), function()
{
    Route::get('/phpinfo',			'HelpCtrl@phpinfo');
});