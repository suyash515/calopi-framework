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
	    $staticVariableNameForList = PageTitlePHPFileWriter::getVariableForPageTitle($tableName);
	    $staticVariableNameForAdd = PageTitlePHPFileWriter::getVariableForAddPageTitle($tableName);
	    $staticVariableNameForEdit = PageTitlePHPFileWriter::getVariableForEditPageTitle($tableName);

	    $entityListName = PageTitlePHPFileWriter::getListTitle($tableName);
	    $entityAddName = PageTitlePHPFileWriter::getAddTitle($tableName);
	    $entityEditName = PageTitlePHPFileWriter::getEditTitle($tableName);

	    $this->addContent("public static $staticVariableNameForList = \"$entityListName\";");
	    $this->addContent("public static $staticVariableNameForAdd = \"$entityAddName\";");
	    $this->addContent("public static $staticVariableNameForEdit = \"$entityEditName\";");
	}
    }

    public static function getListTitle($tableName)
    {
	$entityName = TextUtility::formatReadText($tableName);

	return $entityName." ".Configuration::$ENTITY_TITLE_LIST_SUFFIX;
    }

    public static function getAddTitle($tableName)
    {
	$entityName = TextUtility::formatReadText($tableName);

	return Configuration::$ENTITY_TITLE_ADD_PREFIX." ".$entityName;
    }

    public static function getEditTitle($tableName)
    {
	$entityName = TextUtility::formatReadText($tableName);

	return Configuration::$ENTITY_TITLE_EDIT_PREFIX." ".$entityName;
    }

    public static function getVariableForPageTitle($tableName)
    {
	return GenericPHPFileWriter::createVariable(TextUtility::formatStaticVariable($tableName));
    }

    public static function getVariableForAddPageTitle($tableName)
    {
	return GenericPHPFileWriter::createVariable(strtoupper(Configuration::$ENTITY_TITLE_ADD_PREFIX)."_".TextUtility::formatStaticVariable($tableName));
    }

    public static function getVariableForEditPageTitle($tableName)
    {
	return GenericPHPFileWriter::createVariable(strtoupper(Configuration::$ENTITY_TITLE_EDIT_PREFIX)."_".TextUtility::formatStaticVariable($tableName));
    }
}

?>
