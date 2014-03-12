<?php

/**
 * Description of GenderGuiUtility
 *
 * @author suyash
 */
class GenderGuiUtility
{


    public static function getGenderCombo($selectedGender = "", $comboId = "", $includeAll = false, $class = "")
    {
        $output = "";

        $maleSelected = "";
        $femaleSelected = "";

        if($selectedGender == TblContactLogicUtility::$GENDER_MALE)
        {
            $maleSelected = "selected";
        }
        elseif($selectedGender == TblContactLogicUtility::$GENDER_FEMALE)
        {
            $femaleSelected = "selected";
        }

        $male = TblContactLogicUtility::$GENDER_MALE;
        $female = TblContactLogicUtility::$GENDER_FEMALE;

        if($comboId == "")
        {
            $comboId = "cbo_gender";
        }

        $output .= "<select id='$comboId' name='$comboId' class='$class'>";

        if($includeAll)
        {
            $output .= "<option value=''>All</option>";
        }

        $output .= "<option value='$male' $maleSelected>$male</option>";
        $output .= "<option value='$female' $femaleSelected>$female</option>";
        $output .= "</select>";

        return $output;
    }
}

?>
