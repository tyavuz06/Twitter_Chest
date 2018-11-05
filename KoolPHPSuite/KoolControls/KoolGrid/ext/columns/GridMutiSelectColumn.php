<?php

class GridDropDownColumn extends GridColumn
{
	var $_Items = array();
	var $Size = 3;

	function Render($_row)
	{
		$_value = $_row->DataItem[$this->DataField]; 
		$_text = $_row->DataItem[$this->DataField];
		for($i=0;$i<sizeof($this->_Items);$i++)
		{
			if ($_value==$this->_Items[$i][1])
			{
				$_text = $this->_Items[$i][0];
				break;
			}	
		}
		return $_text;
	}	
	
	function AddItem($_text,$_value=null)
	{
		if ($_value===null) $_value = $_text;
		array_push($this->_Items,array($_text,$_value));
	}
	
	function _RenderEditTemplate($_row,$_tpl_select)
	{
		$_tpl_option = "<option value='{value}' {selected}>{text}</option>";		
		$_options = "";
		foreach ($this->_Items as $_item)
		{
			$_option = str_replace("{text}",$_item[0],$_tpl_option);
			$_option = str_replace("{value}",htmlentities($_item[1],ENT_QUOTES,$this->_TableView->_Grid->CharSet),$_option);
			$_option = str_replace("{selected}",($_item[1]==$_row->DataItem[$this->DataField])?"selected":"",$_option);
			$_options.=$_option;
		}
		
		$_select = str_replace("{id}",$_row->_UniqueID."_".$this->_UniqueID."_input",$_tpl_select);
		$_select = str_replace("{options}",$_options,$_select);
		
		return $_select;		
	}
	
	function InlineEditRender($_row)
	{
		if (!$this->ReadOnly)
		{
			$_tpl_select = "<span class='kgrECap'><select id='{id}' name='{id}' style='width:100%'>{options}</select></span>";
			return $this->_RenderEditTemplate($_row,$_tpl_select);
		}
		else
		{
			return $this->Render($_row);
		}
	}
	function FormEditRender($_row)
	{
		$_tpl_select = "<select id='{id}' name='{id}' style='width:90%'>{options}</select>";
		return $this->_RenderEditTemplate($_row,$_tpl_select);
	}	
	
	function RenderFilter()
	{
		$_tpl_select = "<span class='kgrECap'><select id='{id}' name='{id}' style='width:100%' onchange='grid_filter_trigger(\"{colid}\",this)'>{options}</select></span>";
		$_tpl_option = "<option value='{value}' {selected}>{text}</option>";		
		$_options = "";
		foreach($this->_Items as $_item)
		{
			$_option = str_replace("{text}",$_item[0],$_tpl_option);
			$_option = str_replace("{value}",$_item[1],$_option);
			$_option = str_replace("{selected}",($_item[1]==$this->Filter["Value"])?"selected":"",$_option);
			$_options.=$_option;
		}
		
		$_select = str_replace("{id}",$this->_UniqueID."_filter_input",$_tpl_select);
		$_select = str_replace("{colid}",$this->_UniqueID,$_select);
		$_select = str_replace("{options}",$_options,$_select);
		return $_select;
	}

		
	function CreateInstance($_instance = null)
	{
		if($_instance===null)
		{
			$_instance = new GridDropDownColumn();
		}				
		parent::CreateInstance($_instance);
		$_instance->_Items = $this->_Items;
		return $_instance;
	}
}
?>