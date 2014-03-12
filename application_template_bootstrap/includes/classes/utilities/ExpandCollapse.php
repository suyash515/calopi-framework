<?php


class ExpandCollapse
{

    public function __construct()
    {
	
    }

    public function getExpandIcon($expandAction, $id)
    {
	$output = "";

	$output .= "<span onclick=\"toggleAction('icon_$id');$expandAction;\">";
//	$output .= "<img src='./images/expand.png' style='vertical-align: middle;' id='icon_$id' />";
	$output .= "<img src='".UrlConfiguration::getImageSrc("expand.png")."' style='vertical-align: middle;' id='icon_$id' />";
	$output .= "</span>";

	return $output;
    }

    public function getEmptyIcon()
    {
	$output = "";

	$output .= "<span>";
	$output .= "&nbsp;";
	$output .= "&nbsp;";
	$output .= "&nbsp;";
	$output .= "&nbsp;";
	$output .= "&nbsp;";
	$output .= "</span>";

	return $output;
    }

    public function getContractIcon($contactAction)
    {

    }
}

?>