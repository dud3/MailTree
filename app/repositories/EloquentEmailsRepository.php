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
            $email->utc_time =  date('l, F Y h:i:s A', $email->x_udate);

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
