<?php


class SqlConcatenator
{

    public function __construct()
    {
	
    }

    public static function concatenateWhereANDCondition($array, $field)
    {
	$output = "";

	if(count($array) == 1)
	{
	    $output .= "$field='".$array[0]."'";
	}
	else
	{
	    for($i = 0; $i < count($array); $i++)
	    {
		if($i == 0)
		{
		    $output .= " $field='".$array[$i]."'";

		    if(count($array) > 0)
		    {
			$output .= " AND ";
		    }
		}
		else
		{
		    if($i < (count($array) - 1))
		    {
			$output .= " $field='".$array[$i]."' AND ";
		    }
		    else
		    {
			$output .= " $field='".$array[$i]."'";
		    }
		}
	    }
	}

	return $output;
    }

    public static function concatenateWhereORCondition($array, $field)
    {
	$output = "";

	if(count($array) == 1)
	{
	    $output .= "$field='".$array[0]."'";
	}
	else
	{
	    for($i = 0; $i < count($array); $i++)
	    {
		if($i == 0)
		{
		    $output .= " $field='".$array[$i]."'";

		    if(count($array) > 1)
		    {
			$output .= " OR ";
		    }
		}
		else
		{
		    if($i < (count($array) - 1))
		    {
			$output .= " $field='".$array[$i]."' OR ";
		    }
		    else
		    {
			$output .= " $field='".$array[$i]."'";
		    }
		}
	    }
	}

	return $output;
    }

    public static function concatenateWhereLikeORCondition($array, $field)
    {
	$output = "";

	if(count($array) == 1)
	{
	    $output .= "$field LIKE '%".$array[0]."%'";
	}
	else
	{
	    for($i = 0; $i < count($array); $i++)
	    {
		if($i == 0)
		{
		    $output .= " $field LIKE '%".$array[$i]."%'";

		    if(count($array) > 1)
		    {
			$output .= " OR ";
		    }
		}
		else
		{
		    if($i < (count($array) - 1))
		    {
			$output .= " $field LIKE '%".$array[$i]."%' OR ";
		    }
		    else
		    {
			$output .= " $field LIKE '%".$array[$i]."%'";
		    }
		}
	    }
	}

	return $output;
    }

    public static function createSelectInQueryPart($array)
    {
	$output = "";
	$text = "";

	$output .= "(";

	for($i = 0; $i < count($array); $i++)
	{
	    if($i == (count($array) - 1))
	    {
		$text .= $array[$i];
	    }
	    else
	    {
		$text .= $array[$i].", ";
	    }
	}

	if(strlen($text) > 0)
	{
	    $output = "($text)";
	}
	else
	{
	    $output = "";
	}

	return $output;
    }
}

?>
