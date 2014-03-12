<?php

/**
 * Description of ScriptGenerator
 *
 * @author suyash.sumaroo
 */
class ScriptGenerator
{

    //put your code here

    private $scriptFile = "script.js";

    public function __construct()
    {

    }

    public function appendScriptFile($directory, $string)
    {
        $handle = fopen($directory."////includes////js////".$this->scriptFile, 'a');

        fwrite($handle, $string);
    }

    public function createScriptFile($directory)
    {
        fopen($directory."////includes////js////".$this->scriptFile, 'w');
    }

    public function addGlobalVariables($directory)
    {
        $output = "";

        $output .= "var mainContent = \"right_content\";\n\n";

        $this->appendScriptFile($directory, $output);
    }

    public function appendGetAddFunction($name, $directory)
    {
        $output = "";

        $output .= "\nfunction getAdd".$name."()\n";
        $output .= "{\n";
        $output .= "getSSContent(mainContent, \"getAdd".$name."\", \"\");\n";
        $output .= "}\n";

        $this->appendScriptFile($directory, $output);
    }

    public function appendAddFunction($name, $underscoreName, $directory, $fields)
    {
        $output = "";

        $output .= "\nfunction save".$name."()\n";
        $output .= "{";

        $params = "";

        for($i = 0; $i < count($fields); $i++)
        {
            if(($fields[$i]['name'] <> "") && ($fields[$i]['key'] != "PRI"))
            {
                $output .= "\nvar ".$fields[$i]['name']." = ".$this->determineRetrievalType($fields[$i]);

                if($params == "")
                {
                    $params .= "'".$fields[$i]['name']."=' + ".$fields[$i]['name'];
                }
                else
                {
                    $params .= "'"."&".$fields[$i]['name']."=' + ".$fields[$i]['name'];
                }

                if(($i <> count($fields) - 1))
                {
                    $params .= " + ";
                }
            }
        }

        if($params <> "")
        {
            $output .= "\n\nvar params = ".$params.";";
        }

        $output .= "\ngetSSContent('add_".$underscoreName."_con', 'save".$name."', params);";

        $output .= "\n}\n";

        $this->appendScriptFile($directory, $output);
    }

    public function appendGetEditFunction($name, $directory, $fields)
    {
        $output = "";

        $args = $this->getKeyParametersList($fields);

        $output .= "\nfunction getEdit".$name."($args)\n";
        $output .= "{";

        $params = "";

        for($i = 0; $i < count($fields); $i++)
        {
            if($fields[$i]['name'] != "")
            {
                if($fields[$i]['key'] == "PRI")
                {
                    if($params == "")
                    {
                        $params .= "'".$fields[$i]['name']."=' + ".$fields[$i]['name']." + ";
                    }
                    else
                    {
                        $params .= "'"."&".$fields[$i]['name']."=' + ".$fields[$i]['name']." + ";
                    }
                }
            }
        }

        if($params != "")
        {
            $params = substr($params, 0, count($params) - 4);
            $output .= "\nvar params = ".$params.";";
        }

        $output .= "\ngetSSContent(mainContent, 'getEdit".$name."', params);";

        $output .= "\n}\n";

        $this->appendScriptFile($directory, $output);
    }

    public function appendEditFunction($name, $underscoreName, $directory, $fields)
    {
        $output = "";

        $args = $this->getKeyParametersList($fields);

        $output .= "\nfunction edit".$name."($args)\n";
        $output .= "{";

        $params = "";

        for($i = 0; $i < count($fields); $i++)
        {
            if($fields[$i]['name'] <> "")
            {
                if($fields[$i]['key'] != "PRI")
                {
                    $output .= "\nvar ".$fields[$i]['name']." = ".$this->determineRetrievalType($fields[$i]);
                }

                if($params == "")
                {
                    $params .= "'".$fields[$i]['name']."=' + ".$fields[$i]['name'];
                }
                else
                {
                    $params .= "'"."&".$fields[$i]['name']."=' + ".$fields[$i]['name'];
                }

                if(($i <> count($fields) - 1))
                {
                    $params .= " + ";
                }
            }
        }

        if($params <> "")
        {
            $output .= "\n\nvar params = ".$params.";";
        }

        $output .= "\ngetSSContent('edit_".$underscoreName."_con', 'edit".$name."', params);";

        $output .= "\n}\n";

        $this->appendScriptFile($directory, $output);
    }

    public function appendListFunction($name, $directory, $fields)
    {
        $output = "";

        $output .= "\nfunction get".$name."List()\n";
        $output .= "{\n";
        $output .= "getSSContent(mainContent, \"get".$name."List\", \"\");\n";
        $output .= "}\n";

        $this->appendScriptFile($directory, $output);
    }

    public function appendClearAddFunction($name, $underscoreName, $fields, $directory)
    {
        $output = "";

        $output .= "\nfunction clearAdd".$name."()";
        $output .= "\n{";
        $output .= "getSSContent('add_".$underscoreName."_con', 'clearAdd".$name."', '');";
        $output .= "\n}\n";

        $this->appendScriptFile($directory, $output);
    }

    public function appendDeleteFunction($name, $underscoreName, $directory, $fields)
    {
        $output = "";

        $output .= "\nfunction delete".$name."(".$this->getKeyParametersList($fields).")";
        $output .= "\n{";

        $params = "";

        $numberOfPrimaryKeys = $this->getNumberOfPrimaryKeys($fields);

        for($i = 0; $i < count($fields); $i++)
        {
            if(($fields[$i]['name'] <> "") and ($fields[$i]['key'] == "PRI"))
            {
                if($params == "")
                {
                    $params .= "'".$fields[$i]['name']."=' + ".$fields[$i]['name'];
                }
                else
                {
                    $params .= "'"."&".$fields[$i]['name']."=' + ".$fields[$i]['name'];
                }

                if($i <> ($numberOfPrimaryKeys - 1))
                {
                    $params .= " + ";
                }
            }
        }

        if($params <> "")
        {
            $output .= "\nvar params = ".$params.";\n";
        }

        $output .= "getSSContent(\"conf_del_".$underscoreName."\", \"delete".$name."\", params);";

        $output .= "\n}\n";

        $this->appendScriptFile($directory, $output);
    }

    private function getKeyParametersList($fields)
    {
        $output = "";

        for($i = 0; $i < count($fields); $i++)
        {
            if($fields[$i]['key'] == "PRI")
            {
                $output .= $fields[$i]['name'].", ";
            }
        }

        if(count($output) > 0)
        {
            $output = substr($output, 0, count($output) - 3);
        }

        return $output;
    }

    private function determineRetrievalType($field)
    {
        $output = "";

        if(strstr($field['type'], "varchar"))
        {
            $output .= "\$('txt_".$field['name']."').value;";
        }
        elseif($field['type'] == "text")
        {
            $output .= "\$('txt_".$field['name']."').value;";
        }
        elseif($field['type'] == "date")
        {
            $output .= "\$('txt_".$field['name']."').value;";
        }
        elseif($field['type'] == "datetime")
        {
            $output .= "\$('txt_".$field['name']."').value;";
        }
        elseif(strstr($field['type'], "enum"))
        {
            $output .= "\$('cbo_".$field['name']."').options[\$('cbo_".$field['name']."').selectedIndex].value;";
        }
        else
        {
            $output .= "\$('txt_".$field['name']."').value;";
        }

        return $output;
    }

    private function getVariableName($field)
    {
        $output = "";

        if(strstr($field['type'], "varchar"))
        {
            $output = "txt_".$field['name'];
        }
        elseif($field['type'] == "text")
        {
            $output = "txt_".$field['name'];
        }
        elseif($field['type'] == "date")
        {
            $output = "txt_".$field['name'];
        }
        elseif($field['type'] == "datetime")
        {
            $output = "txt_".$field['name'];
        }
        else
        {
            $output = "txt_".$field['name'];
        }

        return $output;
    }

    private function getNumberOfPrimaryKeys($fields)
    {
        $counter = 0;

        for($i = 0; $i < count($fields); $i++)
        {
            if($fields[$i]['key'] == "PRI")
            {
                $counter++;
            }
        }

        return $counter;
    }

}

?>
