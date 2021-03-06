<?php


/**
 * Description of QueryBuilder
 *
 * @author suyash
 */
class QueryBuilder
{

    private $tables;
    private $fields;
    private $andConditions;
    private $andQueryConditions;
    private $orderBy;
    private $groupBy;
    private $limit;
    private $offset;
    private $queryDataArray;
    private $queryJoinArray;
    private $sequenceReturn = "";
    public static $OPERATOR_EQUAL = "=";
    public static $OPERATOR_NOT_EQUAL = "<>";
    public static $OPERATOR_GREATER_THAN = ">";
    public static $OPERATOR_GREATER_OR_EQUAL = ">=";
    public static $OPERATOR_LESS_THAN = "<";
    public static $OPERATOR_LESS_OR_EQUAL = "<=";
    public static $OPERATOR_LIKE = "LIKE";
    public static $SINGLE_QUOTE = "single_quote";
    public static $DOUBLE_QUOTE = "double_quote";
    public static $IS_NULL = "IS NULL";

    public function __construct()
    {
	$this->tables = array();
	$this->fields = array();
	$this->andConditions = array();
	$this->andQueryConditions = array();
	$this->queryJoinArray = array();
    }

    public function reInitialise()
    {
	$this->tables = array();
	$this->fields = array();
	$this->andConditions = array();
	$this->orderBy = array();
	$this->groupBy = array();
	$this->limit = "";
	$this->offset = "";
	$this->queryDataArray = array();
	$this->sequenceReturn = "";
    }

    public function addTable($table)
    {
	$this->tables[count($this->tables)] = $table;
    }

    public function addFields($field, $table = "", $distinct = false, $alias = "")
    {
	$aliasQuery = "";

	if($alias != "")
	{
	    $aliasQuery = "AS $alias";
	}

	if($table != "")
	{
	    if($distinct)
	    {
		$this->fields[count($this->fields)] = "DISTINCT($table.$field) $aliasQuery";
	    }
	    else
	    {
		$this->fields[count($this->fields)] = "$table.$field $aliasQuery";
	    }
	}
	else
	{
	    if($distinct)
	    {
		$this->fields[count($this->fields)] = "DISTINCT($field) $aliasQuery";
	    }
	    else
	    {
		$this->fields[count($this->fields)] = "$field $aliasQuery";
	    }
	}
    }

    public function setSequenceReturn($sequence)
    {
	$this->sequenceReturn = $sequence;
    }

    public function addUpdateField($field, $value, $quoteStyle = "", $escape = true)
    {
	if($escape)
	{
//            $value = mysql_real_escape_string($value);
	    $value = mysql_escape_string($value);
	}

	$this->queryDataArray[count($this->queryDataArray)] = new QueryData($field, $value, $quoteStyle);
    }

    public function addOrderBy($sortBy)
    {
	$this->orderBy[count($this->orderBy)] = $sortBy;
    }

    public function addSortQuery(SortQuery $sortQuery)
    {
	for($i = 0; $i < $sortQuery->getCount(); $i++)
	{
	    $this->addOrderBy($sortQuery->getQueryPart($i));
	}
    }

    public function addGroupBy($groupBy)
    {
	$this->groupBy[count($this->groupBy)] = $groupBy;
    }

    public function addAndCondition($condition)
    {
	$this->andConditions[count($this->andConditions)] = $condition;
    }

    public function addAndConditionWithValue($field, $value, $operator = "", $tableName = "", $escape = false)
    {
	if($escape)
	{
	    $value = mysql_escape_string($value);
	}

	if($operator == "")
	{
	    $operator = QueryBuilder::$OPERATOR_EQUAL;
	}

	if($tableName == "")
	{
	    $this->andConditions[count($this->andConditions)] = $field." ".$operator." "."'".$value."'";
	}
	else
	{
	    $this->andConditions[count($this->andConditions)] = $tableName.".".$field." ".$operator." "."'".$value."'";
	}
    }

    public function addIsNull($field, $operator = "", $table = "")
    {
	if($operator == "")
	{
	    $operator = QueryBuilder::$IS_NULL;
	}

	if($table != "")
	{
	    $field = $table.".".$field;
	}

	$this->andConditions[count($this->andConditions)] = $field." ".$operator;
    }

    public function addStartsWithCondition($field, $value)
    {
	$this->andConditions[count($this->andConditions)] = "";
    }

    /**
     * When comparison between two fields in same or different tables is needed
     * @param String $field1
     * @param String $field2
     * @param String $operator
     * @param String $table1
     * @param String $table2
     */
    public function addAndQueryCondition($field1, $field2, $operator, $table1 = "", $table2 = "")
    {
	$this->andQueryConditions[count($this->andQueryConditions)] =
		new QueryCondition($table1, $field1, $table2, $field2, $operator);
    }

    public function addLeftJoin($table, $leftTable, $leftField, $rightTable, $rightField, $tableAlias = "",
	    $andConditionArray = array())
    {
	$queryJoin =
		new QueryJoin($table, QueryJoin::$LEFT_JOIN, $leftTable, $leftField, $rightTable, $rightField, $andConditionArray,
		$tableAlias);

	$this->queryJoinArray[count($this->queryJoinArray)] = $queryJoin;
    }

    public function addJoin($table, $leftTable, $leftField, $rightTable, $rightField, $andConditionArray = array(),
	    $tableAlias = "")
    {
	$queryJoin =
		new QueryJoin($table, QueryJoin::$JOIN, $leftTable, $leftField, $rightTable, $rightField, $andConditionArray,
		$tableAlias);

	$this->queryJoinArray[count($this->queryJoinArray)] = $queryJoin;
    }

    public function setLimit($limit)
    {
	if($limit != "")
	{
	    $this->limit = $limit;
	}
    }

    public function setOffset($offset)
    {
	if($offset != "")
	{
	    $this->offset = $offset;
	}
    }

    public function getQuery()
    {
	$output = "";

	$fieldPart = $this->getFieldPart();
	$tablePart = $this->getTablePart();
	$joinPart = $this->getJoinPart();
	$conditionPart = $this->getConditionPart();
	$sortByPart = $this->getOrderByPart();
	$groupByPart = $this->getGroupByPart();

	if($conditionPart != "")
	{
	    $output .= "SELECT $fieldPart FROM $tablePart $joinPart WHERE $conditionPart $groupByPart $sortByPart";
	}
	else
	{
	    $output .= "SELECT $fieldPart FROM $tablePart $joinPart $groupByPart $sortByPart";
	}

	if(strlen($this->limit) > 0)
	{
	    $output .= " LIMIT ".$this->limit;
	}

	if(strlen($this->offset) > 0)
	{
	    $output .= " OFFSET ".$this->offset;
	}

	return $output;
    }

    public function getUpdateQuery()
    {
	$output = "";

	$fieldPart = $this->getUpdateFieldPart();
	$tablePart = $this->getTablePart();
	$conditionPart = $this->getConditionPart();

	if($conditionPart != "")
	{
	    $output .= "UPDATE $tablePart SET $fieldPart WHERE $conditionPart";
	}
	else
	{
	    $output .= "UPDATE $tablePart SET $fieldPart";
	}

	return $output;
    }

    public function getInsertQuery()
    {
	$output = "";

	$tablePart = $this->getTablePart();

	if(count($this->queryDataArray) > 0)
	{
	    $fieldPart = "(";
	    $valuesPart = "(";

	    for($i = 0; $i < count($this->queryDataArray); $i++)
	    {
		$fieldPart .= $this->queryDataArray[$i]->getField();
		$valuesPart .= $this->queryDataArray[$i]->getQuotedData();

		if($i < (count($this->queryDataArray) - 1))
		{
		    $fieldPart .= ", ";
		    $valuesPart .= ", ";
		}
	    }

	    $fieldPart .= ")";
	    $valuesPart .= ")";

	    $output .= "INSERT INTO $tablePart $fieldPart VALUES $valuesPart";

	    if($this->sequenceReturn != "")
	    {
		$output .= ";";
		$output .= "SELECT CURRVAL('".$this->sequenceReturn."');";
	    }
	}

	return $output;
    }

    public function getDeleteQuery()
    {
	$output = "";

	$tablePart = $this->getTablePart();
	$conditionPart = $this->getConditionPart();

	if($conditionPart != "")
	{
	    $output .= "DELETE FROM $tablePart WHERE $conditionPart";
	}
	else
	{
	    $output .= "DELETE FROM $tablePart";
	}

	return $output;
    }

    public function getCountQuery()
    {
	$output = "";

//        $fieldPart = $this->getFieldPart();
	$tablePart = $this->getTablePart();
	$conditionPart = $this->getConditionPart();
	$sortByPart = $this->getOrderByPart();
	$groupByPart = $this->getGroupByPart();

	if($conditionPart != "")
	{
	    $output .= "SELECT COUNT(*) AS total FROM $tablePart WHERE $conditionPart $groupByPart $sortByPart";
	}
	else
	{
	    $output .= "SELECT COUNT(*) AS total FROM $tablePart $groupByPart $sortByPart";
	}

	if(strlen($this->limit) > 0)
	{
	    $output .= " LIMIT ".$this->limit;
	}

	return $output;
    }

    private function getFieldPart()
    {
	$output = "";

	for($i = 0; $i < count($this->fields); $i++)
	{
	    $output .= $this->fields[$i];

	    if($i < (count($this->fields) - 1))
	    {
		$output .= ", ";
	    }
	}

	return $output;
    }

    private function getUpdateFieldPart()
    {
	$output = "";

	for($i = 0; $i < count($this->queryDataArray); $i++)
	{
	    $output .= $this->queryDataArray[$i]->getQuery();

	    if($i < (count($this->queryDataArray) - 1))
	    {
		$output .= ", ";
	    }
	}

	return $output;
    }

    private function getTablePart()
    {
	$output = "";

	for($i = 0; $i < count($this->tables); $i++)
	{
	    $output .= $this->tables[$i];

	    if($i < (count($this->tables) - 1))
	    {
		$output .= ", ";
	    }
	}

	return $output;
    }

    private function getJoinPart()
    {
	$output = "";

	for($i = 0; $i < count($this->queryJoinArray); $i++)
	{
	    $output .= " ".$this->queryJoinArray[$i]->getQuery();
	}

	return $output;
    }

    private function getConditionPart()
    {
	$output = "";

	$andConditionPart = $this->getAndConditionPart();
	$andQueryConditionPart = $this->getAndQueryConditionPart();

	$output .= $andConditionPart;

	if((strlen($andConditionPart) > 0) && (strlen($andQueryConditionPart) > 0))
	{
	    $output .= " AND ";
	}

	$output .= $andQueryConditionPart;

	return $output;
    }

    private function getAndQueryConditionPart()
    {
	$output = "";

	for($i = 0; $i < count($this->andQueryConditions); $i++)
	{
	    $output .= $this->andQueryConditions[$i]->getConditionSql();

	    if($i < (count($this->andQueryConditions) - 1))
	    {
		$output .= " AND ";
	    }
	}

	return $output;
    }

    private function getAndConditionPart()
    {
	$output = "";

	for($i = 0; $i < count($this->andConditions); $i++)
	{
	    $output .= $this->andConditions[$i];

	    if($i < (count($this->andConditions) - 1))
	    {
		$output .= " AND ";
	    }
	}

	return $output;
    }

    private function getOrderByPart()
    {
	$output = "";

	if(count($this->orderBy) > 0)
	{
	    $output .= " ORDER BY ";

	    for($i = 0; $i < count($this->orderBy); $i++)
	    {
		$output .= $this->orderBy[$i];

		if($i < (count($this->orderBy) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    private function getGroupByPart()
    {
	$output = "";

	if(count($this->groupBy) > 0)
	{
	    $output .= " GROUP BY ";

	    for($i = 0; $i < count($this->groupBy); $i++)
	    {
		$output .= $this->groupBy[$i];

		if($i < (count($this->groupBy) - 1))
		{
		    $output .= ", ";
		}
	    }
	}

	return $output;
    }

    public function executeQuery()
    {
	$db = DBQuery::getInstance();

	return $db->executeQuery($this->getQuery());
    }

    public function executeQueryCount()
    {
	$db = DBQuery::getInstance();

	$result = $db->executeQuery($this->getCountQuery());

	return intval($result[0]['total']);
    }

    public function executeUpdateQuery()
    {
	$db = DBQuery::getInstance();

	$db->executeNonQuery($this->getUpdateQuery());
    }

    public function executeDeleteQuery()
    {
	$db = DBQuery::getInstance();

	$db->executeNonQuery($this->getDeleteQuery());
    }

    public function executeInsertQuery()
    {
	$db = DBQuery::getInstance();

	return $db->executeNonQuery($this->getInsertQuery());
    }

    public static function getQueryValue($array, $index)
    {
	if(isset($array[$index]))
	{
	    return $array[$index];
	}
	else
	{
	    return "";
	}
    }

    public function debug()
    {
	Debug::e($this->getQuery());
    }

    public function debugInsert()
    {
	Debug::e($this->getInsertQuery());
    }

    public function debugDelete()
    {
	Debug::e($this->getDeleteQuery());
    }

    public function debugUpdate()
    {
	Debug::e($this->getUpdateQuery());
    }
}

?>