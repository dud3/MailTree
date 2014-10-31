<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EloquentKeywordsRepository extends EloquentListRepository implements EloquentKeywordsRepositoryInterface {

	protected $main_sql = null;

	protected $user;
	protected $list;
	protected $emails;

	/**
	 * Main Constructor.
	 */
	public function __construct() {

	}

	/**
	 * Get all emails.
	 * @return [type] [description]
	 */
	public function get_all() {

		$sql_keywords = DB::select(

			"SELECT k.id, k.keywords

			 FROM keywords k"
		
		);

		foreach ($sql_keywords as $keyword) {

			$keyword->email = DB::select(
			
				"SELECT e_a_l.id AS email_list_id, e_a_l.email, e_a_l.full_name
				
				 FROM email_address_list e_a_l"
			
			);

		}

	}

	/**
	 * Get email by ID.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id = null) {

	}

	/**
	 * Store a new email.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function store($data) {

	}

	/**
	 * Updaten the email
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function update($data) {

	}

	/**
	 * Read the email.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function read($data) {

	}

	/**
	 * Forward single emails.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function forward_single($data) {

	}

	/**
	 * Forward multiple mails.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function forward_multiple($data) {

	}

	/**
	 * Delete single email.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete_single($id) {

	}

	/**
	 * Delete multiple messages at a time.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function delete_multiple($data) {

	}

}