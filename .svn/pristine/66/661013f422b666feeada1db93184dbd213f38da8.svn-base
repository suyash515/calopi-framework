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
    public static function writeFiles($tableEntityList, ApplicationEntity $applicationEntity)
    {
        PHPFileWriterManager::createPhpFiles($tableEntityList, $applicationEntity);
        JavascriptFileWriterManager::createJavascriptFiles($tableEntityList, $applicationEntity);
    }

}

?>
