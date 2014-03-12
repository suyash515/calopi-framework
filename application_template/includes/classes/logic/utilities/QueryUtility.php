<?php

/**
 * Description of InsertQueryUtility
 *
 * @author suyash
 */
class QueryUtility
{

    private $tableName;
    private $fields;
    private $values;
    private $queryDataArray;
    public static $SINGLE_QUOTE = "single_quote";
    public static $DOUBLE_QUOTE = "double_quote";

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
        $this->fields = array();
        $this->values = array();
        $this->queryDataArray = array();
    }

    public function addData($field, $value, $escape = false)
    {
        $this->fields[count($this->fields)] = $field;

        if($escape)
        {
            $this->values[count($this->values)] = mysql_escape_string($value);
        }
        else
        {
            $this->values[count($this->values)] = $value;
        }
    }

    public function addQueryData($field, $data, $quoteStyle = "")
    {
        if($quoteStyle == "")
        {
            $quoteStyle == QueryUtility::$DOUBLE_QUOTE;
        }

        $this->queryDataArray[count($this->queryDataArray)] = new QueryData($field, $data, $quoteStyle);
    }

    public function getUpdateQuery($whereCondition)
    {
        $output = "";

        if(count($this->fields) > 0)
        {
            $updatePart = "";
            $field = "";
            $value = "";

            for($i = 0; $i < count($this->fields); $i++)
            {
                $field = $this->fields[$i];
                $value = "\"".$this->values[$i]."\"";

                $updatePart .= "$field = $value";

                if($i < (count($this->fields) - 1))
                {
                    $updatePart .= ", ";
                }
            }

            $output .= "UPDATE ".$this->tableName." SET $updatePart WHERE $whereCondition";
        }

        return $output;
    }

    private function getConditionPart()
    {
        $output = "";

        for ($i = 0; $i < count($this->queryDataArray); $i++)
        {
            $output .= $this->queryDataArray[$i]->getDisplay();

            if ($i < (count($this->queryDataArray) - 1))
            {
                $output .= ", ";
            }
        }

        return $output;
    }

    public function getDeleteQuery($whereCondition)
    {
        $output = "";

        $output .= "DELETE FROM ".$this->tableName." WHERE $whereCondition";

        return $output;
    }

    public function getInsertQuery()
    {
        $output = "";

        if(count($this->fields) > 0)
        {
            $fieldPart = "(";
            $valuesPart = "(";

            for($i = 0; $i < count($this->fields); $i++)
            {
                $fieldPart .= $this->fields[$i];
                $valuesPart .= "'".$this->values[$i]."'";

                if($i < (count($this->fields) - 1))
                {
                    $fieldPart .= ", ";
                    $valuesPart .= ", ";
                }
            }

            $fieldPart .= ")";
            $valuesPart .= ")";

            $output .= "INSERT INTO ".$this->tableName." $fieldPart VALUES $valuesPart";
        }

        return $output;
    }

    public function executeInsert()
    {
        $db = DBQuery::getInstance();

        return $db->executeNonQuery($this->getInsertQuery());
    }

    public function executeDelete($whereCondition)
    {
        $db = DBQuery::getInstance();

        $db->executeNonQuery($this->getDeleteQuery($whereCondition));
    }

    public function executeUpdate($whereCondition)
    {
        $db = DBQuery::getInstance();

        $db->executeNonQuery($this->getUpdateQuery($whereCondition));
    }

}

?>