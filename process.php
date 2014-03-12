<?php

require_once("./includes/config.php");

require_once './includes/classes/logic/TableStructureLogicUtility.php';


if(isset($_REQUEST['action']))
{
    switch($_REQUEST['action'])
    {
        case "generateStructure":
            $tableStructureLogicUtility = new TableStructureLogicUtility();
            $tableStructureLogicUtility->generateStructure($_REQUEST['directory'], $_REQUEST['host'], $_REQUEST['url'], $_REQUEST['database'], $_REQUEST['user'], $_REQUEST['password']);
            break;
    }
}
else
{
    echo "Action not defined.";
}