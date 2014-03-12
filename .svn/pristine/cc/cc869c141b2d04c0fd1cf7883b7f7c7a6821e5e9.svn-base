<?php


/**
 * Description of CssUtility
 *
 * @author suyash
 */
class CssUtility
{

    public static function getBackgroundImageStyle($image, $additionalStyle = "", $directory = "")
    {
	$output = "";

	$imageSource = UrlConfiguration::getImageSrc($image, $directory);

	$output .= "background-image: url(\"$imageSource\");background-repeat: no-repeat;$additionalStyle";

	return $output;
    }
}

?>
