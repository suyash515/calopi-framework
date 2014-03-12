<?php


/**
 * Description of GooglePlusOneUtility
 *
 * @author suyash
 */
class GooglePlusOneUtility
{

    public static function getPlusOneButton($link)
    {
	$output = "";

	$output .= "<g:plusone size=\"medium\" href=\"$link\"></g:plusone>";

	$output .= "<script type=\"text/javascript\">";
	$output .= "(function() {";
	$output .= "var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;";
	$output .= "po.src = 'https://apis.google.com/js/plusone.js';";
	$output .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);";
	$output .= "})();";
	$output .= "</script>";

	return $output;
    }
}

?>
