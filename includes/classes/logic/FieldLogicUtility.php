<?php

/**
 * Description of FieldLogicUtility
 *
 * @author suyash.sumaroo
 */
class FieldLogicUtility
{

    private $name;
    private $type;
    private $null;
    private $key;
    private $default;
    private $extra;

    public function __construct($fieldName, $fieldType, $fieldNull, $fieldKey, $fieldDefault, $fieldExtra)
    {
        $this->name = $fieldName;
        $this->type = $fieldType;
        $this->null = $fieldNull;
        $this->key = $fieldKey;
        $this->default = $fieldDefault;
        $this->extra = $fieldExtra;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getNull()
    {
        return $this->null;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getExtra()
    {
        return $this->extra;
    }

}

?>
