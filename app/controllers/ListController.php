<?php

/**
 * ListController class.
 * The view and whatever type of a function that includes
 * interaction of emails and keywords together are listed here.
 */
class ListController extends internalCtrl {

    public $user;
    public $lists;
    public $keywords;
    public $emails;
    public $ret;

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
	 * Get all keyowrds.
	 * @return [object] [object of keywords]
	 */
	public function get_all_keywords() {
		return Response::json(['keywords' => $this->keywords->get_all()], 200);
	}

	/**
	 * Create keywords list.
	 * @return [array] [array of objects]
	 */
	public function create_keywords_list() {

		$input = Input::all();
		$ret = $this->lists->create_keywords_list($input);

		if(!$ret->error) {
			$ret = Response::json(["ketwordsList" => $ret->data], 200);
		} else {
			$ret = Response::json([$ret->message], 401);
		}

		return $ret;

	}

	/**
	 * Remove from the keywords list.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function remove_keywords_list($id) {

		$ret = $this->lists->remove_keywords_list($id);
		if(!$ret->error) {
			$ret = Response::json(["ketwordsList" => $ret->data], 200);
		} else {
			$ret = Response::json([$ret->message], 401);
		}

		return $ret;

	}

	/**
	 * Set the value to keep the original content of email.
	 * Basically if we want to include HTML or not.
	 * @param [object] $data [keywordEntity_id, state]
	 */
	public function keepOriginalContent($data = null) {

		if($data == null) {
			$data = Input::all();
		}

		$this->ret = $this->keywords->keepOriginalContent($data);
		if(!$this->ret->error) {
			$this->ret = Response::json(["ketwordsList" => $this->ret->data], 200);
		} else {
			$this->ret = Response::json([$this->ret->message], 401);
		}

		return $this->ret;

	}

}
