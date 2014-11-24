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
    public $lists;
    public $keywords;
    public $emails;

    /**
     * [__construct description]
     */
    public function __construct(EloquentListRepositoryInterface $lists, EloquentKeywordsRepositoryInterface $keywords, EloquentEmailsRepository $emails) {
    	$this->lists = $lists;
    	$this->keywords = $keywords;
    	$this->emails = $emails;
    }

	
	/**
	 * view keywords list.
	 * @return [type] [description]
	 */
	public function view_k_list() {
		$view = View::make('list.keywords');
		return $view;
	}

	/**
	 * view emails list.
	 * @return [type] [description]
	 */
	public function view_e_list() {
		$view = View::make('list.emails');
		return $view;
	}

	/**
	 * Get all keyowrds
	 * @return [object] [object of keywords]
	 */
	public function get_all_keywords() {
		return Response::json(['keywords' => $this->keywords->get_all()], 200);
	}

	/**
	 * Create keywords list
	 * @return [array] [array of objects]
	 */
	public function create_keywords_list() {
		
		$input = Input::all();
		$ret = $this->lists->create_keywords_list($input);

		if(!$ret->error) {
			$ret = Response::json(["ketwordsList" => $ret], 200);
		} else {
			$ret = Response::json([$ret->error], 401);
		}

	}

}
