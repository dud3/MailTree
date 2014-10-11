<?php

use Carbon\Carbon;

class EmailsRepository implements EmailsRepositoryInterface {

    public $server;
    public $server_name = 'imap.gmail.com';
    public $username = 'notifications@acsbill.com';
    public $password = '8655morro';

    public $inbox;
    public $emails;

    public $user;

    protected static $dump_folder;
    protected static $dump_file_fullpath;

    protected static $dump_files = ['email_dump.txt', 
                          'email_header_dump.txt',
                          'email_get_address_dump.txt',
                          'email_body_dump.txt', 
                          'email_overview_dump.txt',
                          'email_subject_dump.txt'];


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
    public function readMails() {

        $emails = $this->emails;
        $arr_emails = [];

        echo("= = = = = =\n");
        echo("Read Emails\n");
        echo("= = = = = =\n");
        echo("Count Emails: " . count($emails) . "\n");
        echo("-------------------\n");

        self::openDump();
        self::dump_output('all', $emails);

        foreach ($emails as $message) {

            $std_email = new StdClass;

            $std_email->header = $message->getHeaders();
            $std_email->overview = $message->getOverview();
            $std_email->address = $message->getAddresses('from');
            $std_email->subject = $message->getSubject();
            $std_email->body = $message->getMessageBody();
            $std_email->date = $message->getDate();

            $std_email->body = explode("\n", $std_email->body);
            $std_email->body = array_slice($std_email->body, 6);
            $std_email->body = implode("\n", $std_email->body);

            $arr_emails[] = $std_email;

            self::dump_output('headers', $std_email->header);
            self::dump_output('address', $std_email->address);
            self::dump_output('body',   $std_email->body);
            self::dump_output('overview', $std_email->overview);
            self::dump_output('subject', $std_email->subject);

            var_dump($std_email->body);

        }

        $this->getEmailKeywords($arr_emails);

        self::closeDump();

    }


    /**
     * Send stored mails from the database.
     * @return [type] [description]
     */
    public function sendMails() {
        foreach (mails::all()->toArray() as $mail) {
            
        }
    }


    /**
     * Remove emails.
     * @return [type] [description]
     */
    public function removeMails($all = false, $id = null) {
          return imap_delete();
    }


    /**
     * Get the subject of the email.
     * @return [type] [description]
     */
    public function getEmailSubject() {

    }

    /**
     * Get the body of the email.
     * @return [type] [description]
     */
    public function getEmailBody() {

    }


    /**
     * Get the keywords fro mthe email.
     * @return [type] [description]
     */
    public function getEmailKeywords($data) {

        foreach ($data as $email) {
     
            // Get the keywords from the DB
            $get_keywords =  explode(" ", $email->subject);
            $k_db = keywords_list::all()->toArray();
            $k_intersect = [];

            // var_dump($email);
      
            foreach ($k_db as $db_keywords) {
       
                $k_db = (string)$db_keywords["keywords"];
                $k_id = $db_keywords["id"];

                $k_db = trim($k_db);
                $k_db = json_decode($k_db, true);

                //
                //
                // Get the common between the database keywords that belong 
                // -> to each user and the keywords from the emails subject.
                // 
                // Sample: 
                //          * Email Keyword: 'dog', 'fish', 'rocket', 'etc'
                //          * DB Keywords: 'dog', 'rocket'
                // 
                // Union and the output will be 'dog' and 'fish'   
                //
                // 
                $k_intersect = array_intersect($k_db, $get_keywords);


                //
                //
                // After we union the smmilarities check if there's a difference
                // -> between the DB array and the filtered array from the "email subject"
                // -> this way we can figure it out if they are identical.
                // 
                //  Since the `array_intersect()` get's the common between both of arrays
                //  -> we might have a situation like the following:
                //  
                //  * Email Keywords: 'dog', 'fish', 'rocket', '-', 'something'
                //  * DB Keywords: 'dog', 'fish', 'dolphin'
                //  
                //  array_intersect($e_kwd, $db_kwd) => 'dog', 'fish'
                //  
                //  -> so e_kwd != $db_kwd => because the 'dolphin' should match also.
                //  
                //
                $k_arr_diff = array_diff($k_db, $get_keywords);

                if(count($k_arr_diff) == 0) {

                   $e_add_list = email_address_list::where("keyword_id", "=", $k_id)->get()->toArray();

                    if($e_add_list !== null) {
                        foreach ($e_add_list as $e_list) {

                           // var_dump($e_list);
                            $std_store_email = new StdClass;
                            $std_store_email->email_address_id = (int)$e_list["id"];
                            $std_store_email->subject = $email->subject;
                            $std_store_email->body = $email->body;

                            $this->storeMail($std_store_email);
                            
                        }
                    }

                }

            }
        }

    }


    /**
     * Sotore emails in the database.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function storeMail($data) {
        var_dump($data->email_address_id);
        mails::create(["email_address_id" => $data->email_address_id, "subject" => $data->subject, "body" => $data->body]);
    }


    /**
     * Store Keywords
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function storeKeywords($data) {
        var_dump($data);
    }


    public function validateJson() {

        switch (json_last_error()) {

            case JSON_ERROR_NONE:
                echo ' - No errors';
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
            default:
                echo ' - Unknown error';
            break;

        }

        echo PHP_EOL;
    }

    // ------------------------------- 
    // Helper Functions
    // -------------------------------
    // 
    // Helper functions reside here.
    // 
    // --------------------------------

    /**
     * Dump sent messages.
     * @param  [type] $item_type          [description]
     * @param  [type] $item_id            [description]
     * @param  [type] $user_email         [description]
     * @param  [type] $user_full_name     [description]
     * @param  [type] $message_style_type [description]
     * @return [type]                     [description]
     */
    public static function dump_output($type, $var_dump) {

        self::$dump_folder = base_path() . "/sys_dump/";
        self::$dump_file_fullpath = self::$dump_folder;

        if(!file_exists(self::$dump_folder)) {
            File::makeDirectory(self::$dump_folder, $mode = 0777, true, true);
        }

        if(!file_exists(self::$dump_file_fullpath)) {
            foreach (self::$dump_files as $dump_file) {
                fopen(self::$dump_file_fullpath . $dump_file, "w");
            }
        }
        
        // Dump output
        switch ($type) {

            case 'all':
                self::$dump_file_fullpath .= self::$dump_files[0];
                break;

            case 'headers':
                self::$dump_file_fullpath .= self::$dump_files[1];
                break;

            case 'address':
                self::$dump_file_fullpath .= self::$dump_files[2];
                break;

            case 'body':
                self::$dump_file_fullpath .= self::$dump_files[3];
                break;

            case 'overview':
                self::$dump_file_fullpath .= self::$dump_files[4];
                break;
            
            case 'subject':
                self::$dump_file_fullpath .= self::$dump_files[5];
                break;
        }

        // $var_dump =  ("Write: " . $type . "\n");

        file_put_contents(self::$dump_file_fullpath, json_encode($var_dump) . "\n", FILE_APPEND | LOCK_EX);

    }


    /**
     * Start dump file.
     * @return [type] [description]
     */
    public static function openDump() {

        self::$dump_folder = base_path() . "/sys_dump/";
        self::$dump_file_fullpath = self::$dump_folder;

        foreach (self::$dump_files  as $dump_file) {
             file_put_contents(self::$dump_file_fullpath . $dump_file,  "\n" . date("F j, Y, g:i a"), FILE_APPEND | LOCK_EX);
             file_put_contents(self::$dump_file_fullpath . $dump_file,  "\n----------------------------------------------------------------------------------------------------\n", FILE_APPEND | LOCK_EX);
        }

    }


    /**
     * Close the dump files.
     * @return [type] [description]
     */
    public static function closeDump() {

        self::$dump_folder = base_path() . "/sys_dump/";
        self::$dump_file_fullpath = self::$dump_folder;

        foreach (self::$dump_files  as $dump_file) {
             file_put_contents(self::$dump_file_fullpath . $dump_file, "--------------------------------------------------", FILE_APPEND | LOCK_EX);
        }

    }

}
