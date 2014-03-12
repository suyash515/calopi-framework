<?php

class TextUtility
{

    public static function reformatText($str)
    {
        $output = $str;

        $output = str_replace("amp;", "&", $output);
        $output = str_replace("&quot;", "\"", $output);
        $output = str_replace("&apos;", "'", $output);

        return $output;
    }

    public static function formatTextForDatabase($str)
    {
        $output = $str;

        $output = str_replace("\"", "&quot;", $output);
        $output = str_replace("'", "&apos;", $output);
        $output = str_replace("&", "amp;", $output);

        return $output;
    }

    /**
     * If the parameter is an empty string, then '(not specified)' is returned, else the string is returned.
     *
     * @param <String> $str
     */
    public static function checkNotSpecified($str)
    {
        if(strlen($str) > 0)
        {
            return $str;
        }
        else
        {
            return "<span style='color: gray'>(not specified)</span>";
        }
    }

    public static function formatFileName($underscoredString)
    {
        $ret = TextUtility::formatToCamelCapitalised($underscoredString);

        return $ret;
    }

    public static function formatReadText($underscoredText)
    {
        $array = explode("_", $underscoredText);

        $retString = "";

        if(count($array) == 1)
        {
            $firstLetter = substr($underscoredText, 0, 1);

            $retString = strtoupper($firstLetter).substr($underscoredText, 1, strlen($underscoredText));
        }
        else
        {
            for($i = 0; $i < count($array); $i++)
            {
                $text = $array[$i];

                $firstLetter = substr($text, 0, 1);

                $array[$i] = strtoupper($firstLetter).substr($text, 1, strlen($text));
            }

            $ret = implode(" ", $array);

            $retString = $ret;
        }

        return $retString;
    }

    public static function formatToCamelCapitalised($underscoredString)
    {
        $array = explode("_", $underscoredString);

        $retFileName = "";

        if(count($array) == 1)
        {
            $firstLetter = substr($underscoredString, 0, 1);

            $retFileName = strtoupper($firstLetter).substr($underscoredString, 1, strlen($underscoredString));
        }
        else
        {
            for($i = 0; $i < count($array); $i++)
            {
                $text = $array[$i];

                $firstLetter = substr($text, 0, 1);

                $array[$i] = strtoupper($firstLetter).substr($text, 1, strlen($text));
            }

            $ret = implode($array);

            $retFileName = $ret;
        }

        return $retFileName;
    }

    public static function formatVariableName($name)
    {
        $firstProcess = TextUtility::formatToCamelCapitalised($name);

        $firstPart = substr($firstProcess, 0, 1);
        $secondPart = substr($firstProcess, 1, (strlen($firstProcess) - 1));

        $ret = strtolower($firstPart).$secondPart;

        return $ret;
    }

    public static function formatVariableNameWithFirstLetterCapitalised($name)
    {
        $firstProcess = TextUtility::formatToCamelCapitalised($name);

        return $firstProcess;
    }

    public static function formatStaticVariable($underscoredString)
    {
        return strtoupper($underscoredString);
    }

    public static function removeLastSlash($text)
    {
        $retString = "";

        $lastCharacter = substr($text, strlen($text) - 1, 1);

        if($lastCharacter == DIRECTORY_SEPARATOR)
        {
            $retString = substr($text, 0, strlen($text) - 1);
        }
        else
        {
            $retString = $text;
        }

        return $retString;
    }

}

?>