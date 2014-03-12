<?php

/**
 * Description of MailTemplateGuiUtility
 *
 * @author suyash
 */
class MailTemplateGuiUtility
{

    private static function getHeader()
    {
        $output = "";

        $output .= "<div>";
        $output .= "<img src='".UrlConfiguration::getImageSrc("logo.png")."' alt='".Configuration::$APPLICATION_NAME."' />";
        $output .= "</div>";

        $output .= "<div style='font-family: Verdana;padding: 20px;font-size: 14px;'>";

        return $output;
    }

    private static function getFooter()
    {
        $output = "";

        $websiteAddress = Configuration::$WEBSITE_ADDRESS;
        $applicationName = Configuration::$APPLICATION_NAME;
        $contactPerson = Configuration::$CONTACT_PERSON;

        $output .= "<p style='padding-top: 10px'>$contactPerson</p>";
        $output .= "<p>$applicationName</p>";
        $output .= "<p>$websiteAddress</p>";

        $output .= "</div>";

        return $output;
    }

    private static function getMessageSubject($message)
    {
        $output = "";

        $applicationName = Configuration::$APPLICATION_NAME;

        $output .= "$applicationName - $message";

        return $output;
    }

    private static function getWebsiteDescription()
    {
        $output = "";

        $basicDescription = AboutGuiUtility::getBasicDescription();
        $moreDescription = AboutGuiUtility::getMoreDescription();

        $output .= "<p style='padding-top: 20px;'>$basicDescription</p>";
        $output .= "<p>$moreDescription</p>";

        return $output;
    }

    private static function getEmailRegisterUnsubscribeText($email, $activationKey)
    {
        $output = "";

        $applicationName = Configuration::$APPLICATION_NAME;
        $encryptedEmail = Encryptor::encrypt($email);
        $encryptedActivationKey = Encryptor::encrypt($activationKey);

        $output .= "<p>You have chosen to receive these emails in $applicationName. If you do not want to receive these emails in the future, you can click <a href='".UrlConfiguration::getUrl("email",
                        "unsubscribeRegisterEmail", "e=$encryptedEmail&k=$encryptedActivationKey")."'>here to unsubscribe</a>.</p>";

        return $output;
    }

    public static function generateRegistrationEmail($receiverDisplayName, $registeredEmail, $activationKey, $userId)
    {
        $output = "";

        $applicationName = Configuration::$APPLICATION_NAME;
        $fromEmail = Configuration::$EMAIL_FROM;
        $subject = MailTemplateGuiUtility::getMessageSubject("Registration in $applicationName");

        $activationLink = UrlConfiguration::getUrl("email", "activateEmail", "k=$activationKey&u=$userId");

        $output .= MailTemplateGuiUtility::getHeader();

        $output .= "<p>Dear $receiverDisplayName,</p>";
        $output .= "<p>You have registered this email ($registeredEmail) in $applicationName.</p>";
        $output .= "<p>Please click on the following link to activate it:</p>";
        $output .= "<p>";
        $output .= "<a href='$activationLink' target='_blank'>$activationLink</a>";
        $output .= "</p>";

        $output .= MailTemplateGuiUtility::getWebsiteDescription();

        $output .= "<p style='padding-top: 20px;'>If you have not registered this email in $applicationName, please do not respond to this email and do NOT click the above link.</p>";

        $output .= MailTemplateGuiUtility::getFooter();

        EmailUtility::sendMail($registeredEmail, $fromEmail, $subject, $output);
    }



    public static function sendContactMessageHtmlMessage($message, $userName, $userEmail)
    {
	$messageHtml = "";

	$websiteAddress = Configuration::$WEBSITE_ADDRESS;
	$adminEmail = Configuration::$ADMIN_EMAIL;
	$commentEmail = Configuration::$COMMENT_EMAIL;

	$messageHtml .= "<div style='font-family: Verdana;padding: 20px;font-size: 12px;'>";
	$messageHtml .= "<p>Dear ".Configuration::$APPLICATION_OWNER.",</p>";
	$messageHtml .= "<p>$userName ($userEmail) sent this message:</p>";
	$messageHtml .= "<p>$message</p>";

	$messageHtml .= "<p style='padding-top: 10px'>Regards,</p>";
	$messageHtml .= "<p>".Configuration::$APPLICATION_NAME." team</p>";
	$messageHtml .= "<p>http://$websiteAddress</p>";
	$messageHtml .= "</div>";

	EmailUtility::sendMail($adminEmail, $commentEmail, "contact", $messageHtml);
    }




//    public static function generateMessageEmail($messageText, $emailFrom, $surnameSender, $otherNamesSender,
//            $receiverDisplayName, $registeredEmail)
//    {
//        $output = "";
//
//        $applicationName = Configuration::$APPLICATION_NAME;
//        $fromEmail = Configuration::$EMAIL_FROM;
//        $subject = MailTemplateGuiUtility::getMessageSubject("$surnameSender $otherNamesSender sent you a message in $applicationName");
//
//        $output .= MailTemplateGuiUtility::getHeader();
//
//        $output .= "<p>Dear $receiverDisplayName,</p>";
//        $output .= "<p>$surnameSender $otherNamesSender ($emailFrom) has sent you a message on $applicationName:</p>";
//        $output .= "<p>$messageText</p>";
//
//        $output .= MailTemplateGuiUtility::getWebsiteDescription();
//
//        $output .= MailTemplateGuiUtility::getFooter();
//
//        EmailUtility::sendMail($registeredEmail, $fromEmail, $subject, $output);
//    }
//
//    public static function generateActivateNotificationEmail($email, $activationKey)
//    {
//        $output = "";
//
//        $applicationName = Configuration::$APPLICATION_NAME;
//        $fromEmail = Configuration::$EMAIL_FROM;
//        $subject = MailTemplateGuiUtility::getMessageSubject("activation email");
//
//        $output .= MailTemplateGuiUtility::getHeader();
//
//        $activationLink = UrlConfiguration::getUrl("email", "activateEmailNotification", "k=$activationKey&e=$email");
//
//        $output .= "<p>Dear User,</p>";
//        $output .= "<p>You have registered your email on $applicationName to receive notifications on the profiles that are displayed in this website.</p>";
//        $output .= "<p>Please click on the following link to activate your email and receive notifications.</p>";
//
//        $output .= "<p>";
//        $output .= "Activation link: ";
//        $output .= "<a href='$activationLink'>$activationLink</a>";
//        $output .= "</p>";
//
//        $output .= "<p>If you have not registered your email, please do NOT click on the activation link and ignore this email.</p>";
//
//        $output .= MailTemplateGuiUtility::getWebsiteDescription();
//
//        $output .= MailTemplateGuiUtility::getFooter();
//
//        EmailUtility::sendMail($email, $fromEmail, $subject, $output);
//    }
//
//    public static function generateContactEmail($surname, $otherNames, $message, $email)
//    {
//        $output = "";
//
//        $fromEmail = Configuration::$EMAIL_FROM;
//        $subject = MailTemplateGuiUtility::getMessageSubject("contact from user");
//
//        $output .= MailTemplateGuiUtility::getHeader();
//
//        $output .= "<p>Dear User,</p>";
//        $output .= "<p>A user has contacted you:</p>";
//        $output .= "<p>Surname: $surname</p>";
//        $output .= "<p>Other Names: $otherNames</p>";
//        $output .= "<p>Message: $message</p>";
//        $output .= "<p>Email: $email</p>";
//
//        $output .= MailTemplateGuiUtility::getWebsiteDescription();
//
//        $output .= MailTemplateGuiUtility::getFooter();
//
//        EmailUtility::sendMail($fromEmail, $fromEmail, $subject, $output);
//    }
//
//    public static function generateIncumbentProfileEmail($userEmail)
//    {
//        $output = "";
//
//        $websiteAddress = Configuration::$WEBSITE_ADDRESS;
//        $applicationName = Configuration::$APPLICATION_NAME;
//        $fromEmail = Configuration::$EMAIL_FROM;
//        $subject = MailTemplateGuiUtility::getMessageSubject("you day of fame is tomorrow");
//
//        $output .= MailTemplateGuiUtility::getHeader();
//
//        $output .= "<p>Dear User,</p>";
//        $output .= "<p>Tomorrow is your day of fame!</p>";
//        $output .= "<p>Tomorrow your profile will appear on $applicationName ($websiteAddress). Let your friends know by telling them via email, facebook or any other means.</p>";
//        $output .= "<p>Also, don't forget to check your profile information as your information will be available to the whole world.</p>";
//
//        $output .= MailTemplateGuiUtility::getWebsiteDescription();
//
//        $output .= MailTemplateGuiUtility::getFooter();
//
//        EmailUtility::sendMail($userEmail, $fromEmail, $subject, $output);
//    }
//
//    public static function generateComingProfileEmail($userEmail, $duration)
//    {
//        $output = "";
//
//        $applicationName = Configuration::$APPLICATION_NAME;
//        $fromEmail = Configuration::$EMAIL_FROM;
//        $subject = MailTemplateGuiUtility::getMessageSubject("your day of fame is coming soon");
//
//        $output .= MailTemplateGuiUtility::getHeader();
//
//        $dayText = "day";
//
//        if(intval($duration) > 1)
//        {
//            $dayText = "days";
//        }
//
//        $output .= "<p>Dear User,</p>";
//        $output .= "<p>Your profile will appear on $applicationName in exactly $duration $dayText.</p>";
//        $output .= "<p>Please check your profile information and make any necessary changes, as your information will be available to the whole world.</p>";
//
//        $output .= MailTemplateGuiUtility::getWebsiteDescription();
//
//        $output .= MailTemplateGuiUtility::getFooter();
//
//        EmailUtility::sendMail($userEmail, $fromEmail, $subject, $output);
//    }
//
//    public static function generatePresentProfileEmail($userEmail, $activationKey, UserEntity $userObject)
//    {
//        $output = "";
//
//        $websiteAddress = Configuration::$WEBSITE_ADDRESS;
//        $fromEmail = Configuration::$EMAIL_FROM;
//        $subject = MailTemplateGuiUtility::getMessageSubject("new celebrity");
//
//        $output .= MailTemplateGuiUtility::getHeader();
//
//        $output .= "<p>Dear User,</p>";
//        $output .= "<p>There is a new user today who has become famous. You can view the profile for today's famous person here: <a href='$websiteAddress'>$websiteAddress</a></p>";
//
//        $output .= "<table>";
//        $output .= "<tr>";
//        $output .= "<td>";
//
//        if($userObject->getThumbnailPicture() != "")
//        {
//            $output .= "<img src='".UrlConfiguration::getProfilePictureSrc($userObject->getThumbnailPicture())."' alt='profile picture' />";
//        }
//        else
//        {
//            $output .= "<span style='font-size: 12px;font-style: italic;'>no picture</span>";
//        }
//
//        $output .= "</td>";
//        $output .= "<td style='padding: 10px;border: solid thin lightgray;'>";
//        $output .= $userObject->getNameDisplay();
//        $output .= "</td>";
//        $output .= "</tr>";
//        $output .= "</table>";
//
//        $output .= MailTemplateGuiUtility::getWebsiteDescription();
//        $output .= MailTemplateGuiUtility::getEmailRegisterUnsubscribeText($userEmail, $activationKey);
//
//        $output .= MailTemplateGuiUtility::getFooter();
//
//        EmailUtility::sendMail($userEmail, $fromEmail, $subject, $output);
//    }

}

?>
