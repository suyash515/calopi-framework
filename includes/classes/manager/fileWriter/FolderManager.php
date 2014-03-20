<?php


/**
 * Description of FolderManager
 *
 * @author suyash
 */
class FolderManager
{

    private static $DIRECTORY = "";

    public static function initialiseDirectory($directory, $tableEntityList)
    {
	FolderManager::$DIRECTORY = $directory;

	FolderManager::createFolders();
	FolderManager::createModulePageFolders($tableEntityList);
    }

    private static function createFolders()
    {
	$arrayFolder = array();
	$arrayFolder[count($arrayFolder)] = FolderManager::getIncludesFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getClassesFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getGuiFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getBaseGuiFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getLogicFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getBaseLogicFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getPagesFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getModulesFolder();
	$arrayFolder[count($arrayFolder)] = FolderManager::getGuiNavigationFolder();

	for($i = 0; $i < count($arrayFolder); $i++)
	{
	    mkdir($arrayFolder[$i]);
	}
    }

    private static function createModulePageFolders($tableEntityList)
    {
	for($i = 0; $i < count($tableEntityList); $i++)
	{
	    $tableEntity = $tableEntityList[$i];
	    $tableName = $tableEntity->getTableName();

	    $folder = FolderManager::getModulePageFolder($tableName);

	    mkdir($folder);
	}
    }

    public static function getModulePageFolder($tableName)
    {
	$s = DIRECTORY_SEPARATOR;

	$moduleFolder = FolderManager::getModulesFolder();

	return $moduleFolder.$s.$tableName;
    }

    private static function getPagesFolder()
    {
	$s = DIRECTORY_SEPARATOR;

	return FolderManager::$DIRECTORY."pages";
    }

    private static function getModulesFolder()
    {
	$s = DIRECTORY_SEPARATOR;

	$pagesFolder = FolderManager::getPagesFolder();

	return $pagesFolder.$s."modules";
    }

    private static function getIncludesFolder()
    {
	$s = DIRECTORY_SEPARATOR;

	$includesFolder = FolderManager::$DIRECTORY."includes";

	return $includesFolder;
    }

    private static function getClassesFolder()
    {
	$includesFolder = FolderManager::getIncludesFolder();

	$s = DIRECTORY_SEPARATOR;

	$classFolder = $includesFolder.$s."classes";

	return $classFolder;
    }

    public static function getGuiNavigationFolder()
    {
	$guiFolder = FolderManager::getGuiFolder();

	$s = DIRECTORY_SEPARATOR;

	$navigationFolder = $guiFolder.$s."navigation";

	return $navigationFolder;
    }

    public static function getAutoloadFolder()
    {
	return FolderManager::$DIRECTORY;
    }

    public static function getProcessFolder()
    {
	return FolderManager::$DIRECTORY;
    }

    public static function getJavascriptFolder()
    {
	$s = DIRECTORY_SEPARATOR;

	return FolderManager::$DIRECTORY."includes".$s."js";
    }

    public static function getConfigurationFolder()
    {
	$classDirectory = FolderManager::getClassesFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."framework".$s."configuration";

	return $guiFolder;
    }

    public static function getGuiFolder()
    {
	$classDirectory = FolderManager::getClassesFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."gui";

	return $guiFolder;
    }

    public static function getModelGuiFolder()
    {
	$classDirectory = FolderManager::getGuiFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."model";

	return $guiFolder;
    }

    public static function getLogicFolder()
    {
	$classDirectory = FolderManager::getClassesFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."logic";

	return $guiFolder;
    }

    public static function getModelLogicFolder()
    {
	$classDirectory = FolderManager::getLogicFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."model";

	return $guiFolder;
    }

    public static function getValidatorFolder()
    {
	$classDirectory = FolderManager::getClassesFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."validator";

	return $guiFolder;
    }

    public static function getBaseGuiFolder()
    {
	$classDirectory = FolderManager::getModelGuiFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."base";

	return $guiFolder;
    }

    public static function getBaseLogicFolder()
    {
	$classDirectory = FolderManager::getModelLogicFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."base";

	return $guiFolder;
    }

    public static function getBaseEntityFolder()
    {
	$classDirectory = FolderManager::getLogicFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."entity".$s."model".$s."base";

	return $guiFolder;
    }

    public static function getEntityFolder()
    {
	$classDirectory = FolderManager::getLogicFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."entity".$s."model";

	return $guiFolder;
    }

    public static function getBaseValidatorFolder()
    {
	$classDirectory = FolderManager::getValidatorFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."model".$s."base";

	return $guiFolder;
    }

    public static function getManagerFolder()
    {
	$classDirectory = FolderManager::getClassesFolder();

	$s = DIRECTORY_SEPARATOR;

	$guiFolder = $classDirectory.$s."manager";

	return $guiFolder;
    }
}

?>
