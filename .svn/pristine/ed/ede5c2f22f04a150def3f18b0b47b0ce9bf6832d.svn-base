<?php

/**
 * Description of DatabaseStructureManager
 *
 * @author suyash
 */
class DatabaseStructureManager
{

    public static function getDatabaseStructure(ApplicationEntity $applicationEntity)
    {
        $tableEntityList = DatabaseStructureLogicUtility::getDatabaseStructure($applicationEntity);

        for($i = 0; $i < count($tableEntityList); $i++)
        {
            DatabaseStructureLogicUtility::describeTable($tableEntityList[$i]);
        }

        return $tableEntityList;
    }

}

?>
