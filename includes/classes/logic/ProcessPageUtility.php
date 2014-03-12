<?php

require_once './includes/classes/utilities/TextUtility.php';

/**
 * Description of ProcessPageUtility
 *
 * @author suyash.sumaroo
 */
class ProcessPageUtility
{

    //put your code here
    private $processFile = "process.php";

    public function __construct()
    {

    }

    public function appendProcessFile($directory, $string)
    {
        $handle = fopen($directory.$this->processFile, 'a');

        fwrite($handle, $string);
    }

    public function createProcessFile($directory)
    {
        fopen($directory.$this->processFile, 'w');
    }

    public function addHeader($directory, $databaseStructure)
    {
//        $textUtility = new TextUtility();

        $output = "";

        $output .= "<?php\n";
        $output .= "\n\nrequire_once(\"./autoload.php\");";
        $output .= "\n";

//        for($i = 0; $i < count($databaseStructure); $i++)
//        {
//            $output .= "\nrequire_once(\"./includes/classes/gui/".$textUtility->formatFileName($databaseStructure[$i]->getName())."GuiUtility.php\");";
//        }

        $output .= "\n\nif(isset(\$_REQUEST['action']))\n";
        $output .= "{\n";
        $output .= "switch(\$_REQUEST['action'])\n";
        $output .= "{\n";

        $this->appendProcessFile($directory, $output);
    }

    public function addFooter($directory)
    {
        $output = "";

        $output .= "}\n";
        $output .= "}\n";
        $output .= "?>";

        $this->appendProcessFile($directory, $output);
    }

    public function appendAllFunctions($name, $underscoredName, $directory, $fields)
    {
        $textUtility = new TextUtility();
        $variableName = $textUtility->formatVariableName($underscoredName);

        $this->appendGetAddFunction($name, $variableName, $directory);
        $this->appendAddFunction($name, $variableName, $directory, $fields);
        $this->appendClearAddFunction($name, $variableName, $directory);
        $this->appendGetEditFunction($name, $variableName, $directory, $fields);
        $this->appendEditFunction($name, $variableName, $directory, $fields);
        $this->appendGetDeleteFunction($name, $variableName, $directory, $fields);
        $this->appendDeleteFunction($name, $variableName, $directory, $fields);
        $this->appendListFunction($name, $variableName, $directory, $fields);
    }

    public function appendGetAddFunction($name, $variableName, $directory)
    {
        $output = "";

        $output .= "\ncase \"getAdd".$name."\":";
        $output .= "\necho ".$name."GuiUtility::getAdd".$name."();";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    public function appendClearAddFunction($name, $variableName, $directory)
    {
        $output = "";

        $output .= "\ncase \"clearAdd".$name."\":";
//        $output .= "\n\$".$variableName."GuiUtility = new ".$name."GuiUtility();";
        $output .= "\necho ".$name."GuiUtility::clearAdd".$name."();";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    public function appendGetEditFunction($name, $variableName, $directory, $fields)
    {
        $output = "";

        $params = $this->getPrimaryKeysParameterList($fields);

        $output .= "\ncase \"getEdit".$name."\":";
//        $output .= "\n\$".$variableName."GuiUtility = new ".$name."GuiUtility();";
        $output .= "\necho ".$name."GuiUtility::getEdit".$name."($params);";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    public function appendAddFunction($name, $variableName, $directory, $fields)
    {
        $output = "";

        $params = $this->getParametersList($fields);

        $output .= "\ncase \"save".$name."\":";
//        $output .= "\n\$".$variableName."GuiUtility = new ".$name."GuiUtility();";
        $output .= "\necho ".$name."GuiUtility::save".$name."($params);";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    public function appendEditFunction($name, $variableName, $directory, $fields)
    {
        $output = "";

        $params = $this->getAllParametersList($fields);

        $output .= "\ncase \"edit".$name."\":";
//        $output .= "\n\$".$variableName."GuiUtility = new ".$name."GuiUtility();";
        $output .= "\necho ".$name."GuiUtility::edit".$name."($params);";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    public function appendGetDeleteFunction($name, $variableName, $directory, $fields)
    {
        $output = "";

        $params = $this->getPrimaryKeysParameterList($fields);

        $output .= "\ncase \"getDelete".$name."\":";
//        $output .= "\n\$".$variableName."GuiUtility = new ".$name."GuiUtility();";
        $output .= "\necho ".$name."GuiUtility::getDelete".$name."($params);";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    public function appendDeleteFunction($name, $variableName, $directory, $fields)
    {
        $output = "";

        $params = $this->getPrimaryKeysParameterList($fields);

        $output .= "\ncase \"delete".$name."\":";
//        $output .= "\n\$".$variableName."GuiUtility = new ".$name."GuiUtility();";
        $output .= "\necho ".$name."GuiUtility::delete".$name."($params);";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    public function appendListFunction($name, $variableName, $directory, $fields)
    {
        $output = "";

        $output .= "\ncase \"get".$name."List\":";
//        $output .= "\n\$".$variableName."GuiUtility = new ".$name."GuiUtility();";
        $output .= "\necho ".$name."GuiUtility::get".$name."List();";
        $output .= "\nbreak;\n";

        $this->appendProcessFile($directory, $output);
    }

    private function getParametersList($fields)
    {
        $params = "";

        for($i = 0; $i < count($fields); $i++)
        {
            if(($fields[$i]->getName() <> "") and ($fields[$i]->getExtra() == "") and ($fields[$i]->getKey() <> "PRI"))
            {
                $params .= "RequestHelper::getRequestValue('".$fields[$i]->getName()."')";

                if($i < (count($fields) - 1))
                {
                    $params .= ", ";
                }
            }
        }

        return $params;
    }

    private function getAllParametersList($fields)
    {
        $params = "";

        for($i = 0; $i < count($fields); $i++)
        {
            if($fields[$i]->getName() <> "")
            {
                $params .= "RequestHelper::getRequestValue('".$fields[$i]->getName()."')";

                if($i < (count($fields) - 1))
                {
                    $params .= ", ";
                }
            }
        }

        return $params;
    }

    private function getPrimaryKeysParameterList($fields)
    {
        $output = "";

        $keys = $this->getPrimaryKeys($fields);

        for($i = 0; $i < count($keys); $i++)
        {
            $output .= "RequestHelper::getRequestValue('".$fields[$i]->getName()."')";

            if($i < (count($keys) - 1))
            {
                $output .= ", ";
            }
        }

        return $output;
    }

    private function getPrimaryKeys($fields)
    {
        $key = array();

        for($i = 0; $i < count($fields); $i++)
        {
            if($fields[$i]->getKey() == "PRI")
            {
                $key[count($key)] = $fields[$i]->getName();
            }
        }

        return $key;
    }

}

?>
