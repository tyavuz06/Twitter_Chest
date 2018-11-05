<?php

class GridCustomDateTimeColumn extends GridDateTimeColumn
{



	function GetEditValue($_row)
	{
		$_string_date_input_from_user = _slash_decode($_POST[$_row->GetUniqueID()."_".$this->GetUniqueID()."_input"]);

		//You can do any conversion here and return the correct date that you want to insert to database.

		$_int_datetime = strtotime($_string_date_input_from_user);
		return date("Y-m-d H:i:s",$_datetime);
	}	


	function CreateInstance($_instance = null)
	{
		if($_instance===null)
		{
			$_instance = new GridCustomDateTimeColumn();		
		}
		parent::CreateInstance($_instance);
		return $_instance;
	}	
}
?>