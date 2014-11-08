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
    public $ketwords;

    /**
     * [__construct description]
     */
    public function __construct(EloquentKeywordsRepositoryInterface $keywords) {
    	$this->keywords = $keywords;
    }

	
	/**
	 * [view_emails description]
	 * @return [type] [description]
	 */
	public function view_k_list() {

		$view = View::make('list.keywords');

		return $view;

	}

	/**
	 * Get all keyowrds
	 * @return [object] [object of keywords]
	 */
	public function get_all_keywords() {
		return Response::json(['keywords' => $this->keywords->get_all()], 200);
	}

}
