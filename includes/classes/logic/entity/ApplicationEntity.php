<?php

/**
 * Description of ApplicationEntity
 *
 * @author suyash
 */
class ApplicationEntity
{
    private $directory;
    private $url;

    /**
     *
     * @var DatabaseEntity
     */
    private $databaseEntity;

    public function __construct($directory, $url, DatabaseEntity $databaseEntity)
    {
        $this->directory = $directory;
        $this->url = $url;
        $this->databaseEntity = $databaseEntity;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getDatabaseEntity()
    {
        return $this->databaseEntity;
    }
}

?>
