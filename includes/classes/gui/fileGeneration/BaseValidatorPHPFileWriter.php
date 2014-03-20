<?php


/**
 * Description of BaseValidatorPHPFileWriter
 *
 * @author suyash
 */
class BaseValidatorPHPFileWriter extends PHPFileWriter
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
	$arrayExtend = array("Validator");

	$this->appendPhpFileOpening();
	$this->appendClassStart($arrayExtend);
	$this->appendConstructor();
	$this->addEmptyLine();
	$this->appendValidateAdd();
	$this->addEmptyLine();
	$this->appendValidateEdit();
	$this->appendClassEnd();
	$this->appendPhpFileClosing();
    }

    protected function appendConstructor()
    {
	$this->appendDefaultConstructor();
	$this->openCurly();
	$this->addContent("\$this->error = new Error();");
	$this->closeCurly();
    }

    protected function appendValidateAdd()
    {
	$tableName = $this->tableEntity->getTableName();

	$validateAddFunctionName = BaseValidatorPHPFileWriter::getValidateAddFunctionName($tableName);
	$parameterString = $this->tableEntity->getCommaNonAutoParameterList();

	$this->appendFunctionDeclaration($validateAddFunctionName, "", "", false, $parameterString);
	$this->openCurly();
	$this->appendValidateAddFieldValidation();
	$this->addEmptyLine();
	$this->addContent("return \$this->error;");
	$this->closeCurly();
    }

    private function appendValidateAddFieldValidation()
    {
	$tableName = $this->tableEntity->getTableName();
	$fieldEntityList = $this->tableEntity->getNonAutoParameterList();

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldName = $fieldEntityList[$i]->getField();
	    $fieldVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));
	    $fieldDisplayName = TextUtility::formatReadText($fieldName);

	    if(!$fieldEntityList[$i]->acceptsNull())
	    {
		$this->addContent("\$this->checkEmptyError($fieldVariableName, \"$fieldDisplayName\");");
	    }

	    if($fieldEntityList[$i]->hasLength())
	    {
		$logicClassName = PHPFileWriterManager::getBaseLogicName($tableName);
		$fieldNameVariable = BaseLogicPHPFileWriter::getFieldLimitVariableName($fieldName);

		$this->addContent("\$this->validateLength($fieldVariableName, \"$fieldDisplayName\", $logicClassName::$fieldNameVariable);");
		$this->addEmptyLine();
	    }
	}
    }

    protected function appendValidateEdit()
    {
	$tableName = $this->tableEntity->getTableName();

	$validateAddFunctionName = BaseValidatorPHPFileWriter::getValidateEditFunctionName($tableName);
	$parameterString = $this->tableEntity->getCommaNonAutoParameterList();

	$this->appendFunctionDeclaration($validateAddFunctionName, "", "", false, $parameterString);
	$this->openCurly();
	$this->appendValidateEditFieldValidation();
	$this->addEmptyLine();
	$this->addContent("return \$this->error;");
	$this->closeCurly();
    }

    private function appendValidateEditFieldValidation()
    {
	$tableName = $this->tableEntity->getTableName();
	$fieldEntityList = $this->tableEntity->getNonAutoParameterList();

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldName = $fieldEntityList[$i]->getField();
	    $fieldVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));
	    $fieldDisplayName = TextUtility::formatReadText($fieldName);

	    if(!$fieldEntityList[$i]->acceptsNull())
	    {
		$this->addContent("\$this->checkEmptyError($fieldVariableName, \"$fieldDisplayName\");");
	    }

	    if($fieldEntityList[$i]->hasLength())
	    {
		$logicClassName = PHPFileWriterManager::getBaseLogicName($tableName);
		$fieldNameVariable = BaseLogicPHPFileWriter::getFieldLimitVariableName($fieldName);

		$this->addContent("\$this->validateLength($fieldVariableName, \"$fieldDisplayName\", $logicClassName::$fieldNameVariable);");
		$this->addEmptyLine();
	    }
	}
    }

    public static function getValidateAddFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$VALIDATE_ADD_PREFIX.$functionName;
    }

    public static function getValidateEditFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$VALIDATE_EDIT_PREFIX.$functionName;
    }
}

?>