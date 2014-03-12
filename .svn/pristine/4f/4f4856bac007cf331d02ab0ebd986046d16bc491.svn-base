<?php


/**
 * Description of TooltipGuiUtility
 *
 * @author suyash
 */
class TooltipGuiUtility
{

    public static function getTooltip($tooltipText)
    {
	$output = "";

	$output .= "&nbsp;";
	$output .= "<a href='javascript:void(0)' onmouseover=\"showtip(event, '$tooltipText');\" onmouseout=\"hidetip();\">";
	$output .= "(?)";
	$output .= "</a>";

	return $output;
    }

    public static function getTooltipForElement($element, $tooltipText, $linkClass = "", $addSpace = true)
    {
	$output = "";

        if($addSpace)
	{
            $output .= "&nbsp;";
        }

        $tooltipText = htmlentities($tooltipText);

	$output .= "<a href='javascript:void(0)' onmouseover=\"showtip(event, '$tooltipText');\" onmouseout=\"hidetip();\" class='$linkClass'>";
	$output .= "$element";
	$output .= "</a>";

	return $output;
    }
}

?>
