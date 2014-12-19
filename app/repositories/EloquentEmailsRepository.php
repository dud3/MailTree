<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EloquentEmailsRepository extends EloquentListRepository implements EloquentEmailsRepositoryInterface {

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

		$sql_emails = DB::select(

		"SELECT m.id, m.email_address_id, m.subject, m.body, m.body_html, m.optional_text, m.sender_email, m.reciver_email,
				m.fwd_accept, m.sent,
				m.x_message_id, m.x_date,	m.x_size, m.x_uid, m.x_msgno,	m.x_recent, m.x_flagged, m.x_answered, m.x_deleted,
				m.x_seen, m.x_draft, m.x_udate,
				k_l.keywords

		FROM mails m

			INNER JOIN email_address_list e_a_l
				ON e_a_l.id = m.email_address_id

			INNER JOIN keywords_list k_l
				ON k_l.id = e_a_l.keyword_id

			GROUP BY m.x_uid
			ORDER BY m.id DESC

		");

		foreach ($sql_emails as $email) {

			$keywords = [];

			// trim the string
			$keywords = trim($email->keywords);

			// decode the JSON string
			$keywords = json_decode($email->keywords, true);

			// Search the keywords from the email subject
			$subject = explode(" ", $email->subject);

			// Basically label around the keywords
			// -> found in the email's subject.
			foreach ($keywords as $keyword) {

	            if(false !== $key = array_search($keyword, $subject)) {
	            	$subject[$key] = "<span class='label label-primary'>" . $subject[$key] . "</span>";
	            }

        	}

        	// Put everything back togather
            $email->subject = implode(" ", $subject);

            // Conver to easily readable date format
            $email->utc_time =  date('l, d. F Y h:i:s A', $email->x_udate);

		}

		return $sql_emails;

	}

	/**
	 * Get email by ID.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function get_by_id($id = null) {

	}

	/**
	 * Find recipients by keyword.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function find_recipients_by_keyword($id) {
		return email_address_list::where("keyword_id", "=", $id);
	}

	/**
	 * Store a new email.
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function store($data) {

		$ret = new stdClass();

		try {

			if($data != null) {

				if(!empty($data)) {

					foreach ($data as $recipent) {

						if(self::validate($recipent)) {
							$ret->data[] = email_address_list::create($recipent);
							$ret->error = false;
						}

					}

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

	/**
	 * Remove recipent from the keywords list.
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function removeRecipent($id) {
		return email_address_list::find($id)->delete();
	}

	/**
	 * Validate email_address_loist.
	 * @return [type] [description]
	 */
	public static function validate($data) {
		$validator = Validator::make($data, email_address_list::$rules);
		if($validator->fails()) return $validator->messages();
		return true;
	}

}
