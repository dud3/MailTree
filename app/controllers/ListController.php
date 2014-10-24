<?php

/*
|--------------------------------------------------------------------------
| ListController Controller
|--------------------------------------------------------------------------
|
| This is where the enmails go.
|
*/

class ListController extends internalCtrl {

    public $user;

    /**
     * [__construct description]
     */
    public function __construct() {

    }

	
	/**
	 * [view_emails description]
	 * @return [type] [description]
	 */
	public function view_k_list() {

		$view = View::make('list.keywords');

		return $view;

	}

}
