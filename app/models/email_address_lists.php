<?php

class email_address_list extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'email_address_list';

	protected $guarded = array();
    
    /**
	 * Modal rules.
	 * @var array
	 */
	public static $rules = array(
        'id',
        'email' => 'required|email',
 		'full_name' => 'required',
 		'keyword_id' => 'required'
	);

}
