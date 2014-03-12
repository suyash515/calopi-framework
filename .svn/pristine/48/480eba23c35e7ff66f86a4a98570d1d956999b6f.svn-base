<?php


/**
 * Description of FacebookUtility
 *
 * @author suyash
 */
class FacebookUtility
{

    public static function getLikeButton($link)
    {
	$output = "";

	$output .= "<div id=\"fb-root\"></div>";
	$output .= "<script>(function(d, s, id) {";
	$output .= "var js, fjs = d.getElementsByTagName(s)[0];";
	$output .= "if (d.getElementById(id)) {return;}";
	$output .= "js = d.createElement(s); js.id = id;";
	$output .= "js.src = \"//connect.facebook.net/en_US/all.js#appId=248663165154515&xfbml=1\";";
	$output .= "fjs.parentNode.insertBefore(js, fjs);";
	$output .= "}(document, 'script', 'facebook-jssdk'));</script>";

	$output .= "<div class=\"fb-like\" data-href=\"$link\" data-send=\"false\" data-width=\"300\" data-show-faces=\"true\" data-font=\"verdana\"></div>";

	return $output;
    }
}

?>
