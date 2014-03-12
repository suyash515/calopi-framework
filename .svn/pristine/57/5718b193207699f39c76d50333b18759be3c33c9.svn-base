<?php

/**
 * Description of ConfigurationClassUtility
 *
 * @author suyash
 */
class ConfigurationClassUtility
{

    private static $CLASS_NAME = "Configuration.php";

    public static function generatePage($directory, $host, $url, $database, $user, $password)
    {
        $output = "";

        $output .= ConfigurationClassUtility::generatePageContent($host, $url, $database, $user, $password);

        $directory = $directory.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."framework".DIRECTORY_SEPARATOR."configuration".DIRECTORY_SEPARATOR;

        $handle = fopen($directory.ConfigurationClassUtility::$CLASS_NAME, 'w');

        fwrite($handle, $output);
    }

    private static function generatePageContent($host, $url, $database, $user, $password)
    {
        $output = "";

        $output .= "<?php"."\n";
        $output .= "\n";
        $output .= "class Configuration"."\n";
        $output .= "{"."\n";
        $output .= "\n";
        $output .= "//url"."\n";
        $output .= "public static \$URL = \"$url\";"."\n";
        $output .= "//"."\n";
        $output .= "//database parameters"."\n";
        $output .= "public static \$CONNECTION_PARAMETERS = array(\"host\" => \"$host\","."\n";
        $output .= "\"username\" => \"$user\","."\n";
        $output .= "\"password\" => \"$password\","."\n";
        $output .= "\"database\" => \"$database\""."\n";
        $output .= ");"."\n";
        $output .= "\n";
        $output .= "}"."\n";
        $output .= "\n";
        $output .= "?>"."\n";

        return $output;
    }

}

?>
