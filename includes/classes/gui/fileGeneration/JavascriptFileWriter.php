<?php

/**
 * Description of JavascriptFileWriter
 *
 * @author suyash
 */
class JavascriptFileWriter extends GenericFileWriter
{

    protected function addComment($comment)
    {
        $this->addContent("//$comment");
    }

    public static function createVariable($variableName)
    {
        return $variableName;
    }

    protected function appendFunctionDeclaration($functionName, $parameterString = "")
    {
        $this->addContent("function $functionName($parameterString)");
    }

    /**
     * Gets a list of FieldEntity objects and returns a string in the form param1 + "_" + param2 + "_" + ...
     * @param type $fieldEntityList
     */
    protected function getParameterAddedString($fieldEntityList)
    {
        $output = "";

        for($i=0;$i<count($fieldEntityList);$i++)
        {
            $fieldEntity = $fieldEntityList[$i];
            $output .= TextUtility::formatVariableName($fieldEntity->getField());

            if($i < (count($fieldEntity) - 1))
            {
                $output .= "\"_\" + ";
            }
        }

        return $output;
    }

}

?>
