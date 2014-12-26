<?php

use Carbon\Carbon;
use Illuminate\Console\Command as cmd;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class EmailsRepository implements EmailsRepositoryInterface {

    public $server;
    public $server_name = ['imap.gmail.com', 'mail.alexent.com'];
    public $port = [143, 993];

    public $username = ['notifications@acsbill.com', 'notification@alexent.com'];
    public $password = '8655morro';

    public $search_for = [];

    public $inbox;
    public $emails;

    public $user;

    protected static $forward_email_from;
    protected static $forward_email_full_name;

    protected static $options;
    protected static $arguments;

    protected static $enable_html_email = false;
    protected static $fresh_email = false;

    protected static $dump_folder;
    protected static $dump_file_fullpath;

    protected static $dump_files = ['email_dump.txt', 
                          'email_header_dump.txt',
                          'email_get_address_dump.txt',
                          'email_body_dump.txt', 
                          'email_overview_dump.txt',
                          'email_subject_dump.txt',
                          'internal_stored_emails.txt',
                          'internal_sent_emails.txt',
                          'internal_track_keywords.txt'];


    /**
     * [__construct description]
     */
    public function __construct() {

        self::$forward_email_from = Config::get("constant.g_fwd_email_address");
        self::$forward_email_full_name = Config::get("constant.g_fwd_email_address_full_name");

        $this->server = new \Fetch\Server($this->server_name[1], $this->port[0]);
        $this->server->setAuthentication($this->username[1], $this->password);

     /**
      * ---------------------------------------------------------------------------------------------------------
      *  State of emails (http://php.net/manual/en/function.imap-search.php)
      * ---------------------------------------------------------------------------------------------------------       
      *  ALL - return all messages matching the rest of the criteria
      *  ANSWERED - match messages with the \\ANSWERED flag set
      *  BCC "string" - match messages with "string" in the Bcc: field
      *  BEFORE "date" - match messages with Date: before "date"
      *  BODY "string" - match messages with "string" in the body of the message
      *  CC "string" - match messages with "string" in the Cc: field
      *  DELETED - match deleted messages
      *  FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
      *  FROM "string" - match messages with "string" in the From: field
      *  KEYWORD "string" - match messages with "string" as a keyword
      *  NEW - match new messages
      *  OLD - match old messages
      *  ON "date" - match messages with Date: matching "date"
      *  RECENT - match messages with the \\RECENT flag set
      *  SEEN - match messages that have been read (the \\SEEN flag is set)
      *  SINCE "date" - match messages with Date: after "date"
      *  SUBJECT "string" - match messages with "string" in the Subject:
      *  TEXT "string" - match messages with text "string"
      *  TO "string" - match messages with "string" in the To:
      *  UNANSWERED - match messages that have not been answered
      *  UNDELETED - match messages that are not deleted
      *  UNFLAGGED - match messages that are not flagged
      *  UNKEYWORD "string" - match messages that do not have the keyword "string"
      *  UNSEEN - match messages which have not been read yet
      *  ---------------------------------------------------------------------------------------------------------
      */

    }


      /**
     * Read all the emails.
     * @return [type] [description]
     */
    public function readMails($html_enable, $email_search) {

        /**
         * @note: read only unssen emails
         * First of all make the artisan command accespt some 
         * -> argouments so we can easily switch between "read all emails"
         * -> and "unseen emails"
         * $this->server->search('UNSEEN')
         *
         * Default value;
         * $this->inbox = $this->server->getMessages();
         *
         */

        $this->inbox = $this->server->search($email_search);

        /* Read the inbox */
        $this->emails = $this->inbox;

        self::$enable_html_email = $html_enable;

        (self::$enable_html_email) ? $html_enable = 2 : $html_enable = 0;

        $emails = $this->emails;
        $arr_emails = [];

        echo("= = = = = =\n");
        echo("Read Emails\n");
        echo("= = = = = =\n");
        echo("Count Emails: " . count($emails) . "\n");
        echo("-------------------------------------------------------------------------------------\n");

        self::openDump();
        self::dump_output('all', $emails);

        foreach ($emails as $message) {

            $std_email = new StdClass;

            $std_email->header = $message->getHeaders();
            $std_email->overview = $message->getOverview();
            $std_email->address = $message->getAddresses('from');
            $std_email->subject = $message->getSubject();
            $std_email->body = $message->getMessageBody($html_enable);
            $std_email->date = $message->getDate();

            /* Check the subject fitst */
            $std_email->subject = explode(" ", $std_email->subject);
            
            /* If Fwd is present in the subject */
            if(in_array('Fwd:', $std_email->subject)) {
                unset($std_email->subject[0]);
            }

            $std_email->subject = implode(" ", $std_email->subject);

            if(!self::$enable_html_email) {

                /* Explode the email into pieces */
                $std_email->body = explode("\n", $std_email->body);

               /**
                * Trim the value otherwise at the end of the each mail
                * -> we will strat seeing the value of ^M after exploding
                * -> the string, and this makes imposibble to compare the 
                * -> keywords from the database even if we include the 
                * -> ^M symbol at the end of each array element.
                */ 
                array_walk($std_email->body, array($this, 'trim_value'));

               /**
                * Two of this following conditions are for:
                * * if the mail is forwarded by a person/automatic email forwarder
                * * if the mail contains the keyword of "Dear"
                * 
                * The reason for the first one is that, we don't want to store mails into the 
                * -> DB with the forwarded information.
                * 
                * The second one is that we won't eventually want to erase the mail that has been
                * -> forwarded to an X person since we will forward the same email to multiple
                * -> users that match the keyword(s), and replace their name on the emal.
                */
                if(in_array('---------- Forwarded message ----------', $std_email->body)) {
                    $std_email->body = array_slice($std_email->body, 9);
                }

               /** 
                * if strpos($mystring, $findme)
                * We might want to search the string if it contains the keyword of "Dear" or simmilar.
                */
                $this->search_for = ["Dear", "Dear Alexander", "Dear Alexander Notifications,"];
              
                if(in_array($this->search_for[0], $std_email->body) 
                || in_array($this->search_for[1], $std_email->body) 
                || in_array($this->search_for[2], $std_email->body)) {

                    $std_email->body = array_slice($std_email->body, 3);
                }

            /**
             * -----------------
             * !If HTML enabled
             * -----------------
             */
            } else if(self::$enable_html_email) {

                /* Explode the email into pieces */
                $std_email->body = explode("\n", $std_email->body);

                /* Repeat the simmilar as for non-HTML emails */
                array_walk($std_email->body, array($this, 'trim_value'));
        
                /* If the mail is forwarded in case */
                if(in_array('---------- Forwarded message ----------', $std_email->body)) {
                    $std_email->body = array_slice($std_email->body, 9);
                }

                /* Search for default values in the mail */
                $this->search_for = ["Dear Alexander Notifications,<br /><br />"];

                if(in_array($this->search_for[0], $std_email->body)) {
                  $std_email->body = array_slice($std_email->body, 3);
                }

            }

            /* Put everything all togather */
            $std_email->body = implode("\n", $std_email->body); 

            $arr_emails[] = $std_email;

            self::dump_output('headers', $std_email->header);
            self::dump_output('address', $std_email->address);
            self::dump_output('body',   $std_email->body);
            self::dump_output('overview', $std_email->overview);
            self::dump_output('subject', $std_email->subject);

        }

        /**
         * This one actualy does the magic for us.
         */
        $this->compareKeywords($arr_emails);

        self::closeDump();

    }

      /**
     * Read all the emails.
     * @return [type] [description]
     */
    public function readHTMLMails($html_enable = true, $email_search) {

        $this->inbox = $this->server->search($email_search);

        /* Read the inbox */
        $this->emails = $this->inbox;

        self::$enable_html_email = $html_enable;

        $html_enable = 2;

        $emails = $this->emails;
        $arr_emails = [];

        foreach ($emails as $message) {

            $std_email = new StdClass;

            $std_email->header = $message->getHeaders();
            $std_email->overview = $message->getOverview();
            $std_email->address = $message->getAddresses('from');
            $std_email->subject = $message->getSubject();
            $std_email->body = $message->getMessageBody($html_enable);
            $std_email->date = $message->getDate();

            /* Check the subject fitst */
            $std_email->subject = explode(" ", $std_email->subject);
            
            /* If Fwd is present in the subject */
            if(in_array('Fwd:', $std_email->subject)) {
                unset($std_email->subject[0]);
            }

            $std_email->subject = implode(" ", $std_email->subject);

            /* Explode the email into pieces */
            $std_email->body = explode("\n", $std_email->body);

            /* Repeat the simmilar as for non-HTML emails */
            array_walk($std_email->body, array($this, 'trim_value'));
    
            /* If the mail is forwarded in case */
            if(in_array('---------- Forwarded message ----------', $std_email->body)) {
                $std_email->body = array_slice($std_email->body, 9);
            }

            /* Search for default values in the mail */
            $this->search_for = ["Dear Alexander Notifications,<br /><br />"];

            if(in_array($this->search_for[0], $std_email->body)) {
              $std_email->body = array_slice($std_email->body, 3);
            }

            /* Put everything all togather */
            $std_email->body = implode("\n", $std_email->body); 

            $arr_emails[] = $std_email;

        }

        /**
         * This one actualy does the magic for us.
         */
        $this->compareKeywords($arr_emails);

        self::closeDump();

    }


    /**
     * Send stored mails from the database.
     * @return [type] [description]
     */
    public function sendMails($fwd_from = null, $test_user_only = false) {

        $where = " WHERE m.sent = 0 AND k_l.send_automatically = 1 ";

        /**
         * If in html enabled mode, read only emails that contain html.
         */
        if(self::$enable_html_email) {
          $where = " AND m.html = 1 ";
        }

        $arg = [];
        if($test_user_only)  {
            $where .= " AND m.email_address_id IN(?, ?, ?, ?, ?) ";
            $arg[] = 1;
            $arg[] = 12;
            $arg[] = 21;
            $arg[] = 20;
            $arg[] = 16;
        }

        $sql_mails = DB::select(

            "SELECT DISTINCT m.id, m.email_address_id, m.body, m.subject,
            e_a_l.email, e_a_l.full_name,
            k_l.send_automatically

            FROM mails m

             INNER JOIN email_address_list e_a_l
                ON m.email_address_id = e_a_l.id

             JOIN keywords_list k_l
                ON e_a_l.keyword_id = k_l.id

             " . $where . "

             ORDER BY e_a_l.email"

        ,$arg);

        foreach ($sql_mails as $mail) {

            self::openDump();

            $email = $mail->email;
            $full_name = $mail->full_name;
            $message_body = $mail->body;
            $message_subject = $mail->subject;

            $data = ["email" => $email,
                     "full_name" => $full_name,
                     "message_body" => $message_body,
                     "message_subject" => $message_subject];

            // Some Error handling
            foreach ($data as $inputs) {
                if($inputs == null || empty($inputs)) {
                    var_dump($data);
                    throw new Exception("Some data is missing", 1);
                    exit;
                }
            }

           /**
            * Basically what we're doing here is that
            * -> whenever we see a text that says 'Click here'
            * -> automatically splice "Click here" text and
            * -> everything else that comes after it.
            * 
            * Let's just have this one here right now.
            * And maybe later on we can actually prevent this data
            * -> get into the DB at the frst place.
            */
            $data["message_body"] = explode("\n", $data["message_body"]);

            array_walk($data["message_body"], array($this, 'trim_value'));

            for($i = 0; $i < count($data["message_body"]); $i++) {

                if($data["message_body"][$i] == "Click here" || $data["message_body"][$i] == "--") {
                    array_splice($data["message_body"], $i, count($data["message_body"]) - 1);
                }

            }

            $data["message_body"] = implode("\n", $data["message_body"]);

            $message = [];
            
            foreach (self::$forward_email_from as $fwd_from) {

                Mail::send('emails.sentMail', $data, function($message) use ($email, $full_name, $message_body, $message_subject, $fwd_from)
                {
                    $message->from($fwd_from, self::$forward_email_full_name);

                    $message->subject($message_subject);

                    $message->to($email);

                    // 
                    // Save for later on if needed
                    // 
                    // $message->attach($pathToFile);
                    // 
                
                });

            }

            /* Sleep a little */
            sleep(1);

            // Set sent to 1
            $this->updateEmailStatus($mail->id, ["sent" => 1]);

            var_dump("Sending message to: " . $data["email"] . " | full_name: " . $data["full_name"] . " | email_id:" . $mail->id);
            self::dump_output('send_emails', $data);
            self::closeDump();

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
     * Basically update the status of the email
     * Such as if the emails is:
     * * sent
     * * seen
     * * deleted
     * @return [type] [description]
     */
    public function updateEmailStatus($id, $data) {
        $findOne = $this->findMailByID($id);
        $findOne->fill($data);
        $findOne->save();
    }


    /**
     * Get the keywords fro mthe email.
     * @return [type] [description]
     */
    public function compareKeywords($data) {

        foreach ($data as $email) {

            /* Get the keywords from the  */
            $get_keywords =  explode(" ", $email->subject);
            $k_db = keywords_list::all()->toArray();
            $k_intersect = [];
      
            foreach ($k_db as $db_keywords) {
       
                $k_db = (string)$db_keywords["keywords"];
                $k_id = $db_keywords["id"];

                $k_db = trim($k_db);
                $k_db = json_decode($k_db, true);

                /* Keep the original content, simply don't remove the HTML tags from it. */
                $k_db_original_content = (int)$db_keywords["original_content"];

                /**
                * Before everything, set the keywords from the emails subject
                * and the keywords from the database to lowercase.
                */
                for ($i = 0; $i < count($get_keywords); $i++) {
                  $get_keywords[$i] = strtolower($get_keywords[$i]);
                }
                for ($i = 0; $i < count($k_db); $i++) {
                  $k_db[$i] = strtolower($k_db[$i]);
                }

               /**
                * Get the common between the database keywords that belong 
                * -> to each user and the keywords from the emails subject.
                * 
                * Sample: 
                *          * Email Keyword: 'dog', 'fish', 'rocket', 'etc'
                *          * DB Keywords: 'dog', 'rocket'
                * 
                * Union and the output will be 'dog' and 'fish'   
                *
                */ 
                $k_intersect = array_intersect($k_db, $get_keywords);


               /**
                * After we union the smmilarities check if there's a difference
                * -> between the DB array and the filtered array from the "email subject"
                * -> this way we can figure it out if they are identical.
                * 
                *  Since the `array_intersect()` get's the common between both of arrays
                *  -> we might have a situation like the following:
                *  
                *  * Email Keywords: 'dog', 'fish', 'rocket', '-', 'something'
                *  * DB Keywords: 'dog', 'fish', 'dolphin'
                *  
                *  array_intersect($e_kwd, $db_kwd) => 'dog', 'fish'
                *  
                *  -> so e_kwd != $db_kwd => because the 'dolphin' should match also.
                *  
                */
                $k_arr_diff = array_diff($k_db, $get_keywords);

                /*
                  echo "\n-------------------- DB --------------------\n";
                  var_dump($k_db);
                  echo "\n-------------------- Get --------------------\n";
                  var_dump($get_keywords);
                  echo "\n-------------------- Intersect --------------------\n";
                  var_dump($k_intersect);
                  echo "\n-------------------- Diff Array --------------------\n";
                  var_dump($k_arr_diff);
                */

                if(count($k_arr_diff) == 0) {

                  // echo ">>>>>>>>>>>>>>>>>>>>>>>> BINGO <<<<<<<<<<<<<<<<<<<<<<<<\n";

                   $e_add_list = email_address_list::where("keyword_id", "=", $k_id)->get()->toArray();

                    if(!empty($e_add_list)) {
                        foreach ($e_add_list as $e_list) {

                            $std_store_email = new StdClass;
                            $std_store_email->email_address_id = (int)$e_list["id"];
                            $std_store_email->email = $e_list["email"];
                            $std_store_email->full_name = $e_list["full_name"];
                            $std_store_email->subject = $email->subject;
                            $std_store_email->body = $email->body;
                            $std_store_email->html = 0;


                            /**
                             * Since we would want to distingush between the
                             * emails that depent on HTML we should first check if
                             * the email listener listens with html_enable = true
                             * and if they keywordEndtity wants to save the email in it's original content,
                             * if so flag the email.
                             */
                            if(self::$enable_html_email) {
                              if($k_db_original_content == 1) {
                                $std_store_email->html = 1;
                              } else {
                                continue;
                              }
                            }


                            $std_store_email->__date = $email->header->date;
                            $std_store_email->__message_id = $email->header->message_id;
                            $std_store_email->__size = $email->overview->size;
                            $std_store_email->__uid = $email->overview->uid;
                            $std_store_email->__msgno = $email->overview->msgno;
                            $std_store_email->__recent = $email->overview->recent;
                            $std_store_email->__flagged = $email->overview->flagged;
                            $std_store_email->__answered = $email->overview->answered;
                            $std_store_email->__deleted = $email->overview->deleted;
                            $std_store_email->__seen = $email->overview->seen;
                            $std_store_email->__draft = $email->overview->draft;
                            $std_store_email->__udate = $email->overview->udate;

                           /**
                            * Let's insert the name of the user that 
                            * -> will get the eamil.
                            * 
                            * Explode into pieces
                            * $std_store_email->body = explode("\n", $std_store_email->body);
                            *
                            * Reorder the array and push this one on top of the queue
                            * array_unshift($std_store_email->body, "Dear " . $e_list["full_name"] . ",\n");
                            * 
                            * Put everything togather
                            * $std_store_email->body = implode("\n", $std_store_email->body);
                            */
                           
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

        $insert_data = [

                 "email_address_id" => $data->email_address_id, 
                 "subject" => $data->subject, 
                 "body" => $data->body,
                 "html" => $data->html,

                 "x_message_id" => $data->__message_id,
                 "x_date" => $data->__date,
                 "x_size" => $data->__size,
                 "x_uid" => $data->__uid,
                 "x_msgno" => $data->__msgno,
                 "x_recent" => $data->__recent,
                 "x_flagged" => $data->__flagged,
                 "x_answered" => $data->__answered,
                 "x_deleted" => $data->__deleted,
                 "x_seen" => $data->__seen,
                 "x_draft" => $data->__draft,
                 "x_udate" => $data->__udate

        ];

        mails::create($insert_data);
        
        $dump_sent_emails = ("Email stored for: " . " \t| ID: " . $data->email_address_id . " \t| Email: " . $data->email . " \t| Name: " . $data->full_name . "\n");
        
        self::dump_output('store_emails', $dump_sent_emails);
        
        echo($dump_sent_emails);

    }


    /**
     * Store Keywords
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function storeKeywords($data) {
        var_dump($data);
    }


    /**
     * Find mail by id.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function findMailByID($id) {
        return mails::find($id);
    }


    /**
     * Validate JSON.
     * @todo  move it its own class/interface.
     * @return [type] [description]
     */
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

    /*
    |-------------------------------------------------------------- 
    | Helper Functions
    |--------------------------------------------------------------
    |
    | Helper functions reside here.
    |
    | @todo create helpers service provider.
    | 
    */

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

            case 'store_emails':
                self::$dump_file_fullpath .= self::$dump_files[6];
                break;

            case 'send_emails':
                self::$dump_file_fullpath .= self::$dump_files[7];
                break;

            case 'track_keywords':
                self::$dump_file_fullpath .= self::$dump_files[8];
                break;

        }

        if(is_array($var_dump) || is_object($var_dump)) {
            $var_dump = self::indent(json_encode($var_dump));
        }

        file_put_contents(self::$dump_file_fullpath, $var_dump . "\n", FILE_APPEND | LOCK_EX);

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
             file_put_contents(self::$dump_file_fullpath . $dump_file, "----------------------------------------------------------------------------------------------------\n", FILE_APPEND | LOCK_EX);
        }

    }


    /**
     * Get arguments from the cmd.
     * @param  [type] $arguments [description]
     * @return [type]            [description]
     */
    public static function arguments($arguments = null) {
        return self::$arguments;
    }


    /**
     * Trim values.
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function trim_value(&$value) { 
        $value = trim($value); 
    }
    

    /**
     * Replace value
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function replace_value(&$value, $needle = null) {
        $value = preg_replace('/(\r\n|\r|\n)/s',"\n",$contents);
    }


    /**
    * Indents a flat JSON string to make it more human-readable.
    *
    * @param string $json The original JSON string to process.
    * @return string Indented version of the original JSON string.
    */
    public static function indent($json) {

        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = "\t";
        $newLine = "\n";

        for ($i = 0; $i < $strLen; $i++) {
            // Grab the next character in the string.
            $char = $json[$i];

            // Are we inside a quoted string?
            if ($char == '"') {
                // search for the end of the string (keeping in mind of the escape sequences)
                if (!preg_match('`"(\\\\\\\\|\\\\"|.)*?"`s', $json, $m, null, $i)) return $json;

                    // add extracted string to the result and move ahead
                    $result .= $m[0];
                    $i += strLen($m[0]) - 1;
                    continue;
            }

            else if ($char == '}' || $char == ']') {
                $result .= $newLine;
                $pos --;
                $result .= str_repeat($indentStr, $pos);
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if ($char == ',' || $char == '{' || $char == '[') {

                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }

                $result .= str_repeat($indentStr, $pos);

            }
        }

        return $result;
    }

}
