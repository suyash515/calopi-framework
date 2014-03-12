<?php

/**
 * Description of ResultUpdateGuiUtility
 *
 * @author suyash
 */
class ResultUpdateGuiUtility
{

    public static function getResultDisplay($resultText = "", $containerId = "", $fade = true)
    {
        $output = "";

        $output .= ResultUpdateGuiUtility::getDisplay($resultText, $containerId, $fade);

        return $output;
    }

    public static function getErrorDisplay($resultText = "", $containerId = "", $fade = true)
    {
        $output = "";

        $output .= ResultUpdateGuiUtility::getDisplay($resultText, $containerId, $fade, "error_message");

        return $output;
    }

    public static function getBootstrapErrorDisplay($error, $width = "")
    {
        $output = "";

        $style = "";

        if($width != "")
        {
            $style = "style='width: $width;'";
        }

        $output .= "<div class='alert' $style>";
        $output .= "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        $output .= "<strong>Error!</strong> $error";
        $output .= "</div>";

        return $output;
    }

    public static function getBootstrapSuccessDisplay($error, $width = "")
    {
        $output = "";

        $style = "";

        if($width != "")
        {
            $style = "style='width: $width;'";
        }

        $output .= "<div class='alert alert-success' $style>";
        $output .= "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
        $output .= "<strong>Success!</strong> $error";
        $output .= "</div>";

        return $output;
    }

    public static function getBootstrapInfoDisplay($text, $width = "")
    {
        $output = "";

        $style = "";

        if($width != "")
        {
            $style = "style='width: $width;'";
        }

        $output .= "<div class='alert alert-info' $style>";
        $output .= $text;
        $output .= "</div>";

        return $output;
    }

    public static function getBootstrapAlertDisplay($text, $width = "")
    {
        $output = "";

        $style = "";

        if($width != "")
        {
            $style = "style='width: $width;'";
        }

        $output .= "<div class='alert' $style>";
        $output .= $text;
        $output .= "</div>";

        return $output;
    }

    private static function getDisplay($resultText = "", $containerId = "", $fade = true, $class = "action_message")
    {
        $output = "";

        if($resultText == "")
        {
            $resultText = "Changes have been saved";
        }

        if($containerId == "")
        {
            $containerId = "con_".time();
        }

        $output .= "<div id='$containerId' class='$class'>$resultText</div>";

        if($fade)
        {
            $output .= "<script>";
            $output .= "$('#$containerId').fadeOut(3000);";
            $output .= "</script>";
        }

        return $output;
    }

}

?>
