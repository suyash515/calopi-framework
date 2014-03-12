<?php

/**
 * Description of SessionHelper
 *
 * @author suyash
 */
class SessionHelper
{

    private static $USER_SESSION_VARIABLE = "id";
    private static $USER_NAME_VARIABLE = "name";

    public static function setUserSessionVariable($userId)
    {
        $_SESSION[SessionHelper::$USER_SESSION_VARIABLE] = $userId;
    }

    public static function setUserDetails($name)
    {
        $_SESSION[SessionHelper::$USER_NAME_VARIABLE] = $name;
    }

    public static function getUserId()
    {
        if(isset($_SESSION[SessionHelper::$USER_SESSION_VARIABLE]))
        {
            return $_SESSION[SessionHelper::$USER_SESSION_VARIABLE];
        }
        else
        {
            return "";
        }
    }

    public static function getUserName()
    {
        if(isset($_SESSION[SessionHelper::$USER_NAME_VARIABLE]))
        {
            return $_SESSION[SessionHelper::$USER_NAME_VARIABLE];
        }
        else
        {
            return "";
        }
    }

    public static function isLoggedIn()
    {
        if(isset($_SESSION[SessionHelper::$USER_SESSION_VARIABLE]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

?>
