<?php

class keywords_list extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'keywords_list';

	protected $guarded = array();

	/**
	 * Modal rules.
	 * @var array
	 */
	public static $rules = array(
        'id',
 		'keywords' => 'required'
	);
	
}
