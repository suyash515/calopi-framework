<?php


/**
 * Description of PHPFileWriterManager
 *
 * @author suyash
 */
class PHPFileWriterManager
{

    /**
     *
     * @param type $tableEntityList - Array of TableEntity objects
     */
    public static function createPhpFiles($tableEntityList, ApplicationEntity $applicationEntity, $overwrite)
    {
	$phpWriterObjectArray = PHPFileWriterManager::initialisePhpFiles($tableEntityList, $applicationEntity, $overwrite);
	PHPFileWriterManager::createFiles($phpWriterObjectArray);
    }

    private static function initialisePhpFiles($tableEntityList, ApplicationEntity $applicationEntity, $overwrite)
    {
	$phpFileWriterArray = array();
	$phpBaseGuiClassFolder = FolderManager::getBaseGuiFolder();
	$phpBaseLogicClassFolder = FolderManager::getBaseLogicFolder();
	$phpBaseEntityClassFolder = FolderManager::getBaseEntityFolder();
	$phpBaseValidatorClassFolder = FolderManager::getBaseValidatorFolder();

	$phpModelGuiClassFolder = FolderManager::getModelGuiFolder();
	$phpEntityClassFolder = FolderManager::getEntityFolder();
	$phpManagerClassFolder = FolderManager::getManagerFolder();
	$phpConfigurationClassFolder = FolderManager::getConfigurationFolder();
	$phpAutoloadClassFolder = FolderManager::getAutoloadFolder();
	$phpProcessClassFolder = FolderManager::getProcessFolder();
	$phpGuiNavigationClassFolder = FolderManager::getGuiNavigationFolder();
	$phpLogicClassFolder = FolderManager::getModelLogicFolder();

	for($i = 0; $i < count($tableEntityList); $i++)
	{
	    $tableName = $tableEntityList[$i]->getTableName();

	    $baseGuiFileName = PHPFileWriterManager::getBaseGuiName($tableName);
	    $guiFileName = PHPFileWriterManager::getGuiName($tableName);
	    $baseLogicFileName = PHPFileWriterManager::getBaseLogicName($tableName);
	    $logicFileName = PHPFileWriterManager::getLogicName($tableName);
	    $baseEntityFileName = PHPFileWriterManager::getBaseEntityName($tableName);
	    $entityFileName = PHPFileWriterManager::getEntityName($tableName);
	    $baseValidatorFileName = PHPFileWriterManager::getValidatorName($tableName);
	    $managerFileName = PHPFileWriterManager::getManagerName($tableName);
	    $phpModuleListPageFileName = PHPFileWriterManager::getModuleListPageName($tableName);
	    $phpModuleAddPageFileName = PHPFileWriterManager::getModuleAddPageName($tableName);
	    $phpModuleAddProcessorPageFileName = PHPFileWriterManager::getModuleAddProcessorPageName($tableName);
	    $phpModuleEditPageFileName = PHPFileWriterManager::getModuleEditPageName($tableName);
	    $phpModuleEditProcessorPageFileName = PHPFileWriterManager::getModuleEditProcessorPageName($tableName);

	    $phpModulePageFolder = FolderManager::getModulePageFolder($tableName);

	    $phpFileWriterArray[count($phpFileWriterArray)] = new BaseGuiPHPFileWriter($phpBaseGuiClassFolder,
		    $baseGuiFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new GuiPHPFileWriter($phpModelGuiClassFolder, $guiFileName,
		    $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new BaseLogicPHPFileWriter($phpBaseLogicClassFolder,
		    $baseLogicFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new LogicPHPFileWriter($phpLogicClassFolder, $logicFileName,
		    $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new BaseEntityPhpFileWriter($phpBaseEntityClassFolder,
		    $baseEntityFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new BaseValidatorPHPFileWriter($phpBaseValidatorClassFolder,
		    $baseValidatorFileName, $tableEntityList[$i]);

	    $phpFileWriterArray[count($phpFileWriterArray)] = new EntityPhpFileWriter($phpEntityClassFolder, $entityFileName,
		    $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ManagerPHPFileWriter($phpManagerClassFolder,
		    $managerFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ModuleListPagePHPFileWriter($phpModulePageFolder,
		    $phpModuleListPageFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ModuleAddPagePHPFileWriter($phpModulePageFolder,
		    $phpModuleAddPageFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ModuleAddProcessorPagePHPFileWriter($phpModulePageFolder,
		    $phpModuleAddProcessorPageFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ModuleEditPagePHPFileWriter($phpModulePageFolder,
		    $phpModuleEditPageFileName, $tableEntityList[$i]);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ModuleEditProcessorPagePHPFileWriter($phpModulePageFolder,
		    $phpModuleEditProcessorPageFileName, $tableEntityList[$i]);
	}

	$configurationFileName = PHPFileWriterManager::getConfigurationName();
	$autoloadFileName = PHPFileWriterManager::getAutoloadFileName();
	$processFileName = PHPFileWriterManager::getProcessFileName();
	$pageTitleFileName = PHPFileWriterManager::getPageTitleFileName();
	$navigationFileName = PHPFileWriterManager::getNavigationFileName();
	$bootstrapNavigationFileName = PHPFileWriterManager::getBootstrapNavigationFileName();

	if(!$overwrite)
	{
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ConfigurationPHPFileWriter($phpConfigurationClassFolder,
		    $configurationFileName, $applicationEntity);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new AutoloadPHPFileWriter($phpAutoloadClassFolder,
		    $autoloadFileName, $applicationEntity);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new ProcessPHPFileWriter($phpProcessClassFolder,
		    $processFileName, $applicationEntity, $tableEntityList);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new PageTitlePHPFileWriter($phpGuiNavigationClassFolder,
		    $pageTitleFileName, $tableEntityList);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new NavigationPHPFileWriter($phpGuiNavigationClassFolder,
		    $navigationFileName, $tableEntityList);
	    $phpFileWriterArray[count($phpFileWriterArray)] = new BootstrapNavigationPHPFileWriter($phpGuiNavigationClassFolder,
		    $bootstrapNavigationFileName, $tableEntityList);
	}

	return $phpFileWriterArray;
    }

    private static function createFiles($phpFileWriterArray)
    {
	for($i = 0; $i < count($phpFileWriterArray); $i++)
	{
	    $phpFileWriterArray[$i]->createFile();
	}
    }

    public static function getBaseGuiName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = Configuration::$BASE_SUFFIX.$fileName.Configuration::$GUI_SUFFIX;

	return $fileName;
    }

    public static function getGuiName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = $fileName.Configuration::$GUI_SUFFIX;

	return $fileName;
    }

    public static function getBaseLogicName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = Configuration::$BASE_SUFFIX.$fileName.Configuration::$LOGIC_SUFFIX;

	return $fileName;
    }

    public static function getLogicName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = $fileName.Configuration::$LOGIC_SUFFIX;

	return $fileName;
    }

    public static function getBaseEntityName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = Configuration::$BASE_SUFFIX.$fileName.Configuration::$ENTITY_SUFFIX;

	return $fileName;
    }

    public static function getEntityName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = $fileName.Configuration::$ENTITY_SUFFIX;

	return $fileName;
    }

    public static function getValidatorName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = Configuration::$BASE_SUFFIX.$fileName.Configuration::$VALIDATOR_SUFFIX;

	return $fileName;
    }

    public static function getManagerName($tableName)
    {
	$fileName = TextUtility::formatFileName($tableName);

	$fileName = $fileName.Configuration::$MANAGER_SUFFIX;

	return $fileName;
    }

    public static function getModuleListPageName($tableName)
    {
	$fileName = TextUtility::formatVariableName($tableName).Configuration::$ENTITY_LIST_SUFFIX;

	return $fileName;
    }

    public static function getModuleAddPageName($tableName)
    {
	$fileName = Configuration::$ENTITY_ADD_PREFIX.TextUtility::formatVariableNameWithFirstLetterCapitalised($tableName);

	return $fileName;
    }

    public static function getModuleAddProcessorPageName($tableName)
    {
	$fileName = Configuration::$ENTITY_ADD_PREFIX.TextUtility::formatVariableNameWithFirstLetterCapitalised($tableName).Configuration::$ENTITY_ADD_SUFFIX;

	return $fileName;
    }

    public static function getModuleEditPageName($tableName)
    {
	$fileName = Configuration::$ENTITY_EDIT_PREFIX.TextUtility::formatVariableNameWithFirstLetterCapitalised($tableName);

	return $fileName;
    }

    public static function getModuleEditProcessorPageName($tableName)
    {
	$fileName = Configuration::$ENTITY_EDIT_PREFIX.TextUtility::formatVariableNameWithFirstLetterCapitalised($tableName).Configuration::$ENTITY_EDIT_SUFFIX;

	return $fileName;
    }

    public static function getAutoloadFileName()
    {
	return Configuration::$AUTOLOAD_FILE_NAME;
    }

    public static function getProcessFileName()
    {
	return Configuration::$PROCESS_FILE_NAME;
    }

    public static function getPageTitleFileName()
    {
	return Configuration::$PAGE_TITLE_FILE_NAME;
    }

    public static function getNavigationFileName()
    {
	return Configuration::$NAVIGATION_FILE_NAME;
    }

    public static function getBootstrapNavigationFileName()
    {
	return Configuration::$BOOTSTRAP_NAVIGATION_FILE_NAME;
    }

    public static function getConfigurationName()
    {
	return Configuration::$CONFIGURATION_CLASS_NAME;
    }
}

?>
