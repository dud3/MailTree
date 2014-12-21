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

    Route::group(array('prefix' => 'auth'), function()
    {
        Route::post('/login',		'AuthCtrl@login');
    });

});


Route::get('/app',				'ListController@view_k_list');
Route::get('/app/emails',		'EmailListCtrl@index');

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
    // Route::get('/app',			'EmailListCtrl@view_emails');

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

    Route::group(array('prefix' => 'keywords'), function()
    {
        Route::get('get', 					'ListController@get_all_keywords');
        Route::post('create', 				'ListController@create_keywords_list');
        Route::post('remove/{id}',			'ListController@remove_keywords_list');
        Route::post('keepOriginalContent',	'ListController@keepOriginalContent');
        Route::get('populateKeywords',		'APIActiveFilterList@populateKeywords');
        Route::get('populateRootKeywords',	'APIActiveFilterList@populateRootKeywords');
    });

    Route::group(array('prefix' => 'emails'), function()
    {

        Route::get('get_all',				'EmailListCtrl@get_all');
        Route::post('get_collection',		'EmailListCtrl@get_collection');
        Route::post('saveEmail',			'EmailListCtrl@saveEmail');
        Route::get('get/{id}',				'EmailListCtrl@get');
        Route::post('create',				'EmailListCtrl@create');
        Route::post('update',				'EmailListCtrl@update');
        Route::post('delete/{id}',			'EmailListCtrl@delete');
        Route::post('removeRecipent/{id}',	'EmailListCtrl@removeRecipent');
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