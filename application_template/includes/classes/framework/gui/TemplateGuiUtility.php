<?php

/**
 * Description of TemplateGuiUtility
 *
 * @author suyash
 */
class TemplateGuiUtility
{

    protected $defaultCssFiles;
    protected $additionalCssFiles;
    protected $defaultJsFiles;
    protected $additionalJsFiles;
    protected $externalJsFiles;
    protected $javascriptImages;

    public function __construct()
    {
        $this->initialiseCss();
        $this->initialiseJs();
        $this->initialiseJavascriptImages();
    }

    protected function initialiseCss()
    {
        $this->defaultCssFiles = array();
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "style";
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "template";
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "modalbox";
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "calendar-brown";

        $this->additionalCssFiles = array();
    }

    protected function initialiseJs()
    {
        $this->defaultJsFiles = array();
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "prototype-1-6", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "scriptaculous", "folder" => "scriptaculous");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "modalbox", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "script", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "ajax", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "utilities", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "calendar", "folder" => "calendar");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "calendar-en", "folder" => "calendar");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "calendar-setup", "folder" => "calendar");

        $this->additionalJsFiles = array();
        $this->externalJsFiles = array();
    }

    /**
     * Images that you want preloaded in javascript
     */
    protected function initialiseJavascriptImages()
    {
        $this->javascriptImages = array();
//        $this->javascriptImages[count($this->javascriptImages)] = array("image" => "expand.png", "var" => "expand");//example
//        $this->javascriptImages[count($this->javascriptImages)] = array("image" => "collapse.png", "var" => "collapse");//example
    }

    public function getNormalDisplay($title, $leftContentData, $contentData, $navigation = "", $loadFacebookLibrary = false)
    {
        $output = "";

        $output .= "<html xmlns='http://www.w3.org/1999/xhtml'>";

        $output .= "<head id='head'>";
        $output .= "<title>$title</title>";
        $output .= "<link sizes='16x16' type='image/gif' href='".UrlConfiguration::getImageSrc("favicon.png")."' rel='icon'>";

        $output .= $this->loadAllCss();
        $output .= $this->loadAllJavascript();
        $output .= $this->loadAllJavascriptImages();
        $output .= $this->setJavascriptFolderPath(); //should always be called after other javascript files
//        $output .= $this->loadGoogleAnalytics();

        $output .= "</head>";

        $output .= "<body>";

        if($loadFacebookLibrary)
        {
            $output .= TemplateGuiUtility::loadFacebookLibrary();
        }

        $output .= "<div id='main_container'>";
        $output .= TemplateGuiUtility::getHeader($navigation);
        $output .= TemplateGuiUtility::getMainContent($leftContentData, $contentData);
        $output .= TemplateGuiUtility::getFooter();
        $output .= "</div>";

        $output .= "<div id='mktipmsg' class='mktipmsg'></div>";
        $output .= "</body>";
        $output .= "</html>";

        return $output;
    }

    private static function getHeader($navigation)
    {
        $output = "";

        $output .= "<div id='header'>";
        $output .= "<div id='logo'>";
        $output .= "<a href='home.html'>";
        $output .= "<img src='".UrlConfiguration::getImageSrc("logo.gif", "template")."' alt='' title='' border='0' />";
        $output .= "</a></div>";

        $output .= "<div id='menu'>";
        $output .= Navigation::getNavigationDisplay($navigation);
        $output .= "</div>";

        $output .= "</div>";

        return $output;
    }

    private static function getMainContent($leftContentData, $contentData)
    {
        $output = "";

        $output .= "<div id='main_content'>";
        $output .= "<div id='left_content'>";
        $output .= "<h2>Welcome to Calopi Framework</h2>";
//        $output .= "<p>";
//        $output .= "Below is the list of functionalities that have been generated";
//        $output .= "</p>";

        $output .= "<div id='left_nav'>$leftContentData</div>";

        $output .= "</div>";

        $output .= "<div id='right_content'>";
        $output .= "<div>$contentData</div>";
        $output .= "</div>";

        $output .= "<div style=' clear:both;'></div>";
        $output .= "</div>";

        return $output;
    }

    private static function getFooter()
    {
        $output = "";

        $output .= "<div id='footer'>";
        $output .= "<div class='copyright'>";
        $output .= "<a href='home.html'>";
        $output .= "<img src='".UrlConfiguration::getImageSrc("footer_logo.gif", "template")."' alt='' title='' border='0' />";
        $output .= "</a>";
        $output .= "</div>";
        $output .= "<div class='footer_links'>";
        $output .= "<a href='#'>About us</a>";
        $output .= "<a href='privacy.html'>Privacy policy</a>";
        $output .= "<a href='contact.html'>Contact us </a>";
        $output .= "<a href='http://www.wix.com/start/matrix/?utm_campaign=af_webpagedesign.com.au&amp;experiment_id=Greefies'>Create your own free web site</a>";
        $output .= "</div>";
        $output .= "</div>";

        return $output;
    }

    protected static function loadFacebookLibrary()
    {
        $output = "";

        $output .= "<div id='fb-root'></div>";
        $output .= "<script src='http://connect.facebook.net/en_US/all.js'></script>";
        $output .= "<script>";
        $output .= "FB.init({";
        $output .= "appId  : '245917528765965',";
        $output .= "status : true,";
        $output .= "cookie : true,";
        $output .= "xfbml  : true,";
        $output .= "channelURL : 'http://WWW.CALOPI.COM/channel.html',";
        $output .= "oauth  : true";
        $output .= "});";
        $output .= "</script>";


        return $output;
    }

    protected function setJavascriptFolderPath()
    {
        $output = "";

        $output .= "<script>";
        $output .= "imageFolder = '".UrlConfiguration::getImageSrc("")."';";
        $output .= "websiteAddress = '".Configuration::$URL."';";
        $output .= "</script>";

        return $output;
    }

    protected function loadGoogleAnalytics()
    {
        $output = "";

        $output .= "<script type=\"text/javascript\">";

        $output .= "var _gaq = _gaq || [];";
        $output .= "_gaq.push(['_setAccount', 'UA-25773056-1']);";
        $output .= "_gaq.push(['_trackPageview']);";

        $output .= "(function() {";
        $output .= "var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
        $output .= "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
        $output .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
        $output .= "})();";

        $output .= "</script>";

        return $output;
    }

    protected function loadAllCss()
    {
        $output = "";

        for($i = 0; $i < count($this->defaultCssFiles); $i++)
        {
            $output .= UrlConfiguration::loadCss($this->defaultCssFiles[$i]);
        }

        for($i = 0; $i < count($this->additionalCssFiles); $i++)
        {
            $output .= UrlConfiguration::loadCss($this->additionalCssFiles[$i]);
        }

        return $output;
    }

    protected function loadAllJavascript()
    {
        $output = "";

        for($i = 0; $i < count($this->defaultJsFiles); $i++)
        {
            $output .= UrlConfiguration::loadJavascript($this->defaultJsFiles[$i]['file'],
                            $this->defaultJsFiles[$i]['folder']);
        }

        for($i = 0; $i < count($this->additionalJsFiles); $i++)
        {
            $output .= UrlConfiguration::loadJavascript($this->additionalJsFiles[$i]['file'],
                            $this->additionalJsFiles[$i]['folder']);
        }

        for($i = 0; $i < count($this->externalJsFiles); $i++)
        {
            $output .= UrlConfiguration::loadExternalJavascript($this->externalJsFiles[$i]);
        }

        return $output;
    }

    protected function loadAllJavascriptImages()
    {
        $output = "";

        $output .= "<script>";

        for($i = 0; $i < count($this->javascriptImages); $i++)
        {
            $output .= "var ".$this->javascriptImages[$i]['var']." = \"".UrlConfiguration::getImageSrc($this->javascriptImages[$i]['image'])."\";";
        }

        $output .= "</script>";

        return $output;
    }

    public function addCssFile($css)
    {
        $this->additionalCssFiles[count($this->additionalCssFiles)] = $css;
    }

    public function addJsFile($js, $folder = "")
    {
        if($folder == "")
        {
            $this->additionalJsFiles[count($this->additionalJsFiles)] = array("file" => $js, "folder" => "");
        }
        else
        {
            $this->additionalJsFiles[count($this->additionalJsFiles)] = array("file" => $js, "folder" => $folder);
        }
    }

    public function addGoogleMapApi()
    {
        $this->externalJsFiles[count($this->externalJsFiles)] = "http://maps.google.com/maps/api/js?sensor=false";
    }

    public function addTwitterTweetApi()
    {
        $this->externalJsFiles[count($this->externalJsFiles)] = "http://platform.twitter.com/widgets.js";
    }

}

?>
