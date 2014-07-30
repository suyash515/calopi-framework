<?php


/**
 * Description of ModulePagePHPFileWriter
 *
 * @author suyash
 */
class ModuleAddPagePHPFileWriter extends GenericPHPFileWriter
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
	$displayFunctionName = BaseGuiPHPFileWriter::getGetAddFunctionName($tableName);
	$staticVariableName = PageTitlePHPFileWriter::getVariableForAddPageTitle($tableName);

	$this->addContent("require_once '../../../autoload.php';");
	$this->addEmptyLine();
	$this->addContent("\$compressor = new compressor(array('page, javascript, css'));");
	$this->addEmptyLine();
	$this->addContent("session_start();");
	$this->addEmptyLine();
	$this->addContent("if(SessionHelper::isLoggedIn())");
	$this->openCurly();
	$this->addContent("\$templateGuiUtility = new BootstrapTemplateGuiUtility();");
	$this->addEmptyLine();
	$this->addContent("\$mainContent = $guiClassName::$displayFunctionName();");
	$this->addContent("echo \$templateGuiUtility->getNormalDisplay(PageTitle::$staticVariableName, \$mainContent);");
	$this->closeCurly();
	$this->addContent("else");
	$this->openCurly();
	$this->addContent("UrlConfiguration::redirect(UrlConfiguration::getUrl(\"login\", \"login\"));");
	$this->closeCurly();
	$this->addContent("\$compressor->finish();");
    }
}

?>
