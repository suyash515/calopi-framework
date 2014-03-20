<?php

/**
 * Description of BootstrapNavigationPHPFileWriter
 *
 * @author suyash
 */
class BootstrapNavigationPHPFileWriter extends GenericPHPFileWriter
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
        $extendArray = array("Navigation");

        $this->appendPhpFileOpening();
        $this->appendClassStart($extendArray);
        $this->appendGetDisplayFunction();
        $this->appendClassEnd();
        $this->appendPhpFileClosing();
    }

    protected function appendGetDisplayFunction()
    {
        $functionName = BootstrapNavigationPHPFileWriter::getGetDisplayFunctionName();
        $parameterString = "\$selected = \"\"";

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterString);
        $this->openCurly();
        $this->addContent("\$output = \"\";");
        $this->addEmptyLine();

        for($i = 0; $i < count($this->tableEntityList); $i++)
        {
            $tableEntity = $this->tableEntityList[$i];
            $tableName = $tableEntity->getTableName();

            $variableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName."Selected"));

            $this->addContent("$variableName = \"\";");
        }

        $this->addContent("\$homeSelected = \"\";");

        $this->addEmptyLine();

        for($i = 0; $i < count($this->tableEntityList); $i++)
        {
            $tableEntity = $this->tableEntityList[$i];
            $tableName = $tableEntity->getTableName();
            $variableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName."Selected"));
            $staticVariableName = PageTitlePHPFileWriter::getVariableForPageTitle($tableName)."_SELECTED";

            $this->addContent("if(\$selected == Navigation::$staticVariableName)");
            $this->openCurly();
            $this->addContent("$variableName = \"active\";");
            $this->closeCurly();
        }

        $this->addEmptyLine();
        $this->addContent("\$homeLink = \"index.php\";");
        $this->addEmptyLine();
        $this->addContent("\$output .= \"<div class='navbar navbar-fixed-top'>\";");
        $this->addContent("\$output .= \"<div class='navbar-inner'>\";");
        $this->addContent("\$output .= \"<div class='container'>\";");
        $this->addContent("\$output .= \"<button type='button' class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>\";");
        $this->addContent("\$output .= \"<span class='icon-bar'></span>\";");
        $this->addContent("\$output .= \"<span class='icon-bar'></span>\";");
        $this->addContent("\$output .= \"<span class='icon-bar'></span>\";");
        $this->addContent("\$output .= \"</button>\";");
        $this->addContent("\$output .= \"<div class='nav-collapse collapse'>\";");
        $this->addEmptyLine();
        $this->addContent("\$output .= \"<ul class='nav'>\";");
        $this->addContent("\$output .= \"<li class='\$homeSelected' id='li-contact'><a href=\\\"\$homeLink\\\">Home</a></li>\";");
        $this->addEmptyLine();

        for($i = 0; $i < count($this->tableEntityList); $i++)
        {
            $tableName = $this->tableEntityList[$i]->getTableName();
            $url = PHPFileWriterManager::getModuleListPageName($tableName);
            $urlVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName("url_".$tableName));

            $this->addContent("$urlVariable = UrlConfiguration::getUrl(\"$tableName\", \"$url\");");
        }

        $this->addEmptyLine();
        $this->addContent("\$output .= \"<li class='dropdown'>\";");
        $this->addContent("\$output .= \"<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Application <b class='caret'></b></a>\";");
        $this->addContent("\$output .= \"<ul class='dropdown-menu'>\";");
        $this->addEmptyLine();

        for($i = 0; $i < count($this->tableEntityList); $i++)
        {
            $tableName = $this->tableEntityList[$i]->getTableName();
            $entityName = TextUtility::formatReadText($tableName);
            $url = PHPFileWriterManager::getModuleListPageName($tableName);
            $urlVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName("url_".$tableName));
            $variableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName."Selected"));

            $this->addContent("\$output .= \"<li class='$variableName' id='li-analyser'><a href=\\\"$urlVariable\\\">$entityName</a></li>\";");
        }

        $this->addEmptyLine();
        $this->addContent("\$output .= \"</ul>\";");
        $this->addContent("\$output .= \"</ul>\";");
        $this->addEmptyLine();
        $this->addContent("\$output .= \"</div><!--/.nav-collapse -->\";");
        $this->addContent("\$output .= \"</div>\";");
        $this->addContent("\$output .= \"</div>\";");
        $this->addContent("\$output .= \"</div>\";");
        $this->addEmptyLine();
        $this->addContent("return \$output;");
        $this->closeCurly();
    }

    public static function getGetDisplayFunctionName()
    {
        return "getDisplay";
    }

}

?>
