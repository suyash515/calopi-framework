<?php

/**
 * Description of HeaderTextGuiUtility
 *
 * @author suyash
 */
class HeaderTextGuiUtility
{

    public static function getHeaderDisplay($title)
    {
        $output = "";

        $output .= "<div class='page-header'>";
        $output .= "<h1 style='text-align: center;'>$title</h1>";
        $output .= "</div>";

        return $output;
    }

    public static function getHeaderDisplayWithoutUnderLine($title, $customStyle = "", $pageHeaderCustomStyle = "")
    {
        $output = "";

        if($customStyle == "")
        {
            $customStyle = "text-align: center;";
        }

        $output .= "<div class='page-header' style='border-bottom: none;$pageHeaderCustomStyle'>";
        $output .= "<h1 style='$customStyle'>$title</h1>";
        $output .= "</div>";

        return $output;
    }

}

?>
