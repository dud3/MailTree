<?php

class EloquentActiveFilterList implements EloquentActiveFilterListInterface {

    public function populateKeywords() {
        return keywords_list::all();
    }

    public function populateUserKeywords($user_id) {
        return keywords_list::where('user_id', '=', $user_id)->get();
    }

    /**
     * Populates root keywords.
     * Basically the first keyword in the array, since the keywords
     * are stored as an array in the database.
     * @return [array] [first item from the array]
     */
    public function populateRootKeywords() {

        $ret_k = [];

        $keywords = DB::select(
            "SELECT keywords
            FROM keywords_list"
        );

        foreach ($keywords as $k) {

            // trim and decode the JSON string
            $keywords = json_decode(trim($k->keywords, true));
            $ret_k[] = $keywords;
        }

        return $ret_k;

    }

    /**
     * Populate by current user.
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function populateUserRootKeywords($user_id) {

        $ret_k = [];

        $keywords = DB::select(
            "SELECT keywords
            FROM keywords_list
            WHERE keywords_list.user_id = ?"
        ,[$user_id]);

        foreach ($keywords as $k) {

            // trim and decode the JSON string
            $keywords = json_decode(trim($k->keywords, true));
            $ret_k[] = $keywords;
        }

        return $ret_k;

    }

}