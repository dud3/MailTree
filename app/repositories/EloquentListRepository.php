<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EloquentListRepository implements EloquentListRepositoryInterface {

    protected $list_type;

    protected $keywords;
    protected $emails;

    protected static $forward_email_from;
    protected static $forward_email_full_name;

    /**
     * Return data.
     * @var stdClass
     */
    protected $ret;

    /**
     * Main Constructor.
     */
    public function __construct(EloquentKeywordsRepositoryInterface $keywords, EloquentEmailsRepository $emails) {

        $this->keywords = $keywords;
        $this->emails = $emails;

        self::$forward_email_from = Config::get("constant.g_fwd_email_address");
        self::$forward_email_full_name = Config::get("constant.g_fwd_email_address_full_name");

        $this->ret = new stdClass();

    }

    /**
     * Call the list type.
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function __call_list($type) {

        $this->list_type = $type;

        switch ($this->list_type) {

            case 'get_email_list':
                $this->get_email_list();
                break;

            case 'get_keyword_list':
                $this->get_keyword_list();
                break;

        }

    }

    /**
     * Get list by keywords.
     * @return [type] [description]
     */
    public function get_email_list() {
        return $this->keywords->get_all();
    }

    /**
     * Get list by emails.
     * @return [type] [description]
     */
    public function get_keyword_list() {

    }

    /**
     * Create Keyword list.
     * @return [type] [description]
     */
    public function create_keywords_list($data) {

        $ret = new stdClass();

        try {

            if($data != null) {

                if(!empty($data)) {

                    /*! First of all store the keyword(s) */
                    $keywords = $this->keywords->store(["keywords" => $data["keywords"]],
                                                        $original_content = (isset($data["original_content"]) ? $data["original_content"] : false),
                                                        $send_automatically =  (isset($data["send_automatically"]) ? $data["send_automatically"] : false));

                    if(!$keywords->error) {

                        /* If no errors returned get the created keywords */
                        $keywords = $keywords->toArray();

                        /*! To each of the recipents assign the keyword id(s) */
                        for($i = 0; $i < count($data["recipients"]); $i++) {
                            $data["recipients"][$i]["keyword_id"] = $keywords["id"];
                        }

                    } else {
                        /**
                         *If error returned return the error
                         * the keyword variable itself will descriebe the errorto the parent class
                         */
                        return $keywords;
                    }

                    /* Finally store the recipients with the assigned keywords to them */
                    $recipients = $this->emails->store($data["recipients"]);

                    /* If no error returned */
                    if(!$recipients->error) {

                        $rec_arr = [];
                        foreach ($recipients->data as $rec) {
                            $rec_arr[] = $rec->toArray();
                        }

                        /* Return proper data, and let the js handled the rest */
                        $ret->error = $recipients->error;
                        $ret->data = [ "id" => $keywords["id"], "keywords" => $keywords["keywords"], "email" => $rec_arr, 
                                       "original_content" => $keywords["original_content"], "send_automatically" => $keywords["send_automatically"] ];
                                       
                        return $ret;

                    } else {
                        throw new RuntimeException("Error, recipients has couldn't succeed.", 0.2);
                    }

                } else {
                    throw new RuntimeException("Error, The array can not be empty", 0.2);

                }

            } else {
                throw new RuntimeException("Errorm The array can not be null", 0.1);
            }

        } catch(RuntimeException $e) {

            $error = new stdClass();
            $error->message = $e->getMessage();
            $error->code = $e->getCode();
            $error->error = true;

            return $error;

        }

    }

    /**
     * Remove from the keywords list.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function remove_keywords_list($id) {

        try {

            if($id != null) {

                if(!empty($id)) {

                    /*! First of all find all the users with keywords */
                    $recipients_with_keywords = $this->emails->find_recipients_by_keyword($id);

                    /* There might be keyword lists without recipients */
                    if(count($recipients_with_keywords) > 0) {
                        $recipients_with_keywords->delete();
                    } else {
                        $recipients_with_keywords = true;
                    }

                    if($recipients_with_keywords) {

                        /* Return proper data, and let the js handled the rest */
                        $keywords = $this->keywords->find($id);

                        /* If we're all good delete keywords as well */
                        if($keywords->delete()) {

                            $this->ret->error = false;
                            $this->ret->data = "Cool KeywordList deleted";

                            return $this->ret;

                        } else {
                            throw new RuntimeException("Error, recipients couldn't be deleted.", 0.2);
                        }

                    } else {
                        throw new RuntimeException("Error, recipients couldn't be deleted.", 0.2);
                    }

                } else {
                    throw new RuntimeException("Error, The array can not be empty", 0.2);

                }

            } else {
                throw new RuntimeException("Errorm The array can not be null", 0.1);
            }

        } catch(RuntimeException $e) {

            $error = new stdClass();
            $error->message = $e->getMessage();
            $error->code = $e->getCode();
            $error->error = true;

            return $error;

        }

    }

}