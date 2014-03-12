<?php

/**
 * Description of BaseLogicPHPFileWriter
 *
 * @author suyash
 */
class BaseLogicPHPFileWriter extends PHPFileWriter
{

    private static $TABLE_NAME_TEXT = "TABLE_NAME";

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

        $this->appendVariables();
        $this->addEmptyLine();
        $this->appendAddFunction();
        $this->addEmptyLine();
        $this->appendGetDetailsFunction();
        $this->addEmptyLine();
        $this->appendUpdateFunction();
        $this->addEmptyLine();
        $this->appendGetListFunction();
        $this->addEmptyLine();
        $this->appendDeleteFunction();
        $this->addEmptyLine();
        $this->appendAddAllFieldsFunction();
        $this->addEmptyLine();
        $this->appendConvertToObjectArrayFunction();
        $this->addEmptyLine();
        $this->appendConvertToObjectFunction();

        $this->appendClassEnd();
        $this->appendPhpFileClosing();
    }

    protected function appendVariables()
    {
        $this->addTableNameVariables();
        $this->addFieldListVariables();
        $this->addFieldEnumVariables();
        $this->addFieldLimits();
    }

    protected function addTableNameVariables()
    {
        $this->addComment("table name");

        $tableNameVariable = PHPFileWriter::createVariable(BaseLogicPHPFileWriter::$TABLE_NAME_TEXT);
        $tableName = $this->tableEntity->getTableName();

        $this->addContent("public static $tableNameVariable = \"$tableName\";");
    }

    protected function addFieldListVariables()
    {
        $this->addComment("fields list");

        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);

            $this->addContent("public static $fieldNameVariable = \"$fieldName\";");
        }
    }

    protected function addFieldEnumVariables()
    {
        $this->addComment("fields values");

        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];

            if($fieldEntity->isEnum())
            {
                $fieldName = $fieldEntity->getField();
                $fieldValues = $fieldEntity->getFieldValues();

                if(count($fieldValues) > 0)
                {
                    $this->addComment("fields values for $fieldName");

                    for($j = 0; $j < count($fieldValues); $j++)
                    {
                        $valueName = $fieldValues[$j];

                        $enumVariableName = $this->getFieldEnumVariableName($fieldName, $valueName);

                        $this->addContent("public static $enumVariableName = \"$valueName\";");
                    }
                }
            }
        }
    }

    protected function addFieldLimits()
    {
        $this->addComment("fields limits");

        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];

            if($fieldEntity->hasLength())
            {
                $fieldName = $fieldEntity->getField();
                $length = $fieldEntity->getLength();

                $fieldNameVariable = BaseLogicPHPFileWriter::getFieldLimitVariableName($fieldName);

                $this->addContent("public static $fieldNameVariable = $length;");
            }
        }
    }

    protected function getFieldVariableName($fieldName)
    {
        $fieldVariableName = "";

        $fieldVariableName = strtoupper($fieldName)."_".Configuration::$FIELD_SUFFIX;

        return PHPFileWriter::createVariable($fieldVariableName);
    }

    public static function getFieldLimitVariableName($fieldName)
    {
        $fieldVariableName = "";

        $fieldVariableName = strtoupper($fieldName)."_".Configuration::$LIMIT_SUFFIX;

        return PHPFileWriter::createVariable($fieldVariableName);
    }

    protected function getFieldEnumVariableName($fieldName, $enum)
    {
        $fieldNamePart = strtoupper($fieldName);
        $enumPart = strtoupper($enum);

        $fullPart = $fieldNamePart."_".$enumPart;

        return PHPFileWriter::createVariable($fullPart);
    }

    protected function appendAddFunction()
    {
        $tableName = $this->tableEntity->getTableName();
        $parameterList = $this->tableEntity->getCommaNonAutoParameterList();
        $functionName = BaseLogicPHPFileWriter::getAddFunctionName($tableName);
        $fileName = $this->fileName;

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();

        $this->addContent("\$queryBuilder = new QueryBuilder();");
        $this->addContent("\$queryBuilder->addTable($fileName::\$TABLE_NAME);");

        $fieldEntityList = $this->tableEntity->getNonAutoParameterList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);
            $valueVariable = TextUtility::formatVariableName($fieldName);
            $valueVariable = PHPFileWriter::createVariable($valueVariable);

            $this->addContent("\$queryBuilder->addUpdateField($fileName::$fieldNameVariable, $valueVariable);");
        }

        $this->addEmptyLine();
        $this->addContent("return \$queryBuilder->executeInsertQuery();");

        $this->closeCurly();
    }

    protected function appendGetDetailsFunction()
    {
        $tableName = $this->tableEntity->getTableName();
        $parameterList = $this->tableEntity->getPhpCommaPrimaryParameterList();
        $functionName = BaseLogicPHPFileWriter::getDetailsFunctionName($tableName);
        $fileName = $this->fileName;
        $addAllFieldsFunction = BaseLogicPHPFileWriter::getAddAllFieldsFunctionName();

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();

        $this->addContent("\$queryBuilder = new QueryBuilder();");
        $this->addContent("\$queryBuilder->addTable($fileName::\$TABLE_NAME);");
        $this->addContent("\$queryBuilder = $fileName::$addAllFieldsFunction(\$queryBuilder);");

        $fieldEntityList = $this->tableEntity->getPrimaryParameterList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);
            $valueVariable = TextUtility::formatVariableName($fieldName);
            $valueVariable = PHPFileWriter::createVariable($valueVariable);

            $this->addContent("\$queryBuilder->addAndConditionWithValue($fileName::$fieldNameVariable, $valueVariable);");
        }

        $this->addContent("\$result = \$queryBuilder->executeQuery();");

        $this->addEmptyLine();

        $this->addContent("if(count(\$result) > 0)");
        $this->openCurly();
        $this->addContent("return $fileName::convertToObject(\$result[0]);");
        $this->closeCurly();
        $this->addContent("else");
        $this->openCurly();
        $this->addContent("return null;");
        $this->closeCurly();

        $this->addEmptyLine();

        $this->closeCurly();
    }

    protected function appendUpdateFunction()
    {
        $tableName = $this->tableEntity->getTableName();
        $parameterList = $this->tableEntity->getCommaAllParameterList();
        $functionName = BaseLogicPHPFileWriter::getUpdateFunctionName($tableName);
        $fileName = $this->fileName;

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();

        $this->addContent("\$queryBuilder = new QueryBuilder();");
        $this->addContent("\$queryBuilder->addTable($fileName::\$TABLE_NAME);");

        $fieldEntityList = $this->tableEntity->getNonAutoParameterList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);
            $valueVariable = TextUtility::formatVariableName($fieldName);
            $valueVariable = PHPFileWriter::createVariable($valueVariable);

            $this->addContent("\$queryBuilder->addUpdateField($fileName::$fieldNameVariable, $valueVariable);");
        }

        $this->addEmptyLine();

        $primaryFieldEntityList = $this->tableEntity->getPrimaryParameterList();

        for($i = 0; $i < count($primaryFieldEntityList); $i++)
        {
            $fieldEntity = $primaryFieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);
            $valueVariable = TextUtility::formatVariableName($fieldName);
            $valueVariable = PHPFileWriter::createVariable($valueVariable);

            $this->addContent("\$queryBuilder->addAndConditionWithValue($fileName::$fieldNameVariable, $valueVariable);");
        }

        $this->addEmptyLine();
        $this->addContent("return \$queryBuilder->executeUpdateQuery();");

        $this->closeCurly();
    }

    protected function appendGetListFunction()
    {
        $tableName = $this->tableEntity->getTableName();
        $parameterList = "SortQuery \$sortQuery = null";
        $functionName = BaseLogicPHPFileWriter::getListFunctionName($tableName);
        $fileName = $this->fileName;
        $addAllFieldsFunction = BaseLogicPHPFileWriter::getAddAllFieldsFunctionName();

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();

        $this->addContent("\$queryBuilder = new QueryBuilder();");
        $this->addContent("\$queryBuilder->addTable($fileName::\$TABLE_NAME);");
        $this->addContent("\$queryBuilder = $fileName::$addAllFieldsFunction(\$queryBuilder);");

        $this->addEmptyLine();

        $this->addContent("if(\$sortQuery)");
        $this->openCurly();
        $this->addContent("\$queryBuilder->addSortQuery(\$sortQuery);");
        $this->closeCurly();

        $this->addEmptyLine();

        $this->addContent("\$result = \$queryBuilder->executeQuery();");

        $this->addEmptyLine();

        $this->addContent("return $fileName::convertToObjectArray(\$result);");

        $this->closeCurly();
    }

    protected function appendDeleteFunction()
    {
        $tableName = $this->tableEntity->getTableName();
        $parameterList = $this->tableEntity->getPhpCommaPrimaryParameterList();
        $functionName = BaseLogicPHPFileWriter::getDeleteFunctionName($tableName);
        $fileName = $this->fileName;

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();

        $this->addContent("\$queryBuilder = new QueryBuilder();");
        $this->addContent("\$queryBuilder->addTable($fileName::\$TABLE_NAME);");

        $fieldEntityList = $this->tableEntity->getPrimaryParameterList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);
            $valueVariable = TextUtility::formatVariableName($fieldName);
            $valueVariable = PHPFileWriter::createVariable($valueVariable);

            $this->addContent("\$queryBuilder->addAndConditionWithValue($fileName::$fieldNameVariable, $valueVariable);");
        }

        $this->addEmptyLine();
        $this->addContent("return \$queryBuilder->executeDeleteQuery();");

        $this->closeCurly();
    }

    protected function appendAddAllFieldsFunction()
    {
        $parameterList = "QueryBuilder \$queryBuilder";
        $functionName = BaseLogicPHPFileWriter::getAddAllFieldsFunctionName();
        $fileName = $this->fileName;

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();

        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);

            $this->addContent("\$queryBuilder->addFields($fileName::$fieldNameVariable);");
        }

        $this->addEmptyLine();
        $this->addContent("return \$queryBuilder;");

        $this->closeCurly();
    }

    protected function appendConvertToObjectArrayFunction()
    {
        $parameterList = "\$result";
        $functionName = BaseLogicPHPFileWriter::getConvertToObjectArrayFunctionName();
        $fileName = $this->fileName;

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();


        $this->addContent("\$objectArray = array();");
        $this->addEmptyLine();

        $this->addContent("for(\$i = 0; \$i < count(\$result); \$i++)");
        $this->openCurly();
        $this->addContent("\$objectArray[\$i] = $fileName::convertToObject(\$result[\$i]);");
        $this->closeCurly();

        $this->addEmptyLine();

        $this->addContent("return \$objectArray;");

        $this->closeCurly();
    }

    protected function appendConvertToObjectFunction()
    {
        $parameterList = "\$resultDetails";
        $functionName = BaseLogicPHPFileWriter::getConvertToObjectFunctionName();
        $fileName = $this->fileName;

        $this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
        $this->openCurly();

        $fieldEntityList = $this->tableEntity->getFieldEntityList();

        $valueVariableParameterList = "";

        for($i = 0; $i < count($fieldEntityList); $i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $fieldName = $fieldEntity->getField();

            $fieldNameVariable = $this->getFieldVariableName($fieldName);
            $valueVariable = TextUtility::formatVariableName($fieldName);
            $valueVariable = PHPFileWriter::createVariable($valueVariable);

            $this->addContent("$valueVariable = QueryBuilder::getQueryValue(\$resultDetails, $fileName::$fieldNameVariable);");

            $valueVariableParameterList .= $valueVariable;

            if($i < (count($fieldEntityList) - 1))
            {
                $valueVariableParameterList .= ", ";
            }
        }

        $entityClassName = PHPFileWriterManager::getBaseEntityName($this->tableEntity->getTableName());

        $this->addEmptyLine();
        $this->addContent("return new $entityClassName($valueVariableParameterList, \$resultDetails);");

        $this->closeCurly();
    }

    public static function getAddFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$ADD_LOGIC_PREFIX.$functionName;
    }

    public static function getDetailsFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$GET_DETAILS_PREFIX.$functionName.Configuration::$GET_DETAILS_SUFFIX;
    }

    public static function getListFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$GET_LIST_PREFIX.$functionName.Configuration::$GET_LIST_SUFFIX;
    }

    public static function getUpdateFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$UPDATE_PREFIX.$functionName;
    }

    public static function getDeleteFunctionName($tableName)
    {
        $functionName = TextUtility::formatToCamelCapitalised($tableName);

        return Configuration::$DELETE_PREFIX.$functionName;
    }

    public static function getAddAllFieldsFunctionName()
    {
        return "addAllFields";
    }

    public static function getConvertToObjectArrayFunctionName()
    {
        return "convertToObjectArray";
    }

    public static function getConvertToObjectFunctionName()
    {
        return "convertToObject";
    }

}

?>
