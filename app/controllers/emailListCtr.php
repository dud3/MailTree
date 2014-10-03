<?php

class emailListCtrl extends internlCtrl {

	/*
	|--------------------------------------------------------------------------
	| emailListCtrl Controller
	|--------------------------------------------------------------------------
	|
	| This is where the enmails go.
	|
	*/

	public $user;

	public function __construct() {

	}

	public function view_emails() {
		$vew = View::make('email.index');
		return $view;
	}

}
