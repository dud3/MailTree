<?php
        
namespace lib\Helpers;
use Carbon\Carbon;

class Helper {

    /**
     * Validate JSON.
     * @todo  move it its own class/interface.
     * @return [type] [description]
     */
    public static function validateJson() {

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
    public static function trim_value(&$value) { 
        $value = trim($value); 
    }
    

    /**
     * Replace value
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function replace_value(&$value, $needle = null) {
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