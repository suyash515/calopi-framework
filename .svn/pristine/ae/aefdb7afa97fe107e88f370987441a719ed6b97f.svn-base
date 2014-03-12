<?php

/**
 * Description of IndexPageUtility
 *
 * @author suyash.sumaroo
 */
class IndexPageUtility
{

    private $indexFile = "index.php";

    public function __construct()
    {

    }

    public function createIndexFile($directory)
    {
        fopen($directory.$this->indexFile, 'w');
    }

    public function generatePage($fields, $directory)
    {
        $output = "";

        $output .= $this->generateHeader($fields);

        $handle = fopen($directory.$this->indexFile, 'a');

        fwrite($handle, $output);
    }

    private function generateHeader($fields)
    {
        $output = "";

//        $output .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";

        $output .= $this->generateHTML($fields);

        return $output;
    }

    private function generateHTML()
    {
        $output = "";

        $output .= "<?php";
        $output .= "\n\n";
        $output .= "require_once 'autoload.php';";
        $output .= "\n\n";
        $output .= "\$compressor = new compressor(array('page, javascript, css'));";
        $output .= "\n\n";
        $output .= "session_start();";
        $output .= "\n\n";
        $output .= "\$data = HomeGuiUtility::getDisplay();";
        $output .= "\n";
        $output .= "\$leftData = IndexGuiUtility::getApplicationNavigation();";
        $output .= "\n";
        $output .= "\$templateGuiUtility = new TemplateGuiUtility();";
        $output .= "\n\n";
        $output .= "echo \$templateGuiUtility->getNormalDisplay(\"Index Page\", \$leftData, \$data, Navigation::\$APPLICATION_LINK);";
        $output .= "\n";
        $output .= "\n";
        $output .= "\$compressor->finish();";
        $output .= "\n";
        $output .= "\n";
        $output .= "?>";

        return $output;
    }

//    private function generateCssLinkFiles()
//    {
//        $output = "";
//
//        $output .= "<link href=\"./includes/css/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
//        $output .= "<link href=\"./includes/css/common.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
//        $output .= "<link href=\"./includes/css/lightbox.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
//        $output .= "<link href=\"./includes/css/modalbox.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
//        $output .= "<link href=\"./includes/css/calendar-brown.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
//
//        return $output;
//    }
//
//    private function generateJavascriptLinkFiles()
//    {
//        $output = "";
//
//        $output .= "<script type='text/javascript' src='includes/js/prototype-1-6.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/scriptaculous/scriptaculous.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/scriptaculous/scriptaculous.js?load=effects,builder'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/scriptaculous/lightbox.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/modalbox.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/script.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/common.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/calendar/calendar.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/calendar/calendar-en.js'></script>\n";
//        $output .= "<script type='text/javascript' src='includes/js/calendar/calendar-setup.js'></script>\n";
//
//        return $output;
//    }

}

?>
