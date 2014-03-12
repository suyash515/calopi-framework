<?php

/**
 * Description of GuiPHPFileWriter
 *
 * @author suyash
 */
class GuiPHPFileWriter extends PHPFileWriter
{

    public function __construct($folder, $fileName, TableEntity $tableEntity)
    {
        parent::__construct($folder, $fileName, $tableEntity);
    }

    public function createFile()
    {
        $this->appendFunctions();

        parent::createFile();
    }

    protected function appendFunctions()
    {
        $extendClassName = PHPFileWriterManager::getBaseGuiName($this->tableEntity->getTableName());
        $extendArray = array($extendClassName);

        $this->appendPhpFileOpening();
        $this->appendClassStart($extendArray);
        $this->appendClassEnd();
        $this->appendPhpFileClosing();
    }

}

?>
