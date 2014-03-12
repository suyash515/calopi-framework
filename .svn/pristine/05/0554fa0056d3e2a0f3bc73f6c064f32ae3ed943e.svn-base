<?php

/**
 * Description of QueryData
 *
 * @author suyash
 */
class QueryData
{

    private $field;
    private $data;
    private $quoteStyle;

    public function __construct($field, $data, $quoteStyle)
    {
        $this->field = $field;
        $this->data = $data;

        if($quoteStyle == "")
        {
            $this->quoteStyle = QueryBuilder::$SINGLE_QUOTE;
        }
        else
        {
            $this->quoteStyle = $quoteStyle;
        }
    }

    public function getField()
    {
        return $this->field;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getQuotedData()
    {
        $output = "";

        if($this->quoteStyle == QueryBuilder::$SINGLE_QUOTE)
        {
            $output .= "'$this->data'";
        }
        elseif($this->quoteStyle == QueryBuilder::$DOUBLE_QUOTE)
        {
            $output .= "\"$this->data\"";
        }

        return $output;
    }

    public function getQuery()
    {
        $output = "";

        if($this->quoteStyle == QueryBuilder::$SINGLE_QUOTE)
        {
            $output .= "$this->field = '$this->data'";
        }
        elseif($this->quoteStyle == QueryBuilder::$DOUBLE_QUOTE)
        {
            $output .= "$this->field = \"$this->data\"";
        }

        return $output;
    }

}

?>
