<?php


class EntityPhpFileWriter extends PHPFileWriter
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
	$extendClassName = PHPFileWriterManager::getBaseEntityName($this->tableEntity->getTableName());
	$extendArray = array($extendClassName);

	$this->appendPhpFileOpening();
	$this->appendClassStart($extendArray);
	$this->appendClassEnd();
	$this->appendPhpFileClosing();
    }
}

?>