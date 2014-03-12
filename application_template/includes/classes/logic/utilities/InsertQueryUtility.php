<?php

/**
 * Description of InsertQueryUtility
 *
 * @author suyash
 */
class InsertQueryUtility
{

    private $tableName;
    private $fields;
    private $values;

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
        $this->fields = array();
        $this->values = array();
    }

    public function addData($field, $value, $escape = false, $checkNull = false)
    {
        $this->fields[count($this->fields)] = $field;

        if (($checkNull) && (strlen($value) == 0))
        {
            $this->values[count($this->values)] = null;
        }
        else
        {
            if ($escape)
            {
                $this->values[count($this->values)] = mysql_escape_string($value);
            }
            else
            {
                $this->values[count($this->values)] = $value;
            }
        }
    }

    public function getUpdateQuery($whereCondition)
    {
        $output = "";

        if (count($this->fields) > 0)
        {
            $updatePart = "";
            $field = "";
            $value = "";

            for ($i = 0; $i < count($this->fields); $i++)
            {
                $field = $this->fields[$i];

                if (!is_null($this->values[$i]))
                {
                    $value = "\"".$this->values[$i]."\"";
                }
                else
                {
                    $value = "NULL";
                }

                $updatePart .= "$field = $value";

                if ($i < (count($this->fields) - 1))
                {
                    $updatePart .= ", ";
                }
            }

            $output .= "UPDATE ".$this->tableName." SET $updatePart WHERE $whereCondition";
        }

        return $output;
    }

    public function getInsertQuery()
    {
        $output = "";

        if (count($this->fields) > 0)
        {
            $fieldPart = "(";
            $valuesPart = "(";

            for ($i = 0; $i < count($this->fields); $i++)
            {
                $fieldPart .= $this->fields[$i];

                if (!is_null($this->values[$i]))
                {
                    $valuesPart .= "'".$this->values[$i]."'";
                }
                else
                {
                    $valuesPart .= "NULL";
                }

                if ($i < (count($this->fields) - 1))
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

    public function getDeleteQuery($whereCondition)
    {
        $output = "";

        $output .= "DELETE FROM ".$this->tableName." WHERE $whereCondition";

        return $output;
    }

    public function executeInsert()
    {
        $db = DBQuery::getInstance();

        return $db->executeNonQuery($this->getInsertQuery());
    }

    public function executeUpdate($whereCondition)
    {
        $db = DBQuery::getInstance();

        $db->executeNonQuery($this->getUpdateQuery($whereCondition));
    }

    public function executeDelete($whereCondition)
    {
        $db = DBQuery::getInstance();

        $db->executeNonQuery($this->getDeleteQuery($whereCondition));
    }

}

?>