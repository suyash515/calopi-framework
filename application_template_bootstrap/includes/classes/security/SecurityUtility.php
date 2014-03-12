<?php

abstract class SecurityUtility
{

    public function __construct()
    {

    }

    public function getIllegalAccessError()
    {
        $output = "";

        $output .= "<div class='genericElement error'>";
        $output .= "An error occurred while retrieving the details. Please try again. If the problem persists, try logging in again. If the problem is not resolved, please contact the administrator.";
        $output .= "</div>";

        return $output;
    }

}

?>