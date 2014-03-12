<?php


/**
 * Description of ArrayUtility
 *
 * @author suyash
 */
class ArrayUtility
{

    public static function convertArrayToUnderscoredString($array)
    {
	$output = "";

	if(count($array) == 0)
	{
	    return "";
	}
	elseif(count($array) == 1)
	{
	    return $array[0];
	}
	else
	{
	    for($i = 0; $i < count($array); $i++)
	    {
		if($i == (count($array) - 1))
		{
		    $output .= $array[$i];
		}
		else
		{
		    $output .= $array[$i]."_";
		}
	    }
	}

	return $output;
    }

    /**
     * Takes an array and groups it by the field specified
     * @param <type> $array
     * @param <type> $field
     */
    public static function groupArray($array, $field)
    {
	$groupedArray = array();

	for($i = 0; $i < count($array); $i++)
	{
	    $index = $array[$i][$field];

	    if(isset($groupedArray[$index]))
	    {
		$groupedArray[$index][count($groupedArray[$index])] = $array[$i];
	    }
	    else
	    {
		$groupedArray[$index][0] = $array[$i];
	    }
	}

	return $groupedArray;
    }
}

?>
