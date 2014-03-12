<?php

/**
 * Description of PHPFileWriter
 *
 * @author suyash
 */
class PHPFileWriter extends GenericPHPFileWriter
{

    /**
     *
     * @var TableEntity
     */
    protected $tableEntity;

    public function __construct($folder, $fileName, TableEntity $tableEntity)
    {
        parent::initialise($folder, $fileName, GenericFileWriter::$PHP_EXTENSION);

        $this->tableEntity = $tableEntity;
    }

}

?>
