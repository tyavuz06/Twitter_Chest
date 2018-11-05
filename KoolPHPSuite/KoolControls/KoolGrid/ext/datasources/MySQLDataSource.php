<?php
/*
 * MySQLDataSource class of KoolGrid
 */
class CustomMySQLDataSource extends DataSource
{
	var $SelectCommand;
	var $UpdateCommand;
	var $InsertCommand;
	var $DeleteCommand;
	
	var $_Link;
	
	function __construct($_link)
	{
		$this->_Link = $_link;
	}
  
  function database_escape($_s) {
    return mysql_real_escape_string($_s);
  }
	
	function Count()
	{
		$_count_command = "SELECT COUNT(*) FROM (".$this->SelectCommand.") AS _TMP {where}";
		$_where = "";
		$_filters = $this->Filters;
		for($i=0;$i<sizeof($_filters);$i++)
		{
			$_where.=" and ".$this->GetFilterExpression($_filters[$i]);
		}
		if ($_where!="")
		{
			$_where = "WHERE ".substr($_where,5);
		}
		$_count_command = str_replace("{where}",$_where,$_count_command);
		$_result = mysql_query($_count_command,$this->_Link);
		$_count =  mysql_result($_result,0,0);
		mysql_free_result($_result);
		return $_count;
	}	
	
	function GetFields()
	{
		$_fields = array();
		$_result = mysql_query($this->SelectCommand,$this->_Link);
		while($_prop = mysql_fetch_field($_result))
		{
			$_field = array(
                "Name"=>$_prop->name,
                "Type"=>$_prop->type,
                "Not_Null"=>$_prop->not_null
            );
			array_push($_fields,$_field);
		}
		mysql_free_result($_result);
		return $_fields;
	}
	
	function GetData($_start=0,$_count=9999999)
	{
		//Return associate array of data
		$_tpl_select_command =  "SELECT * FROM ({SelectCommand}) AS _TMP {where} {orderby} {groupby} {limit}";
		
		//Filters
		$_where = "";
		$_filters = $this->Filters;
		for($i=0;$i<sizeof($_filters);$i++)
		{
			$_where.=" and ".$this->GetFilterExpression($_filters[$i]);
		}
		if ($_where!="")
		{
			$_where = "WHERE ".substr($_where,5);
		}
		//Order
		$_orderby = "";
		$_orders = $this->Sorts;
		for($i=0;$i<sizeof($_orders);$i++)
		{
			$_orderby.=", ".$_orders[$i]->Field." ".$_orders[$i]->Order;
		}
		if ($_orderby!="")
		{
			$_orderby = "ORDER BY ".substr($_orderby,2);
		}
		//Group
		$_groupby = "";
		$_groups = $this->Groups;
		for($i=0;$i<sizeof($_groups);$i++)
		{
			$_groupby.=", ".$_groups[$i]->Field;
		}
		if ($_groupby!="")
		{
			$_groupby = "GROUP BY ".substr($_groupby,2);
		}
		//Limit
		$_limit = "LIMIT ".$_start." , ".$_count; 		
		
		$_select_command = str_replace("{SelectCommand}",$this->SelectCommand,$_tpl_select_command);
		$_select_command = str_replace("{where}",$_where,$_select_command);
		$_select_command = str_replace("{orderby}",$_orderby,$_select_command);
		$_select_command = str_replace("{groupby}",$_groupby,$_select_command);
		$_select_command = str_replace("{limit}",$_limit,$_select_command);
		
		echo htmlentities($_select_command) . '<br>';
		
		$_result = mysql_query($_select_command,$this->_Link);
		$_rows = array();
		
		while ($_row = mysql_fetch_assoc($_result)) 
		{
            foreach ($_row as $_column => & $_value)
                $_value = $this->getMappedValue($_value, $_column);
			array_push($_rows,$_row);
		}
		mysql_free_result($_result);
		return $_rows;
	}
    
	function GetAggregates($_arr) //Only with MYSQLDataSource
	{
		$_tpl_select_command =  "SELECT {text} FROM ({SelectCommand}) AS _TMP {where} {orderby} {groupby}";

		$_text = "";
		$_agg_result = array();
		foreach($_arr as $_aggregate)
		{
			if (strpos("-|min|max|first|last|count|sum|avg|","|".strtolower($_aggregate["Aggregate"])."|")>0)
			{
				$_text .=  ", ".$_aggregate["Aggregate"]."(".$_aggregate["DataField"].") as ".$_aggregate["Key"];				
			}
		}
		
		
		if ($_text!="")
		{

			$_text = substr($_text,2);
		//Fill command and query
			//Filters
			$_where = "";
			$_filters = $this->Filters;
			for($i=0;$i<sizeof($_filters);$i++)
			{
				$_where.=" and ".$this->GetFilterExpression($_filters[$i]);
			}
			if ($_where!="")
			{
				$_where = "WHERE ".substr($_where,5);
			}
			//Order
			$_orderby = "";
			$_orders = $this->Sorts;
			for($i=0;$i<sizeof($_orders);$i++)
			{
				$_orderby.=", ".$_orders[$i]->Field." ".$_orders[$i]->Order;
			}
			if ($_orderby!="")
			{
				$_orderby = "ORDER BY ".substr($_orderby,2);
			}
			//Group
			$_groupby = "";
			$_groups = $this->Groups;
			for($i=0;$i<sizeof($_groups);$i++)
			{
				$_groupby.=", ".$_groups[$i]->Field;
			}
			if ($_groupby!="")
			{
				$_groupby = "GROUP BY ".substr($_groupby,2);
			}
			
			$_select_command = str_replace("{SelectCommand}",$this->SelectCommand,$_tpl_select_command);
			$_select_command = str_replace("{text}",$_text,$_select_command);
			$_select_command = str_replace("{where}",$_where,$_select_command);
			$_select_command = str_replace("{orderby}",$_orderby,$_select_command);
			$_select_command = str_replace("{groupby}",$_groupby,$_select_command);
			
			//echo $_select_command;
			$_result = mysql_query($_select_command,$this->_Link);
			$_agg_result = mysql_fetch_assoc($_result);
            foreach ($_agg_result as $_column => & $_value)
                $_value = $this->getMappedValue($_value, $_column);
			mysql_free_result($_result);

		//-----
		}
		return $_agg_result;
	}
    
	function Insert($_associate_array)
	{
		$_insert_commands = explode(";",$this->InsertCommand);
		foreach($_associate_array as $_key=>$_value)
		{
            $_value = $this->getInverseMappedValue($_value, $_key);
			for($i=0;$i<sizeof($_insert_commands);$i++)
			{
				$_insert_commands[$i] = pregstr_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",preg_quote(addslashes($_value))."$2",$_insert_commands[$i]);
				$_insert_commands[$i] = pregstr_replace("/(@".$_key.")([\)\'\"]*$)/",preg_quote(addslashes($_value))."$2",$_insert_commands[$i]);
			}
			
		}
		foreach($_insert_commands as $_insert_command)
		{
            echo $_insert_command."<br>";
			if (mysql_query($_insert_command,$this->_Link)==false)
			{
				return false;
			}
		}
		return true;
	}
    
	function Update($_associate_array)
	{
		$_update_commands = explode(";",$this->UpdateCommand);		
		foreach($_associate_array as $_key=>$_value)
		{
            $_value = $this->getInverseMappedValue($_value, $_key);
			for($i=0;$i<sizeof($_update_commands);$i++)
			{
				$_update_commands[$i] = pregstr_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",preg_quote(addslashes($_value))."$2",$_update_commands[$i]);
				$_update_commands[$i] = pregstr_replace("/(@".$_key.")([\)\'\"]*$)/",preg_quote(addslashes($_value))."$2",$_update_commands[$i]);
			}
		}
		foreach($_update_commands as $_update_command)
		{
			if (mysql_query($_update_command,$this->_Link)==false)
			{
				return false;
			}
		}
		return true;
	}

	function Delete($_associate_array)
	{
		$_delete_commands = explode(";",$this->DeleteCommand);
		
		foreach($_associate_array as $_key=>$_value)
		{
            $_value = $this->getInverseMappedValue($_value, $_key);
			for($i=0;$i<sizeof($_delete_commands);$i++)
			{
				$_delete_commands[$i] = pregstr_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",preg_quote(addslashes($_value))."$2",$_delete_commands[$i]);
				$_delete_commands[$i] = pregstr_replace("/(@".$_key.")([\)\'\"]*$)/",preg_quote(addslashes($_value))."$2",$_delete_commands[$i]);
			}
		}
		foreach($_delete_commands as $_delete_command)
		{
			if (mysql_query($_delete_command,$this->_Link)==false)
			{
				return false;
			}
		}
		return true;
	}
	function GetError()
	{
		return mysql_error($this->_Link);
	}
	function SetCharSet($_charset)
	{
		mysql_set_charset($_charset,$this->_Link);	
	}	
}
