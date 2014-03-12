<?php

require_once '../../../autoload.php';

$compressor = new compressor(array('page, javascript, css'));

session_start();

$data = HomeGuiUtility::getDisplay();
$leftData = HomeGuiUtility::getLeftDisplay();
$templateGuiUtility = new TemplateGuiUtility();

echo $templateGuiUtility->getNormalDisplay("Home Page", $leftData, $data, Navigation::$HOME_LINK);

$compressor->finish();

?>