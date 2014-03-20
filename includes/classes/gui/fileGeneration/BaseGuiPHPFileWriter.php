<?php


/**
 * Description of BaseGuiPHPFileWriter
 *
 * @author suyash
 */
class BaseGuiPHPFileWriter extends PHPFileWriter
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
	$this->appendGetDisplay();
	$this->addEmptyLine();
	$this->appendGetAddFunction();
	$this->addEmptyLine();
	$this->appendAddFunction();
	$this->addEmptyLine();
	$this->appendListFunction();
	$this->addEmptyLine();
	$this->appendClearFunction();
	$this->addEmptyLine();
	$this->appendGetEditFunction();
	$this->addEmptyLine();
	$this->appendEditFunction();
	$this->addEmptyLine();
	$this->appendGetDeleteFunction();
	$this->addEmptyLine();
	$this->appendDeleteFunction();
	$this->addEmptyLine();
	$this->appendComboFunctions();
	$this->addEmptyLine();
	$this->getTableEntityComboFunction();
	$this->appendClassEnd();
	$this->appendPhpFileClosing();
    }

    protected function appendGetDisplay()
    {
	$tableName = $this->tableEntity->getTableName();
	$entityName = TextUtility::formatReadText($tableName);
	$addContainerName = BaseGuiPHPFileWriter::getAddFormContainerId($tableName);
	$javascriptAddFunctionName = ScriptJavascriptFileWriter::getGetAddFunctionName($tableName);
	$listContainerId = BaseGuiPHPFileWriter::getListContainerId($tableName);
	$listFunctionName = BaseGuiPHPFileWriter::getListFunctionName($tableName);
	$guiClassName = PHPFileWriterManager::getBaseGuiName($tableName);
	$displayFunctionName = BaseGuiPHPFileWriter::getDisplayFunctionName();

	$this->appendFunctionDeclaration($displayFunctionName, "", "", true);
	$this->openCurly();
	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= HeaderTextGuiUtility::getHeaderDisplay(\"$entityName\");");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<div>\";");
	$this->addContent("\$output .= \"<a href='javascript:void(0);' onclick=\\\"$javascriptAddFunctionName();\\\">Add $entityName</a>\";");
	$this->addContent("\$output .= \"</div>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<div id='$addContainerName' style='display: none;'>\";");
	$this->addContent("\$output .= \"</div>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<div class='' id='$listContainerId'>\";");
	$this->addContent("\$output .= $guiClassName::$listFunctionName();");
	$this->addContent("\$output .= \"</div>\";");
	$this->addEmptyLine();
	$this->addContent("return \$output;");
	$this->closeCurly();
    }

    protected function appendGetAddFunction()
    {
	$tableName = $this->tableEntity->getTableName();
	$addCommandContainerId = BaseGuiPHPFileWriter::getAddCommandContainerId($tableName);
	$addResultContainerId = BaseGuiPHPFileWriter::getAddResultContainerId($tableName);
	$javascriptAddAction = ScriptJavascriptFileWriter::getAddFunctionName($tableName);
	$listContainerId = BaseGuiPHPFileWriter::getListContainerId($tableName);
	$dateFieldEntityList = $this->tableEntity->getDateFieldTypeList();
	$functionName = BaseGuiPHPFileWriter::getGetAddFunctionName($tableName);

	$this->appendFunctionDeclaration($functionName, "", "", true);
	$this->openCurly();

	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();
	$this->addContent("\$urlForm = UrlConfiguration::getUrl(\"$tableName\", \"addProcessor\");");
	$this->addEmptyLine();
	$this->addOutputContent("<h3 style='text-align: center;'>Add Banner</h3>");
	$this->addEmptyLine();
	$this->addOutputContent("<div class='col-sm-12'>");
	$this->addOutputContent("<form role='form' action='\$urlForm' method='post'>");

	$fieldEntityList = $this->tableEntity->getNonAutoParameterList();

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldEntity = $fieldEntityList[$i];

	    $this->appendInputField($fieldEntity, $tableName);
	    $this->addEmptyLine();
	}

	$this->addEmptyLine();
	$this->addOutputContent("<div id='$addResultContainerId'></div>");

	$this->addEmptyLine();
	$this->addOutputContent("<div id='$addCommandContainerId'>");
	$this->addOutputContent("<button type='button' class='btn btn-primary' onclick=\"$javascriptAddAction\">Save</button>");
	$this->addOutputContent("&nbsp;");
	$this->addOutputContent("<button type='submit' class='btn btn-primary'>Submit</button>");
	$this->addOutputContent("&nbsp;");
	$this->addOutputContent("<button type='reset' class='btn'>Reset</button>");
	$this->addOutputContent("</div>");

	$this->addOutputContent("</form>");
	$this->addOutputContent("</div>");

	$this->addEmptyLine();

	$this->addEmptyLine();

	for($i = 0; $i < count($dateFieldEntityList); $i++)
	{
	    $fieldVariableNameArray = $this->getDateTimeFieldIdArray($dateFieldEntityList[$i]);
	    $fieldVariableName = $fieldVariableNameArray[1];

	    $this->addContent("\$output .= DateGuiUtility::getJQueryDatePicker(\"$fieldVariableName\");");
	}

	$this->addReturnOutput();

	$this->closeCurly();
    }

    protected function appendAddFunction()
    {
	$tableName = $this->tableEntity->getTableName();
	$parameterString = $this->tableEntity->getCommaNonAutoParameterList();
	$entityName = TextUtility::formatReadText($this->tableEntity->getTableName());
	$addFunctionName = BaseGuiPHPFileWriter::getAddFunctionName($tableName);

	$this->appendFunctionDeclaration($addFunctionName, "", "", true, $parameterString);
	$this->openCurly();

	$managerClassName = PHPFileWriterManager::getManagerName($tableName);

	$managerAddFunctionName = ManagerPHPFileWriter::getAddFunctionName($tableName);
	$clearAddFunctionName = ScriptJavascriptFileWriter::getClearAddFunctionName($tableName);
	$addCommandContainerId = BaseGuiPHPFileWriter::getAddCommandContainerId($tableName);
	$javascriptReloadFunctionName = ScriptJavascriptFileWriter::getReloadListFunctionName($tableName);

	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();

	$this->addContent("\$error = $managerClassName::$managerAddFunctionName($parameterString);");

	$this->addEmptyLine();

	$this->addContent("if(\$error->errorExists())");
	$this->openCurly();
	$this->addContent("\$output .= \$error->getBoostrapError();");
	$this->closeCurly();

	$this->addContent("else");
	$this->openCurly();
	$this->addContent("\$resultMessage = \"\";");
	$this->addContent("\$resultMessage .= \"<p>$entityName has been successfully saved.</p>\";");
	$this->addContent("\$resultMessage .= \"<p>\";");
	$this->addContent("\$resultMessage .= \"<a href='javascript:void(0);' onclick=\\\"$clearAddFunctionName();\\\">Add another >$entityName</a> or \";");
	$this->addContent("\$resultMessage .= \"<a href='javascript:void(0);' onclick=\\\"\$('#add_notification_form_con').html('');\\\">Close</a>\";");
	$this->addContent("\$resultMessage .= \"</p>\";");

	$this->addEmptyLine();
	$this->addContent("\$resultMessage .= \"<script>\";");
	$this->addContent("\$resultMessage .= \"\$('#$addCommandContainerId').hide();\";");
	$this->addContent("\$resultMessage .= \"$javascriptReloadFunctionName();\";");
	$this->addContent("\$resultMessage .= \"</script>\";");

	$this->addEmptyLine();
	$this->addContent("\$output .= ResultUpdateGuiUtility::getBootstrapSuccessDisplay(\$resultMessage);");

	$this->closeCurly();

	$this->addEmptyLine();

	$this->addContent("return \$output;");

	$this->closeCurly();
    }

    protected function appendClearFunction()
    {
	$tableName = $this->tableEntity->getTableName();

	$clearFunctionName = BaseGuiPHPFileWriter::getClearFunctionName($tableName);
	$commandContainerId = BaseGuiPHPFileWriter::getAddCommandContainerId($tableName);

	$this->appendFunctionDeclaration($clearFunctionName, "", "", true);
	$this->openCurly();

	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();

	$this->addContent("\$output .= \"<script>\";");

	$fieldEntityList = $this->tableEntity->getTextTypeList();

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $inputContainerId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntityList[$i]);

	    $this->addContent("\$output .= \"\$('#$inputContainerId').val('');\";");
	}

	$this->addEmptyLine();
	$this->addContent("\$output .= \"\$('#$commandContainerId').show();\";");

	$this->addContent("\$output .= \"</script>\";");
	$this->addEmptyLine();

	$this->addContent("return \$output;");
	$this->closeCurly();
    }

    protected function appendGetEditFunction()
    {
	$tableName = $this->tableEntity->getTableName();
	$javascriptEditAction = ScriptJavascriptFileWriter::getEditFunctionName($tableName);
	$dateFieldEntityList = $this->tableEntity->getDateFieldTypeList();
	$functionName = BaseGuiPHPFileWriter::getGetEditFunctionName($tableName);

	$entityVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."Entity");
	$logicClassName = PHPFileWriterManager::getBaseLogicName($tableName);
	$logicDetailsFunctionName = BaseLogicPHPFileWriter::getDetailsFunctionName($tableName);
	$parameterList = $this->tableEntity->getPhpCommaPrimaryParameterList();
	$parameterList .= ", \$userId";
	$primaryKeyUnderscore = PHPFileWriter::createVariable($this->tableEntity->getUnderscoredPrimaryKey());

	$fieldEntityList = $this->tableEntity->getNonAutoParameterList();

	$this->appendFunctionDeclaration($functionName, "", "", true, $parameterList);
	$this->openCurly();

	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();

	$this->addContent("$entityVariableName = $logicClassName::$logicDetailsFunctionName($parameterList);");

	$this->addEmptyLine();

	$this->addContent("if($entityVariableName)");
	$this->openCurly();

	$actionLineContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionLineContainerId");
	$actionContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionContainerId");

	$actionLineContainerText = BaseGuiPHPFileWriter::getActionLineContainerId($tableName, $primaryKeyUnderscore);
	$actionContainerText = BaseGuiPHPFileWriter::getActionContainerId($tableName, $primaryKeyUnderscore);

	$this->addContent("$actionLineContainerIdVariable = $actionLineContainerText;");
	$this->addContent("$actionContainerIdVariable = $actionContainerText;");

	$this->addEmptyLine();

	$editContainerText = BaseGuiPHPFileWriter::getEditContainerId($tableName, $primaryKeyUnderscore);
	$editCommandContainerText = BaseGuiPHPFileWriter::getEditCommandContainerId($tableName, $primaryKeyUnderscore);

	$this->addContent("\$editContainer = $editContainerText;");
	$this->addContent("\$editCommandContainer = $editCommandContainerText;");

	$this->addEmptyLine();

	//values retrieved for edit
	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldEntity = $fieldEntityList[$i];
	    $fieldName = $fieldEntity->getField();

	    $editContainerVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));
	    $entityGetFunctionName = BaseEntityPhpFileWriter::getGetAttributeFunctionName($fieldName);

	    $this->addContent("$editContainerVariableName = ".$entityVariableName."->$entityGetFunctionName();");
	}

	$this->addEmptyLine();

	//container ids for fields
	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldEntity = $fieldEntityList[$i];
	    $fieldName = $fieldEntity->getField();

	    $editContainerVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName."Container"));
	    $editContainerIdName = BaseGuiPHPFileWriter::getEditFieldContainerId($tableName, $fieldName, $primaryKeyUnderscore);

	    $this->addContent("$editContainerVariableName = $editContainerIdName;");
	}

	$this->addEmptyLine();

	$this->addOutputContent("<h2 class='text-center'>Edit ".$this->tableEntity->getDisplayName()."</h2>");
	$this->addEmptyLine();

	$this->addOutputContent("<form class='form' role='form' action=\"\" method\"post\">");

	//display of fields in table
	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldEntity = $fieldEntityList[$i];
	    $fieldName = $fieldEntity->getField();

	    $fieldVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));
	    $editContainerVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName."Container"));

	    $this->appendInputField($fieldEntity, $tableName, $fieldVariableName, $editContainerVariableName,
		    $primaryKeyUnderscore);
	    $this->addEmptyLine();
	}

	$this->addContent("\$output .= \"<div class='form-group' id='\$editContainer'>\";");
	$this->addContent("\$output .= \"</div>\";");

	$this->addEmptyLine();
	$this->addContent("\$output .= \"<div class='form-group' id='\$editCommandContainer'>\";");
	$this->addContent("\$output .= \"<button class='btn btn-primary' type='button' onclick=\\\"$javascriptEditAction();\\\">Save</button>\";");
	$this->addContent("\$output .= \"&nbsp;\";");
	$this->addContent("\$output .= \"<button class='btn' type='button' onclick=\\\"\$('#$actionContainerIdVariable').html('');$('#$actionLineContainerIdVariable').hide();\\\">Cancel</button>\";");

	$this->addContent("\$output .= \"</div>\";");

	$this->addEmptyLine();
	$this->addContent("\$output .= \"</form>\";");

	$this->addEmptyLine();

	for($i = 0; $i < count($dateFieldEntityList); $i++)
	{
	    $fieldName = $dateFieldEntityList[$i]->getField();
	    $editContainerVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName."Container"));

	    $this->addContent("\$output .= DateGuiUtility::getJQueryDatePicker($editContainerVariableName);");
	}

	$this->closeCurly();

	$this->addContent("else");
	$this->openCurly();
	$this->addContent("\$output .= \"<p>An error occurred while retrieving details</p>\";");
	$this->closeCurly();

	$this->addReturnOutput();

	$this->closeCurly();
    }

    protected function appendEditFunction()
    {
	$tableName = $this->tableEntity->getTableName();
	$entityName = TextUtility::formatReadText($this->tableEntity->getTableName());
	$editFunctionName = BaseGuiPHPFileWriter::getEditFunctionName($tableName);

	$managerClassName = PHPFileWriterManager::getManagerName($tableName);
	$managerEditFunctionName = ManagerPHPFileWriter::getEditFunctionName($tableName);

	$fieldEntityList = $this->tableEntity->getNonAutoParameterList();

	$parameterString = $this->tableEntity->getCommaAllParameterList();

	$this->appendFunctionDeclaration($editFunctionName, "", "", true, $parameterString);

	$this->openCurly();
	$this->addContent("\$output = \"\";");

	$this->addEmptyLine();

	$this->addContent("\$error = $managerClassName::$managerEditFunctionName($parameterString);");

	$this->addEmptyLine();

	$this->addContent("if(\$error->errorExists())");
	$this->openCurly();
	$this->addContent("\$output .= \$error->getBoostrapError();");
	$this->closeCurly();

	$this->addContent("else");
	$this->openCurly();

	$primaryKeyUnderscore = PHPFileWriter::createVariable($this->tableEntity->getUnderscoredPrimaryKey());

	$actionLineContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionLineContainerId");
	$actionContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionContainerId");

	$actionLineContainerText = BaseGuiPHPFileWriter::getActionLineContainerId($tableName, $primaryKeyUnderscore);
	$actionContainerText = BaseGuiPHPFileWriter::getActionContainerId($tableName, $primaryKeyUnderscore);

	$this->addContent("$actionLineContainerIdVariable = $actionLineContainerText;");
	$this->addContent("$actionContainerIdVariable = $actionContainerText;");

	$this->addEmptyLine();

	$editCommandContainerText = BaseGuiPHPFileWriter::getEditCommandContainerId($tableName, $primaryKeyUnderscore);

	$this->addContent("\$editCommandContainer = $editCommandContainerText;");

	$this->addEmptyLine();

	//container ids for fields
	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldEntity = $fieldEntityList[$i];
	    $fieldName = $fieldEntity->getField();

	    $editContainerVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName."Container"));
	    $editContainerIdName = BaseGuiPHPFileWriter::getEditFieldContainerId($tableName, $fieldName, $primaryKeyUnderscore);

	    $this->addContent("$editContainerVariableName = $editContainerIdName;");
	}

	$this->addEmptyLine();
	$this->addContent("\$resultMessage = \"\";");
	$this->addContent("\$resultMessage .= \"<p>$entityName has been successfully saved.</p>\";");
	$this->addContent("\$resultMessage .= \"<p>\";");
	$this->addContent("\$resultMessage .= \"<a href='javascript:void(0);' onclick=\\\"\$('#$actionContainerIdVariable').html('');$('#$actionLineContainerIdVariable').hide();\\\">Close</a>\";");
	$this->addContent("\$resultMessage .= \"</p>\";");

	$this->addEmptyLine();
	$this->addContent("\$resultMessage .= \"<script>\";");
	$this->addContent("\$resultMessage .= \"\$('#\$editCommandContainer').hide();\";");

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldEntity = $fieldEntityList[$i];
	    $fieldName = $fieldEntity->getField();
	    $fieldValueName = TextUtility::formatVariableName($fieldName);
	    $formattedFieldValueName = "";

	    if($fieldEntity->isText())
	    {
		$formattedFieldValueName = PHPFileWriter::createVariable(TextUtility::formatVariableName("formatted_".$fieldEntityList[$i]->getField()));

		$this->addEmptyLine();
		$this->addContent("$formattedFieldValueName = TextUtility::reformatBreakLines($fieldValueName);");
		$this->addEmptyLine();
	    }

	    $editContainerVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName."Container"));

	    if($formattedFieldValueName == "")
	    {
		$this->addContent("\$resultMessage .= \"\$('#$editContainerVariableName').html(\\\"$fieldValueName\\\");\";");
	    }
	    else
	    {
		$this->addContent("\$resultMessage .= \"\$('#$editContainerVariableName').html(\\\"$formattedFieldValueName\\\");\";");
	    }
	}

	$this->addContent("\$resultMessage .= \"</script>\";");

	$this->addEmptyLine();

	$this->addContent("\$output .= ResultUpdateGuiUtility::getBootstrapSuccessDisplay(\$resultMessage);");

	$this->closeCurly();

	$this->addEmptyLine();

	$this->addContent("return \$output;");

	$this->closeCurly();
    }

    protected function appendGetDeleteFunction()
    {
	$tableName = $this->tableEntity->getTableName();
	$entityName = TextUtility::formatReadText($tableName);

	$primaryParameterString = $this->tableEntity->getPhpCommaPrimaryParameterList();
	$deleteFunctionName = BaseGuiPHPFileWriter::getGetDeleteFunctionName($tableName);

	$this->appendFunctionDeclaration($deleteFunctionName, "", "", true, $primaryParameterString);

	$this->openCurly();

	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();

	$primaryKeyUnderscore = PHPFileWriter::createVariable($this->tableEntity->getUnderscoredPrimaryKey());

	$javascriptDeleteFunctionName = ScriptJavascriptFileWriter::getDeleteFunctionName($tableName);

	$actionLineContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionLineContainerId");
	$actionContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionContainerId");
	$deleteActionContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."DeleteActionContainerId");

	$actionLineContainerText = BaseGuiPHPFileWriter::getActionLineContainerId($tableName, $primaryKeyUnderscore);
	$actionContainerText = BaseGuiPHPFileWriter::getActionContainerId($tableName, $primaryKeyUnderscore);
	$deleteActionContainerText = BaseGuiPHPFileWriter::getDeleteActionContainerId($tableName, $primaryKeyUnderscore);

	$this->addContent("$actionLineContainerIdVariable = $actionLineContainerText;");
	$this->addContent("$actionContainerIdVariable = $actionContainerText;");
	$this->addContent("$deleteActionContainerIdVariable = $deleteActionContainerText;");

	$this->addEmptyLine();
	$this->addContent("\$output .= \"<div class='well'>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<table class='form_table'>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<tr>\";");
	$this->addContent("\$output .= \"<td>Do you really want to delete this $entityName ?</td>\";");
	$this->addContent("\$output .= \"</tr>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<tr>\";");
	$this->addContent("\$output .= \"<td id='$deleteActionContainerIdVariable'></td>\";");
	$this->addContent("\$output .= \"</tr>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<tr>\";");
	$this->addContent("\$output .= \"<td>\";");
	$this->addContent("\$output .= \"<button class='btn btn-primary' type='button' onclick=\\\"$javascriptDeleteFunctionName('$primaryParameterString');\\\">Delete</button>\";");
	$this->addContent("\$output .= \"&nbsp;\";");
	$this->addContent("\$output .= \"<button class='btn' type='button' onclick=\\\"\$('#$actionContainerIdVariable').html('');$('#$actionLineContainerIdVariable').hide();\\\">Cancel</button>\";");
	$this->addContent("\$output .= \"</td>\";");
	$this->addContent("\$output .= \"</tr>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"</table>\";");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"</div>\";");
	$this->addEmptyLine();
	$this->addContent("return \$output;");

	$this->closeCurly();
    }

    protected function appendDeleteFunction()
    {
	$tableName = $this->tableEntity->getTableName();

	$primaryParameterString = $this->tableEntity->getPhpCommaPrimaryParameterList();
	$deleteFunctionName = BaseGuiPHPFileWriter::getDeleteFunctionName($tableName);
	$primaryKeyUnderscore = PHPFileWriter::createVariable($this->tableEntity->getUnderscoredPrimaryKey());

	$managerClassName = PHPFileWriterManager::getManagerName($tableName);
	$managerEditFunctionName = ManagerPHPFileWriter::getEditFunctionName($tableName);

	$lineContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."LineContainerId");
	$actionLineContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionLineContainerId");

	$lineContainerText = BaseGuiPHPFileWriter::getLineContainerId($tableName, $primaryKeyUnderscore);
	$actionLineContainerText = BaseGuiPHPFileWriter::getActionLineContainerId($tableName, $primaryKeyUnderscore);

	$this->appendFunctionDeclaration($deleteFunctionName, "", "", true, $primaryParameterString);

	$this->openCurly();

	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();
	$this->addContent("$managerClassName::$managerEditFunctionName($primaryParameterString);");
	$this->addEmptyLine();
	$this->addContent("$lineContainerIdVariable = $lineContainerText;");
	$this->addContent("$actionLineContainerIdVariable = $actionLineContainerText;");
	$this->addEmptyLine();
	$this->addContent("\$output .= \"<script>\";");
	$this->addContent("\$output .= \"\$('#$lineContainerIdVariable').hide();\";");
	$this->addContent("\$output .= \"\$('#$actionLineContainerIdVariable').hide();\";");
	$this->addContent("\$output .= \"<\script>\";");
	$this->addEmptyLine();
	$this->addContent("return \$output;");
	$this->closeCurly();
    }

    protected function appendComboFunctions()
    {
	$fieldEntityList = $this->tableEntity->getFieldEntityList();

	$baseLogicPhpFileWriter = new BaseLogicPHPFileWriter($this->folder, $this->fileName, $this->tableEntity);
	$baseLogicClassName = PHPFileWriterManager::getBaseLogicName($this->tableEntity->getTableName());

	$comboIdVariable = $this->createVariable("comboId");
	$selectedValueVariable = $this->createVariable("selectedValue");
	$javascriptActionVariable = $this->createVariable("onclickAction");

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    if($fieldEntityList[$i]->isEnum())
	    {
		$fieldName = $fieldEntityList[$i]->getField();
		$getComboFunctionName = BaseGuiPHPFileWriter::getGetComboFunctionName($fieldName);
		$defaultComboIdValue = $this->getDefaultComboIdName($fieldName);

		$parameterString = "$comboIdVariable = \"$defaultComboIdValue\", $selectedValueVariable = \"\", $javascriptActionVariable = \"\"";

		$this->appendFunctionDeclaration($getComboFunctionName, "", "", true, $parameterString);

		$this->openCurly();
		$this->addContent("\$output = \"\";");
		$this->addEmptyLine();

		$fieldValuesArray = $fieldEntityList[$i]->getFieldValues();

		for($j = 0; $j < count($fieldValuesArray); $j++)
		{
		    $fieldValue = $fieldValuesArray[$j];
		    $enumVariable = PHPFileWriter::createVariable($this->getFieldValueName($fieldName, $fieldValue));
		    $enumValueVariable = $baseLogicPhpFileWriter->getFieldEnumVariableName($fieldName, $fieldValue);

		    $this->addContent("$enumVariable = $baseLogicClassName::$enumValueVariable;");
		}

		$this->addEmptyLine();

		for($j = 0; $j < count($fieldValuesArray); $j++)
		{
		    $fieldValue = $fieldValuesArray[$j];
		    $enumVariable = PHPFileWriter::createVariable($this->getFieldValueName($fieldName, $fieldValue));
		    $enumDisplayVariable = PHPFileWriter::createVariable($this->getFieldDisplayValueName($fieldName, $fieldValue));

		    $this->addContent("$enumDisplayVariable = ucfirst($enumVariable);");
		}

		$this->addEmptyLine();

		for($j = 0; $j < count($fieldValuesArray); $j++)
		{
		    $fieldValue = $fieldValuesArray[$j];
		    $enumVariable = PHPFileWriter::createVariable($this->getComboSelectedDisplayValueName($fieldName, $fieldValue));

		    $this->addContent("$enumVariable = \"\";");
		}

		$this->addEmptyLine();

		for($j = 0; $j < count($fieldValuesArray); $j++)
		{
		    $fieldValue = $fieldValuesArray[$j];
		    $enumVariable = PHPFileWriter::createVariable($this->getFieldValueName($fieldName, $fieldValue));
		    $enumSelectedVariable = PHPFileWriter::createVariable($this->getComboSelectedDisplayValueName($fieldName,
					    $fieldValue));

		    if($j == 0)
		    {
			$this->addContent("if(\$selectedValue == $enumVariable)");
		    }
		    else
		    {
			$this->addContent("elseif(\$selectedValue == $enumVariable)");
		    }

		    $this->openCurly();
		    $this->addContent("$enumSelectedVariable = \"selected\";");
		    $this->closeCurly();
		}

		$this->addEmptyLine();

		$this->addContent("\$output .= \"<select id='$comboIdVariable' name='$comboIdVariable' class='form-control span12' onchance=\\\"$javascriptActionVariable\\\">\";");

		for($j = 0; $j < count($fieldValuesArray); $j++)
		{
		    $fieldValue = $fieldValuesArray[$j];
		    $logicValueVariable = PHPFileWriter::createVariable($this->getFieldValueName($fieldName, $fieldValue));
		    $enumDisplayVariable = PHPFileWriter::createVariable($this->getFieldDisplayValueName($fieldName, $fieldValue));
		    $selectedValueVariable = PHPFileWriter::createVariable($this->getComboSelectedDisplayValueName($fieldName,
					    $fieldValue));

		    $this->addContent("\$output .= \"<option value = '$logicValueVariable' $selectedValueVariable>$enumDisplayVariable</option>\";");
		}

		$this->addContent("\$output .= \"</select>\";");
		$this->addEmptyLine();
		$this->addContent("return \$output;");

		$this->closeCurly();
	    }
	}
    }

    protected function getTableEntityComboFunction()
    {
	$fieldEntityList = $this->tableEntity->getFieldEntityList();
	$tableName = $this->tableEntity->getTableName();

	$listVariable = TextUtility::formatVariableName($tableName)."List";
	$listVariable = PHPFileWriter::createVariable($listVariable);

	$baseLogicPhpFileWriter = new BaseLogicPHPFileWriter($this->folder, $this->fileName, $this->tableEntity);
	$baseLogicClassName = PHPFileWriterManager::getBaseLogicName($this->tableEntity->getTableName());
	$baseLogicFileName = PHPFileWriterManager::getBaseLogicName($tableName);
	$getLogicListFunctionName = BaseLogicPHPFileWriter::getListFunctionName($tableName);
	$getLogicListFunctionName = $getLogicListFunctionName."()";
	$tableEntityIdVariable = $this->createVariable($this->tableEntity->getFirstPrimaryKeyVariable());
	$getterFieldIdFunctionName = $this->tableEntity->getFirstPrimaryKeyGetterFunction();

	$comboIdVariable = $this->createVariable("comboId");
	$selectedValueVariable = $this->createVariable("selectedValue");
	$javascriptActionVariable = $this->createVariable("onclickAction");

//	$fieldName = $fieldEntityList[$i]->getField();
	$getComboFunctionName = BaseGuiPHPFileWriter::getGetComboFunctionName($tableName);
	$defaultComboIdValue = $this->getDefaultComboIdName($tableName);

	$parameterString = "$comboIdVariable = \"$defaultComboIdValue\", $selectedValueVariable = \"\", $javascriptActionVariable = \"\"";

	$this->appendFunctionDeclaration($getComboFunctionName, "", "", true, $parameterString);

	$this->openCurly();
	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();
	$this->addContent("$listVariable = $baseLogicFileName::$getLogicListFunctionName;");
	$this->addEmptyLine();
	$this->addOutputContent("<select id='\$comboId' name='\$comboId' onclick=\"$javascriptActionVariable\">");
	$this->addEmptyLine();
	$this->addContent("for(\$i = 0; \$i < count($listVariable); \$i++)");
	$this->openCurly();
	$this->addContent("$tableEntityIdVariable = $listVariable"."[\$i]->$getterFieldIdFunctionName();");
	$this->addEmptyLine();
	$this->addContent("\$selected = \"\";");
	$this->addEmptyLine();

	$this->addContent("if(\$selectedValue == $tableEntityIdVariable)");
	$this->openCurly();
	$this->addContent("\$selected = \"selected\";");
	$this->closeCurly();
	$this->addEmptyLine();
	$this->addOutputContent("<option selected='\$selected' value='$tableEntityIdVariable'>$tableEntityIdVariable</option>");
	$this->closeCurly();
	$this->addEmptyLine();
	$this->addOutputContent("</select>");
	$this->addEmptyLine();
	$this->addContent("return \$output;");

	$this->closeCurly();
    }

    protected function appendListFunction()
    {
	$tableName = $this->tableEntity->getTableName();

	$listVariable = TextUtility::formatVariableName($tableName)."List";
	$listVariable = PHPFileWriter::createVariable($listVariable);

	$baseLogicFileName = PHPFileWriterManager::getBaseLogicName($tableName);
	$getLogicListFunctionName = BaseLogicPHPFileWriter::getListFunctionName($tableName);
	$getLogicListFunctionName = $getLogicListFunctionName."()";
	$listFunctionName = BaseGuiPHPFileWriter::getListFunctionName($tableName);
	$fieldEntityList = $this->tableEntity->getNonAutoParameterList();
	$allFieldEntityList = $this->tableEntity->getFieldEntityList();

	$primaryKeyUnderscore = PHPFileWriter::createVariable($this->tableEntity->getUnderscoredPrimaryKey());

	$lineContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."LineContainerId");
	$actionLineContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionLineContainerId");
	$actionContainerIdVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($tableName)."ActionContainerId");

	$lineContainerText = BaseGuiPHPFileWriter::getLineContainerId($tableName, $primaryKeyUnderscore);
	$actionLineContainerText = BaseGuiPHPFileWriter::getActionLineContainerId($tableName, $primaryKeyUnderscore);
	$actionContainerText = BaseGuiPHPFileWriter::getActionContainerId($tableName, $primaryKeyUnderscore);

	$this->appendFunctionDeclaration($listFunctionName, "", "", true);
	$this->openCurly();
	$this->addContent("\$output = \"\";");
	$this->addEmptyLine();
	$this->addContent("$listVariable = $baseLogicFileName::$getLogicListFunctionName;");
	$this->addEmptyLine();
	$this->addContent("if(count($listVariable) > 0)");
	$this->openCurly();
	$this->addContent("\$output .= \"<table class='table'>\";");
	$this->addContent("\$output .= \"<tr>\";");

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldValue = TextUtility::formatReadText($fieldEntityList[$i]->getField());

	    $this->addContent("\$output .= \"<th>$fieldValue</th>\";");
	}

	$this->addContent("\$output .= \"</tr>\";");
	$this->addEmptyLine();
	$this->addContent("for(\$i = 0; \$i < count($listVariable); \$i++)");
	$this->openCurly();

	for($i = 0; $i < count($allFieldEntityList); $i++)
	{
	    $fieldValue = $allFieldEntityList[$i]->getField();
	    $fieldVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldValue));
	    $retrieveValueFunction = BaseEntityPhpFileWriter::getGetEntityValue($fieldValue)."()";

	    $this->addContent("$fieldVariableName = $listVariable"."[\$i]->$retrieveValueFunction;");

	    if($allFieldEntityList[$i]->isText())
	    {
		$formattedVariableName = PHPFileWriter::createVariable("formatted".TextUtility::formatVariableNameWithFirstLetterCapitalised($fieldValue));

		$this->addContent("$formattedVariableName = TextUtility::reformatBreakLines($fieldVariableName);");
	    }
	}

	$this->addEmptyLine();
	$this->addContent("$lineContainerIdVariable = $lineContainerText;");
	$this->addContent("$actionLineContainerIdVariable = $actionLineContainerText;");
	$this->addContent("$actionContainerIdVariable = $actionContainerText;");
	$this->addEmptyLine();

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldValue = $fieldEntityList[$i]->getField();
	    $fieldVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldValue));

	    $fieldContainerVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldEntityList[$i]->getField())."ContainerId");

	    $this->addContent("$fieldContainerVariable = \"".$tableName."_".$fieldValue."_con_\".$primaryKeyUnderscore;");
	}

	$this->addEmptyLine();

	$this->addContent("\$output .= \"<tr id='$lineContainerIdVariable'>\";");

	for($i = 0; $i < count($fieldEntityList); $i++)
	{
	    $fieldValue = $fieldEntityList[$i]->getField();
	    $fieldVariableName = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldValue));

	    $fieldContainerVariable = PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldEntityList[$i]->getField())."ContainerId");

	    $this->addContent("\$output .= \"<td id='$fieldContainerVariable'>$fieldVariableName</td>\";");
	}

	$this->addEmptyLine();

	$primaryList = $this->tableEntity->getPhpCommaPrimaryParameterList();

	$getEditFunctionName = ScriptJavascriptFileWriter::getGetEditFunctionName($tableName);
	$getDeleteFunctionName = ScriptJavascriptFileWriter::getGetDeleteFunctionName($tableName);

	$this->addContent("\$output .= \"<td class='list_table_data_act'>\";");
	$this->addContent("\$output .= \"<a href='javascript:void(0);' onclick=\\\"$getEditFunctionName('$primaryList');\\\">Edit</a>\";");
	$this->addContent("\$output .= \" | \";");
	$this->addContent("\$output .= \"<a href='javascript:void(0);' onclick=\\\"$getDeleteFunctionName('$primaryList');\\\">Delete</a>\";");
	$this->addContent("\$output .= \"</td>\";");

	$this->addEmptyLine();

	$colspanNumber = count($this->tableEntity->getNonPrimaryParameterList()) + 1;

	$this->addContent("\$output .= \"<tr id='$actionLineContainerIdVariable' style='display: none;'>\";");
	$this->addContent("\$output .= \"<td colspan='$colspanNumber' id='$actionContainerIdVariable'></td>\";");
	$this->addContent("\$output .= \"</tr>\";");

	$this->closeCurly();

	$this->addEmptyLine();
	$this->addContent("\$output .= \"</table>\";");


	$this->closeCurly();

	$entityName = TextUtility::formatReadText($this->tableEntity->getTableName());

	$this->addContent("else");
	$this->openCurly();
	$this->addContent("\$output .= \"<p>No records for $entityName</p>\";");
	$this->closeCurly();
	$this->addEmptyLine();
	$this->addContent("return \$output;");

	$this->closeCurly();
    }

    protected function appendInputField(FieldEntity $fieldEntity, $tableName, $defaultValue = "",
	    $containerVariableName = "", $suffix = "")
    {
	if($fieldEntity->isPrimaryKey())
	{
//do not generate
	}
	else
	{
	    $field = $fieldEntity->getField();
	    $fieldName = TextUtility::formatReadText($field);
	    $fieldLabel = "";

	    if($fieldEntity->acceptsNull())
	    {
		$fieldLabel = $fieldName." *";
	    }
	    else
	    {
		$fieldLabel = $fieldName;
	    }

	    $this->addOutputContent("<div class='form-group'>");

	    if($fieldEntity->isVarchar())
	    {
		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= \"<input class='form-control span12' type='text' id='$inputFieldId' name='$inputFieldId' placeholder='$fieldName' value=\\\"$defaultValue\\\" />\";");
	    }
	    elseif($fieldEntity->isText())
	    {
		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= \"<textarea class='form-control span12' id='$inputFieldId' name='$inputFieldId' placeholder='$fieldName' rows='5'>$defaultValue</textarea>\";");
	    }
	    elseif($fieldEntity->isDate())
	    {
		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= \"<input class='form-control span12' type='text' id='$inputFieldId' name='$inputFieldId' value=\\\"$defaultValue\\\" />\";");
	    }
	    elseif($fieldEntity->isFloat())
	    {
		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= \"<input class='form-control span12' type='text' id='$inputFieldId' name='$inputFieldId' value=\\\"$defaultValue\\\" />\";");
	    }
	    elseif($fieldEntity->isDouble())
	    {
		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= \"<input class='form-control span12' type='text' id='$inputFieldId' name='$inputFieldId' value=\\\"$defaultValue\\\" />\";");
	    }
	    elseif($fieldEntity->isInt())
	    {
		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= \"<input class='form-control span12' type='text' id='$inputFieldId' name='$inputFieldId' value=\\\"$defaultValue\\\" />\";");
	    }
	    elseif($fieldEntity->isBigInt())
	    {
		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= \"<input class='form-control span12' type='text' id='$inputFieldId' name='$inputFieldId' value=\\\"$defaultValue\\\" />\";");
	    }
	    elseif($fieldEntity->isDateTime())
	    {
		$inputFieldIdArray = $this->getDateTimeFieldIdArray($fieldEntity, $containerVariableName, $suffix);
		$timeChooserPrefix = $inputFieldIdArray[0];
		$dateChooserId = $inputFieldIdArray[1];

		$this->addContent("\$output .= DateGuiUtility::getTimeChooser($timeChooserPrefix);");
		$this->addContent("\$output .= \"<input class='form-control span12' type='text' id='$dateChooserId' name='$dateChooserId' value=\\\"$defaultValue\\\" />\";");
	    }
	    elseif($fieldEntity->isEnum())
	    {
		$fileName = PHPFileWriterManager::getBaseGuiName($tableName);
		$getComboFunctionName = BaseGuiPHPFileWriter::getEnumComboFunctionName($fieldEntity->getField());

		$inputFieldId = BaseGuiPHPFileWriter::getInputFieldId($fieldEntity, $containerVariableName);

		$this->addOutputContent("<label for='$inputFieldId'>$fieldLabel</label>");
		$this->addContent("\$output .= $fileName::$getComboFunctionName($defaultValue);");
	    }

	    $this->addOutputContent("</div>");
	}
    }

    public static function getInputFieldId(FieldEntity $fieldEntity, $containerVariableName = "")
    {
	$output = "";

	if($containerVariableName == "")
	{
	    if(($fieldEntity->isVarchar()) || ($fieldEntity->isText()) || ($fieldEntity->isDate()) || ($fieldEntity->isDouble())
		    || ($fieldEntity->isFloat()) || ($fieldEntity->isInt()))
	    {
		$prefix = Configuration::$TEXTFIELD_PREFIX;

		$output .= $prefix."_".$fieldEntity->getField().$containerVariableName;
	    }
	    elseif($fieldEntity->isEnum())
	    {
		$prefix = Configuration::$COMBO_PREFIX;

		$output .= $prefix."_".$fieldEntity->getField().$containerVariableName;
	    }
	}
	else
	{
	    $output .= $containerVariableName;
	}

	return $output;
    }

    protected function getDateTimeFieldIdArray(FieldEntity $fieldEntity, $containerVariableName = "", $suffix = "")
    {
	$arrayId = array();

	$prefixText = Configuration::$TEXTFIELD_PREFIX;

	if($suffix == "")
	{
	    $arrayId[0] = "\"".$fieldEntity->getField()."\"";
	}
	else
	{
	    $arrayId[0] = "\"".$fieldEntity->getField()."_\".".$suffix;
	}


	if($containerVariableName == "")
	{
	    $arrayId[1] = $prefixText."_".$fieldEntity->getField();
	}
	else
	{
	    $arrayId[1] = $containerVariableName;
	}

	return $arrayId;
    }

    public static function getDisplayFunctionName()
    {
	return "getDisplay";
    }

    public static function getGetAddFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$ADD_FORM_PREFIX.$functionName;
    }

    public static function getAddFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$ADD_ACTION_PREFIX.$functionName;
    }

    public static function getClearAddFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$CLEAR_ADD_FUNCTION_PREFIX.$functionName;
    }

    public static function getListContainerId($tableName)
    {
	return $tableName."_".Configuration::$LIST_CONTAINER_SUFFIX;
    }

    public static function getListFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$GET_LIST_PREFIX.$functionName.Configuration::$GET_LIST_SUFFIX;
    }

    public static function getGetDeleteFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$GET_DELETE_FUNCTION_PREFIX.$functionName;
    }

    public static function getDeleteFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$DELETE_FUNCTION_PREFIX.$functionName;
    }

    public static function getGetComboFunctionName($fieldName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($fieldName);

	return Configuration::$GET_ENUM_COMBO_PREFIX.$functionName.Configuration::$GET_ENUM_COMBO_SUFFIX;
    }

    public static function getClearFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$CLEAR_ADD_FUNCTION_PREFIX.$functionName;
    }

    public static function getGetEditFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$GET_EDIT_FUNCTION_PREFIX.$functionName;
    }

    public static function getEditFunctionName($tableName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($tableName);

	return Configuration::$EDIT_FUNCTION_PREFIX.$functionName;
    }

    public static function getEnumComboFunctionName($fieldName)
    {
	$functionName = TextUtility::formatToCamelCapitalised($fieldName);

	return Configuration::$GET_ENUM_COMBO_PREFIX.$functionName.Configuration::$GET_ENUM_COMBO_SUFFIX;
    }

    public static function getFieldValueName($fieldName, $fieldValue)
    {
	$formattedFieldName = TextUtility::formatVariableName($fieldName);
	$formattedFieldValue = TextUtility::formatToCamelCapitalised($fieldValue);

	return $formattedFieldName.$formattedFieldValue;
    }

    public static function getDefaultComboIdName($fieldName)
    {
	$formattedFieldName = "cbo_".$fieldName;

	return $formattedFieldName;
    }

    public static function getFieldDisplayValueName($fieldName, $fieldValue)
    {
	$formattedFieldName = TextUtility::formatVariableName($fieldName);
	$formattedFieldValue = TextUtility::formatToCamelCapitalised($fieldValue);

	return $formattedFieldName.$formattedFieldValue."Display";
    }

    public static function getComboSelectedDisplayValueName($fieldName, $fieldValue)
    {
	$formattedFieldName = TextUtility::formatToCamelCapitalised($fieldName);
	$formattedFieldValue = TextUtility::formatToCamelCapitalised($fieldValue);

	return "selected".$formattedFieldName.$formattedFieldValue;
    }

    public static function getAddFormContainerId($tableName)
    {
	return $tableName."_".Configuration::$ADD_LINK_CONTAINER_SUFFIX;
    }

    public static function getAddResultContainerId($tableName)
    {
	return Configuration::$ADD_RESULT_CONTAINER_PREFIX."_".$tableName."_".Configuration::$ADD_RESULT_CONTAINER_SUFFIX;
    }

    public static function getAddCommandContainerId($tableName)
    {
	return Configuration::$ADD_COMMAND_CONTAINER_PREFIX."_".$tableName."_".Configuration::$ADD_COMMAND_CONTAINER_SUFFIX;
    }

    public static function getLineContainerId($tableName, $primaryKeyUnderscore)
    {
	return "\"".$tableName."_line_con_\".".$primaryKeyUnderscore;
    }

    public static function getActionLineContainerId($tableName, $primaryKeyUnderscore = "")
    {
	if($primaryKeyUnderscore == "")
	{
	    return "\"".$tableName."_action_line_con_\"";
	}
	else
	{
	    return "\"".$tableName."_action_line_con_\".".$primaryKeyUnderscore;
	}
    }

    public static function getActionContainerId($tableName, $primaryKeyUnderscore = "")
    {
	if($primaryKeyUnderscore == "")
	{
	    return "\"".$tableName."_action_con_\"";
	}
	else
	{
	    return "\"".$tableName."_action_con_\".".$primaryKeyUnderscore;
	}
    }

    public static function getEditContainerId($tableName, $primaryKeyUnderscore = "")
    {
	if($primaryKeyUnderscore == "")
	{
	    return "\"".$tableName."_edit_con_\"";
	}
	else
	{
	    return "\"".$tableName."_edit_con_\".".$primaryKeyUnderscore;
	}
    }

    public static function getEditCommandContainerId($tableName, $primaryKeyUnderscore)
    {
	return "\"".$tableName."_edit_com_\".".$primaryKeyUnderscore;
    }

    public static function getEditFieldContainerId($tableName, $fieldName, $primaryKeyUnderscore = "", $prefix = "",
	    $suffix = "")
    {
	if($primaryKeyUnderscore == "")
	{
	    return "\"".$prefix.$tableName."_".Configuration::$EDIT_FIELD_CONTAINER_PREFIX."_".$fieldName."$suffix\"";
	}
	else
	{
	    return "\"".$prefix.$tableName."_".Configuration::$EDIT_FIELD_CONTAINER_PREFIX."_".$fieldName."_$suffix\".".$primaryKeyUnderscore;
	}
    }

    public static function getDeleteActionContainerId($tableName, $primaryKeyUnderscore = "")
    {
	if($primaryKeyUnderscore == "")
	{
	    return "\"".$tableName."_delete_con_\"";
	}
	else
	{
	    return "\"".$tableName."_delete_con_\".".$primaryKeyUnderscore;
	}
    }

    public function getAddPostUrl($tableName)
    {
	return "\$urlAdd = UrlConfiguration::getUrl(\"$tableName\", \"addProcessor\");";
    }
}

?>
