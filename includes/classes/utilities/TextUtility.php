<?php

class TextUtility
{

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

    public function formatTextForDatabase($str)
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
    public function checkNotSpecified($str)
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

    public function formatFileName($fileName)
    {
        $ret = $this->formatToCamelCapitalised($fileName);

        return $ret;
    }

    public function formatReadText($underscoredText)
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

    private function formatToCamelCapitalised($string)
    {
        $array = explode("_", $string);

        $retFileName = "";

        if(count($array) == 1)
        {
            $firstLetter = substr($string, 0, 1);

            $retFileName = strtoupper($firstLetter).substr($string, 1, strlen($string));
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

    public function formatVariableName($name)
    {
        $firstProcess = $this->formatToCamelCapitalised($name);

        $firstPart = substr($firstProcess, 0, 1);
        $secondPart = substr($firstProcess, 1, (strlen($firstProcess) - 1));

        $ret = strtolower($firstPart).$secondPart;

        return $ret;
    }

    public function formatVariableNameWithFirstLetterCapitalised($name)
    {
        $firstProcess = $this->formatToCamelCapitalised($name);

        return $firstProcess;
    }

}

?>