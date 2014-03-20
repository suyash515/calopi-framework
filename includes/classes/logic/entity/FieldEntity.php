<?php


/**
 * Description of FieldEntity
 *
 * @author suyash
 */
class FieldEntity
{

    private $field;
    private $type;
    private $null;
    private $key;
    private $default;
    private $extra;
    private $realType;
    private $length;
    private $fieldValues;
    //type values
    private static $VARCHAR = "varchar";
    private static $ENUM = "enum";
    private static $TEXT = "text";
    private static $DATE = "date";
    private static $DATE_TIME = "datetime";
    private static $DOUBLE = "double";
    private static $FLOAT = "float";
    private static $INT = "int";
    private static $BIG_INT = "bigint";
    //primary key values
    private static $PRIMARY_KEY = "PRI";
    private static $FOREIGN_KEY = "MUL";
    //null values
    private static $NULL_NO = "NO";
    private static $NULL_YES = "YES";
    //auto values
    private static $AUTO_INCREMENT = "auto_increment";

    public function __construct($field, $type, $null, $key, $default, $extra)
    {
	$this->field = $field;
	$this->type = $type;
	$this->null = $null;
	$this->key = $key;
	$this->default = $default;
	$this->extra = $extra;

	$this->initialiseDerivedData();
    }

    private function initialiseDerivedData()
    {
	$positionOpenBracket = strpos($this->getType(), "(");

	if($positionOpenBracket)
	{
	    $this->realType = substr($this->getType(), 0, $positionOpenBracket);

	    if($this->realType == FieldEntity::$ENUM)
	    {
		$this->initialiseFieldValues();
	    }
	    else
	    {
		$positionCloseBracket = strpos($this->getType(), ")");
		$positionStart = $positionOpenBracket + 1;

		$this->length = substr($this->getType(), $positionStart, $positionCloseBracket - $positionStart);
	    }
	}
    }

    private function initialiseFieldValues()
    {
	$this->fieldValues = array();

	$positionOpenBracket = strpos($this->getType(), "(");
	$positionCloseBracket = strpos($this->getType(), ")");

	$positionStart = $positionOpenBracket + 1;

	$valuesList = substr($this->getType(), $positionStart, $positionCloseBracket - $positionStart);

	$valuesArray = explode(",", $valuesList);

	for($i = 0; $i < count($valuesArray); $i++)
	{
	    $replacedString = str_replace("'", "", $valuesArray[$i]);

	    $this->fieldValues[$i] = trim($replacedString);
	}
    }

    public function getField()
    {
	return $this->field;
    }

    public function getType()
    {
	return $this->type;
    }

    public function getNull()
    {
	return $this->null;
    }

    public function getKey()
    {
	return $this->key;
    }

    public function getDefault()
    {
	return $this->default;
    }

    public function getExtra()
    {
	return $this->extra;
    }

    public function getRealType()
    {
	if($this->realType == "")
	{
	    return $this->type;
	}
	else
	{
	    return $this->realType;
	}
    }

    public function getLength()
    {
	return $this->length;
    }

    public function getFieldValues()
    {
	return $this->fieldValues;
    }

    public function acceptsNull()
    {
	if($this->getNull() == FieldEntity::$NULL_NO)
	{
	    return false;
	}
	else
	{
	    return true;
	}
    }

    public function isPrimaryKey()
    {
	return ($this->getKey() == FieldEntity::$PRIMARY_KEY);
    }

    public function isForeignKey()
    {
	return ($this->getKey() == FieldEntity::$FOREIGN_KEY);
    }

    public function isKey()
    {
	return ($this->isPrimaryKey() || $this->isForeignKey());
    }

    public function isVarchar()
    {
	return ($this->getRealType() == FieldEntity::$VARCHAR);
    }

    public function isEnum()
    {
	return ($this->getRealType() == FieldEntity::$ENUM);
    }

    public function isText()
    {
	return ($this->getRealType() == FieldEntity::$TEXT);
    }

    public function isDate()
    {
	return ($this->getRealType() == FieldEntity::$DATE);
    }

    public function isDateTime()
    {
	return ($this->getRealType() == FieldEntity::$DATE_TIME);
    }

    public function isInt()
    {
	return ($this->getRealType() == FieldEntity::$INT);
    }

    public function isBigInt()
    {
	return ($this->getRealType() == FieldEntity::$BIG_INT);
    }

    public function isDouble()
    {
	return ($this->getRealType() == FieldEntity::$DOUBLE);
    }

    public function isFloat()
    {
	return ($this->getRealType() == FieldEntity::$FLOAT);
    }

    public function isAutoIncrement()
    {
	return ($this->extra == FieldEntity::$AUTO_INCREMENT);
    }

    public function hasLength()
    {
	if($this->getLength() == "")
	{
	    return false;
	}
	else
	{
	    return true;
	}
    }

    public function getConvertedVariableName()
    {
	return TextUtility::formatVariableName($this->getField());
    }

    public function getGetterFunctionName()
    {
	return "get".TextUtility::formatToCamelCapitalised($this->getField());
    }

    public function getUpdateFunctionName()
    {
	return "update".TextUtility::formatToCamelCapitalised($this->getField());
    }
}

?>
