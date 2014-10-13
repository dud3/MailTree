<?php

/**
 * Constants array
 * This File contains all the global constatnts
 * -> used all over the page.
 */
return array(


	/*
	|--------------------------------------------------------------------------
	| Current Enviroment variable 
	|--------------------------------------------------------------------------
	|
	| Will return the enviroment name based.
	| E.x.: dev2 for development env. app2 for production env. prob2 
	| -> for staging env... It changes itself based on the subdomain
	| -> such as if the domain is XY.targetSite.com then the env. var 
	| -> will be "XY".
	|
	*/

	'g_enviroment' => App::environment(),



	/*
	|--------------------------------------------------------------------------
	| Production Enviroment variable 
	|--------------------------------------------------------------------------
	|
	| Production enviroment variable, currently resides on subdomain of
	| -> app2.mymxlog.com(app2), if the subdomain is changes, this should be 
	| -> changed imediately.
	|
	*/

	'g_prod_enviroment' => "app2",


	/*
	|--------------------------------------------------------------------------
	| Currnet Page 
	|--------------------------------------------------------------------------
	|
	| Based on the route it get's the current page...
	|
	*/

	'g_currentPage' =>  Request::path(),



	/*
	|--------------------------------------------------------------------------
	| File Upload Folder [Local erver]
	|--------------------------------------------------------------------------
	|
	| Folder all uploaded files resie.
	| This folder is build up but sub-folders, where sub-folders are 
	| -> basically buid up by prefix of ``user_`` nad by post fix of ``user_id``
	| -> E.x.: user with ID of 101 will have the folder of ``user_101``
	|
	| This folder includes any group of file:
	| - Workitem ~
	| - Training ~
	| - CV ~
	|   and more ...
	|
	| The file types allowed are only .doc and .pdf extension
	|g_local_file_uploads
	*/

	'g_local_file_uploads' => base_path() . '/uploads',



	/*
	|--------------------------------------------------------------------------
	| File Upload Folder [Remote Server]
	|--------------------------------------------------------------------------
	|
	| Folder all uploaded files resie.
	| This folder is build up but sub-folders, where sub-folders are 
	| -> basically buid up by prefix of ``user_`` nad by post fix of ``user_id``
	| -> E.x.: user with ID of 101 will have the folder of ``user_101``
	|
	| This folder includes any group of file:
	| - Workitem ~
	| - Training ~
	| - CV ~
	|   and more ...
	|
	| The file types allowed are only .doc and .pdf extension
	|
	| The only difference from ``g_local_file_uploads`` that the files 
	| -> are on the remote server.
	|
	*/

	'g_remote_file_uploads' => Config::get('remote.connections.fileServer'),

	

	/*
	|--------------------------------------------------------------------------
	| File Upload limits
	|--------------------------------------------------------------------------
	| 
	| Contains constatns for file upload limits.
	|
	*/

	'POST_MAX_SIZE' => ini_set('post_max_size', '5M'),
	'UPLOAD_MAX_SIZE' => ini_set('upload_max_filesize', '5M'),



	/*
	|--------------------------------------------------------------------------
	| File Thumbnail Uploads Folder 
	|--------------------------------------------------------------------------
	|
	| Folder where thumbnails of the first page of the files resie.
	| E.x.: x.pdf file get's uploaded, fist page of this PDF get's snapshooted
	| -> and stored in this folder.
	|
	*/

	'g_fileThumb_Uploads' => public_path() . '/fileThumb',



	/*
	|--------------------------------------------------------------------------
	| Avatar images Uploads Folder 
	|--------------------------------------------------------------------------
	|
	| Folder where after image data has been uploaded reside.
	|
	|
	*/

	'g_avatarIMG_Uploads' => public_path() . '/avatars',



	/*
	|--------------------------------------------------------------------------
	| Contact us image
	|--------------------------------------------------------------------------
	|
	| The contact us is simply the footer of the emails(at least for now)
	| -> the attachment and link to our main website.
	|
	|
	*/

	'g_contactUsIMG' => public_path() . "/css/images/cantactUs.png",



	/*
	|--------------------------------------------------------------------------
	| Internal Notifications
	|--------------------------------------------------------------------------
	|
	| The state of the internal notifications.
	|
	|
	*/
	
	'g_enable_internal_notifications' => true,



	/*
	|--------------------------------------------------------------------------
	| Notifications to Email
	|--------------------------------------------------------------------------
	|
	| The state of the internal notifications being send to emails.
	|
	|
	*/
	
	'g_enable_notification_emails' => false,



	/*
	|--------------------------------------------------------------------------
	| Froward email address
	|--------------------------------------------------------------------------
	|
	| The forward emails address.
	|
	|
	*/

	'g_fwd_email_address' => ['notifications@alexent.com'],



	/*
	|--------------------------------------------------------------------------
	| Froward email address
	|--------------------------------------------------------------------------
	|
	| The forward emails address.
	|
	|
	*/

	'g_fwd_email_address_full_name' => "Alex",

);