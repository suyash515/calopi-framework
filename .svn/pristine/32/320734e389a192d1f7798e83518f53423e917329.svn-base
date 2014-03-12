<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GuiUtility
 *
 * @author suyash
 */
class GuiUtility
{
	//put your code here

	public function __construct()
	{
	}

	public function getSexCombo($comboId)
	{
		$output = "";

		$output .= "<select id='$comboId' class='field'>";
		$output .= "<option value='male'>Male</option>";
		$output .= "<option value='female'>Female</option>";
		$output .= "</select>";

		return $output;
	}

	public function getPreselectedSexCombo($comboId, $sex)
	{
		$output = "";

		$output .= "<select id='$comboId' class='field'>";

		if($sex == "male")
		{
			$output .= "<option value='male' selected='yes'>Male</option>";
			$output .= "<option value='female'>Female</option>";
		}
		else
		{
			$output .= "<option value='male'>Male</option>";
			$output .= "<option value='female' selected='yes'>Female</option>";
		}
		
		$output .= "</select>";

		return $output;
	}
}
?>
