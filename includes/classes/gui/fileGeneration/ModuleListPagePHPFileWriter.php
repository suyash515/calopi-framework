<?php


/**
 * Description of ModulePagePHPFileWriter
 *
 * @author suyash
 */
class ModuleListPagePHPFileWriter extends GenericPHPFileWriter
{

    private $tableEntity;

    public function __construct($folder, $fileName, TableEntity $tableEntity)
    {
	parent::initialise($folder, $fileName, GenericFileWriter::$PHP_EXTENSION);

	$this->tableEntity = $tableEntity;
    }

    public function createFile()
    {
	$this->appendContent();

	parent::createFile();
    }

    protected function appendContent()
    {
	$this->appendPhpFileOpening();
	$this->appendDisplayPage();
	$this->appendPhpFileClosing();
    }

    protected function appendDisplayPage()
    {
	$tableName = $this->tableEntity->getTableName();
	$guiClassName = PHPFileWriterManager::getGuiName($tableName);
	$displayFunctionName = BaseGuiPHPFileWriter::getDisplayFunctionName();
	$staticVariableName = PageTitlePHPFileWriter::getVariableForPageTitle($tableName);

	$this->addContent("require_once '../../../autoload.php';");
	$this->addEmptyLine();
	$this->addContent("\$compressor = new compressor(array('page, javascript, css'));");
	$this->addEmptyLine();
	$this->addContent("session_start();");
	$this->addEmptyLine();
	$this->addContent("\$templateGuiUtility = new BootstrapTemplateGuiUtility();");
	$this->addEmptyLine();
	$this->addContent("\$mainContent = $guiClassName::$displayFunctionName();");
	$this->addContent("echo \$templateGuiUtility->getNormalDisplay(PageTitle::$staticVariableName, \$mainContent);");
	$this->addEmptyLine();
	$this->addContent("\$compressor->finish();");
    }
}

?>
