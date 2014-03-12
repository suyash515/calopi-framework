<?php


/**
 * This class has been written by Sumaroo Suyash Kumar (www.calopi.com). Please do not remove this description
 * from when you are using this class.
 *
 * Also, as a token of gratitude, please do not hesitate to register in www.calopi.com and share this link with your
 * friends
 */
class EmailUtility
{

    private static $phpMailer = "";

    public function __construct()
    {

    }

    private static function getPhpMailer()
    {
	if(EmailUtility::$phpMailer == "")
	{
	    EmailUtility::$phpMailer = new PHPMailer();

	    EmailUtility::$phpMailer->IsSMTP(); // enable SMTP
	    EmailUtility::$phpMailer->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	    EmailUtility::$phpMailer->SMTPAuth = true;  // authentication enabled
	    EmailUtility::$phpMailer->SMTPSecure = Configuration::$EMAIL_SERVER_SECURITY;
	    EmailUtility::$phpMailer->Host = Configuration::$EMAIL_SERVER;
	    EmailUtility::$phpMailer->Port = Configuration::$EMAIL_SERVER_PORT;
	    EmailUtility::$phpMailer->Username = Configuration::$EMAIL_SERVER_USERNAME;
	    EmailUtility::$phpMailer->Password = Configuration::$EMAIL_SERVER_PASSWORD;
	    EmailUtility::$phpMailer->IsHTML(true);
	}

	EmailUtility::$phpMailer->ClearAddresses();
	EmailUtility::$phpMailer->ClearAllRecipients();
	EmailUtility::$phpMailer->ClearAttachments();
	EmailUtility::$phpMailer->ClearBCCs();
	EmailUtility::$phpMailer->ClearCCs();
	EmailUtility::$phpMailer->ClearCustomHeaders();
	EmailUtility::$phpMailer->ClearReplyTos();

	return EmailUtility::$phpMailer;
    }

    public function sendMail($to, $from, $subject, $text, $htmlText, $fromName = "", $priority = 10)
    {
	PlannedEmailLogicUtility::addPlannedEmail($to, $from, $subject, $text, $htmlText, $fromName, $priority);

	return "";
    }

    public function sendPlannedMail($to, $from, $subject, $text, $htmlText, $fromName, $plannedEmailId)
    {
	global $error;

	$mail = EmailUtility::getPhpMailer();

	$mail->From = $from;

	if($fromName == "")
	{
	    $mail->FromName = "Calopi";
	}
	else
	{
	    $mail->FromName = $fromName;
	}

	$mail->Subject = $subject;
	$mail->Body = $htmlText;
	$mail->AddAddress($to);

	if(!$mail->Send())
	{
	    PlannedEmailLogicUtility::updateStatus($plannedEmailId, PlannedEmailLogicUtility::$STATUS_ERROR_SENDING);

	    return "Error while sending message!";
	}
	else
	{
	    PlannedEmailLogicUtility::updateStatus($plannedEmailId, PlannedEmailLogicUtility::$STATUS_SENT);

	    return "";
	}
    }
}

?>