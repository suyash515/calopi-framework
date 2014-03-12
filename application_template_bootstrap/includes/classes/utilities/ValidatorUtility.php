<?php

/**
 * Description of Validator
 *
 * @author suyash
 */
class ValidatorUtility
{

    public function __construct()
    {

    }

    public function validateForDoubleQuote($text)
    {
        $position = strpos($text, "\"");

        if($position == false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function validateNumber($text)
    {
        if(is_numeric($text))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function validateEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }
        else
        {
            return false;
        }


//        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
//
//        if(preg_match($pattern, $email))
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
    }

    /**
     * Validate a time in the format hh:mm
     */
    public function validateHourMinute($time)
    {
        if(strlen($time) <= 5)
        {
            $separatorPosition = strpos($time, ":");

            if($separatorPosition)
            {
                $hour = substr($time, 0, $separatorPosition);
                $minute = substr($time, $separatorPosition + 1, strlen($time));

                if((is_numeric($hour)) && (is_numeric($minute)))
                {
                    if((intval($hour) >= 0) && (intval($hour) < 24))
                    {
                        if((intval($minute) >= 0) && (intval($minute) < 60))
                        {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Validate a time in the format hh:mm
     */
    public function validateHourMinuteIncluding24($time)
    {
        if(strlen($time) <= 5)
        {
            $separatorPosition = strpos($time, ":");

            if($separatorPosition)
            {
                $hour = substr($time, 0, $separatorPosition);
                $minute = substr($time, $separatorPosition + 1, strlen($time));

                if((is_numeric($hour)) && (is_numeric($minute)))
                {
                    if(intval($hour) >= 0)
                    {
                        if(intval($hour) < 24)
                        {
                            if((intval($minute) >= 0) && (intval($minute) < 60))
                            {
                                return true;
                            }
                        }
                        elseif(intval($hour) == 24)
                        {
                            if(intval($minute) == 0)
                            {
                                return true;
                            }
                        }
                    }
                }
            }
        }

        return false;
    }

}

?>
