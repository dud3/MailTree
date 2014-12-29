<?php

namespace lib\Loggers;
use Carbon\Carbon;
use lib\Helpers\Helper as Helper;

class Logger {

    public static $arguments;
    public static $dump_folder;
    public static $dump_file_fullpath;

    protected static $dump_files = ['email_dump.txt', 
                                    'email_header_dump.txt',
                                    'email_get_address_dump.txt',
                                    'email_body_dump.txt', 
                                    'email_overview_dump.txt',
                                    'email_subject_dump.txt',
                                    'internal_stored_emails.txt',
                                    'internal_sent_emails.txt',
                                    'internal_track_keywords.txt'];


    public function __construct() {

        self::$dump_folder = base_path() . "/sys_dump/";

        if(!file_exists(self::$dump_folder)) {
          mkdir(self::$dump_folder, 777);
        }

    }

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
            $var_dump = Helper::indent(json_encode($var_dump));
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

}