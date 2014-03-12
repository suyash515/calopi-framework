<?php


/**
 * Description of PostHelper
 *
 * @author suyash
 */
class RequestHelper
{

    public static function getRequestValue($index)
    {
	if(isset($_POST[$index]))
	{
	    return $_POST[$index];
	}
	elseif(isset($_GET[$index]))
	{
	    return $_GET[$index];
	}
	else
	{
	    return "";
	}
    }

    public static function getFile($index)
    {
	if(isset ($_FILES[$index]))
	{
	    return $_FILES[$index];
	}
	else
	{
	    return "";
	}
    }
}

?>
