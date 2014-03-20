<?php

/**
 * Description of QueryJoin
 *
 * @author suyash
 */
class QueryJoin
{

    private $table;
    private $joinType;
    private $leftTable;
    private $leftField;
    private $rightTable;
    private $rightField;
    private $andCondition;
    private $tableAlias;
    //join types
    public static $LEFT_JOIN = "LEFT JOIN";
    public static $JOIN = "JOIN";

    public function __construct($table, $joinType, $leftTable, $leftField, $rightTable, $rightField,
            $andConditionArray = array(), $tableAlias = "")
    {
        $this->table = $table;
        $this->joinType = $joinType;
        $this->leftTable = $leftTable;
        $this->leftField = $leftField;
        $this->rightTable = $rightTable;
        $this->rightField = $rightField;
        $this->tableAlias = $tableAlias;

        $this->andCondition = $andConditionArray;
    }

    public function addAndCondition($condition)
    {
        $this->andConditions[count($this->andConditions)] = $condition;
    }

    public function getQuery()
    {
        $query = "";

        $query .= $this->joinType;
        $query .= " ".$this->table;

        if($this->tableAlias != "")
        {
            $query .= " AS ".$this->tableAlias;
        }

        $query .= " ON ";

        if($this->tableAlias != "")
        {
            $query .= " $this->leftTable.$this->leftField = $this->tableAlias.$this->rightField";
        }
        else
        {
            $query .= " $this->leftTable.$this->leftField = $this->rightTable.$this->rightField";
        }

        if(count($this->andCondition) > 0)
        {
            for($i = 0; $i < count($this->andCondition); $i++)
            {
                $query .= " AND ";

                if($i < (count($this->andCondition) - 1))
                {
                    $query .= " AND ";
                }

                $query .= $this->andCondition[$i];
            }
        }

        return $query;
    }

}

?>
