<?php

/**
 * Description of TemplateTextUtility
 *
 * @author suyash
 */
class TemplateTextUtility
{

    public static $NAME_MASK = "-x-";
    public static $SURNAME_MASK = "-s-";
    public static $COUPON_REFERENCE_MASK = "-c-";

    public static function getBirthdayExplanationText()
    {
        $output = "";

        $mask = TemplateTextUtility::$NAME_MASK;

        $output .= "<div class='bat1'>";
        $output .= "<div class='bat2'>How to use?</div>";
        $output .= "<div class='bat2'>Insert $mask where you want to insert your customer's name.</div>";
        $output .= "<div class='bat2'>For example: Dear $mask, we wish you a happy birthday.</div>";
        $output .= "<div class='bat2'>$mask will be replaced by your contact's name</div>";
        $output .= "</div>";

        return $output;
    }

    public static function getSmsExplanationText()
    {
        $output = "";

        $mask = TemplateTextUtility::$NAME_MASK;
        $couponReferenceMask = TemplateTextUtility::$COUPON_REFERENCE_MASK;

        $output .= "<div class='bat1'>";
        $output .= "<div class='bat2'>How to use?</div>";
        $output .= "<div class='bat2'>Insert $mask where you want to insert your customer's name.</div>";
        $output .= "<div class='bat2'>For example: Dear $mask, we wish to inform you that...</div>";
        $output .= "<div class='bat2'>$mask will be replaced by your contact's name</div>";
        $output .= "</div>";

        $output .= "<div class='bat1'>";
        $output .= "<div class='bat2'>Specific to coupons</div>";
        $output .= "<div class='bat2'>For templates of type COUPON you have the ability to add $couponReferenceMask to include a coupon reference in the message</div>";
        $output .= "</div>";

        $output .= "<div class='bat1'>";
        $output .= "<div class='bat2'>Specific to registration templates</div>";
        $output .= "<div class='bat2'>You can have only one registration template at any given time. If you add a new registration template, it will override the old registration template.</div>";
        $output .= "</div>";

        return $output;
    }

    public static function getReplacedString($name, $templateText)
    {
        $output = "";

        $output = str_replace(TemplateTextUtility::$NAME_MASK, $name, $templateText);

        return $output;
    }

    public static function getCouponReplacedString($couponReferenceNumber, $verificationCode, $templateText)
    {
        $output = "";

        $replaceString = "$couponReferenceNumber/$verificationCode";

        $output = str_replace(TemplateTextUtility::$COUPON_REFERENCE_MASK, $replaceString, $templateText);

        return $output;
    }

    public static function getRetrieveReplaceString($contactId, $templateText)
    {
        if(strpos($templateText, TemplateTextUtility::$NAME_MASK))
        {
            $contactEntity = TblContactLogicUtility::getName($contactId);

            if($contactEntity)
            {
                return TemplateTextUtility::getReplacedString($contactEntity->getName(), $templateText);
            }
            else
            {
                return $templateText;
            }
        }
        else
        {
            return $templateText;
        }
    }

    public static function getRetrieveReplaceStringForEmployee($employeeId, $templateText)
    {
        if(strpos($templateText, TemplateTextUtility::$NAME_MASK))
        {
            $employeeEntity = EmployeeLogicUtility::getName($employeeId);

            if($employeeEntity)
            {
                return TemplateTextUtility::getReplacedString($employeeEntity->getName(), $templateText);
            }
            else
            {
                return $templateText;
            }
        }
        else
        {
            return $templateText;
        }
    }

    public static function couponReferencePresent($text)
    {
        $position = strpos($text, TemplateTextUtility::$COUPON_REFERENCE_MASK);

        if($position)
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
