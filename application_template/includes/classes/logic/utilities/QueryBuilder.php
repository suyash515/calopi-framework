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
    private $sequenceReturn = "";
    public static $OPERATOR_EQUAL = "=";
    public static $OPERATOR_NOT_EQUAL = "<>";
    public static $OPERATOR_GREATER_THAN = ">";
    public static $OPERATOR_GREATER_OR_EQUAL = ">=";
    public static $OPERATOR_LESS_THAN = "<";
    public static $OPERATOR_LESS_OR_EQUAL = "<=";
    public static $SINGLE_QUOTE = "single_quote";
    public static $DOUBLE_QUOTE = "double_quote";

    public function __construct()
    {
        $this->tables = array();
        $this->fields = array();
        $this->andConditions = array();
        $this->andQueryConditions = array();
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

        if ($alias != "")
        {
            $aliasQuery = "AS $alias";
        }

        if ($table != "")
        {
            if ($distinct)
            {
                $this->fields[count($this->fields)] = "DISTINCT($field) $aliasQuery";
            }
            else
            {
                $this->fields[count($this->fields)] = "$field $aliasQuery";
            }
        }
        else
        {
            if ($distinct)
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

    public function addUpdateField($field, $value, $quoteStyle = "")
    {
        $this->queryDataArray[count($this->queryDataArray)] = new QueryData($field, $value, $quoteStyle);
    }

    public function addOrderBy($sortBy)
    {
        $this->orderBy[count($this->orderBy)] = $sortBy;
    }

    public function addGroupBy($groupBy)
    {
        $this->groupBy[count($this->groupBy)] = $groupBy;
    }

    public function addAndCondition($condition)
    {
        $this->andConditions[count($this->andConditions)] = $condition;
    }

    public function addAndConditionWithValue($field, $value, $operator = "", $tableName = "")
    {
        if ($operator == "")
        {
            $operator = QueryBuilder::$OPERATOR_EQUAL;
        }

        if ($tableName == "")
        {
            $this->andConditions[count($this->andConditions)] = $field.$operator."'".$value."'";
        }
        else
        {
            $this->andConditions[count($this->andConditions)] = $tableName.".".$field.$operator."'".$value."'";
        }
    }

    /**
     * When comparison between two fields in same or different tables is needed
     * @param type $field1
     * @param type $field2
     * @param type $operator
     * @param type $table1
     * @param type $table2
     */
    public function addAndQueryCondition($field1, $field2, $operator, $table1 = "", $table2 = "")
    {
        $this->andQueryConditions[count($this->andQueryConditions)] = new QueryCondition($table1, $field1, $table2, $field2, $operator);
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function getQuery()
    {
        $output = "";

        $fieldPart = $this->getFieldPart();
        $tablePart = $this->getTablePart();
        $conditionPart = $this->getConditionPart();
        $sortByPart = $this->getOrderByPart();
        $groupByPart = $this->getGroupByPart();

        if ($conditionPart != "")
        {
            $output .= "SELECT $fieldPart FROM $tablePart WHERE $conditionPart $groupByPart $sortByPart";
        }
        else
        {
            $output .= "SELECT $fieldPart FROM $tablePart $groupByPart $sortByPart";
        }

        if (strlen($this->limit) > 0)
        {
            $output .= " LIMIT ".$this->limit;
        }

        if (strlen($this->offset) > 0)
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

        if ($conditionPart != "")
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

        if (count($this->queryDataArray) > 0)
        {
            $fieldPart = "(";
            $valuesPart = "(";

            for ($i = 0; $i < count($this->queryDataArray); $i++)
            {
                $fieldPart .= $this->queryDataArray[$i]->getField();
                $valuesPart .= $this->queryDataArray[$i]->getQuotedData();

                if ($i < (count($this->queryDataArray) - 1))
                {
                    $fieldPart .= ", ";
                    $valuesPart .= ", ";
                }
            }

            $fieldPart .= ")";
            $valuesPart .= ")";

            $output .= "INSERT INTO $tablePart $fieldPart VALUES $valuesPart";

            if ($this->sequenceReturn != "")
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

        if ($conditionPart != "")
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

        if ($conditionPart != "")
        {
            $output .= "SELECT COUNT(*) AS total FROM $tablePart WHERE $conditionPart $groupByPart $sortByPart";
        }
        else
        {
            $output .= "SELECT COUNT(*) AS total FROM $tablePart $groupByPart $sortByPart";
        }

        if (strlen($this->limit) > 0)
        {
            $output .= " LIMIT ".$this->limit;
        }

        return $output;
    }

    private function getFieldPart()
    {
        $output = "";

        for ($i = 0; $i < count($this->fields); $i++)
        {
            $output .= $this->fields[$i];

            if ($i < (count($this->fields) - 1))
            {
                $output .= ", ";
            }
        }

        return $output;
    }

    private function getUpdateFieldPart()
    {
        $output = "";

        for ($i = 0; $i < count($this->queryDataArray); $i++)
        {
            $output .= $this->queryDataArray[$i]->getQuery();

            if ($i < (count($this->queryDataArray) - 1))
            {
                $output .= ", ";
            }
        }

        return $output;
    }

    private function getTablePart()
    {
        $output = "";

        for ($i = 0; $i < count($this->tables); $i++)
        {
            $output .= $this->tables[$i];

            if ($i < (count($this->tables) - 1))
            {
                $output .= ", ";
            }
        }

        return $output;
    }

    private function getConditionPart()
    {
        $output = "";

        $andConditionPart = $this->getAndConditionPart();
        $andQueryConditionPart = $this->getAndQueryConditionPart();

        $output .= $andConditionPart;

        if ((strlen($andConditionPart) > 0) && (strlen($andQueryConditionPart) > 0))
        {
            $output .= " AND ";
        }

        $output .= $andQueryConditionPart;

        return $output;
    }

    private function getAndQueryConditionPart()
    {
        $output = "";

        for ($i = 0; $i < count($this->andQueryConditions); $i++)
        {
            $output .= $this->andQueryConditions[$i]->getConditionSql();

            if ($i < (count($this->andQueryConditions) - 1))
            {
                $output .= " AND ";
            }
        }

        return $output;
    }

    private function getAndConditionPart()
    {
        $output = "";

        for ($i = 0; $i < count($this->andConditions); $i++)
        {
            $output .= $this->andConditions[$i];

            if ($i < (count($this->andConditions) - 1))
            {
                $output .= " AND ";
            }
        }

        return $output;
    }

    private function getOrderByPart()
    {
        $output = "";

        if (count($this->orderBy) > 0)
        {
            $output .= " ORDER BY ";

            for ($i = 0; $i < count($this->orderBy); $i++)
            {
                $output .= $this->orderBy[$i];

                if ($i < (count($this->orderBy) - 1))
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

        if (count($this->groupBy) > 0)
        {
            $output .= " GROUP BY ";

            for ($i = 0; $i < count($this->groupBy); $i++)
            {
                $output .= $this->groupBy[$i];

                if ($i < (count($this->groupBy) - 1))
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
        if (isset($array[$index]))
        {
            return $array[$index];
        }
        else
        {
            return "";
        }
    }

}

?>