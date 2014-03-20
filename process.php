<?php

require_once 'autoload.php';


if(isset($_REQUEST['action']))
{
    switch($_REQUEST['action'])
    {
//        case "generateStructure":
//            $tableStructureLogicUtility = new TableStructureLogicUtility();
//            $tableStructureLogicUtility->generateStructure($_REQUEST['directory'], $_REQUEST['host'], $_REQUEST['url'],
//                    $_REQUEST['database'], $_REQUEST['user'], $_REQUEST['password']);
//            break;

	case "generateStructure":
	    ApplicationGeneratorGuiUtility::generateApplication(RequestHelper::getRequestValue("directory"),
		    RequestHelper::getRequestValue("host"), RequestHelper::getRequestValue("url"),
		    RequestHelper::getRequestValue("database"), RequestHelper::getRequestValue("user"),
		    RequestHelper::getRequestValue("password"), RequestHelper::getRequestValue("overwrite"),
		    RequestHelper::getRequestValue("overwrite_folder"));
	    break;
    }
}
else
{
    echo "Action not defined.";
}
