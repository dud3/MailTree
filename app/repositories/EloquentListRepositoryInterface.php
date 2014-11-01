<?php

interface EloquentListRepositoryInterface {

	/**
	 * Call the list type.
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function __call_list($type);

	/**
	 * Main query gues here
	 * @return [type] [description]
	 */
	public function mainQuery();

	/**
	 * Get list by keywords.
	 * @return [type] [description]
	 */
	public function get_list_by_keyword();

	/**
	 * Get list by emails.
	 * @return [type] [description]
	 */
	public function get_list_by_email();

}