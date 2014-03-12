<?php

/**
 * Description of ScheduleDateUtility
 *
 * @author suyash
 */
class ScheduleDateUtility
{

    public static function getRealScheduledMysqlDate($scheduleDateTime, $currentUserTime)
    {
        $dateUtility = DateUtilityHelper::getDateUtility();
        $gmtDate = $dateUtility->getCurrentGMTPhpTimestamp();

        $realScheduleDate = $scheduleDateTime - ($currentUserTime - $gmtDate);
        $realScheduleMysqlDate = $dateUtility->convertPhpDateToMysqlDate($realScheduleDate);

        return $realScheduleMysqlDate;
    }

}

?>
