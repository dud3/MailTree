<?php

class AuthCtrl extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| AuthCtrl
	|--------------------------------------------------------------------------
	|
	| Authentication controller before any users get logged in.
	|
	|
	*/

	/**
	 * Render the view of the log in.
	 * @return [type] [description]
	 */
	public function view_login()
	{
		return View::make('login');
	}

	/**
	 * Login method.
	 * @return [type] [description]
	 */
	public function login() 
	{
		// Sentry goes here...
	}

}
