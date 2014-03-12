<?php


class Navigation
{
    public static $HOME_LINK = "home";
    public static $APPLICATION_LINK = "application";

    public static function getNavigationDisplay($navigation)
    {
        $output = "";

        $homeCurrent = "";
        $applicationCurrent = "";

        if($navigation == Navigation::$HOME_LINK)
        {
            $homeCurrent = "current";
        }
        elseif($navigation == Navigation::$APPLICATION_LINK)
        {
            $applicationCurrent = "current";
        }

        $output .= "<ul>";
        $output .= "<li><a class='$homeCurrent' href='".UrlConfiguration::getUrl("home", "home")."' title='home'>home</a></li>";
        $output .= "<li><a class='$applicationCurrent' href='".UrlConfiguration::getRootPagesUrl("index.php")."' title=''>application</a></li>";
        $output .= "</ul>";

        return $output;
    }
}

?>