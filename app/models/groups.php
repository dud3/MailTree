<?php

class groups extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

	protected $guarded = array();
    // protected $fillable = ['id', 'token']

	public static $rules = array(
		'name',
		'password',
		'permissions'
	);

}
