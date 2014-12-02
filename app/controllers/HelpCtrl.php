<?php

/**
 * HelpCtrl.
 * Basic phpinfo stuff.
 */
class HelpCtrl extends internalCtrl {

	public $user;

	public function __construct() {

	}

	public function phpinfo() {
		return View::make('help.phpinfo');
	}

}
