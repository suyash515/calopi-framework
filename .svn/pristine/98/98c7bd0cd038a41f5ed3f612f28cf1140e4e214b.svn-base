<?php


/**
 * Description of SessionHelper
 *
 * @author suyash
 */
class SessionHelper
{

    private static $USER_SESSION_VARIABLE = "user_id";
    private static $SHOW_TASK_SOCIAL_SESSION_VARIABLE = "show_task_social";

    public static function setUserSessionVariable($userId)
    {
	$_SESSION[SessionHelper::$USER_SESSION_VARIABLE] = $userId;
    }

    public static function initialiseUserSettings($userId)
    {
	$taskSocial = UserProfileSettingsLogicUtility::getShowTaskSocial($userId);

	$_SESSION[SessionHelper::$SHOW_TASK_SOCIAL_SESSION_VARIABLE] = $taskSocial;
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

    public static function getShowTaskSocial()
    {
	return $_SESSION[SessionHelper::$SHOW_TASK_SOCIAL_SESSION_VARIABLE];
    }

    public static function getUserIdForLog()
    {
	if(SessionHelper::getUserId() == "")
	{
	    return MobileSessionHelper::getUserId();
	}
	else
	{
	    return SessionHelper::getUserId();
	}
    }

    public static function isLoggedIn()
    {
	if(isset ($_SESSION[SessionHelper::$USER_SESSION_VARIABLE]))
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
