<?php

class HelpCtrl extends internalCtrl {

	/*
	|--------------------------------------------------------------------------
	| Internal Controller
	|--------------------------------------------------------------------------
	|
	| Everything else extend this controller, unless the AuthCtrl 
	| -> and repositories.
	|
	*/

	public $user;

	public function __construct() {

	}

	public function phpinfo() {
		return View::make('help.phpinfo');
	}

}
