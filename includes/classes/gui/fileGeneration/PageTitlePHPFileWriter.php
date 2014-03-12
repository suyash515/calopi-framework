<?php

/**
 * Description of PageTitlePHPFileWriter
 *
 * @author suyash
 */
class PageTitlePHPFileWriter extends GenericPHPFileWriter
{

    private $tableEntityList;

    public function __construct($folder, $fileName, $tableEntityList)
    {
        parent::initialise($folder, $fileName, GenericFileWriter::$PHP_EXTENSION);

        $this->tableEntityList = $tableEntityList;
    }

    public function createFile()
    {
        $this->appendFunctions();

        parent::createFile();
    }

    protected function appendFunctions()
    {
        $this->appendPhpFileOpening();
        $this->appendClassStart();
        $this->appendVariables();
        $this->appendClassEnd();
        $this->appendPhpFileClosing();
    }

    protected function appendVariables()
    {
        for($i = 0; $i < count($this->tableEntityList); $i++)
        {
            $tableName = $this->tableEntityList[$i]->getTableName();
            $staticVariableName = PageTitlePHPFileWriter::getVariableForPageTitle($tableName);
            $entityName = TextUtility::formatReadText($tableName);

            $this->addContent("public static $staticVariableName = \"$entityName\";");
        }
    }

    public static function getVariableForPageTitle($tableName)
    {
        return GenericPHPFileWriter::createVariable(TextUtility::formatStaticVariable($tableName));
    }

}

?>
