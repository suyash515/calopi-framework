<?php


class Error
{

    /**
     * determines whether an error exists
     *
     * @var boolean
     */
    private $errorExist;
    /**
     * An array containing all the errors
     *
     * @var Array
     */
    private $error;
    /**
     * An object returned along with the error object
     *
     * @var Object
     */
    private $object;

    public function __construct()
    {
	$this->errorExist = false;
	$this->error = array();
    }

    public function setErrorExist($error)
    {
	$this->errorExist = $error;
    }

    public function addError($error)
    {
	$this->errorExist = true;
	$this->error[count($this->error)] = $error;
    }

    public function errorExists()
    {
	return $this->errorExist;
    }

    public function getErrorArray()
    {
	return $this->error;
    }

    public function setObject($obj)
    {
	$this->object = $obj;
    }

    public function getObject()
    {
	return $this->object;
    }

    public function getErrorList($title = "")
    {
	$output = "";

	if($title == "")
	{
	    if(count($this->error) > 1)
	    {
		$title = "The following errors were found:";
	    }
	    else
	    {
		$title = "The following error was found:";
	    }
	}

	$output .= "<img src='".UrlConfiguration::getImageSrc("alert.gif")."' style='vertical-align: middle;' />&nbsp;&nbsp;&nbsp;".$title;

	$output .= "<ol>";

	for($i = 0; $i < count($this->error); $i++)
	{
	    $output .= "<li>";
	    $output .= $this->error[$i];
	    $output .= "</li>";
	}

	$output .= "</ol>";

	return $output;
    }

    public function getSimpleErrorList()
    {
	$output = "";

	for($i = 0; $i < count($this->error); $i++)
	{
	    $output .= $this->error[$i];

	    if($i < (count($this->error) - 1))
	    {
		$output .= "<br />";
	    }
	}

	return $output;
    }

    public function getSimpleTextErrorList()
    {
	$output = "";

	for($i = 0; $i < count($this->error); $i++)
	{
	    $output .= $this->error[$i];

	    if($i < (count($this->error) - 1))
	    {
		$output .= "\n";
	    }
	}

	return $output;
    }

    public function debug()
    {
	$output = "";

	$output .= "<p>Error exists : ".$this->errorExist."</p>";
	$output .= $this->getErrorList("Debug");

	return $output;
    }

    public static function getObjectDetailsError($objectType)
    {
	$output = "";

	$output .= "An error occurred while retrieving details for this $objectType. Please try again. If the problem persist,
		    please contact the administrator.";

	return $output;
    }
}

?>