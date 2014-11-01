<?php

interface EloquentKeywordsRepositoryInterface {

	/**
	 * Get all emails.
	 * @return [type] [description]
	 */
	public function get_all();

	/**
	 * Get email by ID.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id = null);

	/**
	 * Store a new email.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function store($data = null);

	/**
	 * Updaten the email
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function update($data = null);

	/**
	 * Delete single email.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete_single($id);

	/**
	 * Delete multiple messages at a time.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function delete_multiple($data);

	/**
	 * Validate keywords.
	 * @return [type] [description]
	 */
	public static function validate($data);

}