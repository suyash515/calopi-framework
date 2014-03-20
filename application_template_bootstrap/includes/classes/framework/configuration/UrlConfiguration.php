<?php


/**
 * Description of UrlConfiguration
 *
 * @author suyash
 */
class UrlConfiguration
{

    public static $RESULT_PARAM = "r";
    public static $SUCCESS_VALUE = "success";
    public static $PARAM_TYPE_CODE_IGNITER = "code_igniter";

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

    public static function getExternalRootPagesUrl($url, $params = "")
    {
	if($params == "")
	{
	    return Configuration::$EXTERNAL_URL.$url;
	}
	else
	{
	    return Configuration::$EXTERNAL_URL.$url."?$params";
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

    public static function getUrl($module, $url, $params = "", $anchor = "")
    {
	if($params == "")
	{
	    if($anchor == "")
	    {
		return Configuration::$URL."pages/modules/$module/".$url.".php";
	    }
	    else
	    {
		return Configuration::$URL."pages/modules/$module/".$url.".php#".$anchor;
	    }
	}
	else
	{
	    if($anchor == "")
	    {
		return Configuration::$URL."pages/modules/$module/".$url.".php?$params";
	    }
	    else
	    {
		return Configuration::$URL."pages/modules/$module/".$url.".php#".$anchor."?$params";
	    }
	}
    }

    public static function getCodeIgniterUrl($module, $action, $folder = "", $params = "", $paramType = "")
    {
	$url = "";

	if($folder != "")
	{
	    $url = Configuration::$URL.$folder."/".$module."/".$action;
	}
	else
	{
	    $url = Configuration::$URL.$module."/".$action;
	}

	if($params)
	{
	    if($paramType == UrlConfiguration::$PARAM_TYPE_CODE_IGNITER)
	    {
		return $url."/".$params;
	    }
	    else
	    {
		return $url."?".$params;
	    }
	}
	else
	{
	    return $url;
	}
    }

    public static function getSuccessParameterString()
    {
	return UrlConfiguration::$RESULT_PARAM."=".UrlConfiguration::$SUCCESS_VALUE;
    }

    public static function getExternalUrl($module, $url, $params = "")
    {
	if($params == "")
	{
	    return Configuration::$EXTERNAL_URL."pages/modules/$module/".$url.".php";
	}
	else
	{
	    return Configuration::$EXTERNAL_URL."pages/modules/$module/".$url.".php?$params";
	}
    }

    public static function loadCss($cssFile)
    {
	$version = Configuration::$VERSION;
	return "<link href='".Configuration::$URL."includes/css/$cssFile.css?v=$version' rel='stylesheet' type='text/css' />";
    }

    public static function loadBaseCss($cssFile, $url)
    {
	return "<link id='css-$cssFile' href='".$url."includes/css/$cssFile.css' rel='stylesheet' type='text/css' />";
    }

    public static function loadJavascript($javascriptFile, $directory = "")
    {
	$version = Configuration::$VERSION;

	if($directory != "")
	{
	    return "<script type='text/javascript' id='js-$javascriptFile' src='".Configuration::$URL.
		    "includes/js/$directory/$javascriptFile.js?$version'></script>";
	}
	else
	{
	    return "<script type='text/javascript' id='js-$javascriptFile' src='".Configuration::$URL.
		    "includes/js/$javascriptFile.js?$version'></script>";
	}
    }

    public static function loadBaseJavascript($javascriptFile, $url, $directory = "")
    {
	if($directory != "")
	{
	    return "<script type='text/javascript' id='js-$javascriptFile' src='".$url.
		    "js/$directory/$javascriptFile.js'></script>";
	}
	else
	{
	    return
		    "<script type='text/javascript' id='js-$javascriptFile' src='".$url."js/$javascriptFile.js'></script>";
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

    public static function getPluginImageSrc($image, $directory = "")
    {
	if($directory != "")
	{
	    return Configuration::$URL."images/plugins/$directory/$image";
	}
	else
	{
	    return Configuration::$URL."images/plugins/$image";
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
	    return Configuration::$URL."downloads/$file";
	}
    }

    public static function getFaviconLink()
    {
	return UrlConfiguration::getImageSrc("favicon.png");
    }

    public static function getFileGenerationUrl($fileName = "")
    {
	$url = "";

	if($fileName)
	{
	    $url = Configuration::$URL.Configuration::$FILE_GENERATION_FOLDER."/".$fileName;
	}
	else
	{
	    $url = Configuration::$URL.Configuration::$FILE_GENERATION_FOLDER;
	}

	return $url;
    }

    public static function redirect($url)
    {
	header("Location: $url");
    }
}

?>
