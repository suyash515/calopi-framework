<?php

/**
 * Description of DatabaseStructureLogicUtility
 *
 * @author suyash
 */
class DatabaseStructureLogicUtility
{

    public static function getDatabaseStructure(ApplicationEntity $applicationEntity)
    {
        $databaseEntity = $applicationEntity->getDatabaseEntity();
        
        $db = new DBQuery($databaseEntity->getConnectionParamaters(), true);

        $query = "SHOW TABLES";
        $result = $db->executeQuery($query);

        $objectArray = DatabaseStructureLogicUtility::convertToObjectArray($result, $databaseEntity->getDatabase());

        return $objectArray;
    }

    public static function describeTable(TableEntity $tableEntity)
    {
        $db = DBQuery::getInstance();

        $query = "DESCRIBE ".$tableEntity->getTableName();
        $result = $db->executeQuery($query);

        $tableEntity->extractDetails($result);
    }

    private static function convertToObjectArray($result, $databaseName)
    {
        $objectArray = array();

        for($i = 0; $i < count($result); $i++)
        {
            $objectArray[$i] = DatabaseStructureLogicUtility::convertToObject($result[$i], $databaseName);
        }

        return $objectArray;
    }

    private static function convertToObject($resultDetails, $databaseName)
    {
        $tableName = QueryBuilder::getQueryValue($resultDetails, "Tables_in_".$databaseName);

        return new TableEntity($tableName);
    }

}

?>
