<?php

require_once './includes/classes/logic/FieldLogicUtility.php';

require_once './includes/classes/logic/ScriptGenerator.php';

/**
 * Description of TableLogicUtility
 *
 * @author suyash.sumaroo
 */
class TableLogicUtility
{

    private $name;
    private $fields;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addColumn($fieldName, $type, $null, $key, $default, $extra)
    {
        $this->fields[count($this->fields)] = new FieldLogicUtility($fieldName, $type, $null, $key, $default, $extra);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getEntityClassFunction($name)
    {
        $output = "";

        $textUtility = new TextUtility();
        $parametersList = $this->getAllParametersList();

        $output .= "<?php\n";
        $output .= "class ".$name."Entity\n";
        $output .= "{\n";

        for($i = 0; $i < count($this->fields); $i++)
        {
            $fieldVariableName = $textUtility->formatVariableName($this->fields[$i]->getName());

            $output .= "private \$$fieldVariableName;";
            $output .= "\n";
        }

        $output .= "public function __construct($parametersList)\n";
        $output .= "{\n";

        for($i = 0; $i < count($this->fields); $i++)
        {
            $fieldVariableName = $textUtility->formatVariableName($this->fields[$i]->getName());
            $output .= "\$this->".$fieldVariableName." = \$$fieldVariableName;";
            $output .= "\n";
        }

        $output .= "}\n";

        //getters
        for($i = 0; $i < count($this->fields); $i++)
        {
            $fieldVariableName = $textUtility->formatVariableName($this->fields[$i]->getName());
            $functionFieldName = "get".$textUtility->formatVariableNameWithFirstLetterCapitalised($this->fields[$i]->getName());

            $output .= "public function $functionFieldName()";
            $output .= "\n";
            $output .= "{\n";
            $output .= "return \$this->".$fieldVariableName.";";
            $output .= "\n";
            $output .= "}";
            $output .= "\n";
        }

        //setters
        for($i = 0; $i < count($this->fields); $i++)
        {
            $fieldVariableName = $textUtility->formatVariableName($this->fields[$i]->getName());
            $functionFieldName = "set".$textUtility->formatVariableNameWithFirstLetterCapitalised($this->fields[$i]->getName());

            $output .= "public function $functionFieldName(\$$fieldVariableName)";
            $output .= "\n";
            $output .= "{\n";
            $output .= "\$this->".$fieldVariableName." = \$$fieldVariableName;";
            $output .= "\n";
            $output .= "}";
            $output .= "\n";
        }


        $output .= "}\n";
        $output .= "?>";

        return $output;
    }

    public function getValidatorClassFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $output .= "<?php\n";
        $output .= "class ".$name."Validator extends Validator\n";
        $output .= "{\n";

        $output .= "public function __construct()\n";
        $output .= "{\n";
        $output .= "\$this->error = new Error();";
        $output .= "}\n";

        $output .= $this->getValidateAddFunction($name);
        $output .= $this->getValidateEditFunction($name);

        $output .= "}\n";
        $output .= "?>";

        return $output;
    }

    private function getValidateAddFunction($name)
    {
        $output = "";

        $textUtility = new TextUtility();

        $params = $this->getNonPrimaryParametersList();

        $functionName = "validateAdd".$name;

        $output .= "public function $functionName($params)";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";

        $nonPrimaryFields = $this->getNonPrimaryKeysObjects();

        for($i = 0; $i < count($nonPrimaryFields); $i++)
        {
            $fieldName = $nonPrimaryFields[$i]->getName();
            $fieldVariable = $textUtility->formatVariableName($fieldName);
            $fieldText = $textUtility->formatReadText($fieldName);

            if($nonPrimaryFields[$i]->getNull() == "NO")
            {
                $output .= "\$this->checkEmptyError(\$$fieldVariable, \"$fieldText\");";
                $output .= "\n";
            }

            if(($nonPrimaryFields[$i]->getType() == "int") || ($nonPrimaryFields[$i]->getType() == "tinyint") ||
                    ($nonPrimaryFields[$i]->getType() == "bigint") || ($nonPrimaryFields[$i]->getType() == "decimal") ||
                    ($nonPrimaryFields[$i]->getType() == "float") || ($nonPrimaryFields[$i]->getType() == "double"))
            {
                $output .= "\$this->validateNumeric(\$$fieldVariable, \"$fieldText\");";
                $output .= "\n";
            }
        }

        $output .= "\n";
        $output .= "return \$this->error;";
        $output .= "\n";
        $output .= "}";
        $output .= "\n";

        return $output;
    }

    private function getValidateEditFunction($name)
    {
        $output = "";

        $textUtility = new TextUtility();

        $params = $this->getNonPrimaryParametersList();

        $functionName = "validateEdit".$name;

        $output .= "public function $functionName($params)";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";

        $nonPrimaryFields = $this->getNonPrimaryKeysObjects();

        for($i = 0; $i < count($nonPrimaryFields); $i++)
        {
            $fieldName = $nonPrimaryFields[$i]->getName();
            $fieldVariable = $textUtility->formatVariableName($fieldName);
            $fieldText = $textUtility->formatReadText($fieldName);

            if($nonPrimaryFields[$i]->getNull() == "NO")
            {
                $output .= "\$this->checkEmptyError(\$$fieldVariable, \"$fieldText\");";
                $output .= "\n";
            }

            if(($nonPrimaryFields[$i]->getType() == "int") || ($nonPrimaryFields[$i]->getType() == "tinyint") ||
                    ($nonPrimaryFields[$i]->getType() == "bigint") || ($nonPrimaryFields[$i]->getType() == "decimal") ||
                    ($nonPrimaryFields[$i]->getType() == "float") || ($nonPrimaryFields[$i]->getType() == "double"))
            {
                $output .= "\$this->validateNumeric(\$$fieldVariable, \"$fieldText\");";
                $output .= "\n";
            }
        }

        $output .= "\n";
        $output .= "return \$this->error;";
        $output .= "\n";
        $output .= "}";
        $output .= "\n";

        return $output;
    }

    public function getGuiClassFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $output .= "<?php\n";
        $output .= "class ".$name."GuiUtility\n";
        $output .= "{\n";

        $output .= "public function __construct()\n";
        $output .= "{\n";
        $output .= "}\n";

        $output .= $this->getGuiGetAddFunction($name, $underscoreName, $directory);
        $output .= $this->getAddFunction($name, $underscoreName, $directory);
        $output .= $this->getClearAddFunction($name, $underscoreName, $directory);
        $output .= $this->getGuiGetEditFunction($name, $underscoreName, $directory);
        $output .= $this->getEditFunction($name, $underscoreName, $directory);
        $output .= $this->getListFunction($name, $underscoreName, $directory);
        $output .= $this->getGuiGetDeleteFunction($name, $underscoreName, $directory);
        $output .= $this->getDeleteFunction($name, $underscoreName, $directory);

        if($this->hasTypeEnum())
        {
            $output .= $this->getEnumComboFunctions();
            $output .= $this->getEnumPreselectedComboFunctions();
        }

        $output .= "}\n";
        $output .= "?>";

        return $output;
    }

    public function getGuiGetAddFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $output .= "\n";
        $output .= "public static function getAdd".$name."()\n";
        $output .= "{\n";

        $output .= "\$output = \"\";\n";
        $output .= "\n\$output .= \"<table>\";\n";

        $compul = "";

        $field = "";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(($this->fields[$i]->getExtra() != "auto_increment") and ($this->fields[$i]->getKey() <> "PRI"))
            {
                $output .= "\n";
                $output .= "\$output .= \"<tr>\";\n";

                if($this->fields[$i]->getNull() == "NO")
                {
                    $compul = " (*)";
                }
                else
                {
                    $compul = "";
                }

                $output .= "\$output .= \"<td class='field'>\";\n";
                $output .= "\$output .= \"".$this->formatLabel($this->fields[$i]->getName())." $compul : \";\n";
                $output .= "\$output .= \"</td>\";\n";

                $output .= "\$output .= \"<td class='field'>\";\n";
                $output .= $this->getInputText($this->fields[$i], $name);
                $output .= "\$output .= \"</td>\";\n";

                $output .= "\$output .= \"</tr>\";\n";
            }

            $field[$i]['name'] = $this->fields[$i]->getName();
            $field[$i]['type'] = $this->fields[$i]->getType();
            $field[$i]['extra'] = $this->fields[$i]->getExtra();
            $field[$i]['key'] = $this->fields[$i]->getKey();
        }

        $output .= "\n\$output .= \"<tr>\";\n";
        $output .= "\$output .= \"<td colspan='2' id='add_".$underscoreName."_con'></td>\";\n";
        $output .= "\$output .= \"</tr>\";\n";

        $output .= "\n\$output .= \"<tr id='add_".$underscoreName."_com'>\";\n";
        $output .= "\$output .= \"<td colspan='2' style='text-align: center;'>\";\n";
        $output .= "\$output .= \"<input type='button' value='Save' onclick=\\\"save".$name."();\\\" />\";\n";
        $output .= "\$output .= \"&nbsp;&nbsp;&nbsp;\";\n";
        $output .= "\$output .= \"<input type='button' value='Cancel' onclick=\\\"get".$name."List();\\\" />\";\n";
        $output .= "\$output .= \"</td>\";\n";
        $output .= "\$output .= \"</tr>\";\n";

        $output .= "\$output .= \"</table>\";\n";

        $output .= "\n\nreturn \$output;\n";

        $output .= "}\n";

        $scriptGenerator = new ScriptGenerator();
        $scriptGenerator->appendGetAddFunction($name, $directory);
        $scriptGenerator->appendClearAddFunction($name, $underscoreName, $field, $directory);
        $scriptGenerator->appendAddFunction($name, $underscoreName, $directory, $field);
        $scriptGenerator->appendGetEditFunction($name, $directory, $field);
        $scriptGenerator->appendEditFunction($name, $underscoreName, $directory, $field);
        $scriptGenerator->appendListFunction($name, $directory, $field);
        $scriptGenerator->appendDeleteFunction($name, $underscoreName, $directory, $field);

        return $output;
    }

    public function getGuiGetEditFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $textUtility = new TextUtility();
        $primaryParams = $this->getPrimaryKeysParameterList();

        $totalParams = $primaryParams;

        $output .= "public static function getEdit".$name."($totalParams)\n";
        $output .= "{\n";

        $logicVariable = $name."LogicUtility";
        $detailVariable = $textUtility->formatVariableName($name)."Entity";

        $output .= "\$output = \"\";\n";
        $output .= "\n";
        $output .= "\$".$detailVariable." = ".$logicVariable."::get".$name."Details(".$primaryParams.");";

        $output .= "\n\nif(\$".$detailVariable." != \"\")";
        $output .= "\n{";

        if($this->hasTypeDate())
        {
            $output .= "\n\$dateUtility = new DateUtility();\n";
        }

        $output .= "\n\$output .= \"<table>\";\n";

        $compul = "";

        $field = "";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(($this->fields[$i]->getExtra() <> "auto_increment") and ($this->fields[$i]->getKey() <> "PRI"))
            {
                $output .= "\n";
                $output .= "\$output .= \"<tr>\";\n";

                if($this->fields[$i]->getNull() == "NO")
                {
                    $compul = " (*)";
                }
                else
                {
                    $compul = "";
                }

                $output .= "\$output .= \"<td class='field'>\";\n";
                $output .= "\$output .= \"".$this->formatLabel($this->fields[$i]->getName())." $compul : \";\n";
                $output .= "\$output .= \"</td>\";\n";

                $output .= "\$output .= \"<td class='field'>\";\n";
                $output .= $this->getValuedInputText($name, $this->fields[$i], $detailVariable);
                $output .= "\$output .= \"</td>\";\n";

                $output .= "\$output .= \"</tr>\";\n";

                $field[$i]['name'] = $this->fields[$i]->getName();
                $field[$i]['type'] = $this->fields[$i]->getType();
            }
        }

        $output .= "\n\$output .= \"<tr>\";\n";
        $output .= "\$output .= \"<td colspan='2' id='edit_".$underscoreName."_con'></td>\";\n";
        $output .= "\$output .= \"</tr>\";\n";

        $output .= "\n\$output .= \"<tr id='edit_".$underscoreName."_com'>\";\n";
        $output .= "\$output .= \"<td colspan='2' style='text-align: center;'>\";\n";
        $output .= "\$output .= \"<input type='button' value='Save' onclick=\\\"edit".$name."(".$this->getJavascriptPrimaryKeysParameterList().");\\\" />\";\n";
        $output .= "\$output .= \"&nbsp;&nbsp;&nbsp;\";\n";
        $output .= "\$output .= \"<input type='button' value='Cancel' onclick=\\\"get".$name."List();\\\" />\";\n";
        $output .= "\$output .= \"</td>\";\n";
        $output .= "\$output .= \"</tr>\";\n";

        $output .= "\$output .= \"</table>\";";

        $output .= "\n}";

        $output .= "\nelse";
        $output .= "\n{";
        $output .= "\n\$output .= \"<p>An error occurred while retrieving details for the $name</p>\";";
        $output .= "\n}";

        $output .= "\n\nreturn \$output;";

        $output .= "\n}";

        return $output;
    }

    public function getAddFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $textUtility = new TextUtility();

        $params = $this->getNonPrimaryParametersList();

        $output .= "\n\npublic static function save".$name."($params)";
        $output .= "\n{\n";

        $output .= "\$output = \"\";\n\n";

        if($this->hasTypeDate())
        {
            $output .= "\$dateUtility = new DateUtility();\n";
        }

        $fieldValues = "";
        $validationFieldValues = "";
        $fieldValuesCounter = 0;
        $tempFieldNames = array();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getExtra() == "")
            {
                if($this->fields[$i]->getType() == "date")
                {
                    $output .= "\$converted".$textUtility->formatFileName($this->fields[$i]->getName())." = \$dateUtility->convertDateToMysqlDate(\$".$textUtility->formatVariableName($this->fields[$i]->getName()).");\n";
                    $fieldValues[$fieldValuesCounter]['value'] = "\$converted".$textUtility->formatFileName($this->fields[$i]->getName());
                    $validationFieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
                }
                elseif($this->fields[$i]->getType() == "datetime")
                {
                    $output .= "\$converted".$textUtility->formatFileName($this->fields[$i]->getName())." = \$dateUtility->convertJavascriptDateToMysqlDate(\$".$textUtility->formatVariableName($this->fields[$i]->getName()).");\n";
                    $fieldValues[$fieldValuesCounter]['value'] = "\$converted".$textUtility->formatFileName($this->fields[$i]->getName());
                    $validationFieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
                }
                else
                {
                    $fieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
                    $validationFieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
                }

                $tempFieldNames[$fieldValuesCounter] = $this->fields[$i]->getName();
                $fieldValues[$fieldValuesCounter]['key'] = $this->fields[$i]->getKey();
                $validationFieldValues[$fieldValuesCounter]['key'] = $this->fields[$i]->getKey();
                $fieldValuesCounter++;
            }
        }

        $validationParams = "";
        $inputValues = "";

        for($i = 0; $i < count($validationFieldValues); $i++)
        {
            if($validationFieldValues[$i]['key'] <> "PRI")
            {
                if($i == (count($validationFieldValues) - 1))
                {
                    $validationParams .= $validationFieldValues[$i]['value'];
                    $inputValues .= $fieldValues[$i]['value'];
                }
                else
                {
                    $validationParams .= $validationFieldValues[$i]['value'].", ";
                    $inputValues .= $fieldValues[$i]['value'].", ";
                }
            }
        }

        $validatorVariable = $textUtility->formatVariableName($name)."Validator";

        $output .= "\$$validatorVariable = new ".$name."Validator();\n";
        $output .= "\$error = \$".$validatorVariable."->validateAdd".$name."($validationParams);\n";
        $output .= "\nif(strlen(\$error->errorExists()))\n";
        $output .= "{\n";
        $output .= "\$output .= \$error->getErrorList();\n";
        $output .= "}\n";
        $output .= "else\n";
        $output .= "{\n";

        if($validationParams == "")
        {
            $output .= $name."LogicUtility::add".$name."(\$db);\n";
        }
        else
        {
            $output .= $name."LogicUtility::add".$name."($inputValues);\n";
        }

        $output .= "\n\$output .= \"<p>".$textUtility->formatReadText($name)." has been successfully saved.</p>\";\n";
        $output .= "\$output .= \"<p>\";\n";
        $output .= "\$output .= \"<a href='javascript:void(0);' onclick=\\\"clearAdd".$name."();\\\">Add another ".$textUtility->formatReadText($name)."</a> or \";\n";
        $output .= "\$output .= \"<a href='javascript:void(0);' onclick=\\\"get".$name."List();\\\">Go to ".$textUtility->formatReadText($name)." list</a>\";\n";
        $output .= "\$output .= \"</p>\";\n";

        $output .= "\n\$output .= \"<script>\";\n";
        $output .= "\$output .= \"\$('add_".$underscoreName."_com').hide();\";\n";
        $output .= "\$output .= \"</script>\";\n";
        $output .= "}\n";

        $output .= "\nreturn \$output;";

        $output .= "\n}\n";

        return $output;
    }

    public function getClearAddFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $output .= "\npublic static function clearAdd".$name."()";
        $output .= "\n{";

        $output .= "\n\$output = \"\";\n";

        $output .= "\n\$output .= \"<script>\";";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getKey() == "")
            {
                if(strstr($this->fields[$i]->getType(), "enum"))//for enum/combo types, do not reinitialise
                {
                    //do nothing
                }
                else
                {
                    $output .= "\n\$output .= \"\$('".$this->getVariableName($this->fields[$i])."').value = '';\";";
                }
            }
        }

        $output .= "\n\n\$output .= \"\$('add_".$underscoreName."_com').show();\";\n";

        $output .= "\n\$output .= \"</script>\";";

        $output .= "\n\nreturn \$output;";

        $output .= "\n}\n\n";

        return $output;
    }

    public function getEditFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $textUtility = new TextUtility();

        $params = "";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($i == (count($this->fields) - 1))
            {
                $params .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
            }
            else
            {
                $params .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName()).", ";
            }
        }

        $output .= "\n\npublic static function edit".$name."($params)";
        $output .= "\n{\n";

        $output .= "\$output = \"\";\n\n";

        if($this->hasTypeDate())
        {
            $output .= "\$dateUtility = new DateUtility();\n";
        }

        $fieldValues = "";
        $validationFieldValues = "";
        $fieldValuesCounter = 0;
        $tempFieldNames = array();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getType() == "date")
            {
                $output .= "\$converted".$textUtility->formatFileName($this->fields[$i]->getName())." = \$dateUtility->convertDateToMysqlDate(\$".$textUtility->formatVariableName($this->fields[$i]->getName()).");\n";
                $fieldValues[$fieldValuesCounter]['value'] = "\$converted".$textUtility->formatFileName($this->fields[$i]->getName());
                $validationFieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
            }
            elseif($this->fields[$i]->getType() == "datetime")
            {
                $output .= "\$converted".$textUtility->formatFileName($this->fields[$i]->getName())." = \$dateUtility->convertJavascriptDateToMysqlDate(\$".$textUtility->formatVariableName($this->fields[$i]->getName()).");\n";
                $fieldValues[$fieldValuesCounter]['value'] = "\$converted".$textUtility->formatFileName($this->fields[$i]->getName());
                $validationFieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
            }
            else
            {
                $fieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
                $validationFieldValues[$fieldValuesCounter]['value'] = "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
            }

            $tempFieldNames[$fieldValuesCounter] = $this->fields[$i]->getName();
            $fieldValues[$fieldValuesCounter]['key'] = $this->fields[$i]->getKey();
            $validationFieldValues[$fieldValuesCounter]['key'] = $this->fields[$i]->getKey();
            $fieldValuesCounter++;
        }

        $validationParams = "";
        $inputValues = "";

        for($i = 0; $i < count($fieldValues); $i++)
        {
            if($i == (count($fieldValues) - 1))
            {
                $inputValues .= $fieldValues[$i]['value'];
            }
            else
            {
                $inputValues .= $fieldValues[$i]['value'].", ";
            }
        }

        for($i = 0; $i < count($validationFieldValues); $i++)
        {
            if($validationFieldValues[$i]['key'] <> "PRI")
            {
                if($i == (count($validationFieldValues) - 1))
                {
                    $validationParams .= $validationFieldValues[$i]['value'];
                }
                else
                {
                    $validationParams .= $validationFieldValues[$i]['value'].", ";
                }
            }
        }

        $validatorVariableName = "\$".$textUtility->formatVariableName($name)."Validator";
        $validatorClass = $name."Validator";
        $validationAction = "validateEdit".$name."($validationParams)";

        $output .= "$validatorVariableName = new $validatorClass();";
        $output .= "\$error = ".$validatorVariableName."->$validationAction;\n";
        $output .= "\nif(\$error->errorExists())\n";
        $output .= "{\n";
        $output .= "\$output .= \$error->getErrorList();\n";
        $output .= "}\n";
        $output .= "else\n";
        $output .= "{\n";
        $output .= $name."LogicUtility::update".$name."($inputValues);\n";
        $output .= "\n\$output = \"<p>".$textUtility->formatReadText($name)." has been successfully updated.</p>\";\n";
        $output .= "\$output .= \"<p>\";\n";
        $output .= "\$output .= \"<a href='javascript:void(0);' onclick=\\\"get".$name."List();\\\">Go to ".$textUtility->formatReadText($name)." list</a>\";\n";
        $output .= "\$output .= \"</p>\";\n";

        $output .= "\n\$output .= \"<script>\";\n";
        $output .= "\$output .= \"\$('edit_".$underscoreName."_com').hide();\";\n";
        $output .= "\$output .= \"</script>\";\n";
        $output .= "}\n";

        $output .= "\nreturn \$output;";

        $output .= "\n}\n";

        return $output;
    }

    public function getListFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $textUtility = new TextUtility();
        $variableName = $textUtility->formatVariableName($name);

        $output .= "\npublic static function get".$name."List()";
        $output .= "\n{";

        $output .= "\n\$output = \"\";";
        $output .= "\n";
        $output .= "\n";

        $output .= "\$".$variableName."List = ".$name."LogicUtility::get".$name."List();\n";

        $output .= "\nif(count(\$".$variableName."List) > 0)\n";
        $output .= "{\n";

        $output .= "\$output .= \"<table class='list_table'>\";\n";

        $output .= "\$output .= \"<tr>\";\n";

        for($i = 0; $i < count($this->fields); $i++)
        {
            $output .= "\$output .= \"<th class='list_table_header'>".$textUtility->formatReadText($this->fields[$i]->getName())."</th>\";\n";
        }

        $output .= "\$output .= \"<th>Action</th>\";\n";

        $output .= "\$output .= \"</tr>\";\n";

        $output .= "\nfor(\$i=0;\$i<count(\$".$variableName."List);\$i++)\n";
        $output .= "{\n";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getKey() == "PRI")
            {
                $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName())." = \$".$variableName."List[\$i]->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($this->fields[$i]->getName())."();\n";
            }
        }

        $output .= "\n\$output .= \"<tr>\";\n";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getKey() == "PRI")
            {
                $output .= "\$output .= \"<td class='list_table_data'>\".\$".$textUtility->formatVariableName($this->fields[$i]->getName()).".\"</td>\";\n";
            }
            else
            {
                $output .= "\$output .= \"<td class='list_table_data'>\".\$".$variableName."List[\$i]->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($this->fields[$i]->getName())."().\"</td>\";\n";
            }
        }

        $output .= "\n\$output .= \"<td class='list_table_data_act'>\";\n";
        $output .= "\$output .= \"<a href='javascript:void(0);' onclick=\\\"getEdit".$name."(".$this->getJavascriptPrimaryKeysParameterList().");\\\">Edit</a>\";\n";
        $output .= "\$output .= \" | \";\n";

        $deleteAction = "getDelete".$name;
        $params = $this->getPrimaryKeysLinkComparisonList();
        $title = "Delete ".$textUtility->formatReadText($underscoreName)." Confirmation";

        $output .= "\$output .= ModalboxUtility::getModalboxLink(\"$deleteAction\", \"$params\", \"$title\", \"300\", \"150\",\"Delete\");\n";
        $output .= "\$output .= \"</td>\";\n";

        $output .= "\$output .= \"</tr>\";\n";
        $output .= "}\n";

        $output .= "\n";
        $output .= "\$output .= \"</table>\";\n";

        $output .= "}\n";

        $output .= "else";
        $output .= "{";
        $output .= "\$output .= \"<p>No records for $name</p>\";";
        $output .= "}";

        $output .= "\n\nreturn \$output;";

        $output .= "\n}\n\n";

        return $output;
    }

    private function getGuiGetDeleteFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $textUtility = new TextUtility();

        $output .= "public static function getDelete".$name."(".$this->getPrimaryKeysParameterList().")\n";
        $output .= "{\n";

        $output .= "\$output = \"\";\n";
        $output .= "\n";
        $output .= "\$output .= \"<div id='conf_del_".$underscoreName."'>\";\n";
        $output .= "\n";
        $output .= "\$output .= \"<p>Do you really want to delete the ".$textUtility->formatReadText($underscoreName)." ?</p>\";\n";
        $output .= "\$output .= \"<p>\";\n";
        $output .= "\$output .= \"<table style='margin-left: auto;margin-right: auto;'>\";\n";
        $output .= "\$output .= \"<tr>\";\n";
        $output .= "\$output .= \"<td align = 'center'>\";\n";
        $output .= "\$output .= \"<input type='button' value='Yes' onclick=\\\"delete".$name."(".$this->getJavascriptPrimaryKeysParameterList().");\\\" />\";\n";
        $output .= "\$output .= \"&nbsp;&nbsp;\";\n";
        $output .= "\$output .= \"<input type='button' value='No' onclick=\\\"Modalbox.hide();return false;\\\" />\";\n";
        $output .= "\$output .= \"</td>\";\n";
        $output .= "\$output .= \"</tr>\";\n";
        $output .= "\$output .= \"</table>\";\n";
        $output .= "\$output .= \"</p>\";\n";

        $output .= "\n\$output .= \"</div>\";\n";

        $output .= "\nreturn \$output;\n";

        $output .= "}\n";

        return $output;
    }

    private function getDeleteFunction($name, $underscoreName, $directory)
    {
        $output = "";

        $textUtility = new TextUtility();

        $output .= "public static function delete".$name."(".$this->getPrimaryKeysParameterList().")\n";
        $output .= "{\n";
        $output .= "\$output = \"\";\n";
        $output .= $name."LogicUtility::delete".$name."(".$this->getPrimaryKeysParameterList().");\n";
        $output .= "\n\$output .= \"<p>\";\n";
        $output .= "\$output .= \"The details for this ".$textUtility->formatReadText($underscoreName)." have been deleted.\";\n";
        $output .= "\$output .= \"&nbsp;&nbsp;&nbsp;\";\n";
        $output .= "\$output .= \"<table>\";\n";
        $output .= "\$output .= \"<tr>\";\n";
        $output .= "\$output .= \"<td>\";\n";
        $output .= "\$output .= \"<input type='button' value='Ok' onclick=\\\"Modalbox.hide();return false;\\\" />\";\n";
        $output .= "\$output .= \"</td>\";\n";
        $output .= "\$output .= \"</tr>\";\n";
        $output .= "\$output .= \"</table>\";\n";
        $output .= "\$output .= \"</p>\";\n";

        $output .= "\n\$output .= \"<script>\";\n";
        $output .= "\$output .= \"Modalbox.resizeToContent();\";\n";
        $output .= "\$output .= \"get".$name."List();\";\n";
        $output .= "\$output .= \"</script>\";\n";

        $output .= "\nreturn \$output;\n";

        $output .= "}\n";

        return $output;
    }

    private function getEnumComboFunctions()
    {
        $output = "";

        $textUtility = new TextUtility();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(strstr($this->fields[$i]->getType(), "enum"))
            {
                $output .= "public static function ".$textUtility->formatVariableName("get_".$this->fields[$i]->getName())."Combo()\n";
                $output .= "{\n";

                $output .= "\$output = \"\";\n\n";

                $output .= "\$output .= \"<select id='cbo_".$this->fields[$i]->getName()."'>\";";

                $enumOptions = $this->getEnumValues($this->fields[$i]->getType());

                for($j = 0; $j < count($enumOptions); $j++)
                {
                    $output .= "\n\$output .= \"<option value='".$enumOptions[$j]."'>".$enumOptions[$j]."</option>\";";
                }

                $output .= "\n\$output .= \"</select>\";\n";

                $output .= "\nreturn \$output;\n";
                $output .= "}\n";
            }
        }

        return $output;
    }

    private function getEnumPreselectedComboFunctions()
    {
        $output = "";

        $textUtility = new TextUtility();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(strstr($this->fields[$i]->getType(), "enum"))
            {
                $output .= "public static function ".$textUtility->formatVariableName("getPreselected_".$this->fields[$i]->getName())."Combo(\$value)\n";
                $output .= "{\n";

                $output .= "\$output = \"\";\n\n";

                $output .= "\$output .= \"<select id='cbo_".$this->fields[$i]->getName()."'>\";\n";

                $enumOptions = $this->getEnumValues($this->fields[$i]->getType());

                for($j = 0; $j < count($enumOptions); $j++)
                {
                    $output .= "\nif(\$value == \"".$enumOptions[$j]."\")\n";
                    $output .= "{\n";
                    $output .= "\$output .= \"<option value='".$enumOptions[$j]."' selected>".$enumOptions[$j]."</option>\";\n";
                    $output .= "}\n";
                    $output .= "else\n";
                    $output .= "{\n";
                    $output .= "\$output .= \"<option value='".$enumOptions[$j]."'>".$enumOptions[$j]."</option>\";\n";
                    $output .= "}\n";
                }

                $output .= "\n\$output .= \"</select>\";\n";

                $output .= "\nreturn \$output;\n";
                $output .= "}\n";
            }
        }

        return $output;
    }

    private function hasTypeDate()
    {
        $ret = false;

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(($this->fields[$i]->getType() == "date") or (($this->fields[$i]->getType() == "datetime")))
            {
                $ret = true;
                break;
            }
        }

        return $ret;
    }

    private function hasTypeEnum()
    {
        $ret = false;

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(strstr($this->fields[$i]->getType(), "enum"))
            {
                $ret = true;
                break;
            }
        }

        return $ret;
    }

    private function getInputText($field, $name)
    {
        $output = "";

        if(strstr($field->getType(), "varchar"))
        {
            $output .= "\$output .= \"<input class='field' type='text' id='txt_".$field->getName()."' />\";\n";
        }
        elseif($field->getType() == "datetime")
        {
            $output .= "\$output .= \"<input class='field' type='text' class='field_date' id='txt_".$field->getName()."' disabled />\";\n";
            $output .= "\$output .= \"<img src='./images/date_picker.gif' id='img_".$field->getName()."' style='vertical-align: middle;' />\";\n";

            $output .= $this->getJavascriptDateTimeCalendar($field->getName());
        }
        elseif($field->getType() == "date")
        {
            $output .= "\$output .= \"<input class='field' type='text' class='field_date' id='txt_".$field->getName()."' disabled />\";\n";
            $output .= "\$output .= \"<img src='./images/date_picker.gif' id='img_".$field->getName()."' style='vertical-align: middle;' />\";\n";

            $output .= $this->getJavascriptDateCalendar($field->getName());
        }
        elseif($field->getType() == "text")
        {
            $output .= "\$output .= \"<textarea class='field' id='txt_".$field->getName()."'></textarea>\";";
        }
        elseif(strstr($field->getType(), "enum"))
        {
            $textUtility = new TextUtility();

            $className = $name."GuiUtility";

            $output .= "\$output .= $className::".$textUtility->formatVariableName("get_".$field->getName())."Combo();\n";
        }
        else
        {
            $output .= "\$output .= \"<input class='field' type='text' id='txt_".$field->getName()."' />\";\n";
        }

        return $output;
    }

    private function getValuedInputText($name, $field, $valueVariable)
    {
        $output = "";

        $textUtility = new TextUtility();

        if(strstr($field->getType(), "varchar"))
        {
            $output .= "\$output .= \"<input class='field' value='\".\$".$valueVariable."->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($field->getName())."().\"' type='text' id='txt_".$field->getName()."' />\";\n";
        }
        elseif($field->getType() == "datetime")
        {
            $output .= "\$output .= \"<input class='field' value='\".\$dateUtility->convertMySqlDateTimeToJavascriptDateTime(\$".$valueVariable."->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($field->getName())."()).\"' type='text' class='field_date' id='txt_".$field->getName()."' disabled />\";\n";
            $output .= "\$output .= \"<img src='./images/date_picker.gif' id='img_".$field->getName()."' style='vertical-align: middle;' />\";\n";

            $output .= $this->getJavascriptDateTimeCalendar($field->getName());
        }
        elseif($field->getType() == "date")
        {
            $output .= "\$output .= \"<input class='field' value='\".\$dateUtility->convertMySqlDateToJavascriptDate(\$".$valueVariable."->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($field->getName())."()).\"' type='text' class='field_date' id='txt_".$field->getName()."' disabled />\";\n";
            $output .= "\$output .= \"<img src='./images/date_picker.gif' id='img_".$field->getName()."' style='vertical-align: middle;' />\";\n";

            $output .= $this->getJavascriptDateCalendar($field->getName());
        }
        elseif($field->getType() == "text")
        {
            $output .= "\$output .= \"<textarea class='field' id='txt_".$field->getName()."'>\".\$".$valueVariable."->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($field->getName())."().\"</textarea>\";\n";
        }
        elseif(strstr($field->getType(), "enum"))
        {
            $textUtility = new TextUtility();

            $output .= "\$output .= \$this->getPreselected".$textUtility->formatFileName($field->getName())."Combo(\$".$valueVariable."->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($field->getName()).");\n";
        }
        else
        {
            $output .= "\$output .= \"<input class='field' value='\".\$".$valueVariable."->get".$textUtility->formatVariableNameWithFirstLetterCapitalised($field->getName())."().\"' type='text' id='txt_".$field->getName()."' />\";\n";
        }

        return $output;
    }

    private function getJavascriptDateTimeCalendar($fieldName)
    {
        $output = "";

        $output .= "\n";
        $output .= "\$output .= \"<script>\";\n";
        $output .= "\$output .= \"Calendar.setup({\";\n";
        $output .= "\$output .= \"inputField     :    'txt_".$fieldName."',\";\n";
        $output .= "\$output .= \"ifFormat       :    '%a %d %b, %Y, %I:%M',\";\n";
        $output .= "\$output .= \"showsTime      :    'true',\";\n";
        $output .= "\$output .= \"timeFormat     :    '24',\";\n";
        $output .= "\$output .= \"button		   :	'img_".$fieldName."'\";\n";
        $output .= "\$output .= \"});\";\n";
        $output .= "\$output .= \"</script>\";\n";
        $output .= "\n";

        return $output;
    }

    private function getJavascriptDateCalendar($fieldName)
    {
        $output = "";

        $output .= "\n\$output .= \"<script>\";\n";
        $output .= "\$output .= \"Calendar.setup({\";\n";
        $output .= "\$output .= \"inputField     :    'txt_".$fieldName."',\";\n";
        $output .= "\$output .= \"ifFormat       :    '%a %d %b, %Y',\";\n";
        $output .= "\$output .= \"showsTime      :    'true',\";\n";
        $output .= "\$output .= \"timeFormat     :    '24',\";\n";
        $output .= "\$output .= \"button		   :	'img_".$fieldName."'\";\n";
        $output .= "\$output .= \"});\";\n";
        $output .= "\$output .= \"</script>\";\n\n";

        return $output;
    }

    private function formatLabel($label)
    {
        $array = explode("_", $label);

        $retLabelName = "";

        if(count($array) == 1)
        {
            $firstLetter = substr($label, 0, 1);

            $retLabelName = strtoupper($firstLetter).substr($label, 1, strlen($label));
        }
        else
        {
            for($i = 0; $i < count($array); $i++)
            {
                $text = $array[$i];

                $firstLetter = substr($text, 0, 1);

                $array[$i] = strtoupper($firstLetter).substr($text, 1, strlen($text))." ";
            }

            $ret = implode($array);

            $retLabelName = $ret;
        }

        return $retLabelName;
    }

    public function getLogicClassFunction($name, $underscoredName, $directory)
    {
        $output = "";

        $output .= "<?php\n\n";
        $output .= "class ".$name."LogicUtility\n";
        $output .= "{\n";

        $output .= $this->getLogicFields($underscoredName);
        $output .= $this->getLogicAddFunction($name);
        $output .= $this->getLogicQueryDetailsFunction($name, $underscoredName);
        $output .= $this->getLogicUpdateFunction($name, $underscoredName);
        $output .= $this->getLogicListFunction($name, $underscoredName);
        $output .= $this->getLogicDeleteFunction($name, $underscoredName);
        $output .= $this->getAddAllfields($name);
        $output .= $this->getConvertToObjectArray($name);
        $output .= $this->getConvertToObject($name);

        $output .= "\n}\n";
        $output .= "?>";

        return $output;
    }

    private function getConvertToObjectArray($name)
    {
        $output = "";

        $className = $name."LogicUtility";

        $output .= "private static function convertToObjectArray(\$result)\n";
        $output .= "{\n";
        $output .= "\$objectArray = array();\n\n";

        $output .= "for(\$i = 0; \$i < count(\$result); \$i++)\n";
        $output .= "{\n";
        $output .= "\$objectArray[\$i] = $className::convertToObject(\$result[\$i]);\n";
        $output .= "}\n\n";

        $output .= "return \$objectArray;\n";
        $output .= "}\n";

        return $output;
    }

    private function getConvertToObject($name)
    {
        $output = "";

        $output .= "private static function convertToObject(\$resultDetails)\n";
        $output .= "{\n";

        $textUtility = new TextUtility();

        for($i = 0; $i < count($this->fields); $i++)
        {
            $fieldName = $this->fields[$i]->getName();
            $uppercaseFieldName = strtoupper($fieldName);
            $fieldVariable = "\$".$uppercaseFieldName."_FIELD";
            $variableName = $textUtility->formatVariableName($fieldName);

            $output .= "\$$variableName = QueryBuilder::getQueryValue(\$resultDetails, ".$name."LogicUtility::$fieldVariable);\n";
        }

        $parameterList = $this->getAllParametersList();

        $entityClassName = $this->getEntityClassName($name);

        $output .= "\nreturn new $entityClassName($parameterList);\n";
        $output .= "}";

        return $output;
    }

    private function getAddAllfields($name)
    {
        $output = "";

        $output .= "private static function addAllFields(QueryBuilder \$queryBuilder)";
        $output .= "{";

        for($i = 0; $i < count($this->fields); $i++)
        {
            $fieldName = $this->fields[$i]->getName();
            $uppercaseFieldName = strtoupper($fieldName);
            $fieldVariable = "\$".$uppercaseFieldName."_FIELD";

            $output .= "\$queryBuilder->addFields(".$name."LogicUtility::$fieldVariable);\n";
        }

        $output .= "\nreturn \$queryBuilder;";
        $output .= "}";

        return $output;
    }

    private function getLogicFields($underscoredName)
    {
        $output = "";

        $output .= "//table name\n";
        $output .= "private static \$TABLE_NAME = \"$underscoredName\";\n";
        $output .= "//fields list\n";

        for($i = 0; $i < count($this->fields); $i++)
        {
            $fieldName = $this->fields[$i]->getName();
            $uppercaseFieldName = strtoupper($fieldName);
            $fieldVariable = "\$".$uppercaseFieldName."_FIELD";

            $output .= "private static $fieldVariable = \"$fieldName\";";
        }

        return $output;
    }

    public function getLogicAddFunction($name)
    {
        $output = "";

        $textUtility = new TextUtility();

        $output .= "\npublic static function add".$name."(".$this->getNonPrimaryParametersList().")";
        $output .= "\n{";

        $className = $name."LogicUtility";

        $output .= "\n\$queryBuilder = new QueryBuilder();";
        $output .= "\n\$queryBuilder->addTable($className::\$TABLE_NAME);";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(($this->fields[$i]->getExtra() == "") and ($this->fields[$i]->getKey() <> "PRI"))
            {
                $fieldVariable = $this->getFieldVariableName($this->fields[$i]);
                $fieldValue = $textUtility->formatVariableName($this->fields[$i]->getName());

                $output .= "\$queryBuilder->addUpdateField($className::$fieldVariable, \$$fieldValue);";
            }
        }

        $output .= "return \$queryBuilder->executeInsertQuery();";

        $output .= "\n}\n";

        return $output;
    }

    public function getLogicValidateFunction($name)
    {
        $output = "";

        $textUtility = new TextUtility();

        $output .= "\npublic function validate".$name."Details(".$this->getNonPrimaryParametersList().")";
        $output .= "\n{\n";

        $output .= "\$output = \"\";\n\n";

        $output .= "\$validator = new Validator();\n\n";

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(($this->fields[$i]->getExtra() == "") and ($this->fields[$i]->getKey() <> "PRI"))
            {
                if($this->fields[$i]->getNull() == "NO")
                {
                    $output .= "if(strlen(\$".$textUtility->formatVariableName($this->fields[$i]->getName()).") == 0)";
                    $output .= "\n{\n";
                    $output .= "\$output .= \"<p> - ".$textUtility->formatReadText($this->fields[$i]->getName())." cannot be empty</p>\";\n";
                    $output .= "}\n";
                }

                $output .= "\nif(!\$validator->validateForDoubleQuote(\$".$textUtility->formatVariableName($this->fields[$i]->getName())."))";
                $output .= "\n{\n";
                $output .= "\$output .= \"<p> - ".$textUtility->formatReadText($this->fields[$i]->getName())." cannot contain double quotes (\\\")</p>\";\n";
                $output .= "}\n";
            }
        }

        $output .= "\nreturn \$output;";

        $output .= "\n}\n";

        return $output;
    }

    private function getLogicUpdateFunction($name, $underscoredName)
    {
        $output = "";

        $textUtility = new TextUtility();

        $className = $this->getLogicClassName($name);

        $output .= "\n";
        $output .= "\n";
        $output .= "public static function update".$name."(".$this->getAllParametersList().")";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";

        $output .= "\$queryBuilder = new QueryBuilder();";
        $output .= "\n";
        $output .= "\$queryBuilder->addTable($className::\$TABLE_NAME);";
        $output .= "\n";

        $nonPrimaryKeys = $this->getNonPrimaryKeysObjects();

        for($i = 0; $i < count($nonPrimaryKeys); $i++)
        {
            $fieldVariableName = $this->getFieldVariableName($nonPrimaryKeys[$i]);
            $fieldValue = $textUtility->formatVariableName($nonPrimaryKeys[$i]->getName());

            $output .= "\$queryBuilder->addUpdateField($className::$fieldVariableName, \$$fieldValue);";
            $output .= "\n";
        }

        $primaryKeys = $this->getPrimaryKeysObjects();

        for($i = 0; $i < count($primaryKeys); $i++)
        {
            $fieldVariableName = $this->getFieldVariableName($primaryKeys[$i]);
            $fieldValue = $textUtility->formatVariableName($primaryKeys[$i]->getName());

            $output .= "\$queryBuilder->addAndConditionWithValue($className::$fieldVariableName, \$$fieldValue);";
            $output .= "\n";
        }

        $output .= "\n";
        $output .= "\$queryBuilder->executeUpdateQuery();";
        $output .= "\n";

        $output .= "\n}\n";

        return $output;
    }

    private function getLogicListFunction($name, $underscoredName)
    {
        $output = "";

        $output .= "\n";
        $output .= "\n";
        $output .= "public static function get".$name."List()";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";

        $className = $this->getLogicClassName($name);

        $output .= "\$queryBuilder = new QueryBuilder();";
        $output .= "\n";
        $output .= "\$queryBuilder->addTable($className::\$TABLE_NAME);";
        $output .= "\n";
        $output .= "\$queryBuilder = $className::addAllFields(\$queryBuilder);";
        $output .= "\n";

        $output .= "\$result = \$queryBuilder->executeQuery();";
        $output .= "\n";
        $output .= "\n";

        $output .= "return $className::convertToObjectArray(\$result);";
        $output .= "\n";
        $output .= "}";
        $output .= "\n";

        return $output;
    }

    public function getLogicQueryDetailsFunction($name, $underscoredName)
    {
        $output = "";

        $textUtility = new TextUtility();

        $className = $name."LogicUtility";

        $output .= "\npublic static function get".$name."Details(".$this->getPrimaryKeysParameterList().")";
        $output .= "\n{\n";

        $output .= "\$queryBuilder = new QueryBuilder();\n";
        $output .= "\$queryBuilder->addTable($className::\$TABLE_NAME);\n";
        $output .= "\$queryBuilder = $className::addAllFields(\$queryBuilder);\n";

        $primaryKeys = $this->getPrimaryKeysObjects();

        for($i = 0; $i < count($primaryKeys); $i++)
        {
            $key = $primaryKeys[$i]->getName();
            $variableName = $textUtility->formatVariableName($key);
            $fieldVariableName = $this->getFieldVariableName($primaryKeys[$i]);

            $output .= "\$queryBuilder->addAndConditionWithValue($className::$fieldVariableName, \$$variableName);\n";
        }

        $output .= "\n\$result = \$queryBuilder->executeQuery();\n";

        $output .= "\n";
        $output .= "if(count(\$result) > 0)";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";
        $output .= "return $className::convertToObject(\$result[0]);";
        $output .= "\n";
        $output .= "}";
        $output .= "\n";
        $output .= "else";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";
        $output .= "return \"\";";
        $output .= "\n";
        $output .= "}";
        $output .= "\n";

//        $output .= "\nreturn $className::convertToObject(\$result);\n";

        $output .= "\n}\n";

        return $output;
    }

    private function getLogicQueryListFunction($name, $underscoredName)
    {
        $output = "";

        $textUtility = new TextUtility();

        $nonPrimaryKeys = $this->getNonPrimaryKeys();

        for($i = 0; $i < count($nonPrimaryKeys); $i++)
        {
            $output .= "\npublic function get".$textUtility->formatFileName($nonPrimaryKeys[$i])."(".$this->getPrimaryKeysParameterList().")";
            $output .= "\n{\n";
            $output .= "\$query = \"SELECT ".$nonPrimaryKeys[$i]." FROM ".$underscoredName." WHERE ".$this->getPrimaryKeysComparisonList()."\";\n";
            $output .= "\$result = \$db->executeQuery(\$query);";
            $output .= "\n\nreturn \$result;";
            $output .= "\n}\n";
        }

        return $output;
    }

    private function getLogicDeleteFunction($name, $underscoredName)
    {
        $output = "";

        $textUtility = new TextUtility();

        $output .= "\n";
        $output .= "public static function delete".$name."(".$this->getPrimaryKeysParameterList().")";
        $output .= "\n";
        $output .= "{";
        $output .= "\n";

        $className = $this->getLogicClassName($name);

        $output .= "\$queryBuilder = new QueryBuilder();";
        $output .= "\n";
        $output .= "\$queryBuilder->addTable($className::\$TABLE_NAME);";
        $output .= "\n";

        $primaryKeys = $this->getPrimaryKeysObjects();

        for($i = 0; $i < count($primaryKeys); $i++)
        {
            $fieldVariableName = $this->getFieldVariableName($primaryKeys[$i]);
            $variableName = $textUtility->formatVariableName($primaryKeys[$i]->getName());

            $output .= "\$queryBuilder->addAndConditionWithValue($className::$fieldVariableName, \$$variableName);";
            $output .= "\n";
        }

        $output .= "\n";
        $output .= "\$queryBuilder->executeDeleteQuery();";
        $output .= "\n";
        $output .= "}";
        $output .= "\n";

        return $output;
    }

    private function getPrimaryKeysParameterList()
    {
        $output = "";

        $textUtility = new TextUtility;

        $keys = $this->getPrimaryKeys();

        for($i = 0; $i < count($keys); $i++)
        {
            if($i == (count($keys) - 1))
            {
                $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
            }
            else
            {
                $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName()).", ";
            }
        }

        return $output;
    }

    private function getJavascriptPrimaryKeysParameterList()
    {
        $output = "";

        $textUtility = new TextUtility;

        $keys = $this->getPrimaryKeys();

        for($i = 0; $i < count($keys); $i++)
        {
            if($i == (count($keys) - 1))
            {
                $output .= "'\$".$textUtility->formatVariableName($this->fields[$i]->getName())."'";
            }
            else
            {
                $output .= "'\$".$textUtility->formatVariableName($this->fields[$i]->getName())."', ";
            }
        }

        return $output;
    }

    private function getPrimaryKeysComparisonList()
    {
        $output = "";

        $textUtility = new TextUtility;

        $keys = $this->getPrimaryKeys();

        for($i = 0; $i < count($keys); $i++)
        {
            if($i == (count($keys) - 1))
            {
                $output .= $this->fields[$i]->getName()."='\$".$textUtility->formatVariableName($this->fields[$i]->getName())."'";
            }
            else
            {
                $output .= $this->fields[$i]->getName()."='\$".$textUtility->formatVariableName($this->fields[$i]->getName())."' AND ";
            }
        }

        return $output;
    }

    private function getPrimaryKeysLinkComparisonList()
    {
        $output = "";

        $textUtility = new TextUtility;

        $keys = $this->getPrimaryKeys();

        for($i = 0; $i < count($keys); $i++)
        {
            if($i == (count($keys) - 1))
            {
                $output .= $this->fields[$i]->getName()."=\$".$textUtility->formatVariableName($this->fields[$i]->getName())."";
            }
            else
            {
                $output .= $this->fields[$i]->getName()."=\$".$textUtility->formatVariableName($this->fields[$i]->getName())."&";
            }
        }

        return $output;
    }

    private function getPrimaryKeys()
    {
        $key = array();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getKey() == "PRI")
            {
                $key[count($key)] = $this->fields[$i]->getName();
            }
        }

        return $key;
    }

    private function getPrimaryKeysObjects()
    {
        $key = array();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getKey() == "PRI")
            {
                $key[count($key)] = $this->fields[$i];
            }
        }

        return $key;
    }

    private function getNonPrimaryKeys()
    {
        $key = array();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getKey() == "")
            {
                $key[count($key)] = $this->fields[$i]->getName();
            }
        }

        return $key;
    }

    private function getNonPrimaryKeysObjects()
    {
        $key = array();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getKey() == "")
            {
                $key[count($key)] = $this->fields[$i];
            }
        }

        return $key;
    }

    private function getParametersList()
    {
        $output = "";

        $textUtility = new TextUtility();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($this->fields[$i]->getExtra() == "")
            {
                if($i == (count($this->fields) - 1))
                {
                    $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
                }
                else
                {
                    $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName()).", ";
                }
            }
        }

        return $output;
    }

    private function getAllParametersList()
    {
        $output = "";

        $textUtility = new TextUtility();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if($i == (count($this->fields) - 1))
            {
                $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
            }
            else
            {
                $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName()).", ";
            }
        }

        return $output;
    }

    private function getNonPrimaryParametersList()
    {
        $output = "";

        $textUtility = new TextUtility();

        for($i = 0; $i < count($this->fields); $i++)
        {
            if(($this->fields[$i]->getExtra() == "") and ($this->fields[$i]->getKey() <> "PRI"))
            {
                if($i == (count($this->fields) - 1))
                {
                    $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName());
                }
                else
                {
                    $output .= "\$".$textUtility->formatVariableName($this->fields[$i]->getName()).", ";
                }
            }
        }

        return $output;
    }

    private function getVariableName($field)
    {
        $output = "";

        if($field->getType() == "varchar")
        {
            $output = "txt_".$field->getName();
        }
        elseif($field->getType() == "text")
        {
            $output = "txt_".$field->getName();
        }
        elseif($field->getType() == "date")
        {
            $output = "txt_".$field->getName();
        }
        elseif($field->getType() == "datetime")
        {
            $output = "txt_".$field->getName();
        }
        else
        {
            $output = "txt_".$field->getName();
        }

        return $output;
    }

    private function getEnumValues($field)
    {
        #extract the values
        #the values are enclosed in single quotes
        #and separated by commas
        $regex = "/'(.*?)'/";
        preg_match_all($regex, $field, $enumArray);
        $enumFields = $enumArray[1];

        return $enumFields;
    }

    private function getNumberOfPrimaryKeys()
    {
        return count($this->getPrimaryKeys());
    }

    private function getFieldVariableName(FieldLogicUtility $fieldLogicUtility)
    {
        $fieldName = $fieldLogicUtility->getName();
        $uppercaseFieldName = strtoupper($fieldName);
        $fieldVariable = "\$".$uppercaseFieldName."_FIELD";

        return $fieldVariable;
    }

    private function getLogicClassName($name)
    {
        return $name."LogicUtility";
    }

    private function getEntityClassName($name)
    {
        return $name."Entity";
    }

}

?>
