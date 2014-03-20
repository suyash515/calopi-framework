<?php


/**
 * Description of GenericPHPFileWriter
 *
 * @author suyash
 */
class GenericPHPFileWriter extends GenericFileWriter
{

    protected static $MODIFIER_PUBLIC = "public";
    protected static $MODIFIER_PROTECTED = "protected";
    protected static $MODIFIER_PRIVATE = "private";

    protected function appendPhpFileOpening()
    {
	$this->addContent("<?php");
	$this->addEmptyLine(1);
    }

    protected function appendPhpFileClosing()
    {
	$this->addEmptyLine();
	$this->addContent("?>");
    }

    protected function appendClassStart($extendArray = array())
    {
	if(count($extendArray) > 0)
	{
	    $extendList = "";

	    for($i = 0; $i < count($extendArray); $i++)
	    {
		$extendList .= $extendArray[$i];

		if($i < (count($extendArray) - 1))
		{
		    $extendList .= ", ";
		}
	    }

	    $this->addContent("class ".$this->fileName." extends $extendList");
	}
	else
	{
	    $this->addContent("class ".$this->fileName);
	}

	$this->openCurly();
    }

    protected function appendClassEnd()
    {
	$this->closeCurly();
    }

    protected function addComment($comment)
    {
	$this->addContent("//$comment");
    }

    public function appendDefaultConstructor($parameterList = "")
    {
	$this->addContent("public function __construct($parameterList)");
    }

    public static function createVariable($variableName)
    {
	return "\$".$variableName;
    }

    protected function appendFunctionDeclaration($functionName = "", $prefix = "", $suffix = "",
	    $staticFunction = false, $parameterString = "", $functionModifier = "")
    {
	$output = "";

	if($functionName == "")
	{
	    $functionName = TextUtility::formatToCamelCapitalised($this->tableEntity->getTableName());
	}

	if($functionModifier == "")
	{
	    $output .= "public";
	}
	else
	{
	    $output .= $functionModifier;
	}

	if($staticFunction)
	{
	    $output .= " static";
	}

	$output .= " function ";

	$output .= $prefix.$functionName.$suffix;

	$output .= "(";

	if($parameterString != "")
	{
	    $output .= $parameterString;
	}

	$output .= ")";

	$this->addContent($output);
    }
}

?>
