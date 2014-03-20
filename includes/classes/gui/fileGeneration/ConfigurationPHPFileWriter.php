<?php


/**
 * Description of ConfigurationPHPFileWriter
 *
 * @author suyash
 */
class ConfigurationPHPFileWriter extends GenericPHPFileWriter
{

    /**
     *
     * @var ApplicationEntity
     */
    protected $applicationEntity;

    public function __construct($folder, $fileName, ApplicationEntity $applicationEntity)
    {
	parent::initialise($folder, $fileName, GenericFileWriter::$PHP_EXTENSION);

	$this->applicationEntity = $applicationEntity;
    }

    public function createFile()
    {
	$this->appendFunctions();

	parent::createFile();
    }

    protected function appendFunctions()
    {
	$this->appendPhpFileOpening();
	$this->appendClassStart();
	$this->appendVariables();
	$this->appendClassEnd();
	$this->appendPhpFileClosing();
    }

    protected function appendVariables()
    {
	$url = $this->applicationEntity->getUrl();
	$host = $this->applicationEntity->getDatabaseEntity()->getHost();
	$database = $this->applicationEntity->getDatabaseEntity()->getDatabase();
	$username = $this->applicationEntity->getDatabaseEntity()->getUsername();
	$password = $this->applicationEntity->getDatabaseEntity()->getPassword();

	$entityName = TextUtility::formatReadText($database);

	$this->addComment("url");
	$this->addContent("public static \$URL = \"$url\";");
	$this->addComment("database connection parameters");
	$this->addContent("public static \$CONNECTION_PARAMETERS = array(\"host\" => \"$host\", \"username\" => \"$username\", \"password\" => \"$password\", \"database\" => \"$database\");");
	$this->addContent("public static \$APPLICATION_NAME = \"$entityName\";");
	$this->addContent("public static \$VERSION = 1;");
    }
}

?>