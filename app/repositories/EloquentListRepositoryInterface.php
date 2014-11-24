<?php

interface EloquentListRepositoryInterface {

	/**
	 * Call the list type.
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function __call_list($type);
	
	/**
	 * Get list by keywords.
	 * @return [type] [description]
	 */
	public function get_email_list();

	/**
	 * Get list by emails.
	 * @return [type] [description]
	 */
	public function get_keyword_list();

	/**
	 * Create keywords list
	 * @param  [array] $data [array of objects]
	 * @return [array]       [array of objects]
	 */
	public function create_keywords_list($data);

}