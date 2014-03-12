<?php

/**
 * Description of IndexPageClassUtility
 *
 * @author suyash
 */
class IndexPageClassUtility
{

    private static $CLASS_NAME = "IndexGuiUtility.php";

    public static function generatePage($fields, $directory)
    {
        $output = "";

        $output .= IndexPageClassUtility::generatePageContent($fields);

        $handle = fopen($directory.IndexPageClassUtility::$CLASS_NAME, 'w');

        fwrite($handle, $output);
    }

    private static function generatePageContent($fields)
    {
        $output = "";

        $textUtility = new TextUtility();

        $output .= "<?php";
        $output .= "\n\n";
        $output .= "class IndexGuiUtility";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";
        $output .= "public static function getApplicationNavigation()";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";
        $output .= "\$output = \"\";";
        $output .= "\n";
        $output .= "\n";
        $output .= "\$output .= \"<ul>\";";
        $output .= "\n";

        for($i = 0; $i < count($fields); $i++)
        {
            $variableName = $textUtility->formatReadText($fields[$i]->getName());
            $javascriptListAction = "get".$textUtility->formatVariableNameWithFirstLetterCapitalised($fields[$i]->getName())."List();";
            $javascriptAddAction = "getAdd".$textUtility->formatVariableNameWithFirstLetterCapitalised($fields[$i]->getName())."();";

            $output .= "\$output .= \"<li>$variableName</li>\";";
            $output .= "\n";

            $output .= "\$output .= \"<li>\";";
            $output .= "\n";
            $output .= "\$output .= \"<a href='javascript:void(0);' onclick=\\\"$javascriptListAction\\\">List $variableName</a>\";";
            $output .= "\n";
            $output .= "\$output .= \"</li>\";";
            $output .= "\n";

            $output .= "\$output .= \"<li>\";";
            $output .= "\n";
            $output .= "\$output .= \"<a href='javascript:void(0);' onclick=\\\"$javascriptAddAction\\\">Add $variableName</a>\";";
            $output .= "\n";
            $output .= "\$output .= \"</li>\";";
            $output .= "\n";

            $output .= "\n";
        }

        $output .= "\$output .= \"</ul>\";";
        $output .= "\n\n";
        $output .= "return \$output;";
        $output .= "\n";
        $output .= "}";
        $output .= "\n";
        $output .= "}";
        $output .= "\n\n\n";

        $output .= "?>";

        return $output;
    }

}

?>
