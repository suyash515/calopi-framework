<?php

/**
 * Description of CleanTemplateGuiUtility
 *
 * @author suyash
 */
class BootstrapTemplateGuiUtility extends TemplateGuiUtility
{

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

    protected function getNavigation($navigationItemSelected)
    {
        $output = "";

        $output .= BootstrapNavigation::getDisplay($navigationItemSelected);

        return $output;
    }

    protected function getHeader($navigationItemSelected)
    {
        $output = "";

        $output .= "<body>";
        $output .= "<div id='wrap'>";

        $output .= BootstrapTemplateGuiUtility::getNavigation($navigationItemSelected);

        return $output;
    }

    protected function getDataDisplay($data)
    {
        $output = "";

        $output .= "<div class='container template_container'>";
        $output .= $data;
        $output .= "</div>";

        $output .= "<div id='push'></div>";

        $output .= "</div>";

        return $output;
    }

    protected function getFooter()
    {
        $output = "";

        $output .= "<div id='footer'>";
        $output .= "<div class='container' style='text-align: center;'>";
        $output .= "<p class='muted credit'>Calopi Framework</p>";
        $output .= "</div>";
        $output .= "</div>";

        $output .= $this->loadAllEndJavascript();

        $output .= "</body>";
        $output .= "</html>";

        return $output;
    }

}

?>
