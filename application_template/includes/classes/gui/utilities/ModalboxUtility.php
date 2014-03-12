<?php


/**
 * Description of ModalboxUtility
 *
 * @author suyash
 */
class ModalboxUtility
{

    public static function getModalboxLink($action, $params, $title, $width, $height, $linkText, $linkClass = "")
    {
	$output = "";

	$output .= "<a href='".UrlConfiguration::getProcessUrl($action, $params)."' title='$title' onclick=\"Modalbox.show(this.href, {title: this.title, width: $width, height: $height}); return false;\" class='$linkClass'>";
	$output .= "$linkText";
	$output .= "</a>";

	return $output;
    }

    public static function getWizardModalboxLink(WizardElement $wizardElement, $linkText)
    {
	$output = "";

	$action = WizardManager::$WIZARD_GENERIC_ACTION."&".WizardManager::$WIZARD_ACTION_TYPE."=".$wizardElement->getAction();
	$params = $wizardElement->getParams();
	$title = $wizardElement->getTitle();
	$width = $wizardElement->getWidth();
	$height = $wizardElement->getHeight();

	$output .= "<a href='".UrlConfiguration::getProcessUrl($action, $params)."' title='$title' onclick=\"Modalbox.show(this.href, {title: this.title, width: $width, height: $height}); return false;\" class=''>";
	$output .= "$linkText";
	$output .= "</a>";

	return $output;
    }

    public static function getWizardInitialisationLink($action, $linkText, $wizardParameterArray)
    {
	$output = "";

	$actionComplete = WizardManager::$WIZARD_GENERIC_ACTION."&".WizardManager::$WIZARD_ACTION_TYPE."=$action";
	$wizard = WizardManager::getWizard($action, $wizardParameterArray);

	if($wizard)
	{
	    $width = $wizard->getInitialWidth();
	    $title = $wizard->getInitialTitle();
	    $params = $wizard->getInitialParams();

	    $output .= "<a href='".UrlConfiguration::getProcessUrl($actionComplete, $params)."' title='$title' onclick=\"Modalbox.show(this.href, {title: this.title, width: $width}); return false;\" class=''>";
	    $output .= "$linkText";
	    $output .= "</a>";
	}
	else
	{
	    $output .= "link does not exist";
	}

	return $output;
    }
}

?>
