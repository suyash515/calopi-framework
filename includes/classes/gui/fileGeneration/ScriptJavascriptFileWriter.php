<?php

/**
 * Description of ScriptJavascriptFileWriter
 *
 * @author suyash
 */
class ScriptJavascriptFileWriter extends JavascriptFileWriter
{

    private $tableEntityList;

    public function __construct($folder, $fileName, $tableEntityList)
    {
        parent::initialise($folder, $fileName, GenericFileWriter::$JAVASCRIPT_EXTENSION);

        $this->tableEntityList = $tableEntityList;
    }

    public function createFile()
    {
        $this->appendFunctions();

        parent::createFile();
    }

    protected function appendFunctions()
    {
        for($i = 0; $i < count($this->tableEntityList); $i++)
        {
            $this->appendGetAddFunction($this->tableEntityList[$i]);
            $this->appendAddFunction($this->tableEntityList[$i]);
            $this->appendGetEditFunction($this->tableEntityList[$i]);
            $this->appendEditFunction($this->tableEntityList[$i]);
            $this->appendGetDeleteFunction($this->tableEntityList[$i]);
            $this->appendDeleteFunction($this->tableEntityList[$i]);
        }
    }

    protected function appendGetAddFunction(TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $functionName = ScriptJavascriptFileWriter::getGetAddFunctionName($tableName);
        $addContainerName = BaseGuiPHPFileWriter::getAddFormContainerId($tableName);

        $this->appendFunctionDeclaration($functionName);
        $this->openCurly();
        $this->addContent("var con = \"$addContainerName\";");
        $this->addContent("\$(\"#\" + con).show();");
        $this->addEmptyLine();
        $this->addContent("getSSContent(\"$functionName\", con, \"\");");
        $this->closeCurly();
        $this->addEmptyLine();
    }

    protected function appendAddFunction(TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $functionName = ScriptJavascriptFileWriter::getAddFunctionName($tableName);
        $addResultContainerId = BaseGuiPHPFileWriter::getAddResultContainerId($tableName);
        $fieldList = $tableEntity->getNonAutoParameterList();

        $this->appendFunctionDeclaration($functionName);
        $this->openCurly();
        $this->addContent("var con = \"$addResultContainerId\";");
        $this->addEmptyLine();

        for($i = 0; $i < count($fieldList); $i++)
        {
            $fieldId = $inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldList[$i]);
            $fieldVariableName = TextUtility::formatVariableName($fieldList[$i]->getField());

            $this->addContent("var $fieldVariableName = \$(\"#$fieldId\").val();");
        }

        $this->addEmptyLine();
        $this->addContent("var params = {");

        for($i = 0; $i < count($fieldList); $i++)
        {
            $fieldName = $fieldList[$i]->getField();
            $fieldVariableName = TextUtility::formatVariableName($fieldList[$i]->getField());

            $lineContent = "\"$fieldName\" : $fieldVariableName";

            if($i < (count($fieldList) - 1))
            {
                $lineContent .= ",";
            }

            $this->addContent($lineContent);
        }

        $this->addContent("};");

        $this->addEmptyLine();
        $this->addContent("getSSContent(\"$functionName\", con, params);");
        $this->closeCurly();
        $this->addEmptyLine();
    }

    protected function appendGetEditFunction(TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $functionName = ScriptJavascriptFileWriter::getGetEditFunctionName($tableName);
        $parameterString = $tableEntity->getJavascriptCommaPrimaryParameterList();
        $parameterList = $tableEntity->getPrimaryParameterList();
        $actionLineContainerText = BaseGuiPHPFileWriter::getActionLineContainerId($tableName);
        $actionContainerText = BaseGuiPHPFileWriter::getActionContainerId($tableName);

        $this->appendFunctionDeclaration($functionName, $parameterString);
        $this->openCurly();
        $this->addContent("var trCon = $actionLineContainerText + id;");
        $this->addContent("var con = $actionContainerText + id;");
        $this->addEmptyLine();

        $this->addContent("var params = {");

        for($i = 0; $i < count($parameterList); $i++)
        {
            $fieldName = $parameterList[$i]->getField();
            $fieldVariableName = TextUtility::formatVariableName($parameterList[$i]->getField());

            $lineContent = "\"$fieldName\" : $fieldVariableName";

            if($i < (count($parameterList) - 1))
            {
                $lineContent .= ",";
            }

            $this->addContent($lineContent);
        }

        $this->addContent("}");
        $this->addEmptyLine();
        $this->addContent("\$(\"#\" + trCon).show();");
        $this->addEmptyLine();
        $this->addContent("getSSContent(\"$functionName\", con, params);");
        $this->closeCurly();
        $this->addEmptyLine();
    }

    protected function appendEditFunction(TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $functionName = ScriptJavascriptFileWriter::getEditFunctionName($tableName);
        $editContainerText = BaseGuiPHPFileWriter::getEditContainerId($tableName);
        $fieldList = $tableEntity->getNonAutoParameterList();
        $primaryKeyString = $this->getParameterAddedString($tableEntity->getPrimaryParameterList());
        $parameterString = $tableEntity->getJavascriptCommaPrimaryParameterList();
        $allFieldList = $tableEntity->getFieldEntityList();

        $this->appendFunctionDeclaration($functionName, $parameterString);
        $this->openCurly();
        $this->addContent("var con = $editContainerText + $primaryKeyString;");
        $this->addEmptyLine();

        for($i = 0; $i < count($fieldList); $i++)
        {
            $fieldName = $fieldList[$i]->getField();

            $fieldId = BaseGuiPHPFileWriter::getEditFieldContainerId($tableName, $fieldName, "", "#", "_");
            $fieldVariableName = TextUtility::formatVariableName($fieldList[$i]->getField());

            $this->addContent("var $fieldVariableName = \$($fieldId + ".$primaryKeyString.").val();");
        }

        $this->addEmptyLine();
        $this->addContent("var params = {");

        for($i = 0; $i < count($allFieldList); $i++)
        {
            $fieldName = $allFieldList[$i]->getField();
            $fieldVariableName = TextUtility::formatVariableName($allFieldList[$i]->getField());

            $lineContent = "\"$fieldName\" : $fieldVariableName";

            if($i < (count($allFieldList) - 1))
            {
                $lineContent .= ",";
            }

            $this->addContent($lineContent);
        }

        $this->addContent("};");

        $this->addEmptyLine();
        $this->addContent("getSSContent(\"$functionName\", con, params);");
        $this->closeCurly();
        $this->addEmptyLine();
    }

    protected function appendGetDeleteFunction(TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $functionName = ScriptJavascriptFileWriter::getGetDeleteFunctionName($tableName);
        $parameterString = $tableEntity->getJavascriptCommaPrimaryParameterList();
        $parameterList = $tableEntity->getPrimaryParameterList();
        $actionLineContainerText = BaseGuiPHPFileWriter::getActionLineContainerId($tableName);
        $actionContainerText = BaseGuiPHPFileWriter::getActionContainerId($tableName);

        $this->appendFunctionDeclaration($functionName, $parameterString);
        $this->openCurly();
        $this->addContent("var trCon = $actionLineContainerText + id;");
        $this->addContent("var con = $actionContainerText + id;");
        $this->addEmptyLine();

        $this->addContent("var params = {");

        for($i = 0; $i < count($parameterList); $i++)
        {
            $fieldName = $parameterList[$i]->getField();
            $fieldVariableName = TextUtility::formatVariableName($parameterList[$i]->getField());

            $lineContent = "\"$fieldName\" : $fieldVariableName";

            if($i < (count($parameterList) - 1))
            {
                $lineContent .= ",";
            }

            $this->addContent($lineContent);
        }

        $this->addContent("}");
        $this->addEmptyLine();
        $this->addContent("\$(\"#\" + trCon).show();");
        $this->addEmptyLine();
        $this->addContent("getSSContent(\"$functionName\", con, params);");
        $this->closeCurly();
        $this->addEmptyLine();
    }

    protected function appendDeleteFunction(TableEntity $tableEntity)
    {
        $tableName = $tableEntity->getTableName();
        $functionName = ScriptJavascriptFileWriter::getDeleteFunctionName($tableName);
        $parameterString = $tableEntity->getJavascriptCommaPrimaryParameterList();
        $parameterList = $tableEntity->getPrimaryParameterList();
        $actionContainerText = BaseGuiPHPFileWriter::getDeleteActionContainerId($tableName);

        $this->appendFunctionDeclaration($functionName, $parameterString);
        $this->openCurly();
        $this->addContent("var con = $actionContainerText + id;");
        $this->addEmptyLine();

        $this->addContent("var params = {");

        for($i = 0; $i < count($parameterList); $i++)
        {
            $fieldName = $parameterList[$i]->getField();
            $fieldVariableName = TextUtility::formatVariableName($parameterList[$i]->getField());

            $lineContent = "\"$fieldName\" : $fieldVariableName";

            if($i < (count($parameterList) - 1))
            {
                $lineContent .= ",";
            }

            $this->addContent($lineContent);
        }

        $this->addContent("}");
        $this->addEmptyLine();
        $this->addEmptyLine();
        $this->addContent("getSSContent(\"$functionName\", con, params);");
        $this->closeCurly();
        $this->addEmptyLine();
    }

    public static function getClearAddFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_CLEAR_ADD.$functionName;
    }

    public static function getGetAddFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_GET_ADD.$functionName;
    }

    public static function getAddFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_ADD.$functionName;
    }

    public static function getGetEditFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_GET_EDIT.$functionName;
    }

    public static function getEditFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_EDIT.$functionName;
    }

    public static function getGetDeleteFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_GET_DELETE.$functionName;
    }

    public static function getDeleteFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_DELETE.$functionName;
    }

    public static function getReloadListFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$JAVASCRIPT_RELOAD_LIST_PREFIX.$functionName.Configuration::$JAVASCRIPT_RELOAD_LIST_SUFFIX;
    }

}

?>
