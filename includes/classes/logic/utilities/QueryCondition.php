<?php


/**
 * Description of QueryCondition
 *
 * @author suyash
 */
class QueryCondition
{

    private $firstTableName;
    private $firstFieldName;
    private $secondTableName;
    private $secondFieldName;
    private $operator;

    public function __construct($firstTableName, $firstFieldName, $secondTableName, $secondFieldName, $operator)
    {
	$this->firstTableName = $firstTableName;
	$this->firstFieldName = $firstFieldName;
	$this->secondTableName = $secondTableName;
	$this->secondFieldName = $secondFieldName;
	$this->operator = $operator;
    }

    public function getConditionSql()
    {
	$condition = "";

	if($this->firstTableName == "")
	{
	    $condition .= $this->firstFieldName;
	}
	else
	{
	    $condition .= $this->firstTableName.".".$this->firstFieldName;
	}

	$condition .= $this->operator;

	if($this->secondTableName == "")
	{
	    $condition .= $this->secondFieldName;
	}
	else
	{
	    $condition .= $this->secondTableName.".".$this->secondFieldName;
	}

	return $condition;
    }
}

?>
