<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EloquentKeywordsRepository extends EloquentListRepository implements EloquentKeywordsRepositoryInterface {

    /**
     * Main Constructor.
     *
     * @note: I'm unsire if we actually need
     * -> a constructor at all.
     *
     */
    public function __construct() {

    }

    /**
     * Get all emails.
     * @return [type] [description]
     */
    public function get_all() {

        $sql_keywords = DB::select(

            "SELECT k.id, k.keywords, k.original_content, k.send_automatically

             FROM keywords_list k"

        );

        foreach ($sql_keywords as $keyword) {

            $keyword->email = DB::select(

                "SELECT e_a_l.id AS email_list_id, e_a_l.email, e_a_l.full_name

                 FROM email_address_list e_a_l

                 WHERE e_a_l.keyword_id = ?"

            ,[$keyword->id]);

        }

        return $sql_keywords;

    }

    /**
     * Find keyword by ID.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function find($id) {
        return keywords_list::find($id);
    }

    /**
     * Get email by ID.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function get_by_id($id = null) {
        return keywords_list::find($id);
    }

    /**
     * Store a new email.
     * @param  [text] $data 			[text formated array of keywords]
     * @param  [bool] $original_content [keep the original content or not]
     * @return [type]       			[array of created keywords]
     */
    public function store($data = null, $original_content = false, $send_automatically = true) {

        $ret = [];

        $check_if_exists = keywords_list::where('keywords', '=', $data['keywords'])->count();

        ($original_content) ? $data["original_content"] = true : false;
        ($send_automatically) ? $data["send_automatically"] = true : false;

        try {

            if($data != null) {

                if(!empty($data)) {

                    if(self::validate($data)) {

                        if($check_if_exists == 0) {

                            $ret = keywords_list::create($data);
                            $ret->error = false;
                            return $ret;

                        } else {
                            /**
                             *  @note we get the array as string, then it gets converted to std Object by json_decode
                             *  anad since the count() wont count the object elements, simply cast the data to array 
                             *  and then count.
                             */
                            (count((array)json_decode($data["keywords"])) > 1) ? $plural = "keywords " : $plural = "keyword ";
                            throw new RuntimeException("The ". $plural . "\"". implode(', ', (array)json_decode($data["keywords"])) ."\" already exits, please pick another one.", 0.3);
                        }

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
     * Updaten the email
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function update($data = null) {

        try {

            if($data != null) {

                if(!empty($data)) {

                        $k = keywords_list::fill($data);
                        $k->save();
                        $k->error = false;
                        return $k;

                } else {
                    throw new RuntimeException("Error, The array can not be empty.", 0.2);

                }

            } else {
                throw new RuntimeException("Errorm The array can not be null.", 0.1);
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
     * Delete single email.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete_single($id) {
        $k = $this->get_by_id($id);
        $k->delete();
        return $k;
    }

    /**
     * Delete multiple messages at a time.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function delete_multiple($data) {
        foreach ($data as $k) {
            $this->delete_single($k->id);
        }
        return true;
    }

    /**
     * Send the email automatically.
     * Basically tell the system to not send the emails right away,
     * but only if the user sends manually.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function sendAutomatically($data) {
        $keywordEntity = keywords_list::find($data["id"]);
        $keywordEntity->fill(["send_automatically" => $data["send_automatically"]]);
        $keywordEntity->save();
        return $keywordEntity;
    }

    /**
     * Set the value to keep the original content of email.
     * Basically if we want to include HTML or not.
     * @param [object] $data [keywordEntity_id, state]
     */
    public function keepOriginalContent($data) {
        $keywordEntity = keywords_list::find($data["id"]);
        $keywordEntity->fill(["original_content" => $data["original_content"]]);
        $keywordEntity->save();
        return $keywordEntity;
    }

    /**
     * Validate keywords.
     * @return [type] [description]
     */
    public static function validate($data) {
        $validator = Validator::make($data, keywords_list::$rules);
        if($validator->fails()) throw new ValidationException($validator);
        return true;
    }

}