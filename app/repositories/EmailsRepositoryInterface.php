<?php

interface EmailsRepositoryInterface {

    /**
     * Read all the emails.
     * @return [type] [description]
     */
    public function readMails($html_enable);

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
    public function getEmailKeywords($data);

}