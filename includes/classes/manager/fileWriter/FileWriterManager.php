<?php


/**
 * Description of FileWriterManager
 *
 * @author suyash
 */
class FileWriterManager
{

    /**
     *
     * @param type $tableEntityList - Array of TableEntity objects
     */
    public static function writeFiles($tableEntityList, ApplicationEntity $applicationEntity, $overwrite)
    {
	PHPFileWriterManager::createPhpFiles($tableEntityList, $applicationEntity, $overwrite);
	JavascriptFileWriterManager::createJavascriptFiles($tableEntityList, $applicationEntity);
    }
}

?>
