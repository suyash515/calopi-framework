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

    public static function isValueSet($index)
    {
        if(isset($_REQUEST[$index]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function getFile($index)
    {
        if(isset($_FILES[$index]))
        {
            return $_FILES[$index];
        }
        else
        {
            return "";
        }
    }

    public static function getSanitizedRequestValue($index)
    {
        $variableChecker = new VariableChecker();

        return $variableChecker->sanitizeInput(RequestHelper::getRequestValue($index));
    }

    public static function isIndexSet($index)
    {
        return isset($_REQUEST[$index]);
    }

}

?>
