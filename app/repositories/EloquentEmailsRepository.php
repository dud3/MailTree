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

    protected static $forward_email_from;
    protected static $forward_email_full_name;

    /**
     * Main Constructor.
     */
    public function __construct() {
        self::$forward_email_from = Config::get("constant.g_fwd_email_address");
        self::$forward_email_full_name = Config::get("constant.g_fwd_email_address_full_name");

        $this->main_sql = "
        SELECT m.id, m.email_address_id, m.subject, m.body, m.body_html, m.optional_text, m.sender_email, m.reciver_email,
                m.fwd_accept, m.sent,
                m.x_message_id, m.x_date,	m.x_size, m.x_uid, m.x_msgno,	m.x_recent, m.x_flagged, m.x_answered, m.x_deleted,
                m.x_seen, m.x_draft, m.x_udate,
                k_l.keywords

        FROM mails m

            INNER JOIN email_address_list e_a_l
                ON e_a_l.id = m.email_address_id

            INNER JOIN keywords_list k_l
                ON k_l.id = e_a_l.keyword_id

            JOIN (SELECT x_uid, MAX(id) id FROM mails GROUP BY x_uid) m2
                 ON m.id = m2.id AND m.x_uid = m2.x_uid";
    }

    /**
     * Get all emails.
     * @return [type] [description]
     */
    public function get_all() {
        return self::wrapKeywordLabels( DB::select($this->main_sql . " ORDER BY m.sent ASC, m.id DESC ", []) );
    }

    /**
     * Get email by ID.
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function get_by_id($id = null) {

    }

    /**
     * Get unsent emails only.
     * @return [type] [description]
     */
    public function get_unsent() {
        return self::wrapKeywordLabels( DB::select($this->main_sql . " WHERE m.sent = 0 ORDER BY m.id ASC ", []) );
    }

    /**
     * Get the email and it's recpipients.
     * @param  string $input input params.
     * @return [type] [description]
     */
    public function get_collection($input) {

        $ret = [];
        $arg = [];
        $where = " WHERE 1 = 1 ";

        if(isset($input["id"]) && !empty($input["id"])) {
            $where .= " AND m.id = ? ";
            $arg[] = $input["id"];
        }

        if(isset($input["email_address_id"]) && !empty($input["email_address_id"])) {
            $where .= " AND m.email_address_id = ? ";
            $arg[] = $input["email_address_id"];
        }

        $sql_mails = DB::select(

            "SELECT DISTINCT m.id, m.email_address_id, m.body, m.subject,
            e_a_l.email, e_a_l.full_name,
            m.x_message_id, m.x_date, m.x_size, m.x_uid, m.x_msgno,	m.x_recent, m.x_flagged, m.x_answered, m.x_deleted,
            m.x_seen, m.x_draft, m.x_udate

            FROM mails m

             LEFT JOIN email_address_list e_a_l
                ON m.email_address_id = e_a_l.id

             " .$where. "

             ORDER BY e_a_l.email"

        ,$arg);

        foreach ($sql_mails as $mail) {

            $std_email = new stdClass();
            $std_email->id = $mail->id;
            $std_email->x_uid = $mail->x_uid;
            $std_email->x_message_id = $mail->x_message_id;
            $std_email->email = $mail->email;
            $std_email->full_name = $mail->full_name;
            $std_email->message_subject = $mail->subject;
            $std_email->message_body = $mail->body;

            $ret[] = $std_email;

        }

        return $ret;

    }

    /**
     * Save email.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function saveEmail($input) {

        $arg = [];
        $where = "";
        $update_row = [];

        if(isset($input["x_uid"]) && !empty($input["x_uid"])) {
            $arg = $input["x_uid"];
            $where .= "x_uid";
        }

        if(isset($input["id"]) && !empty($input["id"])) {
            $arg = $input["id"];
            $where = "id";
        }

        $update_row["body"] = $input["message_body"];

        $condition = "=";

        return mails::where($where, $condition, $arg)->update($update_row);

    }

    /**
     * ReSend emails.
     * Can be used to resend emails as well.
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function reSendEmail($input) {

        $arg = [];
        $where = " WHERE 1 = 1 ";
        $update_row = [];

        if(isset($input["id"]) && !empty($input["id"])) {
            $arg = $input["id"];
            $where .= " AND id ";
        }

        if(isset($input["email_address_id"]) && !empty($input["email_address_id"])) {
            $arg = $input["email_address_id"];
            $where .= " AND email_address_id ";
        }

        if(isset($input["x_uid"]) && !empty($input["x_uid"])) {
            $arg = $input["x_uid"];
            $where .= "AND m.x_uid = ? ";
        }

        $sql_mails = DB::select(

            "SELECT DISTINCT m.id, m.email_address_id, m.body, m.subject,
            e_a_l.email, e_a_l.full_name

            FROM mails m

             INNER JOIN email_address_list e_a_l
                ON m.email_address_id = e_a_l.id

             " . $where . "

             ORDER BY e_a_l.email"

        ,[$arg]);

        foreach ($sql_mails as $mail) {

            $email = $mail->email;
            $full_name = $mail->full_name;
            $message_body = $mail->body;
            $message_subject = $mail->subject;

            $data = ["email" => $email,
                     "full_name" => $full_name,
                     "message_body" => $message_body,
                     "message_subject" => $message_subject];

           /**
            * Basically what we're doing here is that
            * -> whenever we see a text that says 'Click here'
            * -> automatically splice "Click here" text and
            * -> everything else that comes after it.
            * 
            * Let's just have this one here right now.
            * And maybe later on we can actually prevent this data
            * -> get into the DB at the frst place.
            *
            * @todo Move to the helper function.
            * 
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
            
            foreach (Config::get("constant.g_fwd_email_address") as $fwd_from) {

                Mail::send('emails.sentMail', $data, function($message) use ($email, $full_name, $message_body, $message_subject, $fwd_from)
                {
                    $message->from($fwd_from, Config::get("constant.g_fwd_email_address_full_name"));

                    $message->subject($message_subject);

                    $message->to($email);
                
                });

            }

            $this->updateEmailStatus($mail->id, ["sent" => 1]);

        }

        return true;

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
     * Save recipient.
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function saveRecipient($input) {

        $this_recipient = [];

        if( isset($input['id']) && $input['id'] != null ) {
            $this_recipient = email_address_list::where('id', '=', $input['id'])->get()->toArray();
        }

        if(!empty($this_recipient)) {
            return email_address_list::find($input['id'])->update([ 'email' => $input['email'], 'full_name' => $input['full_name'] ]);
        } else {
            return email_address_list::create($input);
        }

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


    // ---------------------------------------------------------------------
    // Helper Methods
    // ---------------------------------------------------------------------
    // @todo Create a helper service and move it there.
    // 
    
    /**
     * Simply wrap the email sbuject with found keywords.
     * @return [type] [description]
     */
    public static function wrapKeywordLabels($sql_emails) {

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
     * Trim values.
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function trim_value(&$value) { 
        $value = trim($value); 
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
        $findOne = mails::find($id);
        $findOne->fill($data);
        $findOne->save();
    }

}
