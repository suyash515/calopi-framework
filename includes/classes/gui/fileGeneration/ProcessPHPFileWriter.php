<?php

/**
 * Description of ProcessPHPFileWriter
 *
 * @author suyash
 */
class ProcessPHPFileWriter extends GenericPHPFileWriter
{

    private $applicationEntity;
    private $tableEntityList;

    public function __construct($folder, $fileName, ApplicationEntity $applicationEntity, $tableEntityList)
    {
        parent::initialise($folder, $fileName, GenericFileWriter::$PHP_EXTENSION);

        $this->applicationEntity = $applicationEntity;
        $this->tableEntityList = $tableEntityList;
    }

    public function createFile()
    {
        $this->appendSwitchCases();

        $this->replace();
        $this->replaceContents();
    }

    protected function replace()
    {
        $str = file_get_contents($this->getFullFileName());

        $this->contents = str_replace(Configuration::$PROCESS_TEXT_REPLACEMENT_DIRECTORY, $this->contents, $str);
    }

    protected function appendSwitchCases()
    {
        $this->indent();

        for($i = 0; $i < count($this->tableEntityList); $i++)
        {
            $tableEntity = $this->tableEntityList[$i];
            $tableName = $this->tableEntityList[$i]->getTableName();

            $entityName = TextUtility::formatReadText($tableName);
            $guiClassName = PHPFileWriterManager::getGuiName($tableName);

            $this->addComment("///////////////////////$entityName///////////////////////");
            $this->appendSwitchGetAddCase($guiClassName, $tableEntity);
            $this->addEmptyLine();
            $this->appendSwitchAddCase($guiClassName, $tableEntity);
            $this->addEmptyLine();
            $this->appendSwitchGetEditCase($guiClassName, $tableEntity);
            $this->addEmptyLine();
            $this->appendSwitchEditCase($guiClassName, $tableEntity);
            $this->addEmptyLine();
            $this->appendSwitchGetDeleteCase($guiClassName, $tableEntity);
            $this->addEmptyLine();
            $this->appendSwitchDeleteCase($guiClassName, $tableEntity);
            $this->addEmptyLine();
            $this->appendSwitchGetClearAddCase($guiClassName, $tableEntity);
            $this->addComment("///////////////////////end of $entityName///////////////////////");
            $this->addEmptyLine();
        }

        $this->unIndent();
    }

    protected function appendSwitchGetAddCase($guiClassName, TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $getGetAddFunctionName = ScriptJavascriptFileWriter::getGetAddFunctionName($tableName);
        $guiAddFunctionName = BaseGuiPHPFileWriter::getGetAddFunctionName($tableName);
        $guiAddParameterList = $tableEntity->getCommaNonAutoParameterList();

        $this->addContent("case \"$getGetAddFunctionName\":");
        $this->indent();
        $this->addContent("echo $guiClassName::$guiAddFunctionName($guiAddParameterList);");
        $this->unIndent();
        $this->addContent("break;");
    }

    protected function appendSwitchAddCase($guiClassName, TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $getAddFunctionName = ScriptJavascriptFileWriter::getAddFunctionName($tableName);
        $guiAddFunctionName = BaseGuiPHPFileWriter::getAddFunctionName($tableName);
        $guiAddParameterList = $tableEntity->getCommaNonAutoParameterList();

        $this->addContent("case \"$getAddFunctionName\":");
        $this->indent();
        $this->addContent("echo $guiClassName::$guiAddFunctionName($guiAddParameterList);");
        $this->unIndent();
        $this->addContent("break;");
    }

    protected function appendSwitchGetEditCase($guiClassName, TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $getGetEditFunctionName = ScriptJavascriptFileWriter::getGetEditFunctionName($tableName);
        $guiEditFunctionName = BaseGuiPHPFileWriter::getGetEditFunctionName($tableName);
        $guiAddParameterList = $tableEntity->getPhpCommaPrimaryParameterList();

        $this->addContent("case \"$getGetEditFunctionName\":");
        $this->indent();
        $this->addContent("echo $guiClassName::$guiEditFunctionName($guiAddParameterList);");
        $this->unIndent();
        $this->addContent("break;");
    }

    protected function appendSwitchEditCase($guiClassName, TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $getGetEditFunctionName = ScriptJavascriptFileWriter::getEditFunctionName($tableName);
        $guiEditFunctionName = BaseGuiPHPFileWriter::getEditFunctionName($tableName);
        $guiAddParameterList = $tableEntity->getCommaAllParameterList();

        $this->addContent("case \"$getGetEditFunctionName\":");
        $this->indent();
        $this->addContent("echo $guiClassName::$guiEditFunctionName($guiAddParameterList);");
        $this->unIndent();
        $this->addContent("break;");
    }

    protected function appendSwitchGetDeleteCase($guiClassName, TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $getGetDeleteFunctionName = ScriptJavascriptFileWriter::getGetDeleteFunctionName($tableName);
        $guiDeleteFunctionName = BaseGuiPHPFileWriter::getGetDeleteFunctionName($tableName);
        $guiAddParameterList = $tableEntity->getPhpCommaPrimaryParameterList();

        $this->addContent("case \"$getGetDeleteFunctionName\":");
        $this->indent();
        $this->addContent("echo $guiClassName::$guiDeleteFunctionName($guiAddParameterList);");
        $this->unIndent();
        $this->addContent("break;");
    }

    protected function appendSwitchDeleteCase($guiClassName, TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $getDeleteFunctionName = ScriptJavascriptFileWriter::getDeleteFunctionName($tableName);
        $guiDeleteFunctionName = BaseGuiPHPFileWriter::getDeleteFunctionName($tableName);
        $guiAddParameterList = $tableEntity->getPhpCommaPrimaryParameterList();

        $this->addContent("case \"$getDeleteFunctionName\":");
        $this->indent();
        $this->addContent("echo $guiClassName::$guiDeleteFunctionName($guiAddParameterList);");
        $this->unIndent();
        $this->addContent("break;");
    }

    protected function appendSwitchGetClearAddCase($guiClassName, TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $getClearAddFunctionName = ScriptJavascriptFileWriter::getClearAddFunctionName($tableName);
        $guiClearAddFunctionName = BaseGuiPHPFileWriter::getClearAddFunctionName($tableName);
        $guiAddParameterList = $tableEntity->getPhpCommaPrimaryParameterList();

        $this->addContent("case \"$getClearAddFunctionName\":");
        $this->indent();
        $this->addContent("echo $guiClassName::$guiClearAddFunctionName($guiAddParameterList);");
        $this->unIndent();
        $this->addContent("break;");
    }

}

?>
