<?php

use Carbon\Carbon;

class EmailsRepository implements EmailsRepositoryInterface {

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
     * Read all the emails.
     * @return [type] [description]
     */
    public function readMails();

    /**
     * Remove emails.
     * @return [type] [description]
     */
    public function removeMails($all = false, $id = null);

    /**
     * Get the subject of the email.
     * @return [type] [description]
     */
    public function getEmailSubject();

    /**
     * Get the body of the email.
     * @return [type] [description]
     */
    public function getEmailBody();


    /**
     * Get the keywords fro mthe email.
     * @return [type] [description]
     */
    public function getEmailKeywords();

}