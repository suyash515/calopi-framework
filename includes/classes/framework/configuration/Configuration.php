<?php


/**
 * Description of Configuration
 *
 * @author suyash
 */
class Configuration
{

    //project settings
    public static $DEFAULT_URL = "http://localhost/applications/test";
    public static $VERSION = 1;
    //
    //directories
    public static $FRAMEWORK_TEMPLATE_DIRECTORY = "application_template_bootstrap";
    //
    //generation information settings
    public static $ECHO_CONTENTS = false;
    //
    //file prefix/suffix
    public static $GUI_SUFFIX = "GuiUtility";
    public static $LOGIC_SUFFIX = "LogicUtility";
    public static $ENTITY_SUFFIX = "Entity";
    public static $BASE_SUFFIX = "Base";
    public static $VALIDATOR_SUFFIX = "Validator";
    public static $MANAGER_SUFFIX = "Manager";
    //
    //container field prefix/suffix
    public static $TEXTFIELD_PREFIX = "txt";
    public static $COMBO_PREFIX = "cbo";
    //
    //functions prefix/suffix
    public static $ADD_FORM_PREFIX = "getAdd";
    public static $ADD_ACTION_PREFIX = "add";
    public static $GET_LIST_PREFIX = "get";
    public static $GET_LIST_SUFFIX = "List";
    public static $ADD_LOGIC_PREFIX = "add";
    public static $GET_DETAILS_PREFIX = "get";
    public static $GET_DETAILS_SUFFIX = "Details";
    public static $UPDATE_PREFIX = "update";
    public static $DELETE_PREFIX = "delete";
    public static $GET_ENTITY_VALUE_PREFIX = "get";
    public static $VALIDATE_ADD_PREFIX = "validateAdd";
    public static $VALIDATE_EDIT_PREFIX = "validateEdit";
    public static $GET_ENUM_COMBO_PREFIX = "get";
    public static $GET_ENUM_COMBO_SUFFIX = "Combo";
    public static $CLEAR_ADD_FUNCTION_PREFIX = "clearAdd";
    public static $GET_EDIT_FUNCTION_PREFIX = "getEdit";
    public static $GET_GET_ENTITY_VALUE_FUNCTION_PREFIX = "get";
    public static $EDIT_FUNCTION_PREFIX = "edit";
    public static $GET_DELETE_FUNCTION_PREFIX = "getDelete";
    public static $DELETE_FUNCTION_PREFIX = "delete";
    //
    //javascript functions prefix/suffix
    public static $JAVASCRIPT_CLEAR_ADD = "clearAdd";
    public static $JAVASCRIPT_GET_ADD = "getAdd";
    public static $JAVASCRIPT_ADD = "add";
    public static $JAVASCRIPT_GET_EDIT = "getEdit";
    public static $JAVASCRIPT_EDIT = "edit";
    public static $JAVASCRIPT_RELOAD_LIST_PREFIX = "reload";
    public static $JAVASCRIPT_RELOAD_LIST_SUFFIX = "List";
    public static $JAVASCRIPT_GET_DELETE = "getDelete";
    public static $JAVASCRIPT_DELETE = "delete";
    //
    //variable name prefix/suffix
    public static $FIELD_SUFFIX = "FIELD";
    public static $LIMIT_SUFFIX = "LIMIT";
    //
    //container id prefix/suffic
    public static $LIST_CONTAINER_SUFFIX = "list_con";
    public static $ADD_RESULT_CONTAINER_PREFIX = "add";
    public static $ADD_RESULT_CONTAINER_SUFFIX = "con";
    public static $ADD_COMMAND_CONTAINER_PREFIX = "add";
    public static $ADD_COMMAND_CONTAINER_SUFFIX = "com";
    public static $EDIT_FIELD_CONTAINER_PREFIX = "txt";
    public static $ADD_LINK_CONTAINER_SUFFIX = "add_link";
    //
    //class names
    public static $CONFIGURATION_CLASS_NAME = "Configuration";
    public static $PAGE_TITLE_FILE_NAME = "PageTitle";
    public static $NAVIGATION_FILE_NAME = "Navigation";
    public static $BOOTSTRAP_NAVIGATION_FILE_NAME = "BootstrapNavigation";
    //
    //file names
    public static $ENTITY_LIST_SUFFIX = "List";
    public static $ENTITY_ADD_PREFIX = "add";
    public static $ENTITY_ADD_SUFFIX = "Processor";
    public static $ENTITY_EDIT_PREFIX = "edit";
    public static $ENTITY_EDIT_SUFFIX = "Processor";
    //
    //page titles
    public static $ENTITY_TITLE_ADD_PREFIX = "Add";
    public static $ENTITY_TITLE_EDIT_PREFIX = "Edit";
    public static $ENTITY_TITLE_LIST_SUFFIX = "List";
    //autoload
    public static $AUTOLOAD_TEXT_REPLACEMENT_DIRECTORY = "#enter_directory_here";
    public static $AUTOLOAD_FILE_NAME = "autoload";
    //
    //process
    public static $PROCESS_TEXT_REPLACEMENT_DIRECTORY = "//#enter_switch_case_here";
    public static $PROCESS_FILE_NAME = "process";
    //
    //javascript
    public static $JAVASCRIPT_FILE_NAME = "script";
    //
    //php function names
    public static $GET_SPECIFIC_DETAILS_FUNCTION_NAME = "getSpecificDetails";
    public static $UPDATE_SPECIFIC_FIELD_FUNCTION_NAME = "updateSpecificField";

    public static function getDefaultDirectory()
    {
	$s = DIRECTORY_SEPARATOR;

	$defaultDirectory = $s."opt".$s."lampp".$s."htdocs".$s."applications".$s."test".$s;

	return $defaultDirectory;
    }

    public static function getFrameworkTemplateDirectory()
    {
	return Configuration::$FRAMEWORK_TEMPLATE_DIRECTORY.DIRECTORY_SEPARATOR;
    }
}

?>
