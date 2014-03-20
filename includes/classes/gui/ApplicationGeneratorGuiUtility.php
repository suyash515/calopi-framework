<?php

require_once './includes/classes/gui/utilities/FrameworkCopyGuiUtility.php';


/**
 * Description of ApplicationGenerator
 *
 * @author suyash
 */
class ApplicationGeneratorGuiUtility
{

    public static function generateApplication($directory, $host, $url, $database, $user, $password)
    {
	$output = "";

	$databaseEntity = new DatabaseEntity($host, $database, $user, $password);
	$applicationEntity = new ApplicationEntity($directory, $url, $databaseEntity);

	$tableEntityList = DatabaseStructureManager::getDatabaseStructure($applicationEntity);

	FolderManager::initialiseDirectory($directory, $tableEntityList);

	UpdateManagerGuiUtility::addSection("Template Copy");
	UpdateManagerGuiUtility::addUpdate("Template copy started");
	ApplicationGeneratorGuiUtility::copyFrameworkTemplate($directory);
	UpdateManagerGuiUtility::addUpdate("Template copy completed");

	UpdateManagerGuiUtility::addSection("File Generation");
	UpdateManagerGuiUtility::addUpdate("File generation Started");
	ApplicationGeneratorGuiUtility::generateFiles($applicationEntity, $tableEntityList);
	UpdateManagerGuiUtility::addUpdate("File generation Completed");

	ApplicationGeneratorGuiUtility::changeFilePermissions($directory);

	return $output;
    }

    private static function changeFilePermissions($directory)
    {
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

	foreach($iterator as $item)
	{
	    chmod($item, 0777);
	}
    }

    /**
     * Copies the static files into directory
     */
    private static function copyFrameworkTemplate($directory)
    {
	$output = "";

	$source = Configuration::getFrameworkTemplateDirectory();

	FrameworkCopyGuiUtility::smartCopy($source, $directory);

	return $output;
    }

    private static function generateFiles(ApplicationEntity $applicationEntity, $tableEntityList)
    {
	$output = "";

	FileWriterManager::writeFiles($tableEntityList, $applicationEntity);

	return $output;
    }
}

?>
