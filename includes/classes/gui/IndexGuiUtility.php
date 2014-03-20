<?php


/**
 * Description of IndexGuiUtility
 *
 * @author suyash
 */
class IndexGuiUtility
{

    public static $GENERATION_MODE_NORMAL = "normal";
    public static $GENERATION_MODE_EMPTY = "empty";

    public static function getDisplay()
    {
	$output = "";

	$s = DIRECTORY_SEPARATOR;
	$defaultDirectory = Configuration::getDefaultDirectory();
	$defaultDirectoryOverwrite = Configuration::getDefaultOverwrite();
	$defaultUrl = Configuration::$DEFAULT_URL;

	$output .= "<table id='mytable'>";

	$output .= "<tr>";
	$output .= "<th>Directory to generate project(Add a folder ending with $s):</th>";
	$output .= "<td>";
	$output .= "<input type='text' style='width: 300px;' id='txt_directory' value='$defaultDirectory' />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<th>Project URL(Add a url ending with /):</th>";
	$output .= "<td>";
	$output .= "<input type='text' style='width: 300px;' id='txt_url' value='$defaultUrl' />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<th>Database Host:</th>";
	$output .= "<td>";
	$output .= "<input type='text' style='width: 300px;' id='txt_host' value='127.0.0.1' />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<th>Database Name:</th>";
	$output .= "<td>";
	$output .= "<input type='text' style='width: 300px;' id='txt_db_name' value='' />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<th>Database User:</th>";
	$output .= "<td>";
	$output .= "<input type='text' style='width: 300px;' id='txt_user' value='root' />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<th>Database Password:</th>";
	$output .= "<td>";
	$output .= "<input type='password' style='width: 300px;' id='txt_password' />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<th>Mode:</th>";
	$output .= "<td>";
	$output .= IndexGuiUtility::getGenerationModeCombo();
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr style='display: none;'>";
	$output .= "<td colspan='2'>Empty mode is based on the empty template structure and will overwrite all the contents in the overwrite folder below</td>";
	$output .= "</tr>";

	$output .= "<tr style='display: none;'>";
	$output .= "<th>Overwrite Folder:</th>";
	$output .= "<td>";
	$output .= "<input type='text' style='width: 300px;' id='txt_overwrite_folder' value='$defaultDirectoryOverwrite' />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "<tr>";
	$output .= "<td colspan='2' style='text-align: center;'>";
	$output .= "<input type='button' value='Generate Structure' onclick=\"generateStructure();\" />";
	$output .= "</td>";
	$output .= "</tr>";

	$output .= "</table>";

	return $output;
    }

    private static function getGenerationModeCombo()
    {
	$output = "";

	$normal = IndexGuiUtility::$GENERATION_MODE_NORMAL;
	$empty = IndexGuiUtility::$GENERATION_MODE_EMPTY;

	$output .= "<select id='cbo_generation_mode' name='cbo_generation_mode'>";
	$output .= "<option value='$normal'>".ucfirst($normal)."</option>";
	$output .= "<option value='$empty'>".ucfirst($empty)."</option>";
	$output .= "</select>";

	return $output;
    }
}

?>
