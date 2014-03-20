<?php

require_once './includes/classes/gui/utilities/FrameworkCopyGuiUtility.php';


/**
 * Description of ApplicationGenerator
 *
 * @author suyash
 */
class ApplicationGeneratorGuiUtility
{

    private static $INITIAL_FOLDER = "";

    public static function generateApplication($directory, $host, $url, $database, $user, $password, $overwrite,
	    $overwriteFolder)
    {
	$output = "";

	ini_set("display_errors", 1); //debug

	$boolOverwrite = ($overwrite == IndexGuiUtility::$GENERATION_MODE_EMPTY);

//	if($boolOverwrite)
//	{
//	    ApplicationGeneratorGuiUtility::$INITIAL_FOLDER = $directory;
//	    ApplicationGeneratorGuiUtility::clearDirectory($directory);
//	    //clear directory
//	}

	$databaseEntity = new DatabaseEntity($host, $database, $user, $password);
	$applicationEntity = new ApplicationEntity($directory, $url, $databaseEntity);

	$tableEntityList = DatabaseStructureManager::getDatabaseStructure($applicationEntity);

	FolderManager::initialiseDirectory($directory, $tableEntityList);

	UpdateManagerGuiUtility::addSection("Template Copy");
	UpdateManagerGuiUtility::addUpdate("Template copy started");
	ApplicationGeneratorGuiUtility::copyFrameworkTemplate($directory, $boolOverwrite);
	UpdateManagerGuiUtility::addUpdate("Template copy completed");

	UpdateManagerGuiUtility::addSection("File Generation");
	UpdateManagerGuiUtility::addUpdate("File generation Started");
	ApplicationGeneratorGuiUtility::generateFiles($applicationEntity, $tableEntityList, $boolOverwrite);
	UpdateManagerGuiUtility::addUpdate("File generation Completed");

	ApplicationGeneratorGuiUtility::changeFilePermissions($directory);

//	if($boolOverwrite)
//	{
//	    ApplicationGeneratorGuiUtility::overwriteFiles($directory, $overwriteFolder);
//	}

	return $output;
    }

    private static function clearDirectory($path)
    {
	UpdateManagerGuiUtility::addSection("Clearing folder $path");

	if(is_dir($path) === true)
	{
	    $files = array_diff(scandir($path), array('.', '..'));

	    foreach($files as $file)
	    {
		ApplicationGeneratorGuiUtility::clearDirectory(realpath($path).'/'.$file);
	    }

	    UpdateManagerGuiUtility::addUpdate("deleting folder $path");

	    if($path != ApplicationGeneratorGuiUtility::$INITIAL_FOLDER)
	    {
		return rmdir($path);
	    }
	}
	else if(is_file($path) === true)
	{
	    UpdateManagerGuiUtility::addUpdate("deleting file $path");
	    return unlink($path);
	}

	return false;
    }

    private static function changeFilePermissions($directory)
    {
	$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

	foreach($iterator as $item)
	{
	    chmod($item, 0777);
	}
    }

    private static function overwriteFiles($directory, $overwriteFolder)
    {
	if($overwriteFolder != "")
	{

	}
	else
	{
	    UpdateManagerGuiUtility::addUpdate("Overwrite Folder cannot be empty");
	}
    }

    /**
     * Copies the static files into directory
     */
    private static function copyFrameworkTemplate($directory, $boolOverwrite)
    {
	$output = "";

	if($boolOverwrite)
	{
	    $source = Configuration::getEmptyFrameworkTemplateDirectory();
	}
	else
	{
	    $source = Configuration::getFrameworkTemplateDirectory();
	}


	FrameworkCopyGuiUtility::smartCopy($source, $directory);

	return $output;
    }

    private static function generateFiles(ApplicationEntity $applicationEntity, $tableEntityList, $overwrite)
    {
	$output = "";

	FileWriterManager::writeFiles($tableEntityList, $applicationEntity, $overwrite);

	return $output;
    }
}

?>
