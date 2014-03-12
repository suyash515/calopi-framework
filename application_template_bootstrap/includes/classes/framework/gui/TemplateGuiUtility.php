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
    protected $endJsFiles; //files added at the end of the page
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

        $this->defaultCssFiles[count($this->defaultCssFiles)] = "bootstrap/css/bootstrap.min";
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "template";
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "bootstrap/css/bootstrap-responsive.min";
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "general";
        $this->defaultCssFiles[count($this->defaultCssFiles)] = "table";

        $this->additionalCssFiles = array();
    }

    protected function initialiseJs()
    {
        $this->defaultJsFiles = array();
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "script", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "ajax", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "utilities", "folder" => "");
        $this->defaultJsFiles[count($this->defaultJsFiles)] = array("file" => "jquery-1.9.1.min", "folder" => "");

        $this->additionalJsFiles = array();
        $this->externalJsFiles = array();

        $this->endJsFiles = array();
        $this->endJsFiles[count($this->endJsFiles)] = array("file" => "bootstrap.min", "folder" => "bootstrap");
    }

    protected function initialiseJavascriptImages()
    {
        $this->javascriptImages = array();
    }

    protected function openHtmlHeader($title)
    {
        $output = "";

        $output .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
        $output .= "<html xmlns='http://www.w3.org/1999/xhtml'>";
        $output .= "<head id='head'>";
        $output .= "<title>$title</title>";
        $output .= "<link href='".UrlConfiguration::getFaviconLink()."' type='image/png' rel='icon'>";

        return $output;
    }

    protected function closeHtmlHeader()
    {
        $output = "";

        $output .= "</head>";

        return $output;
    }

    public function getNormalDisplay($title, $data, $navigationItemSelected = "")
    {
        $output = "";

        $output .= $this->openHtmlHeader($title);
        $output .= $this->loadAllCss();
        $output .= $this->loadAllJavascript();
        $output .= $this->loadAllJavascriptImages();
        $output .= $this->setJavascriptFolderPath(); //should always be called after other javascript files
        $output .= $this->closeHtmlHeader();

        $output .= $this->getHeader($navigationItemSelected);
        $output .= $this->getDataDisplay($data);
        $output .= $this->getFooter();

        return $output;
    }

    protected function getDataDisplay($data)
    {
        $output = "";

        $output .= "<div class='te3'>$data</div>";

        return $output;
    }

    protected function getHeader($navigationItemSelected)
    {
        $output = "";

        $output .= "<body>";

        $output .= "<div>";
        $output .= "<header>";
        $output .= "<div class='margin-bot'>";
        $output .= "<div style='float: left; padding-right: 20px; font-size: 17px; color: black; font-weight: bold;'>";
        $output .= "</div>";
        $output .= "<div style='float: right; padding-right: 20px; font-size: 17px; color: gray; font-weight: bold;'>Welcome, &nbsp;Text here</div>";
        $output .= "</div>";
        $output .= "<div class='bg-1'>";

        $output .= $this->getNavigation($navigationItemSelected);

        $output .= "</div>";
        $output .= "</header>";
        $output .= "</div>";
        $output .= "<div class='container_12'>";
        $output .= "<div class='wrapper'>";

        return $output;
    }

    protected function getNavigation($navigationItemSelected)
    {
        $output = "";

        $output .= Navigation::getDisplay($navigationItemSelected);

        return $output;
    }

    protected function getFooter()
    {
        $output = "";

        $output .= "<footer>";
        $output .= "<div>";
        $output .= "Powered by Calopi Framework.";
        $output .= "</div>";
        $output .= "</footer>";
        $output .= "</div>";
        $output .= "</div>";

        $output .= $this->loadAllEndJavascript();

        $output .= "</body>";
        $output .= "</html>";

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
        $output .= "var imageFolder = '".UrlConfiguration::getImageSrc("")."';";
        $output .= "var websiteUrl = '".Configuration::$URL."';";
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

    protected function loadAllEndJavascript()
    {
        $output = "";

        for($i = 0; $i < count($this->endJsFiles); $i++)
        {
            $output .= UrlConfiguration::loadJavascript($this->endJsFiles[$i]['file'], $this->endJsFiles[$i]['folder']);
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

    public function addCssFile($css, $folder = "")
    {
        if($folder == "")
        {
            $this->additionalCssFiles[count($this->additionalCssFiles)] = $css;
        }
        else
        {
            $this->additionalCssFiles[count($this->additionalCssFiles)] = $folder."/".$css;
        }
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

    public function addEndJsFile($js, $folder = "")
    {
        if($folder == "")
        {
            $this->endJsFiles[count($this->endJsFiles)] = array("file" => $js, "folder" => "");
        }
        else
        {
            $this->endJsFiles[count($this->endJsFiles)] = array("file" => $js, "folder" => $folder);
        }
    }

    public function addBootstrap()
    {
        $this->addJsFile("bootstrap.min", "bootstrap");
        $this->addCssFile("bootstrap", "bootstrap/css");
    }

    public function addJQueryDatePicker()
    {
        $this->addCssFile("jquery.ui.all", "jquery-ui-1.10.2/themes/base");

        $this->addJsFile("jquery.ui.core", "jquery-ui-1.10.2/ui");
        $this->addJsFile("jquery.ui.widget", "jquery-ui-1.10.2/ui");
        $this->addJsFile("jquery.ui.datepicker", "jquery-ui-1.10.2/ui");
    }

    public function addJqueryUI()
    {
        $this->addCssFile("jquery.ui.all", "jquery-ui-1.10.2/themes/base");

        $this->addJsFile("jquery-ui", "jquery-ui-1.10.2/ui");
    }

    public function addBootstrapDatePicker()
    {
        $this->addJsFile("bootstrap-datepicker", "bootstrap");
        $this->addCssFile("datepicker", "bootstrap/css");
    }

    public function addFancyBox()
    {
        $this->addJsFile("jquery.fancybox.pack", "fancybox");
        $this->addCssFile("jquery.fancybox", "fancybox");
    }

    public function addColorBox()
    {
        $this->addJsFile("jquery.colorbox", "colorbox");
        $this->addCssFile("colorbox", "colorbox");
    }

    public function addGoogleMapApi()
    {
        $this->externalJsFiles[count($this->externalJsFiles)] = "http://maps.google.com/maps/api/js?sensor=false";
    }

    public function addTwitterTweetApi()
    {
        $this->externalJsFiles[count($this->externalJsFiles)] = "http://platform.twitter.com/widgets.js";
    }

    public function getOpenGraphContent()
    {
        $output = "";

//        $imageLink = UrlConfiguration::getImageSrc("logo.jpg", "template");

        $applicationName = Configuration::$APPLICATION_NAME;

        $basicDescription = "$applicationName is an online platform that allows businesses to engage in FREE ADVERTISING. The principle is simple: let others advertise for you and you advertise for others. This way, you do not have to spend vast amounts of money to make your business or website known to the public.";

        $output .= "<meta property=\"og:title\" content=\"Free collaborative advertising platform\" />";
//        $output .= "<meta property=\"og:image\" content=\"$imageLink\" />";
        $output .= "<meta property=\"og:description\" content=\"$basicDescription\" />";

        return $output;
    }

}

?>
