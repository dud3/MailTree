<?php

class internlCtrl extends BaseController {

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

	view::share();

}
