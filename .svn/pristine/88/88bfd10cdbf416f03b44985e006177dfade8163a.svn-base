<?php

/**
 * Description of AutoloadPHPFileWriter
 *
 * @author suyash
 */
class AutoloadPHPFileWriter extends GenericPHPFileWriter
{

    private $applicationEntity;

    public function __construct($folder, $fileName, ApplicationEntity $applicationEntity)
    {
        parent::initialise($folder, $fileName, GenericFileWriter::$PHP_EXTENSION);

        $this->applicationEntity = $applicationEntity;
    }

    public function createFile()
    {
        $str = file_get_contents($this->getFullFileName());

        $formattedDirectory = TextUtility::removeLastSlash($this->applicationEntity->getDirectory());

        $newContent = str_replace(Configuration::$AUTOLOAD_TEXT_REPLACEMENT_DIRECTORY, $formattedDirectory, $str);

        $this->addContent($newContent);

        $this->replaceContents();
    }

}

?>
