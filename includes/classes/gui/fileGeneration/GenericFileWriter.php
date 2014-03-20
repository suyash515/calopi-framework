<?php


/**
 * Description of GenericFileWriter
 *
 * @author suyash
 */
abstract class GenericFileWriter
{

    protected $folder;
    protected $fileName;
    protected $extension;
    protected $contents;
    protected $indentation;
    //file extension values
    protected static $PHP_EXTENSION = "php";
    protected static $JAVASCRIPT_EXTENSION = "js";
    protected static $CSS_EXTENSION = "css";

    abstract protected function addComment($comment);

    public static function createVariable($variableName)
    {

    }

    protected function initialise($folder, $fileName, $extension)
    {
	$this->folder = $folder;
	$this->fileName = $fileName;
	$this->extension = $extension;

	$this->indentation = 0;
    }

    protected function indent()
    {
	$this->indentation++;
    }

    protected function unIndent()
    {
	if($this->indentation > 0)
	{
	    $this->indentation--;
	}
    }

    protected function addIndentation()
    {
	for($i = 0; $i < $this->indentation; $i++)
	{
	    $this->contents .= "    ";
	}
    }

    protected function addEmptyLine($numberOfEmtptyLines = 1)
    {
	for($i = 0; $i < $numberOfEmtptyLines; $i++)
	{
	    $this->contents .= "\n";
	}
    }

    protected function addOutputContent($content)
    {
	$formattedContent = addcslashes($content, '"');
	$this->addContent("\$output .= \"$formattedContent\";");
    }

    protected function addContent($text, $addNewLine = true)
    {
	$this->addIndentation();
	$this->contents .= $text;

	if($addNewLine)
	{
	    $this->addEmptyLine();
	}
    }

    protected function addReturnOutput()
    {
	$this->addContent("return \$output;");
    }

    protected function openCurly()
    {
	$this->addContent("{");
	$this->indent();
    }

    protected function closeCurly()
    {
	$this->unIndent();
	$this->addContent("}");
    }

    public function createFile()
    {
	$this->openFile();
    }

    protected function openFile()
    {
	$fullFileName = $this->getFullFileName();

	$handle = fopen($fullFileName, 'w');

	fwrite($handle, $this->contents);
    }

    public function replaceContents()
    {
	$fullFileName = $this->getFullFileName();

	file_put_contents($fullFileName, $this->contents);
    }

    protected function getFullFileName()
    {
	$lastCharacter = substr($this->folder, strlen($this->folder) - 1, 1);

	if($lastCharacter == DIRECTORY_SEPARATOR)
	{
	    $fullFileName = $this->folder.$this->fileName.".".$this->extension;
	}
	else
	{
	    $fullFileName = $this->folder.DIRECTORY_SEPARATOR.$this->fileName.".".$this->extension;
	}

	return $fullFileName;
    }
}

?>
