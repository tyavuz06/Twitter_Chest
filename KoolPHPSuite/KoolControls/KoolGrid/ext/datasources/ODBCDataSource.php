<?php
/*
 * $dbcon = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=C:\\Nwind.mdb", "", "");
 * $ds = new ODBCDataSource($dbcon);
 * $ds->SelectCommand ="select * from customers";
 * ...
 * $grid->MasterTable->DataSource = $ds;
 * 
 */


class ODBCDataSource extends DataSource
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
	
	function Count()
	{
		$_count_command = "SELECT COUNT(*) as c FROM (".$this->SelectCommand.") AS _TMP {where}";
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
		$_result = odbc_exec($this->_Link,$_count_command);
		odbc_fetch_row($_result);
		return odbc_result($_result,"c");
	}	
	
	function GetFields()
	{
		$_fields = array();
		$_result = odbc_exec($this->_Link,$this->SelectCommand);
		for($i = 1;$i <= odbc_num_fields($_result);$i++)
		{
			$_field = array("Name"=>odbc_field_name($_result,$i),"Type"=>odbc_field_type($_result,$i),"Not_Null"=>0);
			array_push($_fields,$_field);
		}		
		return $_fields;
	}
	
	function GetData($_start=0,$_count=9999999)
	{
		//Return associate array of data
		
		$_tpl_select_command =  "SELECT {limit} * FROM ({SelectCommand}) AS _TMP {where} {orderby} {groupby}";
		
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
		$_limit = "TOP ".($_start+$_count); 		
		
		$_select_command = str_replace("{SelectCommand}",$this->SelectCommand,$_tpl_select_command);
		$_select_command = str_replace("{where}",$_where,$_select_command);
		$_select_command = str_replace("{orderby}",$_orderby,$_select_command);
		$_select_command = str_replace("{groupby}",$_groupby,$_select_command);
		$_select_command = str_replace("{limit}",$_limit,$_select_command);
		
		//echo $_select_command;
		$_result = odbc_exec($this->_Link,$_select_command);
		$_rows = array();
		$_i=0;
		
		
		for($j=$_start;$j<$_start+$_count;$j++)
		{
			$_row = array();			
			if(odbc_fetch_row($_result,$j))
			{
				for($i = 1;$i <= odbc_num_fields($_result);$i++)
				{
					$_row[odbc_field_name($_result,$i)] = odbc_result($_result,$i);
				}				
			}	
            foreach ($_row as $_column => & $_value)
                $_value = $this->getMappedValue($_value, $_column);
			array_push($_rows,$_row);			
		}
		return $_rows;
	}
	function GetAggregates($_arr)
	{
		$_tpl_select_command =  "SELECT {text} FROM ({SelectCommand}) AS _TMP {where} {orderby} {groupby}";

		$_text = "";
		$_agg_result = array();
		foreach($_arr as $_aggregate)
		{
			if (strpos("||min|max|first|last|count|sum|avg|","|".strtolower($_aggregate["Aggregate"])."|")>0)
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
			
			$_result = odbc_exec($this->_Link,$_select_command);

			odbc_fetch_row($result); 
			for($i = 1;$i <= odbc_num_fields($result);$i++)
			{
				$_agg_result[odbc_field_name($result,$i)] = odbc_result($result,$i);
			}
		}
        foreach ($_agg_result as $_column => & $_value)                
            $_value = $this->getMappedValue($_value, $_column);
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
				$_insert_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",preg_quote(addslashes($_value))."$2",$_insert_commands[$i]);
				$_insert_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*$)/",preg_quote(addslashes($_value))."$2",$_insert_commands[$i]);
			}
			
		}
		foreach($_insert_commands as $_insert_command)
		{
			if (odbc_exec($this->_Link,$_insert_command)==false)
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
				$_update_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",preg_quote(addslashes($_value))."$2",$_update_commands[$i]);
				$_update_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*$)/",preg_quote(addslashes($_value))."$2",$_update_commands[$i]);
			}
		}
		//echo sizeof($_update_commands);
		foreach($_update_commands as $_update_command)
		{
			if (odbc_exec($this->_Link,$_update_command)==false)
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
				$_delete_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",preg_quote(addslashes($_value))."$2",$_delete_commands[$i]);
				$_delete_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*$)/",preg_quote(addslashes($_value))."$2",$_delete_commands[$i]);
			}
		}
		foreach($_delete_commands as $_delete_command)
		{
			if (odbc_exec($this->_Link,$_delete_command)==false)
			{
				return false;
			}
		}
		return true;
	}		
}

?>