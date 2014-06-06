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

    public static function stringStartsWith($text, $startText)
    {
	if(strlen($text) > 0)
	{
	    if(substr($text, 0, 1) == $startText)
	    {
		return true;
	    }
	}

	return false;
    }

    public static function formatNumber($number, $addCurrency = false)
    {
	$output = "";

	$formattedNumber = number_format($number, 2, ".", ",");

	if($addCurrency)
	{
	    $output = Configuration::$CURRENCY." ".$formattedNumber;
	}
	else
	{
	    $output = $formattedNumber;
	}

	return $output;
    }

    public static function getFileExtension($fileName)
    {
	$ext = end(explode(".", $fileName));

	return $ext;
    }

    public static function isStringEmpty($str)
    {
	if(strlen(trim($str)) == 0)
	{
	    return true;
	}
	else
	{
	    return false;
	}
    }
}

?>