<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class EloquentListRepository implements EloquentListRepositoryInterface {

	protected $main_sql = null;

	protected $user;
	protected $list;
	protected $emails;

	protected $list_type;

	/**
	 * Main Constructor.
	 */
	public function __construct() {

	}

	/**
	 * Call the list type.
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function __call_list($type) {

		$this->list_type = $type;

		switch ($this->list_type) {

			case 'get_list_by_keyword':
				$this->get_list_by_keyword();
				break;

			case 'get_list_by_email':
				$this->get_list_by_email();
				break;
			
		}

	}


	/**
	 * Main query gues here
	 * @return [type] [description]
	 */
	public function mainQuery() {

	}


	/**
	 * Get list by keywords.
	 * @return [type] [description]
	 */
	public function get_list_by_keyword() {

	}


	/**
	 * Get list by emails.
	 * @return [type] [description]
	 */
	public function get_list_by_email() {

	}


}