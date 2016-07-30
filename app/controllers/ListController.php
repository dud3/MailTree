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
     * Get keywords per current user.
     * @return [type] [description]
     */
    public function get_user_keywords() {
        return Response::json(['keywords' => $this->keywords->get_by_user(Sentry::getUser()->id)], 200);
    }

    /**
     * Create keywords list.
     * @return [array] [array of objects]
     */
    public function create_keywords_list() {

        $input = Input::all();
        $input["user_id"] = null;

        if(Sentry::check()) {
            $input["user_id"] = Sentry::getUser()->id;
        }

        $ret = $this->lists->create_keywords_list($input);

        if(!$ret->error) {
            $ret = Response::json(["ketwordsList" => $ret->data], 200);
        } else {
            $ret = Response::json([$ret->message], 406);
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
            $ret = Response::json([$ret->message], 406);
        }

        return $ret;

    }

    /**
     * Send the email automatically.
     * Basically tell the system to not send the emails right away,
     * but only if the user sends manually.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function sendAutomatically($data = null) {

        if($data == null) {
            $data = Input::all();
        }

        $this->ret = $this->keywords->sendAutomatically($data);
        if(!$this->ret->error) {
            $this->ret = Response::json(["ketwordsList" => $this->ret->data], 200);
        } else {
            $this->ret = Response::json([$this->ret->message], 406);
        }

        return $this->ret;

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
            $this->ret = Response::json([$this->ret->message], 406);
        }

        return $this->ret;

    }

    /**
     * Save recipient.
     * @return [type] [description]
     */
    public function saveRecipient() {
        $input = Input::all();

        if(isset($input['fresh'])) {
            unset($input['fresh']);
        }

        return Response::json(["recipent" => $this->emails->saveRecipient($input)], 200);
    }

    /**
     * Include receivers.
     *
     */
    public function includeReceivers($data = null) {
        if($data == null) {
            $data = Input::all();
        }

        $this->ret = $this->emails->includeReceivers($data);
        $this->ret = Response::json(["result" => $this->ret], 200);

        return $this->ret;
    }

    /**
     * Remove recipent from the keywords list.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function removeRecipent($id) {
        return Response::json(["deleted" => $this->emails->removeRecipent($id)], 200);
    }

    /* todo: refactor */
    public function getLink($id) {
        return Response::json(["result" => keywords_list_links::where('keywords_list_id', '=', $id)->first()], 200);
    }

    /* todo: refactor */
    public function createLink() {
        $input = Input::all();

        return Response::json(["result" => keywords_list_links::create($input)], 200);
    }

    /* todo: refactor */
    public function updateLink() {
        $input = Input::all();

        $find = keywords_list_links::where('keywords_list_id', '=', $input['keywords_list_id']);
        $find->update($input);
        // $find->save();

        return Response::json(["result" => $find], 200);
    }

}
