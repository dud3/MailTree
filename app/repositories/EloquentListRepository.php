<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EloquentListRepository implements EloquentListRepositoryInterface {

	protected $list_type;

	protected $keywords;
	protected $emails;

	/**
	 * Main Constructor.
	 */
	public function __construct(EloquentKeywordsRepositoryInterface $keywords, EloquentEmailsRepository $emails) {
		$this->keywords = $keywords;
		$this->emails = $emails;
	}

	/**
	 * Call the list type.
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function __call_list($type) {

		$this->list_type = $type;

		switch ($this->list_type) {

			case 'get_email_list':
				$this->get_email_list();
				break;

			case 'get_keyword_list':
				$this->get_keyword_list();
				break;
			
		}

	}

	/**
	 * Get list by keywords.
	 * @return [type] [description]
	 */
	public function get_email_list() {
		return $this->keywords->get_all();
	}

	/**
	 * Get list by emails.
	 * @return [type] [description]
	 */
	public function get_keyword_list() {

	}

	/**
	 * Create Keyword list.
	 * @return [type] [description]
	 */
	public function create_keywords_list($data) {

		$ret = [];

		try {
			
			if($data != null) {

				if(!empty($data)) {

					$keywords = $this->keywords->store($data["keywords"]);
					$recipients = $this->emails->store($data["recipients"]);
					
					$ret = ["id" => $keywords['id'], "keywords" => $keywords["keywords"], "email" => $recipients["emails"]];
					return $ret;

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

}