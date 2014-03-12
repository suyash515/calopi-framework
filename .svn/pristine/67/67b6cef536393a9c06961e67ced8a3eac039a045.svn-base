<?php

/**
 * Description of UpdateManagerGuiUtility
 *
 * @author suyash
 */
class UpdateManagerGuiUtility
{

    private static $UPDATE_TEXT = "";

    public static function addSection($sectionText)
    {
        $output = "<div class=''>$sectionText</div>";

        UpdateManagerGuiUtility::addContents($output);
    }

    public static function addSubSection($sectionText)
    {
        $output = "<div class=''>$sectionText</div>";

        UpdateManagerGuiUtility::addContents($output);
    }

    public static function addUpdate($updateText)
    {
        $output = "<div class=''>$updateText</div>";

        UpdateManagerGuiUtility::addContents($output);
    }

    private static function addContents($output)
    {
        UpdateManagerGuiUtility::flushContents($output);

        UpdateManagerGuiUtility::$UPDATE_TEXT .= $output;
    }

    private static function flushContents($output)
    {
        if(Configuration::$ECHO_CONTENTS)
        {
            echo $output;
        }
    }

}

?>
