<?php


class DBQuery
{

    private static $dbLink = "";
    private static $instance = null;

//    private function __construct()
//    {
//	DBQuery::$dbLink = $this->connect();
//    }

    /**
     * This function must be rendered private in the future and instead use the getInstance() function
     * @param <type> $connectionParameters
     */
    public function __construct($connectionParameters = "", $customConnection = false)
    {
	if($customConnection)
	{
	    DBQuery::$dbLink = $this->customConnect($connectionParameters);
	}
	else
	{
	    DBQuery::$dbLink = $this->connect();
	}
    }

    public static function getInstance()
    {
	if(empty(DBQuery::$instance) || empty(DBQuery::$dbLink))
	{
	    DBQuery::$instance = new DBQuery();
	}

	return DBQuery::$instance;
    }

    public function __destroy()
    {
	$this->close(DBQuery::$dbLink);
    }

    public function executeQuery($query)
    {
	$result = array();

	$resource = mysql_query($query, DBQuery::$dbLink) or die(mysql_error());
	$numFields = mysql_num_fields($resource);

	while($row = mysql_fetch_array($resource, MYSQL_ASSOC))
	{
	    $aRow = array();

	    for($i = 0; $i < $numFields; $i++)
	    {
		$fieldName = mysql_field_name($resource, $i);
		$aRow[$fieldName] = $row[$fieldName];
	    }

	    array_push($result, $aRow);
	}

	mysql_free_result($resource);

	return $result;
    }

    public function executeNonQuery($query)
    {
	$querySuccessful = mysql_query($query, DBQuery::$dbLink);

	if(!$querySuccessful)
	{
//	    Log::logQueryError("Query error : $query");
	}
	else
	{
	    $newId = mysql_insert_id();

	    return $newId;
	}
    }

    private function connect()
    {
	$link = mysql_connect(DatabaseConfiguration::getHost(), DatabaseConfiguration::getUsername(), DatabaseConfiguration::getPassword());
	mysql_select_db(DatabaseConfiguration::getDatabase(), $link);

	return $link;
    }

    private function customConnect($connectionParameters)
    {
	$link = mysql_connect($connectionParameters['host'], $connectionParameters['username'], $connectionParameters['password']);
	mysql_select_db($connectionParameters['database'], $link);

	return $link;
    }

    private function close($dbLink)
    {
	return mysql_close($dbLink);
    }

    public function beginTransaction()
    {
	mysql_query("BEGIN");
    }

    public function commitTransaction()
    {
	mysql_query("COMMIT");
    }

    public function rollbackTransaction()
    {
	mysql_query("ROLLBACK");
    }
}

//class DBQuery
//{
//
//    private $dbLink;
//
//    public function __construct($connectionParameters)
//    {
//	$this->dbLink = $this->connect($connectionParameters['host'],
//			$connectionParameters['username'], $connectionParameters['password'],
//			$connectionParameters['database']);
//    }
//
//    public function __destroy()
//    {
//	$this->close($this->dbLink);
//    }
//
//    public function executeQuery($query)
//    {
//	$result = array();
//
//	$resource = mysql_query($query, $this->dbLink) or die(mysql_error());
//	$numFields = mysql_num_fields($resource);
//
//	while($row = mysql_fetch_array($resource, MYSQL_ASSOC))
//	{
//	    $aRow = array();
//
//	    for($i = 0; $i < $numFields; $i++)
//	    {
//		$fieldName = mysql_field_name($resource, $i);
//		$aRow[$fieldName] = $row[$fieldName];
//	    }
//
//	    array_push($result, $aRow);
//	}
//
//	mysql_free_result($resource);
//
//	return $result;
//    }
//
//    public function executeNonQuery($query)
//    {
//	$querySuccessful = mysql_query($query, $this->dbLink);
//
//	if(!$querySuccessful)
//	{
//	    Log::logQueryError("Query error : $query");
//
//	    throw new Exception("Query error");
//	}
//	else
//	{
//	    $newId = mysql_insert_id();
//
//	    return $newId;
//	}
//    }
//
//    private function connect($host, $username, $password, $database)
//    {
//	$link = mysql_connect($host, $username, $password);
//	mysql_select_db($database, $link);
//
//	return $link;
//    }
//
//    private function close($dbLink)
//    {
//	return mysql_close($dbLink);
//    }
//
//    public function beginTransaction()
//    {
//	mysql_query("BEGIN");
//    }
//
//    public function commitTransaction()
//    {
//	mysql_query("COMMIT");
//    }
//
//    public function rollbackTransaction()
//    {
//	mysql_query("ROLLBACK");
//    }
//}

?>