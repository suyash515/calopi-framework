<?php

/**
 * Description of JavascriptFileWriterManager
 *
 * @author suyash
 */
class JavascriptFileWriterManager
{

    /**
     *
     * @param type $tableEntityList - Array of TableEntity objects
     */
    public static function createJavascriptFiles($tableEntityList, ApplicationEntity $applicationEntity)
    {
        $javascriptWriterObjectArray = JavascriptFileWriterManager::initialiseJavascriptFiles($tableEntityList,
                        $applicationEntity);
        JavascriptFileWriterManager::createFiles($javascriptWriterObjectArray);
    }

    private static function initialiseJavascriptFiles($tableEntityList, ApplicationEntity $applicationEntity)
    {
        $javascriptFileWriterArray = array();
        $javascriptFolder = FolderManager::getJavascriptFolder();

        $javascriptFileName = JavascriptFileWriterManager::getJavascriptName();

        $javascriptFileWriterArray[count($javascriptFileWriterArray)] = new ScriptJavascriptFileWriter($javascriptFolder, $javascriptFileName, $tableEntityList);

        return $javascriptFileWriterArray;
    }

    private static function createFiles($javascriptFileWriterArray)
    {
        for($i = 0; $i < count($javascriptFileWriterArray); $i++)
        {
            $javascriptFileWriterArray[$i]->createFile();
        }
    }

    public static function getJavascriptName()
    {
        return Configuration::$JAVASCRIPT_FILE_NAME;
    }

}

?>
