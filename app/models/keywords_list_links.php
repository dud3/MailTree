<?php

class keywords_list_links extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'keywords_list_links';

    public $timestamps = false;

    protected $guarded = array();

    /**
     * Modal rules.
     * @var array
     */
    public static $rules = array(
        'id',
    );

}
