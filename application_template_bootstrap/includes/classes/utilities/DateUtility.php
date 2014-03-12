<?php

/**
 * Description of DateUtility
 *
 * @author user
 */
class DateUtility
{

    private $shortMonthArray;
    private $shortDayArray;
    private $longMonthArray;

    public function __construct()
    {
        $this->initialiseComponents();
    }

    private function initialiseComponents()
    {
        $this->initialiseShortMonthArray();
        $this->initialiseShortDayArray();
        $this->initialiseLongMonthArray();
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

    private function initialiseLongMonthArray()
    {
        $this->longMonthArray[1] = "January";
        $this->longMonthArray[2] = "February";
        $this->longMonthArray[3] = "March";
        $this->longMonthArray[4] = "April";
        $this->longMonthArray[5] = "May";
        $this->longMonthArray[6] = "June";
        $this->longMonthArray[7] = "July";
        $this->longMonthArray[8] = "August";
        $this->longMonthArray[9] = "September";
        $this->longMonthArray[10] = "October";
        $this->longMonthArray[11] = "November";
        $this->longMonthArray[12] = "December";
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

    public function getShortMonthArray()
    {
        return $this->shortMonthArray;
    }

    public function getLongMonthArray()
    {
        return $this->longMonthArray;
    }

    public function getLongMonth($monthIndex)
    {
        return $this->longMonthArray[$monthIndex];
    }

    public function getLongMonthIndex($monthString)
    {
        $array = array_keys($this->longMonthArray, $monthString);

        return $array[0];
    }

    /**
     * Takes a date in the form 'Sat 1 Nov, 2008  08:00' and converts it to a valid PHP date object
     *
     * @param <String> $strDate
     * @return <Error>
     */
    public function convertJavascriptDateTimeToPhpDate($strDate)
    {
        $error = new Error();

        try
        {
            $splitText = explode(", ", $strDate);
            $firstPart = $splitText[0];
            $splitFirstPart = explode(" ", $firstPart);
//			$dayString = $this->getShortDayIndex($splitFirstPart[0]);
            $dateString = $splitFirstPart[1];
            $monthString = $this->getShortMonthIndex($splitFirstPart[2]);

            $secondPart = $splitText[1];
            $splitSecondPart = explode(" ", $secondPart);
            $yearString = $splitSecondPart[0];
            $hourMinuteString = $splitSecondPart[1];

            $splitHourMinute = explode(":", $hourMinuteString);
            $hourString = $splitHourMinute[0];
            $minuteString = $splitHourMinute[1];

            $returnDate = mktime(intval($hourString), intval($minuteString), 0, intval($monthString), intval($dateString), intval($yearString));
            $error->setObject($returnDate);
        }
        catch(Exception $e)
        {
            $error->setErrorExist(true);
            $error->addError("invalid date format");
        }

        return $error;
    }

    public function convertJavascriptDateToPhpDate($strDate)
    {
        $error = new Error();

        try
        {
            $splitText = explode(", ", $strDate);
            $firstPart = $splitText[0];
            $splitFirstPart = explode(" ", $firstPart);
            $dateString = $splitFirstPart[1];
            $monthString = $this->getShortMonthIndex($splitFirstPart[2]);

            $secondPart = $splitText[1];
            $splitSecondPart = explode(" ", $secondPart);
            $yearString = $splitSecondPart[0];

            $returnDate = mktime(0, 0, 0, intval($monthString), intval($dateString), intval($yearString));
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
        $month = trim(intval($datePartArray[1])); //strip of leading zeros
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
     * Takes a mysql datetime in the form '2008-11-06 08:00:00' and converts it to a valid SQL datetime object in the form 'Thu 6 Nov, 2008 08:00'
     *
     * @param <String> $date
     * @return <String>
     */
    public function convertMySqlDateTimeToJavascriptDateOnly($strDate)
    {
        $partArray = explode(" ", $strDate);
        $datePart = $partArray[0];
        $timePart = $partArray[1];

        $datePartArray = explode("-", $datePart);
        $year = $datePartArray[0];
        $month = trim(intval($datePartArray[1])); //strip of leading zeros
        $date = $datePartArray[2];

        $timePartArray = explode(":", $timePart);
        $hour = $timePartArray[0];
        $minute = $timePartArray[1];
        $second = $timePartArray[2];

        $phpDate = mktime($hour, $minute, $second, $month, $date, $year);

        $shortMonth = $this->getShortMonthString($month);
        $shortDay = $this->getShortDayString(date("w", $phpDate));

        return $shortDay." ".$date." ".$shortMonth.", ".$year;
    }

    /**
     * Takes a mysql time in the form '08:00:00' and converts it to a valid javascript datetime object in the form '08:00'
     *
     * @param <String> $date
     * @return <String>
     */
    public function convertMySqlTimeToJavascriptTime($strTime)
    {
        $timePartArray = explode(":", $strTime);
        $hour = $timePartArray[0];
        $minute = $timePartArray[1];
        $second = $timePartArray[2];

        $phpDate = mktime($hour, $minute, $second, 1, 1, 2010);

        $shortMonth = $this->getShortMonthString($month);
        $shortDay = $this->getShortDayString(date("w", $phpDate));

        return $hour.":".$minute;
    }

    /**
     * Takes a javascript time in the form '08:00' and converts it to a valid javascript datetime object in the form '08:00:00'
     *
     * @param <String> $date
     * @return <String>
     */
    public function convertJavascriptTimeToMysqlTime($strTime)
    {
        $timePartArray = explode(":", $strTime);
        $hour = $timePartArray[0];
        $minute = $timePartArray[1];

        return $hour.":".$minute.":00";
    }

    public function convertPhpDateToJavascriptDate($phpDate)
    {
        $month = date("n", $phpDate);
        $date = date("j", $phpDate);
        $year = date("Y", $phpDate);

        $shortMonth = $this->getShortMonthString($month);
        $shortDay = $this->getShortDayString(date("w", $phpDate));

        return $shortDay." ".$date." ".$shortMonth.", ".$year;
    }

    public function convertPhpDateToJavascriptDateTime($phpDate)
    {
        $month = date("n", $phpDate);
        $date = date("j", $phpDate);
        $year = date("Y", $phpDate);
        $hour = date("H", $phpDate);
        $minute = date("i", $phpDate);

        $shortMonth = $this->getShortMonthString($month);
        $shortDay = $this->getShortDayString(date("w", $phpDate));
        $formattedDate = $this->formatWithLeadingZero($date);

        return $shortDay." ".$formattedDate." ".$shortMonth.", ".$year." ".$hour.":".$minute;
    }

    public function formatWithLeadingZero($number)
    {
        if(intval($number) < 10)
        {
            return "0".intval($number);
        }
        else
        {
            return intval($number);
        }
    }

    /**
     * Takes a date in the form 'Sat 1 Nov, 2008  08:00' and converts it to a valid SQL datetime object in the form '2008-11-06 08:00:00'
     *
     * @param <Date> $date
     * @return <String>
     */
    public function convertToMysqlDateTime($strDate)
    {
        $splitText = explode(", ", $strDate);
        $firstPart = $splitText[0];
        $splitFirstPart = explode(" ", $firstPart);
//		$dayString = $this->getShortDayIndex($splitFirstPart[0]);
        $dateString = $splitFirstPart[1];
        $monthString = $this->getShortMonthIndex($splitFirstPart[2]);

        $secondPart = $splitText[1];
        $splitSecondPart = explode(" ", $secondPart);
        $yearString = $splitSecondPart[0];
        $hourMinuteString = $splitSecondPart[1];

        $splitHourMinute = explode(":", $hourMinuteString);
        $hourString = $splitHourMinute[0];
        $minuteString = $splitHourMinute[1];

        $phpDate = mktime(intval($hourString), intval($minuteString), 0, intval($monthString), intval($dateString), intval($yearString));

        return date("Y-m-d H:i:s", $phpDate);
    }

    public function convertPhpDateToMysqlDate($phpDate)
    {
        return date("Y-m-d H:i:s", $phpDate);
    }

    public function convertPhpDateToMysqlDateOnly($phpDate)
    {
        return date("Y-m-d", $phpDate);
    }

    public function convertPhpDateToMysqlTimeOnly($phpDate)
    {
        return date("H:i:s", $phpDate);
    }

    public function convertMySqlDateTimeToPhpTimestamp($strDate)
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

        return $phpDate;
    }

    public function convertMySqlDateOnlyToPhpTimestamp($strDate)
    {
        $datePartArray = explode("-", $strDate);
        $year = $datePartArray[0];
        $month = $datePartArray[1];
        $date = $datePartArray[2];

        $phpDate = mktime(1, 1, 1, $month, $date, $year);

        return $phpDate;
    }

    public function convertMysqlDateToJavascriptDate($strDate)
    {
        $dateArray = explode("-", $strDate);
        $year = $dateArray[0];
        $month = $dateArray[1];
        $date = $dateArray[2];

        $phpDate = mktime(0, 0, 1, $month, $date, $year);
        return $this->convertPhpDateToJavascriptDate($phpDate);
    }

    public function convertJavascriptDateToMysqlDate($strDate)
    {
        $phpDate = $this->convertJavascriptDateToPhpDate($strDate);

        return $this->convertPhpDateToMysqlDateOnly($phpDate->getObject());
    }

    public function formatMysqlDateTimeToHourMinute($strDate)
    {
        $splitText = explode(" ", $strDate);
        $timePart = $splitText[1];
        $splitTime = explode(":", $timePart);

        return $splitTime[0].":".$splitTime[1];
    }

    public function rollHourForward($date)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime(($hour + 1), $minute, $second, $month, $day, $year);

        return $newDate;
    }

    public function rollMinutesForward($date, $minuteInterval)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime($hour, $minute + $minuteInterval, $second, $month, $day, $year);

        return $newDate;
    }

    public function rollMinutesBackward($date, $minuteInterval)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime($hour, $minute - $minuteInterval, $second, $month, $day, $year);

        return $newDate;
    }

    public function rollHourBackward($date)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime(($hour - 1), $minute, $second, $month, $day, $year);

        return $newDate;
    }

    /**
     *
     * @param <timestamp> $date
     * @return <timestamp>
     */
    public function rollDayForward($date)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime($hour, $minute, $second, $month, ($day + 1), $year);

        return $newDate;
    }

    /**
     *
     * @param <timestamp> $date
     * @return <timestamp>
     */
    public function rollDayBackward($date)
    {
        $newDate = $date - (24 * 60 * 60);

        return $newDate;
    }

    public function rollWeekBackward($date)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $currentDate = mktime($hour, $minute, $second, $month, $day, $year);
        $newDate = $currentDate - (7 * 24 * 60 * 60);

        return $newDate;
    }

    public function rollWeekForward($date)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $currentDate = mktime($hour, $minute, $second, $month, $day, $year);
        $newDate = $currentDate + (7 * 24 * 60 * 60);

        return $newDate;
    }

    public function rollMonthBackward($date)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime($hour, $minute, $second, ($month - 1), $day, $year);

        return $newDate;
    }

    public function rollMonthBackwardByInterval($date, $interval)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime($hour, $minute, $second, ($month - intval($interval)), $day, $year);

        return $newDate;
    }

    public function rollMonthForward($date)
    {
        $dateArray = getdate($date);

        $year = $dateArray['year'];
        $month = $dateArray['mon'];
        $day = $dateArray['mday'];
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $newDate = mktime($hour, $minute, $second, ($month + 1), $day, $year);

        return $newDate;
    }

    public function rollHourForwardByInterval($date, $duration)
    {
        if(is_numeric($duration))
        {
            $dateArray = getdate($date);

            $year = $dateArray['year'];
            $month = $dateArray['mon'];
            $day = $dateArray['mday'];
            $hour = $dateArray['hours'];
            $minute = $dateArray['minutes'];
            $second = $dateArray['seconds'];

            $newDate = mktime(($hour + $duration), $minute, $second, $month, $day, $year);

            return $newDate;
        }
        else
        {
            return $date;
        }
    }

    public function rollDayForwardByInterval($date, $duration)
    {
        if(is_numeric($duration))
        {
            $dateArray = getdate($date);

            $year = $dateArray['year'];
            $month = $dateArray['mon'];
            $day = $dateArray['mday'];
            $hour = $dateArray['hours'];
            $minute = $dateArray['minutes'];
            $second = $dateArray['seconds'];

            $newDate = mktime($hour, $minute, $second, $month, ($day + $duration), $year);

            return $newDate;
        }
        else
        {
            return $date;
        }
    }

    public function rollDayBackwardByInterval($date, $duration)
    {
        if(is_numeric($duration))
        {
            $dateArray = getdate($date);

            $year = $dateArray['year'];
            $month = $dateArray['mon'];
            $day = $dateArray['mday'];
            $hour = $dateArray['hours'];
            $minute = $dateArray['minutes'];
            $second = $dateArray['seconds'];

            $newDate = mktime($hour, $minute, $second, $month, ($day - $duration), $year);

            return $newDate;
        }
        else
        {
            return $date;
        }
    }

    public function rollWeekForwardByInterval($date, $duration)
    {
        if(is_numeric($duration))
        {
            $dateArray = getdate($date);

            $year = $dateArray['year'];
            $month = $dateArray['mon'];
            $day = $dateArray['mday'];
            $hour = $dateArray['hours'];
            $minute = $dateArray['minutes'];
            $second = $dateArray['seconds'];

            $currentDate = mktime($hour, $minute, $second, $month, $day, $year);
            $newDate = $currentDate + (intval($duration) * 7 * 24 * 60 * 60);

            return $newDate;
        }
        else
        {
            return $date;
        }
    }

    public function rollMonthForwardByInterval($date, $duration)
    {
        if(is_numeric($duration))
        {
            $dateArray = getdate($date);

            $year = $dateArray['year'];
            $month = $dateArray['mon'];
            $day = $dateArray['mday'];
            $hour = $dateArray['hours'];
            $minute = $dateArray['minutes'];
            $second = $dateArray['seconds'];

            $newDate = mktime($hour, $minute, $second, ($month + $duration), $day, $year);

            return $newDate;
        }
        else
        {
            return $date;
        }
    }

    public function rollYearForwardByInterval($date, $duration)
    {
        if(is_numeric($duration))
        {
            $dateArray = getdate($date);

            $year = $dateArray['year'];
            $month = $dateArray['mon'];
            $day = $dateArray['mday'];
            $hour = $dateArray['hours'];
            $minute = $dateArray['minutes'];
            $second = $dateArray['seconds'];

            $newDate = mktime($hour, $minute, $second, $month, $day, ($year + $duration));

            return $newDate;
        }
        else
        {
            return $date;
        }
    }

    public function formatFullMySqlDateTime($mysqlDateTime)
    {
//	$partArray = explode(" ", $mysqlDateTime);
        $partArray = explode(" ", $mysqlDateTime);
        $datePart = $partArray[0];
        $timePart = $partArray[1];

//	$datePartArray = explode("-", $datePart);
        $datePartArray = explode("-", $datePart);
        $year = $datePartArray[0];
        $month = $datePartArray[1];
        $day = $datePartArray[2];

//	$timePartArray = explode(":", $timePart);
        $timePartArray = explode(":", $timePart);
        $hour = $timePartArray[0];
        $minute = $timePartArray[1];
        $second = $timePartArray[2];

        $phpDate = mktime($hour, $minute, $second, $month, $day, $year);
        $strPhpDate = $this->formatFullDateTime($phpDate);

        return $strPhpDate;
    }

    public function formatMySqlDate($mysqlDateTime)
    {
//	$dateArray = explode(" ", $mysqlDateTime);
        $dateArray = explode(" ", $mysqlDateTime);
        $datePart = $dateArray[0];
//	$datePartArray = explode("-", $datePart);
        $datePartArray = explode("-", $datePart);
        $year = $datePartArray[0];
        $month = $datePartArray[1];
        $day = $datePartArray[2];

        $phpDate = mktime(1, 1, 1, $month, $day, $year);
        $strPhpDate = $this->formatDate($phpDate);

        return $strPhpDate;
    }

    public function formatStartEndCompressed($mysqlStartDateTime, $mysqlEndDateTime)
    {
        $phpStartDate = $this->convertMySqlDateTimeToPhpTimestamp($mysqlStartDateTime);
        $phpEndDate = $this->convertMySqlDateTimeToPhpTimestamp($mysqlEndDateTime);

        $startDateArray = getdate($phpStartDate);
        $startYear = $startDateArray['year'];
        $startMonth = $startDateArray['mon'];
        $startDay = $startDateArray['mday'];

        $endDateArray = getdate($phpEndDate);
        $endYear = $endDateArray['year'];
        $endMonth = $endDateArray['mon'];
        $endDay = $endDateArray['mday'];

        $conditionYear = ($startYear == $endYear);
        $conditionMonth = ($startMonth == $endMonth);
        $conditionDay = ($startDay == $endDay);

        $formattedStartDate = "";
        $formattedEndDate = "";

        if($conditionYear and $conditionMonth and $conditionDay)
        {
            $formattedStartDate = $this->formatHourMinute($phpStartDate);
            $formattedEndDate = $this->formatFullMySqlDateTime($mysqlEndDateTime);
        }
        else
        {
            $formattedStartDate = $this->formatFullMySqlDateTime($mysqlStartDateTime);
            $formattedEndDate = $this->formatFullMySqlDateTime($mysqlEndDateTime);
        }

        return $formattedStartDate." to ".$formattedEndDate;
    }

    public function formatHourMinute($phpDate)
    {
        return date("H:i", $phpDate);
    }

    public function formatFullDateTime($phpDate)
    {
        return date("H:i D, j M, Y", $phpDate);
    }

    public function formatDate($phpDate)
    {
        return date("D, j M, Y", $phpDate);
    }

    public function checkSameMonth($phpStartDate, $phpEndDate)
    {
        $startDateArray = getdate($phpStartDate);
        $startMonth = $startDateArray['mon'];

        $endDateArray = getdate($phpEndDate);
        $endMonth = $endDateArray['mon'];

        if($startMonth == $endMonth)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function checkSameDateUptoDay($phpStartDate, $phpEndDate)
    {
        $startDateArray = getdate($phpStartDate);
        $startYear = $startDateArray['year'];
        $startMonth = $startDateArray['mon'];
        $startDay = $startDateArray['mday'];

        $endDateArray = getdate($phpEndDate);
        $endYear = $endDateArray['year'];
        $endMonth = $endDateArray['mon'];
        $endDay = $endDateArray['mday'];

        if(($startYear == $endYear) and ($startMonth == $endMonth) and ($startDay == $endDay))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getMinutesBetweenMysqlDates($startDate, $endDate)
    {
        $convertedStartDate = $this->convertMySqlDateTimeToPhpTimestamp($startDate);
        $convertedEndDate = $this->convertMySqlDateTimeToPhpTimestamp($endDate);

        $difference = $convertedEndDate - $convertedStartDate;

        $differenceInMinutes = ($difference / 60);

        return $differenceInMinutes;
    }

    public function convertToHourMinute($timestamp)
    {
        $convertedNumber = intval($timestamp);

        $hours = intval($convertedNumber / 3600);
        $minutes = intval(($convertedNumber % 3600) / 60);

        $hours = number_format($hours, 0);
        $minutes = number_format($minutes, 0);

        if($hours < 10)
        {
            if($hours > 0)
            {
                $hours = "0".$hours;
            }
            elseif(($hours < 0) and ($hours > -10))
            {
                $negativeSign = substr($hours, 0, 1);
                $negativeNumber = substr($hours, 1, strlen($hours));
                $hours = $negativeSign."0".$negativeNumber;
            }
        }

        $minutes = intval($minutes);

        if($minutes < 0)
        {
            $minutes = "00";
        }
        elseif($minutes < 10)
        {
            $minutes = "0".$minutes;
        }

        return $hours.":".$minutes;
    }

    public function convertToHourMinuteSecond($strMinutes)
    {
        $convertedMinutes = intval($strMinutes);
        $hours = $convertedMinutes / 60;
        $minutes = $convertedMinutes % 60;

        $hours = number_format($hours, 0);
        $minutes = number_format($minutes, 0);

        if($hours < 10)
        {
            if($hours > 0)
            {
                $hours = "0".$hours;
            }
            elseif(($hours < 0) and ($hours > -10))
            {
                $negativeSign = substr($hours, 0, 1);
                $negativeNumber = substr($hours, 1, strlen($hours));
                $hours = $negativeSign."0".$negativeNumber;
            }
        }

        if($minutes < 10)
        {
            $minutes = "0".$minutes;
        }

        return $hours.":".$minutes.":00";
    }

    public function convertMinutesToHourMinute($strMinutes)
    {
        $convertedMinutes = intval($strMinutes);
        $hours = intval($convertedMinutes / 60);
        $minutes = intval($convertedMinutes % 60);

        $hours = number_format($hours, 0);
        $minutes = number_format($minutes, 0);

        if($hours < 10)
        {
            if($hours > 0)
            {
                $hours = "0".$hours;
            }
            elseif(($hours < 0) and ($hours > -10))
            {
                $negativeSign = substr($hours, 0, 1);
                $negativeNumber = substr($hours, 1, strlen($hours));
                $hours = $negativeSign."0".$negativeNumber;
            }
        }

        if($minutes < 10)
        {
            $minutes = "0".$minutes;
        }

        return $hours." hrs ".$minutes." mins";
    }

    public function getDifferenceInMinutesFromGMT($timezone)
    {
        if($timezone == "")
        {
            return 0;
        }
        else
        {
            $dateTimeZone = new DateTimeZone($timezone);
            $datetime = new DateTime("now", $dateTimeZone);
            $timeOffset = $dateTimeZone->getOffset($datetime);

            return ($timeOffset / 60);
        }
    }

    public function adjustTimezoneOffset($phpDate, $offset)
    {
        $result = $phpDate - ($offset * 60);

        return $result;
    }

    public function getCurrentJavascriptDateTime($timezone)
    {
        $currentDate = time();

        $dateObject = getdate($currentDate);

        $date = $dateObject['mday'];
        $month = $dateObject['mon'];
        $year = $dateObject['year'];
        $hour = $dateObject['hours'];
        $minute = $dateObject['minutes'];

        $formattedMinute = $this->formatWithLeadingZero($minute);
        $formattedHour = $this->formatWithLeadingZero($hour);

        $monthString = $this->getShortMonthString($month);
        $dayString = $this->getShortDayString($dateObject['wday']);

        return "$dayString $date $monthString, $year $formattedHour:$formattedMinute";
    }

    public function formatMinuteToFives($minute)
    {
        return (intval($minute / 5)) * 5;
    }

    /**
     * Converts a $time parameter in the format hh:mm:ss into hh:mm
     *
     * @param <type> $time
     */
    public function formatTimeToHourMinute($time)
    {
        $timeArray = explode(":", $time);

        $retTime = $timeArray[0].":".$timeArray[1];

        return $retTime;
    }

    /**
     * Converts a String in the form hh:mm into a php time object
     *
     * @param <type> $time
     * @return <type> Time
     */
    public function convertHourMinuteStringToTime($time)
    {
        $timeArray = explode(":", $time);

        $retTime = mktime($timeArray[0], $timeArray[1], 0);

        return $retTime;
    }

    /**
     * Gets the number of seconds since the day has started e.g. if the time passed as parameter is 10/09/2010 05:10:00, then the return value
     * will be ((10 * 60) + (5 * 60 * 60))
     * Only the minute and hour field is taken into consideration, the seconds field is NOT taken into consideration
     *
     * @param <type> $time
     */
    public function getNumberOfSecondsFromStartOfDay($time)
    {
        $hour = date("G", $time);
        $minute = date("i", $time);

        return (($minute * 60) + ($hour * 60 * 60));
    }

    /**
     * Gets the number of minutes since the day has started e.g. if the time passed as parameter is 10/09/2010 05:10:00, then the return value
     * will be ((10) + (5 * 60))
     * Only the minute and hour field is taken into consideration, the seconds field is NOT taken into consideration
     *
     * @param <type> $time
     */
    public function getNumberOfMinutesFromStartOfDay($time)
    {
        $hour = date("G", $time);
        $minute = date("i", $time);

        return (($minute) + ($hour * 60));
    }

    public function getCurrentGMTMysqlDateTime()
    {
        $phpStartDate = time();
        $offset = (intval(date("Z")) / 60);

        $phpAdjustedStartDate = $this->adjustTimezoneOffset($phpStartDate, $offset);
        $convertedStartDate = $this->convertPhpDateToMysqlDate($phpAdjustedStartDate);

        return $convertedStartDate;
    }

    public function getCurrentGMTMysqlDate()
    {
        $phpDate = time();
        $offset = (intval(date("Z")) / 60);

        $phpAdjustedDate = $this->adjustTimezoneOffset($phpDate, $offset);
        $convertedDate = $this->convertPhpDateToMysqlDateOnly($phpAdjustedDate);

        return $convertedDate;
    }

    public function getCurrentGMTPhpTimestamp()
    {
        return $this->convertMySqlDateTimeToPhpTimestamp($this->getCurrentGMTMysqlDateTime());
    }

    public function changeTime($phpDate, $phpDateReference)
    {
        $phpDateArray = getdate($phpDate);

        $year = $phpDateArray['year'];
        $month = $phpDateArray['mon'];
        $day = $phpDateArray['mday'];

        $phpDateReferenceArray = getdate($phpDateReference);
        $hour = $phpDateReferenceArray['hours'];
        $minute = $phpDateReferenceArray['minutes'];
        $second = $phpDateReferenceArray['seconds'];

        $newDate = mktime($hour, $minute, $second, $month, $day, $year);

        return $newDate;
    }

    public function getNextHalfHourTime($time = "")
    {
        $current = time();

        if($time != "")
        {
            $current = $time;
        }

        $currentArray = getdate($current);
        $year = $currentArray['year'];
        $month = $currentArray['mon'];
        $day = $currentArray['mday'];
        $hour = $currentArray['hours'];
        $minute = $currentArray['minutes'];
        $second = $currentArray['seconds'];

        if(intval($minute) < 30)
        {
            $minute = 30;
        }
        else
        {
            $hour = intval($currentArray['hours']) + 1;
            $minute = 0;
        }

        $retTime = mktime($hour, $minute, $second, $month, $day, $year);

        return $retTime;
    }

    /*
     * Returns the start date of a specific week - the start day is assumed to be monday
     */

    public function getWeekStartDate($date)
    {
        $condition = true;
        $tempDate = $date;
        $tempDay = "";

        while($condition)
        {
            $tempDay = date("N", $tempDate);

            if($tempDay == "1")
            {
                $condition = false;
                break;
            }
            else
            {
                $tempDate = $this->rollDayBackward($tempDate);
            }
        }

        return $tempDate;
    }

    /*
     * Returns the end date of a specific week - the end day is assumed to be sunday
     */

    public function getWeekEndDate($date)
    {
        $condition = true;
        $tempDate = $date;
        $tempDay = "";

        while($condition)
        {
            $tempDay = date("N", $tempDate);

            if($tempDay == "7")
            {
                $condition = false;
                break;
            }
            else
            {
                $tempDate = $this->rollDayForward($tempDate);
            }
        }

        return $tempDate;
    }

    /*
     * Sets a timestamp to the start of the day, that is, 00:00:00
     */

    public function getTimeStart($date)
    {
        $dateArray = getdate($date);
        $dateYear = $dateArray['year'];
        $dateMonth = $dateArray['mon'];
        $dateDay = $dateArray['mday'];

        return mktime(0, 0, 0, $dateMonth, $dateDay, $dateYear);
    }

    /*
     * Sets a timestamp to the start of the day, that is, 23:59:59
     */

    public function getTimeEnd($date)
    {
        $dateArray = getdate($date);
        $dateYear = $dateArray['year'];
        $dateMonth = $dateArray['mon'];
        $dateDay = $dateArray['mday'];

        return mktime(23, 59, 59, $dateMonth, $dateDay, $dateYear);
    }

    /**
     * Takes a date and replaces its date part by the $replaceDate parameter's date. The time part of the $date parameter remains the same.
     * @param <Date> $date
     * @param <Date> $replaceDate
     */
    public function replateDatePart($date, $replaceDate)
    {
        $dateArray = getdate($date);
        $hour = $dateArray['hours'];
        $minute = $dateArray['minutes'];
        $second = $dateArray['seconds'];

        $replaceDateArray = getdate($replaceDate);
        $year = $replaceDateArray['year'];
        $month = $replaceDateArray['mon'];
        $day = $replaceDateArray['mday'];

        return mktime($hour, $minute, $second, $month, $day, $year);
    }

//    public function getFormattedOffset($userId, $db)
//    {
//	$userLogicUtility = new UserLogicUtility();
//
//	$timezone = $userLogicUtility->getTimezone($userId, $db);
//	$offset = $this->getDifferenceInMinutesFromGMT($timezone);
//	$formattedOffset = $this->convertToHourMinuteSecond($offset);
//
//	return $formattedOffset;
//    }

    public function getFormattedOffset($userId)
    {
        $db = DBQuery::getInstance();
        $userLogicUtility = new UserLogicUtility();

        $timezone = $userLogicUtility->getTimezone($userId, $db);
        $offset = $this->getDifferenceInMinutesFromGMT($timezone);
        $formattedOffset = $this->convertToHourMinuteSecond($offset);

        return $formattedOffset;
    }

    /**
     * Returns the difference between the two dates in the form : today/yesterday/2 days ago and so on
     * @param <Date> $phpDate
     */
    public static function getDayDifferenceFormat($phpDateFirst, $phpDateSecond)
    {
        $phpDateSecondArray = getdate($phpDateSecond);
        $day = $phpDateSecondArray['mday'];
        $month = $phpDateSecondArray['mon'];
        $year = $phpDateSecondArray['year'];

        $phpDateSecondTemp = mktime(0, 0, 0, $month, $day, $year);

        $differenceDays = ($phpDateFirst - $phpDateSecondTemp) / (60 * 60 * 24);

        if($differenceDays < 1)
        {
            return "today";
        }
        else
        {
            if(intval($differenceDays) == 1)
            {
                return "yesterday";
            }
            else
            {
                return intval($differenceDays)." days ago";
            }
        }
    }

    public static function getCurrentUserTime($userId)
    {
        $dateUtility = new DateUtility();
        $db = DBQuery::getInstance();
        $userLogicUtility = new UserLogicUtility();

        $timezone = $userLogicUtility->getTimezone($userId, $db);
        $offset = $dateUtility->getDifferenceInMinutesFromGMT($timezone);
        $currentTime = $dateUtility->getCurrentGMTPhpTimestamp();

        if($offset < 0)
        {
            return $dateUtility->rollMinutesBackward($currentTime, $offset);
        }
        else
        {
            return $dateUtility->rollMinutesForward($currentTime, $offset);
        }
    }

    public static function getAdjustedUserTime($userId, $date)
    {
        $dateUtility = DateUtilityHelper::getDateUtility();
        $db = DBQuery::getInstance();
        $userLogicUtility = new UserLogicUtility();

        $timezone = $userLogicUtility->getTimezone($userId, $db);
        $offset = $dateUtility->getDifferenceInMinutesFromGMT($timezone);

        if($offset < 0)
        {
            return $dateUtility->rollMinutesBackward($date, $offset);
        }
        else
        {
            return $dateUtility->rollMinutesForward($date, $offset);
        }
    }

    /**
     * Converts a string of type Sat 1 Nov, 2008 and a string time of the form hh:mm to a php timestamp
     * @param type $javascriptDate
     * @param type $stringTime
     */
    public static function convertJavascriptDateWithStringTimeToPhpTimestamp($javascriptDate, $stringTime)
    {
        $dateUtility = DateUtilityHelper::getDateUtility();

        $phpTime = $dateUtility->convertHourMinuteStringToTime($stringTime);
        $phpDate = $dateUtility->convertJavascriptDateToPhpDate($javascriptDate);
        $adjustedDate = $dateUtility->changeTime($phpDate->getObject(), $phpTime);

        return $adjustedDate;
    }

}

?>
