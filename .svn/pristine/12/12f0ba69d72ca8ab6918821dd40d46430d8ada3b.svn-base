<?php

/**
 * Description of SortQuery
 *
 * @author suyash
 */
class SortQuery
{

    private $sortByArray;
    private $sortTypeArray;
    public static $ASCENDING = "asc";
    public static $DESCENDING = "desc";

    public function __construct()
    {
        $this->sortByArray = array();
        $this->sortTypeArray = array();
    }

    public function addSort($sortBy, $sortType = "", $table = "")
    {
        if($sortType == "")
        {
            $sortType = SortQuery::$ASCENDING;
        }

        if($table == "")
        {
            $this->sortByArray[count($this->sortByArray)] = $sortBy;
        }
        else
        {
            $this->sortByArray[count($this->sortByArray)] = $table.".".$sortBy;
        }

        $this->sortTypeArray[count($this->sortTypeArray)] = $sortType;
    }

    public function getCount()
    {
        return count($this->sortByArray);
    }

    public function getQueryPart($index)
    {
        $orderByCondition = "";

        if(isset($this->sortByArray[$index]))
        {
            $orderByCondition = $this->sortByArray[$index];

            if(isset($this->sortTypeArray[$index]))
            {
                $orderByCondition .= " ".$this->sortTypeArray[$index];
            }
        }

        return $orderByCondition;
    }

    public function getQuery()
    {
        $output = "";

        for($i = 0; $i < count($this->sortByArray); $i++)
        {
            $output .= $this->getQueryPart($i);
        }

        return $output;
    }

}

?>
