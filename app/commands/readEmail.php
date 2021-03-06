<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class readEmail extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'email:read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read emails from the account.';

    /**
     * State of the email
     */
    protected $email_state = [];

    /**
     * Email interface.
     * @var [type]
     */
    public $emails;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EmailsRepositoryInterface $emails)
    {

        $this->emails = $emails;

        parent::__construct();

        $this->email_state = ["ALL", "ANSWERED", "BCC", "BEFORE", "BODY", "CC", "DELETED", "FLAGGED", "FROM", "KEYWORD", 
                              "NEW", "OLD", "ON", "RECENT", "SEEN", "SINCE", "SUBJECT", "TEXT", "TO", "UNANSWERED", "UNDELETED",
                              "UNFLAGGED", "UNKEYWORD", "UNSEEN"];

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
    
        $__options = $this->option('options');
        $_option_html_enable = $this->option('html_enable');
        $_option_email_search = $this->option('email_search');

        if($_option_html_enable == null && $_option_email_search == null) {

            $_option_html_enable = false;
            $_option_email_search = "UNSEEN";

            $this->info("  --html_enable=false");
            $this->info("  --email_search='UNSEEN'");

        }

        if($_option_html_enable === null && $_option_email_search !== null)  { 
            $_option_html_enable = false;
        }

        if($_option_email_search === null && !$_option_html_enable) {
            $_option_email_search = "UNSEEN";
        }

        echo "\n";

        $this->comment("options");

        $this->info("--html_enable=[...]");
        $this->info("--email_search='[...]");

        echo "\n";

        if(!in_array($_option_email_search, $this->email_state)) {

            $this->error("Email State not found!");

            echo "\n";

            $this->info("Please chose one of the options below:");

            $this->comment('ALL - return all messages matching the rest of the criteria');
            $this->comment('ANSWERED - match messages with the ANSWERED flag set');
            $this->comment('BCC "string" - match messages with "string" in the Bcc: field');
            $this->comment('BEFORE "date" - match messages with Date: before "date"');
            $this->comment('BODY "string" - match messages with "string" in the body of the message');
            $this->comment('CC "string" - match messages with "string" in the Cc: field');
            $this->comment('DELETED - match deleted messages');
            $this->comment('FLAGGED - match messages with the FLAGGED (sometimes referred to as Important or Urgent) flag set');
            $this->comment('FROM "string" - match messages with "string" in the From: field');
            $this->comment('KEYWORD "string" - match messages with "string" as a keyword');
            $this->comment('NEW - match new messages');
            $this->comment('OLD - match old messages');
            $this->comment('ON "date" - match messages with Date: matching "date"');
            $this->comment('RECENT - match messages with the RECENT flag set');
            $this->comment('SEEN - match messages that have been read (the SEEN flag is set)');
            $this->comment('SINCE "date" - match messages with Date: after "date"');
            $this->comment('SUBJECT "string" - match messages with "string" in the Subject:');
            $this->comment('TEXT "string" - match messages with text "string"');
            $this->comment('TO "string" - match messages with "string" in the To:');
            $this->comment('UNANSWERED - match messages that have not been answered');
            $this->comment('UNDELETED - match messages that are not deleted');
            $this->comment('UNFLAGGED - match messages that are not flagged');
            $this->comment('UNKEYWORD "string" - match messages that do not have the keyword "string"');
            $this->comment('UNSEEN - match messages which have not been read yet');
            exit;

        }

        ($_option_html_enable == "true") ? $_option_html_enable = true : $_option_html_enable = false;

        $this->comment("Reading Emails:");

        $email_search_info = "Email search: " . $_option_email_search;
        $email_search_info = str_pad($email_search_info, strlen($email_search_info) + 2, " ", STR_PAD_LEFT);

        $this->info($email_search_info);

        $email_html_info = "HTML enabled:";

        if($_option_html_enable) { 
            $email_html_info = $email_html_info . " true";
        } else {
             $email_html_info = $email_html_info . " false";
        }

        $email_html_info = str_pad($email_html_info, strlen($email_html_info) + 2, " ", STR_PAD_LEFT);
        
        $this->info($email_html_info);
        
        echo "\n";
        
        $this->emails->readMails($_option_html_enable, $_option_email_search);

       /**
        * Store HTML version of the emails as well.
        * @var boolean
        * @todo save for later on.
        */
        // $this->emails->readHTMLMails(true, $_option_email_search);
        
        echo "\n";

        $this->info("Emails has been readen.");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    /*
    protected function getArguments()
    {
        return array(
            array('html_bool', InputArgument::REQUIRED, ' argument is required eother true or false.'),
        );
    }
    */

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

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('options', null, InputOption::VALUE_OPTIONAL, 'Help', null),
            array('html_enable', null, InputOption::VALUE_REQUIRED, 'Argument as option.', null),
            array('email_search', null, InputOption::VALUE_REQUIRED, 'Type of email(New, seen, unseen...).', null),
        );
    }

    /**
     * Further command-line color options...
     * $this->info("This is a comment.");
     * $this->question("This is a question.");
     * $this->error("This is an error.");
     */

}
