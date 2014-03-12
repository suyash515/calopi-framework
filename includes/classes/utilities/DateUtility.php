<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateUtility
 *
 * @author user
 */
class DateUtility
{

    //put your code here
    private $shortMonthArray;
    private $shortDayArray;

    public function __construct()
    {
        $this->initialiseComponents();
    }

    private function initialiseComponents()
    {
        $this->initialiseShortMonthArray();
        $this->initialiseShortDayArray();
    }

    private function initialiseShortMonthArray()
    {
        $this->shortMonthArray[1] = "Jan";
        $this->shortMonthArray[2] = "Feb";
        $this->shortMonthArray[3] = "Mar";
        $this->shortMonthArray[4] = "Apr";
        $this->shortMonthArray[5] = "May";
        $this->shortMonthArray[6] = "Jun";
        $this->shortMonthArray[7] = "Jul";
        $this->shortMonthArray[8] = "Aug";
        $this->shortMonthArray[9] = "Sep";
        $this->shortMonthArray[10] = "Oct";
        $this->shortMonthArray[11] = "Nov";
        $this->shortMonthArray[12] = "Dec";
    }

    private function initialiseShortDayArray()
    {
        $this->shortDayArray[0] = "Sun";
        $this->shortDayArray[1] = "Mon";
        $this->shortDayArray[2] = "Tue";
        $this->shortDayArray[3] = "Wed";
        $this->shortDayArray[4] = "Thu";
        $this->shortDayArray[5] = "Fri";
        $this->shortDayArray[6] = "Sat";
    }

    public function getShortMonthString($index)
    {
        return $this->shortMonthArray[$index];
    }

    public function getShortDayString($index)
    {
        return $this->shortDayArray[$index];
    }

    public function getShortMonthIndex($monthString)
    {
        $array = array_keys($this->shortMonthArray, $monthString);

        return $array[0];
    }

    public function getShortDayIndex($dayString)
    {
        $array = array_keys($this->shortDayArray, $dayString);

        return $array[0];
    }

    /**
     * Takes a date in the form 'Sat 1 Nov, 2008 08:00' and converts it to a valid PHP date object
     *
     * @param <String> $strDate
     * @return <Error>
     */
    public function convertJavascriptDateToPhpDate($strDate)
    {
        $error = new Error();

        try
        {
            $splitText = explode(", ", $strDate);
            $firstPart = $splitText[0];
            $splitFirstPart = explode(" ", $firstPart);
            $dayString = $this->getShortDayIndex($splitFirstPart[0]);
            $dateString = $splitFirstPart[1];
            $monthString = $this->getShortMonthIndex($splitFirstPart[2]);

            $secondPart = $splitText[1];
            $splitSecondPart = explode(" ", $secondPart);
            $yearString = $splitSecondPart[0];
            $hourMinuteString = $splitSecondPart[1];

            $splitHourMinute = explode(":", $hourMinuteString);
            $hourString = $splitHourMinute[0];
            $minuteString = $splitHourMinute[1];

            $returnDate = mktime(intval($hourString), intval($minuteString), 0, intval($monthString),
                    intval($dateString), intval($yearString));
            $error->setObject($returnDate);
        }
        catch(Exception $e)
        {
            $error->setErrorExist(true);
            $error->addError("invalid date format");
        }

        return $error;
    }

    /**
     * Takes a date in the form 'Sat 1 Nov, 2008 08:00' and converts it to a valid SQL datetime object
     *
     * @param <Date> $date
     * @return <String>
     */
    public function convertDateTimeToMysqlDateTime($strDate)
    {
        $splitText = explode(", ", $strDate);
        $firstPart = $splitText[0];
        $splitFirstPart = explode(" ", $firstPart);
        $dayString = $this->getShortDayIndex($splitFirstPart[0]);
        $dateString = $splitFirstPart[1];
        $monthString = $this->getShortMonthIndex($splitFirstPart[2]);

        $secondPart = $splitText[1];
        $splitSecondPart = explode(" ", $secondPart);
        $yearString = $splitSecondPart[0];
        $hourMinuteString = $splitSecondPart[1];

        $splitHourMinute = explode(":", $hourMinuteString);
        $hourString = $splitHourMinute[0];
        $minuteString = $splitHourMinute[1];

        $phpDate = mktime(intval($hourString), intval($minuteString), 0, intval($monthString), intval($dateString),
                intval($yearString));

        return date("Y-m-d H:i:s", $phpDate);
    }

    /**
     * Takes a date in the form 'Wed 19 Nov, 2008' and converts it to a valid SQL datetime object
     *
     * @param <Date> $date
     * @return <String>
     */
    public function convertDateToMysqlDateTime($strDate)
    {
        $splitText = explode(", ", $strDate);
        $firstPart = $splitText[0];
        $splitFirstPart = explode(" ", $firstPart);
        $dayString = $this->getShortDayIndex($splitFirstPart[0]);
        $dateString = $splitFirstPart[1];
        $monthString = $this->getShortMonthIndex($splitFirstPart[2]);

        $secondPart = $splitText[1];
        $splitSecondPart = explode(" ", $secondPart);
        $yearString = $splitSecondPart[0];

        $phpDate = mktime(0, 0, 0, intval($monthString), intval($dateString), intval($yearString));

        return date("Y-m-d H:i:s", $phpDate);
    }

    /**
     * Takes a date in the form 'Wed 19 Nov, 2008' and converts it to a valid SQL date object
     *
     * @param <Date> $date
     * @return <String>
     */
    public function convertDateToMysqlDate($strDate)
    {
        try
        {
            $splitText = explode(", ", $strDate);
            $firstPart = $splitText[0];
            $splitFirstPart = explode(" ", $firstPart);
            $dayString = $this->getShortDayIndex($splitFirstPart[0]);
            $dateString = $splitFirstPart[1];
            $monthString = $this->getShortMonthIndex($splitFirstPart[2]);

            $secondPart = $splitText[1];
            $splitSecondPart = explode(" ", $secondPart);
            $yearString = $splitSecondPart[0];

            $phpDate = mktime(0, 0, 0, intval($monthString), intval($dateString), intval($yearString));

            return date("Y-m-d", $phpDate);
        }
        catch(Exception $e)
        {
            return "";
        }
    }

    /**
     * Takes a mysql datetime in the form '2008-11-06 08:00:00' and converts it to a valid SQL datetime object in the form 'Thu 6 Nov, 2008 08:00'
     *
     * @param <String> $date
     * @return <String>
     */
    public function convertMySqlDateTimeToJavascriptDateTime($strDate)
    {
        $partArray = explode(" ", $strDate);
        $datePart = $partArray[0];
        $timePart = $partArray[1];

        $datePartArray = explode("-", $datePart);
        $year = $datePartArray[0];
        $month = $datePartArray[1];
        $date = $datePartArray[2];

        $timePartArray = explode(":", $timePart);
        $hour = $timePartArray[0];
        $minute = $timePartArray[1];
        $second = $timePartArray[2];

        $phpDate = mktime($hour, $minute, $second, $month, $date, $year);

        $shortMonth = $this->getShortMonthString($month);
        $shortDay = $this->getShortDayString(date("w", $phpDate));

        return $shortDay." ".$date." ".$shortMonth.", ".$year." ".$hour.":".$minute;
    }

    /**
     * Takes a mysql datetime in the form '2008-11-06' and converts it to a valid SQL datetime object in the form 'Thu 6 Nov, 2008'
     *
     * @param <String> $date
     * @return <String>
     */
    public function convertMySqlDateToJavascriptDate($strDate)
    {
        $datePartArray = explode("-", $strDate);
        $year = $datePartArray[0];
        $month = $datePartArray[1];
        $date = $datePartArray[2];

        $phpDate = mktime(0, 0, 0, $month, $date, $year);

        $shortMonth = $this->getShortMonthString(intval($month));
        $shortDay = $this->getShortDayString(date("w", $phpDate));

        return $shortDay." ".$date." ".$shortMonth.", ".$year;
    }

}

?>
