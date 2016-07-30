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
        Route::post('/keepAlive',		'AuthCtrl@keepAlive');
    });

    Route::group(array('prefix' => 'user'), function()
    {
        Route::post('/create',		'UserCtrl@createUser');
    });

    Route::group(array('prefix' => 'keywords'), function()
    {
        Route::get('get', 					'ListController@get_all_keywords');
        Route::get('getUserKeywords',		'ListController@get_user_keywords');
        Route::post('create', 				'ListController@create_keywords_list');
        Route::post('remove/{id}',			'ListController@remove_keywords_list');
        Route::post('sendAutomatically',	'ListController@sendAutomatically');
        Route::post('keepOriginalContent',	'ListController@keepOriginalContent');
        Route::post('saveRecipient',		'ListController@saveRecipient');
        Route::post('includeReceivers',     'ListController@includeReceivers');
        Route::post('removeRecipent/{id}',	'ListController@removeRecipent');

        Route::get('getLink/{id}',  'ListController@getLink');
        Route::post('createLink',  'ListController@createLink');
        Route::post('updateLink',  'ListController@updateLink');

        Route::get('populateKeywords',			'APIActiveFilterList@populateKeywords');
        Route::get('populateRootKeywords',		'APIActiveFilterList@populateRootKeywords');
        Route::get('populateUserKeywords',		'APIActiveFilterList@populateUserKeywords');
        Route::get('populateUserRootKeywords',	'APIActiveFilterList@populateUserRootKeywords');
    });

    Route::group(array('prefix' => 'emails'), function()
    {
        Route::get('get_all',				'EmailListCtrl@get_all');
        Route::get('get_by_id/{id}',		'EmailListCtrl@get_by_id');
        Route::get('get_by_user',			'EmailListCtrl@get_by_user');
        Route::get('get_unsent',			'EmailListCtrl@get_unsent');
        Route::get('get_by_user_unsent',	'EmailListCtrl@get_by_user_unsent');
        Route::post('get_collection',		'EmailListCtrl@get_collection');
        Route::post('saveEmail',			'EmailListCtrl@saveEmail');
        Route::post('reSendEmail',			'EmailListCtrl@reSendEmail');
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
