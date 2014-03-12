<?php

class DateGuiUtility
{

    public static $CBO_HOUR_ID = "cbo_hour_";
    public static $CBO_MINUTE_ID = "cbo_min_";
    public static $MINUTE_INTERVAL = 5;

    public function __construct()
    {

    }

    public function getTimeChooser($suffixId, $headers = false)
    {
        $output = "";

        $dateUtility = new DateUtility();

        $hourComboId = DateGuiUtility::$CBO_HOUR_ID.$suffixId;
        $minuteComboId = DateGuiUtility::$CBO_MINUTE_ID.$suffixId;

        $output .= "<table>";
        $output .= "<tr>";
        $output .= "<td>";

        if($headers)
        {
            $output .= "Hour(s) : ";
        }

        $output .= $this->getHourCombo($hourComboId, $dateUtility);
        $output .= "</td>";
        $output .= "<td>:</td>";
        $output .= "<td>";

        if($headers)
        {
            $output .= "Minute(s) : ";
        }

        $output .= $this->getMinuteCombo($minuteComboId, $dateUtility);
        $output .= "</td>";
        $output .= "</tr>";
        $output .= "</table>";

        return $output;
    }

    private function getHourCombo($comboId, $dateUtility)
    {
        $output = "";

        $output .= "<select id='$comboId' name='$comboId' style='width: 100px;'>";

        for($i = 0; $i < 24; $i++)
        {
            $output .= "<option value='$i'>".$dateUtility->formatWithLeadingZero($i)."</option>";
        }

        $output .= "</select>";

        return $output;
    }

    private function getMinuteCombo($comboId, $dateUtility)
    {
        $output = "";

        $output .= "<select id='$comboId' name='$comboId' style='width: 100px;'>";

        for($i = 0; $i < 60; $i = $i + DateGuiUtility::$MINUTE_INTERVAL)
        {
            $output .= "<option value='$i'>".$dateUtility->formatWithLeadingZero($i)."</option>";
        }

        $output .= "</select>";

        return $output;
    }

    public function getPreselectedTimeChooser($selectedHour, $selectedMinute, $suffixId, $minuteInterval = "")
    {
        $output = "";

        $dateUtility = new DateUtility();

        $hourComboId = DateGuiUtility::$CBO_HOUR_ID.$suffixId;
        $minuteComboId = DateGuiUtility::$CBO_MINUTE_ID.$suffixId;

        $output .= "<table>";
        $output .= "<tr>";
        $output .= "<td>";
        $output .= $this->getPrelectedHourCombo($selectedHour, $hourComboId, $dateUtility);
        $output .= "</td>";
        $output .= "<td>:</td>";
        $output .= "<td>";
        $output .= $this->getPrelectedMinuteCombo($selectedMinute, $minuteComboId, $dateUtility, $minuteInterval);
        $output .= "</td>";
        $output .= "</tr>";
        $output .= "</table>";

        return $output;
    }

    public function getPreselectedTimeChooserIncluding24Hour($selectedHour, $selectedMinute, $suffixId,
            $minuteInterval = "")
    {
        $output = "";

        $dateUtility = new DateUtility();

        $hourComboId = DateGuiUtility::$CBO_HOUR_ID.$suffixId;
        $minuteComboId = DateGuiUtility::$CBO_MINUTE_ID.$suffixId;

        if((intval($selectedHour) == 0) && (intval($selectedMinute) == 0))
        {
            $selectedHour = 24;
        }

        $output .= "<table>";
        $output .= "<tr>";
        $output .= "<td>";
        $output .= $this->getPrelectedHourComboIncluding24($selectedHour, $hourComboId, $minuteComboId, $dateUtility);
        $output .= "</td>";
        $output .= "<td>:</td>";
        $output .= "<td>";
        $output .= $this->getPrelectedMinuteComboIncluding24($selectedMinute, $selectedHour, $minuteComboId,
                $dateUtility, $minuteInterval);
        $output .= "</td>";
        $output .= "</tr>";
        $output .= "</table>";

        return $output;
    }

    private function getPrelectedHourCombo($selectedHour, $comboId, $dateUtility)
    {
        $output = "";

        $output .= "<select id='$comboId'>";

        for($i = 0; $i < 24; $i++)
        {
            if($selectedHour == $i)
            {
                $output .= "<option value='$i' selected>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
            else
            {
                $output .= "<option value='$i'>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
        }

        $output .= "</select>";

        return $output;
    }

    private function getPrelectedHourComboIncluding24($selectedHour, $hourComboId, $minuteComboId, $dateUtility)
    {
        $output = "";

        $output .= "<select id='$hourComboId' onchange=\"timeChooserAcco('$hourComboId', '$minuteComboId');\">";

        for($i = 0; $i < 25; $i++)
        {
            if($selectedHour == $i)
            {
                $output .= "<option value='$i' selected>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
            else
            {
                $output .= "<option value='$i'>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
        }

        $output .= "</select>";

        return $output;
    }

    private function getPrelectedMinuteCombo($selectedMinute, $comboId, $dateUtility, $interval = "")
    {
        $output = "";

        if($interval == "")
        {
            $interval = DateGuiUtility::$MINUTE_INTERVAL;
        }

        $output .= "<select id='$comboId'>";

        for($i = 0; $i < 60; $i = $i + $interval)
        {
            if($selectedMinute == $i)
            {
                $output .= "<option value='$i' selected>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
            else
            {
                $output .= "<option value='$i'>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
        }

        $output .= "</select>";

        return $output;
    }

    private function getPrelectedMinuteComboIncluding24($selectedMinute, $selectedHour, $comboId, $dateUtility,
            $interval = "")
    {
        $output = "";

        if($interval == "")
        {
            $interval = DateGuiUtility::$MINUTE_INTERVAL;
        }

        $output .= "<select id='$comboId'>";

        for($i = 0; $i < 60; $i = $i + $interval)
        {
            $style = "";

            if((intval($selectedHour) == 24) && (intval($i) > 0))
            {
                $style = "display: none;";
            }

            if($selectedMinute == $i)
            {
                $output .= "<option value='$i' style='$style' selected>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
            else
            {
                $output .= "<option value='$i' style='$style'>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
        }

        $output .= "</select>";

        return $output;
    }

    public function getPreselectedFullTimeChooser($selectedHour, $selectedMinute, $suffixId)
    {
        $output = "";

        $dateUtility = new DateUtility();

        $hourComboId = DateGuiUtility::$CBO_HOUR_ID.$suffixId;
        $minuteComboId = DateGuiUtility::$CBO_MINUTE_ID.$suffixId;

        $output .= "<table>";
        $output .= "<tr>";
        $output .= "<td>";
        $output .= $this->getPrelectedHourCombo($selectedHour, $hourComboId, $dateUtility);
        $output .= "</td>";
        $output .= "<td>:</td>";
        $output .= "<td>";
        $output .= $this->getPrelectedFullMinuteCombo($selectedMinute, $minuteComboId, $dateUtility);
        $output .= "</td>";
        $output .= "</tr>";
        $output .= "</table>";

        return $output;
    }

    private function getPrelectedFullMinuteCombo($selectedMinute, $comboId, $dateUtility)
    {
        $output = "";

        $output .= "<select id='$comboId'>";

        for($i = 0; $i < 60; $i++)
        {
            if($selectedMinute == $i)
            {
                $output .= "<option value='$i' selected>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
            else
            {
                $output .= "<option value='$i'>".$dateUtility->formatWithLeadingZero($i)."</option>";
            }
        }

        $output .= "</select>";

        return $output;
    }

    public static function getJavascriptDateChooser($elementId, $defaultValue = "", $className = "")
    {
        $output = "";

        $output .= "<input type='text' id='$elementId' class='date_field $className' value=\"$defaultValue\" onkeydown='return false;' />";

        $output .= "<script>";

        $output .= "Calendar.setup({";
        $output .= "inputField     :    \"$elementId\",";
        $output .= "ifFormat       :    \"%a %d %b, %Y\",";
        $output .= "showsTime      :    \"false\",";
        $output .= "button	   :	\"$elementId\"";
        $output .= "});";

        $output .= "</script>";

        return $output;
    }

    public static function getJQueryDatePicker($elementId)
    {
        $output = "";

        $output .= "<script>";
        $output .= "$(function() {
		$( '#$elementId' ).datepicker({dateFormat : 'dd/mm/yy'});
	});";
        $output .= "</script>";

        return $output;
    }

    public static function getMonthCombo($comboId, $preselectedMonth = "", $comboAction = "", $class = "",
            $includeAll = false)
    {
        $output = "";
        $dateUtility = DateUtilityHelper::getDateUtility();

        $monthArray = $dateUtility->getLongMonthArray();

        $output .= "<select id='$comboId' name='$comboId' class='$class' onchange=\"$comboAction\">";

        if($includeAll)
        {
            $output .= "<option value=''>All</option>";
        }

        for($i = 0; $i < count($monthArray); $i++)
        {
            $monthIndex = $dateUtility->getLongMonthIndex($monthArray[$i + 1]);

            if($preselectedMonth == $monthIndex)
            {
                $output .= "<option value='$monthIndex' selected='selected'>".$monthArray[$i + 1]."</option>";
            }
            else
            {
                $output .= "<option value='$monthIndex'>".$monthArray[$i + 1]."</option>";
            }
        }

        $output .= "</select>";

        return $output;
    }

    public static function getYearCombo($memberId, $selectedYear = "", $comboId = "")
    {
        $output = "";

        $yearComboId = "";

        if($comboId == "")
        {
            $yearComboId = "cbo_year_".$memberId;
        }
        else
        {
            $yearComboId = $comboId;
        }

        $plannedSmsEntity = PlannedSmsLogicUtility::getDistinctYearList($memberId);

        $output .= "<select id='$yearComboId' name='$yearComboId'>";

        $output .= "<option value=''>All</option>";

        for($i = 0; $i < count($plannedSmsEntity); $i++)
        {
            $values = $plannedSmsEntity[$i]->getValues();

            $year = $values['year'];

            $selected = "";

            if($year == $selectedYear)
            {
                $selected = "selected";
            }

            $output .= "<option value='$year' $selected>$year</option>";
        }

        $output .= "</select>";

        return $output;
    }

}

?>