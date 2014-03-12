<?php


/**
 * Description of DatabaseConfiguration
 *
 * @author suyash
 */
class DatabaseConfiguration
{

    public static function getHost()
    {
	return Configuration::$CONNECTION_PARAMETERS['host'];
    }

    public static function getUsername()
    {
	return Configuration::$CONNECTION_PARAMETERS['username'];
    }

    public static function getPassword()
    {
	return Configuration::$CONNECTION_PARAMETERS['password'];
    }

    public static function getDatabase()
    {
	return Configuration::$CONNECTION_PARAMETERS['database'];
    }
}

?>
