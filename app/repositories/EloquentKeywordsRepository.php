<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EloquentKeywordsRepository extends EloquentListRepository implements EloquentKeywordsRepositoryInterface {

	/**
	 * Main Constructor.
	 *
	 * @note: I'm unsire if we actually need
	 * -> a constructor at all.
	 * 
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

			 FROM keywords_list k"
		
		);

		foreach ($sql_keywords as $keyword) {

			$keyword->email = DB::select(
			
				"SELECT e_a_l.id AS email_list_id, e_a_l.email, e_a_l.full_name
				
				 FROM email_address_list e_a_l

				 WHERE e_a_l.keyword_id = ?"
			
			,[$keyword->id]);

		}

		return $sql_keywords;

	}

	/**
	 * Get email by ID.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id = null) {
		return keywords_list::find($id);
	}

	/**
	 * Store a new email.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function store($data = null) {

		$ret = [];

		try {
			
			if($data != null) {

				if(!empty($data)) {

					if(self::validate($data)) {

						$ret = keywords_list::create($data);
						return $ret;

					} else {
						throw new RuntimeException("Error Processing Request", 1);
					}

				} else {
					throw new RuntimeException("Error, The array can not be empty", 0.2);
					
				}

			} else {
				throw new RuntimeException("Errorm The array can not be null", 0.1);
			}

		} catch(RuntimeException $e) {

			$error = new stdClass();
			$error->message = $e->getMessage();
			$error->code = $e->getCode();
			$error->error = true;

			return $error;

		}
	}

	/**
	 * Updaten the email
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function update($data = null) {

		try {
			
			if($data != null) {

				if(!empty($data)) {


					 $k = keywords_list::fill($data);
					 $k->save();
					 $k->error = false;
					 return $k;

				} else {
					throw new RuntimeException("Error, The array can not be empty", 0.2);
					
				}

			} else {
				throw new RuntimeException("Errorm The array can not be null", 0.1);
			}

		} catch(RuntimeException $e) {

			$error = new stdClass();
			$error->message = $e->getMessage();
			$error->code = $e->getCode();
			$error->error = true;

			return $error;

		}

	}

	/**
	 * Delete single email.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete_single($id) {
		$k = $this->get_by_id($id);
		$k->delete();
		return $k;
	}

	/**
	 * Delete multiple messages at a time.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function delete_multiple($data) {
		foreach ($data as $k) {
			$this->delete_single($k->id);
		}
		return true;
	}

	/**
	 * Validate keywords.
	 * @return [type] [description]
	 */
	public static function validate($data) {
		$validator = Validator::make($data, keywords_list::$rules);
		if($validator->fails()) throw new ValidationException($validator);
		return true;
	}

}