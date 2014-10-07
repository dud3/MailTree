<?php

class groups extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

	public static $rules = array(
		'name',
		'password',
		'permissions'
	);

}
