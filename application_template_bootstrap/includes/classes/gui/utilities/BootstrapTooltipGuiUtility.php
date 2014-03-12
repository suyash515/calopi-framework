<?php

/**
 * Description of BootstrapTooltipGuiUtility
 *
 * @author suyash
 */
class BootstrapTooltipGuiUtility
{
    public static function getTooltip($elementId, $container)
    {
        $output = "";

        $output .= "<script>";
        $output .= "$('#$elementId').tooltip(container : '$container');";
        $output .= "</script>";

        return $output;
    }
}

?>
