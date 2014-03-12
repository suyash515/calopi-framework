<?php
class DBQuery
{

	private $dbLink;


	public function __construct($connectionParameters)
	{
		$this->dbLink = $this->connect($connectionParameters['host'],
		$connectionParameters['username'], $connectionParameters['password'],
		$connectionParameters['database']);
	}

	public function __destroy()
	{
		$this->close($this->dbLink);
	}

	public function executeQuery($query)
	{
		$result = array();

		$resource = mysql_query($query, $this->dbLink) or die(mysql_error());
		$numFields = mysql_num_fields($resource);

		while($row = mysql_fetch_array($resource, MYSQL_ASSOC))
		{
			$aRow = array();

			for($i=0;$i<$numFields;$i++)
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
		mysql_query($query, $this->dbLink);
		$newId = mysql_insert_id();

		return $newId;
	}

	private function connect($host, $username, $password, $database)
	{
		$link = mysql_connect($host, $username, $password);
		mysql_select_db($database, $link);

		return $link;
	}

	private function close($dbLink)
	{
		return mysql_close($dbLink);
	}
}
?>