<?php

/*
|--------------------------------------------------------------------------
| emailListCtrl Controller
|--------------------------------------------------------------------------
|
| This is where the enmails go.
|
*/

class EmailListCtrl extends internalCtrl {

    protected $server;
    protected $server_name = 'imap.gmail.com';
    protected $username = 'notifications@acsbill.com';
    protected $password = '8655morro';

    public $inbox;

    protected $emails;

    public $user;

    /**
     * [__construct description]
     */
    public function __construct() {

        $this->server = new \Fetch\Server($this->server_name, 993);
        $this->server->setAuthentication($this->username, $this->password);

        $this->inbox = $this->server->getMessages();

        // Read the inbox
        $this->emails = $this->inbox;

    }

	
	/**
	 * [view_emails description]
	 * @return [type] [description]
	 */
	public function index() {

		/*
		$_emails;
		$_inbox = $this->inbox;

		if($this->emails) {
			
			$output = '';
			
			rsort($this->emails);

			$_emails = $this->emails;

		}
		*/

		$view = View::make('list.emails', compact('_emails', '_inbox'));

		return $view;

	}

}
