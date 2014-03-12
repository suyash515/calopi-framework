<?php


/**
 * Description of Log
 *
 * @author suyash
 */
class Log
{

    private static $ERROR_LOG = "z_erreur_log.txt";
    private static $INFORMATION_LOG = "z_info_log.txt";
    private static $DEBUG_LOG = "z_debug_log.txt";

    public function __construct()
    {
	
    }

    public static function logError($error)
    {
	$handle = Log::openFile(Log::$ERROR_LOG);
	fwrite($handle, "\n\n".date("Y-m-d H:i:s")." : ".$error);
	Log::closeFile($handle);
    }

    public static function logErrorArray($array, $arrayDescription = "")
    {
	$handle = Log::openFile(Log::$ERROR_LOG);
	Log::addSeparator($handle);
	fwrite($handle, "\n\n".date("Y-m-d H:i:s")."\n".$arrayDescription."\n");
	$out = print_r($array, true);
	fwrite($handle, $out);
    }

    public static function logQueryError($error)
    {
	Log::logError($error);

	$emailUtility = new EmailUtility();
	$mailTemplateUtility = new MailTemplateUtility();

	$userId = SessionHelper::getUserIdForLog();
	$userGuiUtility = new UserGuiUtility();
	$userDisplay = $userId." - ".$userGuiUtility->retrieveUserDisplayName($userId, Configuration::$CONNECTION_PARAMETERS);

	$messageArray = $mailTemplateUtility->generateDebugErrorEmail($error, $userDisplay);
	$mailSent = $emailUtility->sendMail(Configuration::$ERROR_EMAIL, Configuration::$ADMIN_EMAIL, "Calopi - Error Log", $messageArray['text'], $messageArray['html']);
    }

    public static function logBackTrace()
    {
	Log::logErrorArray(debug_backtrace());
    }

    public static function logInfo($info)
    {
	$handle = Log::openFile(Log::$INFORMATION_LOG);
	fwrite($handle, "\n".date("Y-m-d H:i:s")." : ".$info);
	Log::closeFile($handle);
    }

    public static function debug($info)
    {
	$handle = Log::openFile(Log::$DEBUG_LOG);
	Log::addSeparator($handle);
	fwrite($handle, "\n\n".date("Y-m-d H:i:s")."\n".$info);
	Log::closeFile($handle);
    }

    public static function debugDate($phpDate, $description = "")
    {
	$dateUtility = new DateUtility();

	$handle = Log::openFile(Log::$DEBUG_LOG);
	Log::addSeparator($handle);
	fwrite($handle, "\n\n".date("Y-m-d H:i:s")."\n".$description."\n".$dateUtility->formatDate($phpDate));
	Log::closeFile($handle);
    }

    public static function debugArray($array, $arrayDescription = "")
    {
	$handle = Log::openFile(Log::$DEBUG_LOG);
	Log::addSeparator($handle);
	fwrite($handle, "\n\n".date("Y-m-d H:i:s")."\n".$arrayDescription."\n");
	$out = print_r($array, true);
	fwrite($handle, $out);
    }

    private static function openFile($file)
    {
	$handle = fopen($file, "a");

	return $handle;
    }

    private static function closeFile($handle)
    {
	fclose($handle);
    }

    private static function addSeparator($handle)
    {
	fwrite($handle, "\n\n");
	fwrite($handle, "--------------------------------------------------------------------------------------------");
	fwrite($handle, "\n\n");
    }

    private static function convertDebugTraceIntoString()
    {
	$output = "";

	$debugTraceArray = debug_backtrace();

	for($i = 0; $i < count($debugTraceArray); $i++)
	{
	    $output .= "<p>File : ".$debugTraceArray[$i]['file']."</p>";
	    $output .= "<p>Line : ".$debugTraceArray[$i]['line']."</p>";
	    $output .= "<p>Function : ".$debugTraceArray[$i]['function']."</p>";
	    $output .= "<p>Class : ".$debugTraceArray[$i]['class']."</p>";
	    $output .= "<p>Type : ".$debugTraceArray[$i]['type']."</p>";

	    $output .= "<p>----------------------</p>";
	}

	return $output;
    }
}

?>
