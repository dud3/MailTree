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
    public function getEmailKeywords($data);

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
     * Validate JSON
     * @return [type] [description]
     */
    public function validateJson();

    /**
     * Dump sent messages.
     * @param  [type] $item_type          [description]
     * @param  [type] $item_id            [description]
     * @param  [type] $user_email         [description]
     * @param  [type] $user_full_name     [description]
     * @param  [type] $message_style_type [description]
     * @return [type]                     [description]
     */
    public static function dump_output($type, $var_dump);

    /**
     * Start dump file.
     * @return [type] [description]
     */
    public static function openDump();

    /**
     * Close the dump files.
     * @return [type] [description]
     */
    public static function closeDump();

    /**
     * Get arguments from the cmd.
     * @param  [type] $arguments [description]
     * @return [type]            [description]
     */
    public static function arguments($arguments = null);

    /**
     * Trim values.
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function trim_value(&$value);

    /**
     * Replace value
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function replace_value(&$value, $needle = null);

    /**
    * Indents a flat JSON string to make it more human-readable.
    *
    * @param string $json The original JSON string to process.
    * @return string Indented version of the original JSON string.
    */
    public static function indent($json);

}