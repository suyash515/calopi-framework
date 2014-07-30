<?php


/**
 * Description of BaseValidatorPHPFileWriter
 *
 * @author suyash
 */
class ManagerPHPFileWriter extends PHPFileWriter
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
	$this->appendAdd();
	$this->addEmptyLine();
	$this->appendEdit();
	$this->addEmptyLine();
	$this->appendDelete();
	$this->appendClassEnd();
	$this->appendPhpFileClosing();
    }

    protected function appendAdd()
    {
	$tableName = $this->tableEntity->getTableName();
	$parameterString = $this->tableEntity->getCommaNonAutoParameterList();
	$addFunctionName = ManagerPHPFileWriter::getAddFunctionName($tableName);

	$this->appendFunctionDeclaration($addFunctionName, "", "", true, $parameterString);
	$this->openCurly();

	$validatorVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName."Validator"));

	$validatorClassName = PHPFileWriterManager::getValidatorName($tableName);
	$validateAddFunctionName = BaseValidatorPHPFileWriter::getValidateAddFunctionName($tableName);
	$logicAddFunctionName = BaseLogicPHPFileWriter::getAddFunctionName($tableName);
	$logicFileName = PHPFileWriterManager::getLogicName($tableName);

	$this->addContent("$validatorVariable = new $validatorClassName();");
	$this->addEmptyLine();

	$this->addContent("\$error = $validatorVariable"."->$validateAddFunctionName($parameterString);");

	$this->addEmptyLine();

	$this->addContent("if(!\$error->errorExists())");
	$this->openCurly();
	$this->addContent("$logicFileName::$logicAddFunctionName($parameterString);");
	$this->closeCurly();

	$this->addEmptyLine();

	$this->addContent("return \$error;");

	$this->closeCurly();
    }

    protected function appendEdit()
    {
	$tableName = $this->tableEntity->getTableName();
	$editFunctionName = ManagerPHPFileWriter::getEditFunctionName($tableName);

	$validatorVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName."Validator"));
	$validatorClassName = PHPFileWriterManager::getValidatorName($tableName);
	$validateEditFunctionName = BaseValidatorPHPFileWriter::getValidateEditFunctionName($tableName);
	$logicFileName = PHPFileWriterManager::getLogicName($tableName);
	$logicEditFunctionName = BaseLogicPHPFileWriter::getUpdateFunctionName($tableName);

	$parameterString = $this->tableEntity->getCommaAllParameterList();

	$this->appendFunctionDeclaration($editFunctionName, "", "", true, $parameterString);

	$this->openCurly();

	$this->addContent("$validatorVariable = new $validatorClassName();");
	$this->addEmptyLine();
	$this->addContent("\$error = $validatorVariable"."->$validateEditFunctionName($parameterString);");

	$this->addEmptyLine();

	$this->addContent("if(!\$error->errorExists())");
	$this->openCurly();
	$this->addContent("$logicFileName::$logicEditFunctionName($parameterString);");
	$this->closeCurly();
	$this->addEmptyLine();

	$this->addContent("return \$error;");

	$this->closeCurly();
    }

    protected function appendDelete()
    {
	$tableName = $this->tableEntity->getTableName();
	$deleteFunctionName = ManagerPHPFileWriter::getDeleteFunctionName($tableName);

	$logicFileName = PHPFileWriterManager::getLogicName($tableName);
	$logicDeleteFunctionName = BaseLogicPHPFileWriter::getDeleteFunctionName($tableName);

	$parameterString = $this->tableEntity->getCommaPrimaryParameterList();

	$this->appendFunctionDeclaration($deleteFunctionName, "", "", true, $parameterString);

	$this->openCurly();
	$this->addContent("$logicFileName::$logicDeleteFunctionName($parameterString);");
	$this->closeCurly();
    }

    public static function getAddFunctionName($tableName)
    {
	return "add".TextUtility::formatToCamelCapitalised($tableName);
    }

    public static function getEditFunctionName($tableName)
    {
	return "edit".TextUtility::formatToCamelCapitalised($tableName);
    }

    public static function getDeleteFunctionName($tableName)
    {
	return "delete".TextUtility::formatToCamelCapitalised($tableName);
    }
}

?>