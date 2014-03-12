<?php


class Debug
{

    public function __construct()
    {

    }

    public static function dumpArray($array, $arrayDescription="")
    {
	echo "<ph1>$arrayDescription</h1>";
	echo "<pre>";
	print_r($array);
	echo "</pre>";
    }

    public static function dumpDate($phpDate, $text = "")
    {
	$dateUtility = new DateUtility();

	echo "<p>$text : ".$dateUtility->formatFullDateTime($phpDate);
    }

    public static function dumpPost()
    {
        Debug::dumpArray($_POST);
    }

    public static function e($text)
    {
        echo "<p style='margin-top: 100px;'>$text</p>";
    }
}

?>