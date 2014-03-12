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
    public static function createPhpFiles($tableEntityList, ApplicationEntity $applicationEntity)
    {
        $phpWriterObjectArray = PHPFileWriterManager::initialisePhpFiles($tableEntityList, $applicationEntity);
        PHPFileWriterManager::createFiles($phpWriterObjectArray);
    }

    private static function initialisePhpFiles($tableEntityList, ApplicationEntity $applicationEntity)
    {
        $phpFileWriterArray = array();
        $phpBaseGuiClassFolder = FolderManager::getBaseGuiFolder();
        $phpModelGuiClassFolder = FolderManager::getModelGuiFolder();
        $phpBaseLogicClassFolder = FolderManager::getBaseLogicFolder();
        $phpLogicClassFolder = FolderManager::getModelLogicFolder();
        $phpBaseEntityClassFolder = FolderManager::getBaseEntityFolder();
        $phpBaseValidatorClassFolder = FolderManager::getBaseValidatorFolder();
        $phpConfigurationClassFolder = FolderManager::getConfigurationFolder();
        $phpAutoloadClassFolder = FolderManager::getAutoloadFolder();
        $phpProcessClassFolder = FolderManager::getProcessFolder();
        $phpGuiNavigationClassFolder = FolderManager::getGuiNavigationFolder();

        for($i = 0; $i < count($tableEntityList); $i++)
        {
            $tableName = $tableEntityList[$i]->getTableName();

            $baseGuiFileName = PHPFileWriterManager::getBaseGuiName($tableName);
            $guiFileName = PHPFileWriterManager::getGuiName($tableName);
            $baseLogicFileName = PHPFileWriterManager::getBaseLogicName($tableName);
            $logicFileName = PHPFileWriterManager::getLogicName($tableName);
            $baseEntityFileName = PHPFileWriterManager::getBaseEntityName($tableName);
            $baseValidatorFileName = PHPFileWriterManager::getValidatorName($tableName);
            $phpModulePageFileName = PHPFileWriterManager::getModulePageName($tableName);

            $phpModulePageFolder = FolderManager::getModulePageFolder($tableName);

            $phpFileWriterArray[count($phpFileWriterArray)] = new BaseGuiPHPFileWriter($phpBaseGuiClassFolder, $baseGuiFileName, $tableEntityList[$i]);
            $phpFileWriterArray[count($phpFileWriterArray)] = new GuiPHPFileWriter($phpModelGuiClassFolder, $guiFileName, $tableEntityList[$i]);
            $phpFileWriterArray[count($phpFileWriterArray)] = new BaseLogicPHPFileWriter($phpBaseLogicClassFolder, $baseLogicFileName, $tableEntityList[$i]);
            $phpFileWriterArray[count($phpFileWriterArray)] = new LogicPHPFileWriter($phpLogicClassFolder, $logicFileName, $tableEntityList[$i]);
            $phpFileWriterArray[count($phpFileWriterArray)] = new BaseEntityPhpFileWriter($phpBaseEntityClassFolder, $baseEntityFileName, $tableEntityList[$i]);
            $phpFileWriterArray[count($phpFileWriterArray)] = new BaseValidatorPHPFileWriter($phpBaseValidatorClassFolder, $baseValidatorFileName, $tableEntityList[$i]);
            $phpFileWriterArray[count($phpFileWriterArray)] = new ModulePagePHPFileWriter($phpModulePageFolder, $phpModulePageFileName, $tableEntityList[$i]);
        }

        $configurationFileName = PHPFileWriterManager::getConfigurationName();
        $autoloadFileName = PHPFileWriterManager::getAutoloadFileName();
        $processFileName = PHPFileWriterManager::getProcessFileName();
        $pageTitleFileName = PHPFileWriterManager::getPageTitleFileName();
        $navigationFileName = PHPFileWriterManager::getNavigationFileName();
        $bootstrapNavigationFileName = PHPFileWriterManager::getBootstrapNavigationFileName();

        $phpFileWriterArray[count($phpFileWriterArray)] = new ConfigurationPHPFileWriter($phpConfigurationClassFolder, $configurationFileName, $applicationEntity);
        $phpFileWriterArray[count($phpFileWriterArray)] = new AutoloadPHPFileWriter($phpAutoloadClassFolder, $autoloadFileName, $applicationEntity);
        $phpFileWriterArray[count($phpFileWriterArray)] = new ProcessPHPFileWriter($phpProcessClassFolder, $processFileName, $applicationEntity, $tableEntityList);
        $phpFileWriterArray[count($phpFileWriterArray)] = new PageTitlePHPFileWriter($phpGuiNavigationClassFolder, $pageTitleFileName, $tableEntityList);
        $phpFileWriterArray[count($phpFileWriterArray)] = new NavigationPHPFileWriter($phpGuiNavigationClassFolder, $navigationFileName, $tableEntityList);
        $phpFileWriterArray[count($phpFileWriterArray)] = new BootstrapNavigationPHPFileWriter($phpGuiNavigationClassFolder, $bootstrapNavigationFileName, $tableEntityList);

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

    public static function getValidatorName($tableName)
    {
        $fileName = TextUtility::formatFileName($tableName);

        $fileName = Configuration::$BASE_SUFFIX.$fileName.Configuration::$VALIDATOR_SUFFIX;

        return $fileName;
    }

    public static function getModulePageName($tableName)
    {
        $fileName = TextUtility::formatVariableName($tableName);

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
