<?php

/**
 * Description of BaseEntityPhpFileWriter
 *
 * @author suyash
 */
class BaseEntityPhpFileWriter extends PHPFileWriter
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
        $this->appendPhpFileOpening();
        $this->appendClassStart();
        $this->appendAttributeDeclaration();
        $this->addEmptyLine();
        $this->appendConstructor();
        $this->addEmptyLine();
        $this->appendGetterFunctions();
        $this->addEmptyLine();
        $this->appendSetterFunctions();
        $this->appendClassEnd();
        $this->appendPhpFileClosing();
    }

    protected function appendAttributeDeclaration()
    {
        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldName = $fieldEntityList[$i]->getField();
            $fieldVariable = TextUtility::formatVariableName($fieldName);
            $fieldVariableName = PHPFileWriter::createVariable($fieldVariable);

            $this->addContent("private $fieldVariableName;");
        }

        $this->addContent("private \$values;");
    }

    protected function appendConstructor()
    {
        $parameterList = $this->tableEntity->getCommaAllParameterList();

        if($parameterList != "")
        {
            $parameterList .= ", ";
        }

        $parameterList .= "\$values";

        $this->addContent("public function __construct($parameterList)");
        $this->openCurly();

        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldName = $fieldEntityList[$i]->getField();
            $fieldVariable = TextUtility::formatVariableName($fieldName);
            $fieldVariableName = PHPFileWriter::createVariable($fieldVariable);

            $this->addContent("\$this->$fieldVariable = $fieldVariableName;");
        }

        $this->addContent("\$this->values = \$values;");

        $this->closeCurly();
    }

    protected function appendGetterFunctions()
    {
        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldName = $fieldEntityList[$i]->getField();

            $fieldVariable = TextUtility::formatVariableName($fieldName);
            $getterFunctionName = "get".TextUtility::formatVariableNameWithFirstLetterCapitalised($fieldName);

            $this->addContent("public function $getterFunctionName()");
            $this->openCurly();
            $this->addContent("return \$this->$fieldVariable;");
            $this->closeCurly();
            $this->addEmptyLine();
        }

        $this->addContent("public function getValues()");
        $this->openCurly();
        $this->addContent("return \$this->values;");
        $this->closeCurly();
    }

    protected function appendSetterFunctions()
    {
        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldName = $fieldEntityList[$i]->getField();

            $fieldVariable = TextUtility::formatVariableName($fieldName);
            $fieldVariableName = PHPFileWriter::createVariable($fieldVariable);
            $getterFunctionName = "set".TextUtility::formatVariableNameWithFirstLetterCapitalised($fieldName);

            $this->addContent("public function $getterFunctionName($fieldVariableName)");
            $this->openCurly();
            $this->addContent("\$this->$fieldVariable = $fieldVariableName;");
            $this->closeCurly();
            $this->addEmptyLine();
        }
    }

    public static function getGetEntityValue($fieldName)
    {
        $variableName = TextUtility::formatVariableNameWithFirstLetterCapitalised($fieldName);

        return Configuration::$GET_ENTITY_VALUE_PREFIX.$variableName;
    }

    public static function getGetAttributeFunctionName($fieldName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($fieldName);

        return Configuration::$GET_GET_ENTITY_VALUE_FUNCTION_PREFIX.$functionName;
    }

}

?>
