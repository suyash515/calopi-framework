<?php

/**
 * Description of HomeGuiUtility
 *
 * @author suyash
 */
class HomeGuiUtility
{

    public static function getDisplay()
    {
        $output = "";

        $output .= "<h2>Description</h2>";

        $output .= "<div class='products_box'>";
        $output .= "<p>Calopi Framework is a framework very easy to setup. It is easy to setup the basic add/edit/delete
            functionalities for an application based on a mysql database.</p>";

        $output .= "<p>The aim behind this framework is to create a structure that you can easily change. Everyone of
            us has a different way of working and structuring a web application. You can change this framework at will
            to generate your own source code, with your own preferences.</p>";
        $output .= "</div>";

        return $output;
    }

    public static function getLeftDisplay()
    {
        $output = "";

        $output .= "<p>Websites created using this framework:</p>";

        $output .= "<ul>";
        $output .= "<li>";
        $output .= "<a href='http://www.calopi.com' target='_blank'>calopi</a>";
        $output .= "</li>";


        $output .= "<li>";
        $output .= "<a href='http://www.barterkick.com' target='_blank'>barterkick</a>";
        $output .= "</li>";

        $output .= "<li>";
        $output .= "<a href='http://www.openingclosingtimes.com' target='_blank'>opening closing times</a>";
        $output .= "</li>";
        $output .= "</ul>";

        return $output;
    }

}

?>
