<?php

/**
 * Description of Validator
 *
 * @author suyash
 */
class Validator
{

    protected $error;

    protected function validateLength($textToCheck, $textLabel, $limit)
    {
        if(strlen($textToCheck) > $limit)
        {
            $this->error->addError("$textLabel cannot be more than $limit characters");
        }
    }

    protected function checkEmptyError($textToCheck, $textLabel)
    {
        if(strlen($textToCheck) == 0)
        {
            $this->error->addError("$textLabel cannot be empty");
        }
    }

    protected function validateNumeric($textToCheck, $textLabel)
    {
        if(!is_numeric($textToCheck))
        {
            $this->error->addError("$textLabel must be a valid number");
        }
    }

    protected function isUploadedFileEmpty()
    {

    }

    /**
     * Validates a string which must be in the form hh:mm
     * @param type $time
     */
    protected function validateTime($time, $textLabel)
    {
        if(!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time))
        {
            $this->error->addError("$textLabel must be a valid time in the form 'hh:mm'");
        }
    }

}

?>
