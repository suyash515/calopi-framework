<?php

/**
 * Description of DateUtilityHelper
 *
 * @author suyash
 */
class DateUtilityHelper
{

    private static $dateUtility = "";

    /**
     *
     * @return DateUtility
     */
    public static function getDateUtility()
    {
        if(DateUtilityHelper::$dateUtility == "")
        {
            DateUtilityHelper::$dateUtility = new DateUtility;
        }

        return DateUtilityHelper::$dateUtility;
    }

}

?>
