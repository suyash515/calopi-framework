<?php


/**
 * Description of UrlConfiguration
 *
 * @author suyash
 */
class UrlConfiguration
{

    public static function getProcessorUrl($url)
    {
	return Configuration::$URL."processors/".$url;
    }

    public static function getProcessUrl($action, $params)
    {
	$output = Configuration::$URL."process.php?action=$action";

	if($params != "")
	{
	    $output .= "&$params";
	}

//	return Configuration::$URL."process.php?action=$action&$params";
	return $output;
    }

    public static function getRootPagesUrl($url, $params = "")
    {
	if($params == "")
	{
	    return Configuration::$URL.$url;
	}
	else
	{
	    return Configuration::$URL.$url."?$params";
	}
    }

    public static function getPagesUrl($url, $params = "")
    {
	if($params == "")
	{
	    return Configuration::$URL."pages/".$url;
	}
	else
	{
	    return Configuration::$URL."pages/".$url."?$params";
	}
    }

    public static function getUrl($module, $url, $params = "")
    {
	if($params == "")
	{
	    return Configuration::$URL."pages/modules/$module/".$url.".php";
	}
	else
	{
	    return Configuration::$URL."pages/modules/$module/".$url.".php?$params";
	}
    }

    public static function loadCss($cssFile)
    {
	return "<link id='css-$cssFile' href='".Configuration::$URL."includes/css/$cssFile.css' rel='stylesheet' type='text/css' />";
    }

    public static function loadBaseCss($cssFile, $url)
    {
	return "<link id='css-$cssFile' href='".$url."includes/css/$cssFile.css' rel='stylesheet' type='text/css' />";
    }

    public static function loadJavascript($javascriptFile, $directory = "")
    {
	if($directory != "")
	{
	    return "<script type='text/javascript' id='js-$javascriptFile' src='".Configuration::$URL."includes/js/$directory/$javascriptFile.js'></script>";
	}
	else
	{
	    return "<script type='text/javascript' id='js-$javascriptFile' src='".Configuration::$URL."includes/js/$javascriptFile.js'></script>";
	}
    }

    public static function loadBaseJavascript($javascriptFile, $url, $directory = "")
    {
	if($directory != "")
	{
	    return "<script type='text/javascript' id='js-$javascriptFile' src='".$url."includes/js/$directory/$javascriptFile.js'></script>";
	}
	else
	{
	    return "<script type='text/javascript' id='js-$javascriptFile' src='".$url."includes/js/$javascriptFile.js'></script>";
	}
    }

    public static function loadExternalJavascript($javascriptFile)
    {
	return "<script type='text/javascript' src='$javascriptFile'></script>";
    }

    public static function getImageSrc($image, $directory = "")
    {
	if($directory != "")
	{
	    return Configuration::$URL."images/$directory/$image";
	}
	else
	{
	    return Configuration::$URL."images/$image";
	}
    }

    public static function getDownloadLink($file, $directory = "")
    {
	if($directory != "")
	{
	    return Configuration::$URL."downloads/$directory/$file";
	}
	else
	{
	    return Configuration::$URL."images/$file";
	}
    }
}

?>
