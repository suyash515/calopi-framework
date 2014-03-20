<?php


/**
 * Description of TableEntity
 *
 * @author suyash
 */
class TableEntity
{

    private $tableName;
    private $fieldEntityList;

    public function __construct($tableName)
    {
	UpdateManagerGuiUtility::addSubSection("Fetched table $tableName");
	$this->tableName = $tableName;

	$this->fieldEntityList = array();
    }

    public function getTableName()
    {
	return $this->tableName;
    }

    public function getDisplayName()
    {
	return TextUtility::formatToCamelCapitalised($this->tableName);
    }

    public function getFieldEntityList()
    {
	return $this->fieldEntityList;
    }

    public function extractDetails($resultDetailsList)
    {
	for($i = 0; $i < count($resultDetailsList); $i++)
	{
	    $field = $resultDetailsList[$i]['Field'];
	    $type = $resultDetailsList[$i]['Type'];
	    $null = $resultDetailsList[$i]['Null'];
	    $key = $resultDetailsList[$i]['Key'];
	    $default = $resultDetailsList[$i]['Default'];
	    $extra = $resultDetailsList[$i]['Extra'];

	    $fieldEntity = new FieldEntity($field, $type, $null, $key, $default, $extra);

	    $this->addFieldEntity($fieldEntity);
	    UpdateManagerGuiUtility::addUpdate("Added field $field");
	}
    }

    private function addFieldEntity(FieldEntity $fieldEntity)
    {
	$this->fieldEntityList[count($this->fieldEntityList)] = $fieldEntity;
    }

    public function getCommaNonAutoParameterList()
    {
	$output = "";

	$fieldArray = $this->getNonAutoParameterList();

	if(count($fieldArray) > 0)
	{
	    for($i = 0; $i < count($fieldArray); $i++)
	    {
		$fieldName = $fieldArray[$i]->getField();
		$output .= PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));

		if($i < (count($fieldArray) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    public function getNonAutoParameterList()
    {
	$retArray = array();

	for($i = 0; $i < count($this->fieldEntityList); $i++)
	{
	    if($this->fieldEntityList[$i]->isPrimaryKey() && $this->fieldEntityList[$i]->isAutoIncrement())
	    {
		//don't add
	    }
	    else
	    {
		$retArray[count($retArray)] = $this->fieldEntityList[$i];
	    }
	}

	return $retArray;
    }

    public function getNonPrimaryParameterList()
    {
	$retArray = array();

	for($i = 0; $i < count($this->fieldEntityList); $i++)
	{
	    if($this->fieldEntityList[$i]->isPrimaryKey())
	    {
		//don't add
	    }
	    else
	    {
		$retArray[count($retArray)] = $this->fieldEntityList[$i];
	    }
	}

	return $retArray;
    }

    public function getNonKeyParameterList()
    {
	$retArray = array();

	for($i = 0; $i < count($this->fieldEntityList); $i++)
	{
	    if($this->fieldEntityList[$i]->isKey())
	    {
		//don't add
	    }
	    else
	    {
		$retArray[count($retArray)] = $this->fieldEntityList[$i];
	    }
	}

	return $retArray;
    }

    public function getPhpCommaPrimaryParameterList()
    {
	$output = "";

	$fieldArray = $this->getPrimaryParameterList();

	if(count($fieldArray) > 0)
	{
	    for($i = 0; $i < count($fieldArray); $i++)
	    {
		$fieldName = $fieldArray[$i]->getField();
		$output .= PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));

		if($i < (count($fieldArray) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    public function getPhpCommaNonPrimaryParameterList()
    {
	$output = "";

	$fieldArray = $this->getNonPrimaryParameterList();

	if(count($fieldArray) > 0)
	{
	    for($i = 0; $i < count($fieldArray); $i++)
	    {
		$fieldName = $fieldArray[$i]->getField();
		$output .= PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));

		if($i < (count($fieldArray) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    public function getJavascriptCommaPrimaryParameterList()
    {
	$output = "";

	$fieldArray = $this->getPrimaryParameterList();

	if(count($fieldArray) > 0)
	{
	    for($i = 0; $i < count($fieldArray); $i++)
	    {
		$fieldName = $fieldArray[$i]->getField();
		$output .= TextUtility::formatVariableName($fieldName);

		if($i < (count($fieldArray) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    public function getPrimaryParameterList()
    {
	$retArray = array();

	for($i = 0; $i < count($this->fieldEntityList); $i++)
	{
	    if($this->fieldEntityList[$i]->isPrimaryKey())
	    {
		$retArray[count($retArray)] = $this->fieldEntityList[$i];
	    }
	}

	return $retArray;
    }

    public function getForeignKeyParameterList()
    {
	$retArray = array();

	for($i = 0; $i < count($this->fieldEntityList); $i++)
	{
	    if($this->fieldEntityList[$i]->isForeignKey())
	    {
		$retArray[count($retArray)] = $this->fieldEntityList[$i];
	    }
	}

	return $retArray;
    }

    public function getCommaAllParameterList()
    {
	$output = "";

	$fieldArray = $this->getFieldEntityList();

	if(count($fieldArray) > 0)
	{
	    for($i = 0; $i < count($fieldArray); $i++)
	    {
		$fieldName = $fieldArray[$i]->getField();
		$output .= PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));

		if($i < (count($fieldArray) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    public function getCommaPrimaryParameterList()
    {
	$output = "";

	$fieldArray = $this->getPrimaryParameterList();

	if(count($fieldArray) > 0)
	{
	    for($i = 0; $i < count($fieldArray); $i++)
	    {
		$fieldName = $fieldArray[$i]->getField();
		$output .= PHPFileWriter::createVariable(TextUtility::formatVariableName($fieldName));

		if($i < (count($fieldArray) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    public function getUnderscoredPrimaryKey()
    {
	$output = "";

	$arrayEntityList = $this->getPrimaryParameterList();

	for($i = 0; $i < count($arrayEntityList); $i++)
	{
	    $fieldName = $arrayEntityList[$i]->getField();
	    $output .= TextUtility::formatVariableName($fieldName);

	    if($i < (count($arrayEntityList) - 1))
	    {
		$output .= ".\"_\".";
	    }
	}

	return $output;
    }

    public function getDateFieldTypeList()
    {
	$arrayDate = array();

	$fieldList = $this->getFieldEntityList();

	for($i = 0; $i < count($fieldList); $i++)
	{
	    if(($fieldList[$i]->isDate()) || ($fieldList[$i]->isDateTime()))
	    {
		$arrayDate[count($arrayDate)] = $fieldList[$i];
	    }
	}

	return $arrayDate;
    }

    /**
     * Returns array of FieldEntity of type varchar or text
     */
    public function getTextTypeList()
    {
	$arrayText = array();

	$fieldList = $this->getFieldEntityList();

	for($i = 0; $i < count($fieldList); $i++)
	{
	    if(!$fieldList[$i]->isPrimaryKey())
	    {
		$conditionVarchar = $fieldList[$i]->isVarchar();
		$conditionText = $fieldList[$i]->isText();
		$conditionDate = $fieldList[$i]->isDate();
		$conditionInt = $fieldList[$i]->isInt();
		$conditionDouble = $fieldList[$i]->isDouble();
		$conditionFloat = $fieldList[$i]->isFloat();

		if($conditionVarchar || $conditionText || $conditionDate || $conditionInt || $conditionDouble || $conditionFloat)
		{
		    $arrayText[count($arrayText)] = $fieldList[$i];
		}
	    }
	}

	return $arrayText;
    }

    public function getFirstPrimaryKeyVariable()
    {
	$fieldArray = $this->getPrimaryParameterList();

	if(count($fieldArray) > 0)
	{
	    $fieldEntity = $fieldArray[0];

	    return $fieldEntity->getConvertedVariableName();
	}
	else
	{
	    return "";
	}
    }

    public function getFirstPrimaryKeyGetterFunction()
    {
	$fieldArray = $this->getPrimaryParameterList();

	if(count($fieldArray) > 0)
	{
	    $fieldEntity = $fieldArray[0];

	    return $fieldEntity->getGetterFunctionName();
	}
	else
	{
	    return "";
	}
    }
}

?>
