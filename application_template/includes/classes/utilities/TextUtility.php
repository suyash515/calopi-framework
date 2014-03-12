<?php


class TextUtility
{

    public static $LONG_WORK_TEXT_LIMIT = 130;

    public function __construct()
    {

    }

    public function reformatText($str)
    {
	$output = $str;

	$output = str_replace("amp;", "&", $output);
	$output = str_replace("&quot;", "\"", $output);
	$output = str_replace("&apos;", "'", $output);

	return $output;
    }

    public function formatLongWords($str)
    {
	$output = "";

//	$strArray = split(" ", $str);
	$strArray = explode(" ", $str);

	for($i = 0; $i < count($strArray); $i++)
	{
	    $text = $strArray[$i];

	    if(strlen($text) > TextUtility::$LONG_WORK_TEXT_LIMIT)
	    {
		$firstPart = substr($text, 0, TextUtility::$LONG_WORK_TEXT_LIMIT);
		$secondPart = substr($text, TextUtility::$LONG_WORK_TEXT_LIMIT, strlen($text));

		$output .= $firstPart."-<br />";

		if(strlen($secondPart) > TextUtility::$LONG_WORK_TEXT_LIMIT)
		{
		    $output .= $this->formatLongWords($secondPart);
		}
		else
		{
		    $output .= $secondPart;
		}
	    }
	    else
	    {
		$output .= $text;
	    }

	    $output .= " ";
	}

	return $output;
    }

    public static function reformatBreakLines($str)
    {
	return str_replace("\n", "<br />", $str);
    }

    public static function reformatNewLine($str)
    {
	return str_replace("<br />", "\n", $str);
    }

    public function stringEndsWith($string, $check)
    {
	$strlen = strlen($string);
	$testlen = strlen($check);

	if($testlen > $strlen)
	{
	    return false;
	}

	return substr_compare($string, $check, -$testlen) === 0;
    }

    public static function determinePlural($counter, $word)
    {
	$output = "";

	if($counter > 1)
	{
	    $output .= $counter." ".$word."s";
	}
	else
	{
	    $output .= $counter." ".$word;
	}

	return $output;
    }
}

?>