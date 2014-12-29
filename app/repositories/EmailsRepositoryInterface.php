<?php

interface EmailsRepositoryInterface {

    /**
     * Read all the emails.
     * @return [type] [description]
     */
    public function readMails($html_enable, $email_search);

    /**
     * Send stored mails from the database.
     * @return [type] [description]
     */
    public function sendMails($fwd_from = null);

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
    public function compareKeywords($data);

    /**
     * Sotore emails in the database.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function storeMail($data);

    /**
     * Store Keywords
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function storeKeywords($data);

    /**
     * Find mail by id.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function findMailByID($id);

    /**
     * Trim values.
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function trim_value(&$value);

}