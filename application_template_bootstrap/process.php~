<?php

require_once 'autoload.php';

$compressor = new compressor(array('page, javascript, css'));

session_start();

$variableChecker = new VariableChecker();

//start of sanitize user input
foreach($_REQUEST as $index => $value)
{
    $_REQUEST[$index] = $variableChecker->sanitizeInput($value);
}
//end of sanitize user input


if(isset($_REQUEST['action']))
{
    switch($_REQUEST['action'])
    {
//#enter_switch_case_here

        default:
            echo "An error occurred. Please try again. If the problem persists, please contact the site administrator.";
    }
}
else
{
    echo "Action not defined.";
}

$compressor->finish();

?>
