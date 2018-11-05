<?php
require_once (dirname(__FILE__) . '/parser/php-sql-parser.php');
require_once (dirname(__FILE__) . '/parser/php-sql-creator.php');
class AdvancedOracleDataSource extends DataSource
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
    function GetFilterExpression($_filter)
    {
            $_expression = "";
            $_value = $_filter->Value;
            switch($_filter->Expression)
            {
                case "Equal":
                    $_expression = "=";
                    break;
                case "Not_Equal":
                    $_expression = "<>";
                    break;
                case "Greater_Than":
                    $_expression = ">";
                    break;          
                case "Less_Than":
                    $_expression = "<";
                    break;                                      
                case "Greater_Than_Or_Equal":
                    $_expression = ">=";
                    break;          
                case "Less_Than_Or_Equal":
                    $_expression = "<=";
                    break;                                      
                case "Contain":
                    $_expression = "LIKE";
                    $_value = "%".$_value."%";
                    break;
                case "Not_Contain":
                    $_expression = "NOT LIKE";
                    $_value = "%".$_value."%";
                    break;
                case "Start_With":
                    $_expression = "LIKE";
                    $_value = $_value."%";
                    break;
                case "End_With":
                    $_expression = "LIKE";
                    $_value = "%".$_value;
                    break;
            }
            return array("field"=>$_filter->Field,"expression"=>$_expression,"value"=>"'".$_value."'");     
    }

    
    function Count()
    {
        $_parser = new PHPSQLParser();
        $_parser->parse($this->SelectCommand);
        $_parsed_query = $_parser->parsed;
        
        //var_dump($_parsed_query);
        //Change to SELECT count(*)
        
        $_parsed_query["SELECT"] = array(array("expr_type"=>"aggregate_function","alias"=>false,"base_expr"=>"count","sub_tree"=>array(array("expr_type"=>"colref","base_expr"=>"*","sub_tree"=>false))));
        
        //Filters
        $_filters = $this->Filters;
        if(count($_filters)>0)
        {
            for($i=0;$i<sizeof($_filters);$i++)
            {
                if (!isset($_parsed_query["WHERE"]))
                {
                    $_parsed_query["WHERE"]=array();
                }
                else
                {
                    array_push($_parsed_query["WHERE"],array("expr_type"=>"operator","base_expr"=>"and","sub_tree"=>false));
                }
                $_epx = $this->GetFilterExpression($_filters[$i]);
                array_push($_parsed_query["WHERE"],array("expr_type"=>"colref","base_expr"=>$_epx["field"],"sub_tree"=>false));
                array_push($_parsed_query["WHERE"],array("expr_type"=>"operator","base_expr"=>$_epx["expression"],"sub_tree"=>false));
                array_push($_parsed_query["WHERE"],array("expr_type"=>"const","base_expr"=>$_epx["value"],"sub_tree"=>false));
            }           
        }               
        
        $_creator = new PHPSQLCreator($_parsed_query);
        $_count_command = $_creator->created;       
        //echo $_count_command;
        $_st_id = oci_parse($this->_Link, $_count_command);
        oci_execute($_st_id);
        $row = oci_fetch_array( $_st_id, OCI_NUM+OCI_RETURN_NULLS );
        return $row[0];
    }   
    
    function GetFields()
    {
        $_fields = array();
        $_st_id = oci_parse ( $this->_Link , $this->SelectCommand );
        if($_st_id)
        {
            oci_execute($_st_id);
            //$_result = pg_query($this->_Link,$this->SelectCommand);
            $_num_fields = oci_num_fields ($_st_id);
            for($i=1;$i<=$_num_fields;$i++)
            {
                $_field = array( "Name"=>oci_field_name($_st_id,$i), "Type"=>oci_field_type($_st_id,$i), "Not_Null"=>0 );
                array_push($_fields,$_field);
            }
        }
        return $_fields;
    }
    
    function GetData($_start=0,$_count=9999999)
    {
        
        $_parser = new PHPSQLParser();
        $_parser->parse($this->SelectCommand);
        $_parsed_query = $_parser->parsed;

        //Limit
        //$_parsed_query["LIMIT"] = array("offset"=>$_start,"rowcount"=>$_count);
                         
        //Filter
        $_filters = $this->Filters;
        if(count($_filters)>0)
        {
            for($i=0;$i<sizeof($_filters);$i++)
            {
                if (!isset($_parsed_query["WHERE"]))
                {
                    $_parsed_query["WHERE"]=array();
                }
                else
                {
                    array_push($_parsed_query["WHERE"],array("expr_type"=>"operator","base_expr"=>"and","sub_tree"=>false));
                }
                $_epx = $this->GetFilterExpression($_filters[$i]);
                array_push($_parsed_query["WHERE"],array("expr_type"=>"colref","base_expr"=>$_epx["field"],"sub_tree"=>false));
                array_push($_parsed_query["WHERE"],array("expr_type"=>"operator","base_expr"=>$_epx["expression"],"sub_tree"=>false));
                array_push($_parsed_query["WHERE"],array("expr_type"=>"const","base_expr"=>$_epx["value"],"sub_tree"=>false));
            }           
        }   
                   
        //Sort
        $_sorts = $this->Sorts;
        $_orders = "";
        $_row_order = "row_order";
        //print_r($_sorts);
        if(count($_sorts)>0)
        {
            for($i=0;$i<sizeof($_sorts);$i++)
            {
                // if (!isset($_parsed_query["ORDER"]))
                // {
                    // $_parsed_query["ORDER"]=array();
                // }
                //array_push($_parsed_query["ORDER"],array("expr_type"=>"colref","base_expr"=>$_sorts[$i]->Field,"sub_tree"=>false,"direction"=>$_sorts[$i]->Order));
                $_orders .= $_sorts[$i]->Field." ".$_sorts[$i]->Order.",";
            }           
            $_orders = trim($_orders,", ");
        }  
        
        if (empty($_orders)) 
            foreach ($_parsed_query["SELECT"] as $_parsed_select)
                if ($_parsed_select["expr_type"]=="colref")
                    $_orders = $_parsed_select["base_expr"]; 
        $_expr = "ROW_NUMBER() OVER (ORDER BY ".$_orders.")";
        //echo $_expr."<br>";
        array_push($_parsed_query["SELECT"], array("expr_type"=>"colref", "alias"=>array("as"=>1, "name"=>$_row_order), "base_expr"=>$_expr, "sub_tree"=>false));
        
        $_parsed_query["ORDER"] = null;
        
        //Group
        $_groups = $this->Groups;
        if(count($_groups)>0)
        {
            for($i=0;$i<sizeof($_groups);$i++)
            {
                if (!isset($_parsed_query["GROUP"]))
                {
                    $_parsed_query["GROUP"]=array();
                }
                array_push($_parsed_query["GROUP"],array("expr_type"=>"colref","base_expr"=>$_groups[$i]->Field,"sub_tree"=>false));
            }           
        }   
        
        $_creator = new PHPSQLCreator($_parsed_query);
        $_select_command = $_creator->created;
        
        $_select_command = " SELECT * FROM (".$_select_command.") tmp WHERE ".$_row_order." BETWEEN ".$_start." AND ". ($_start+$_count);
        
        // echo $_select_command."<br>";
        
        $_rows = array();
        $_st_id = oci_parse($this->_Link, $_select_command );
        if( $_st_id )
        {
            oci_execute($_st_id);
            while ( $_row = oci_fetch_array( $_st_id, OCI_ASSOC+OCI_RETURN_NULLS ) )
            {
                foreach ($_row as $_column => & $_value)
                    $_value = $this->getMappedValue($_value, $_column);
                array_push($_rows,$_row);
            }
        }       
        return $_rows;
    }

    function GetAggregates($_arr) //Only with MYSQLDataSource
    {
        
        $_parser = new PHPSQLParser();
        $_parser->parse($this->SelectCommand);
        $_parsed_query = $_parser->parsed;

        //Filter
        $_filters = $this->Filters;
        if(count($_filters)>0)
        {
            for($i=0;$i<sizeof($_filters);$i++)
            {
                if (!isset($_parsed_query["WHERE"]))
                {
                    $_parsed_query["WHERE"]=array();
                }
                else
                {
                    array_push($_parsed_query["WHERE"],array("expr_type"=>"operator","base_expr"=>"and","sub_tree"=>false));
                }
                $_epx = $this->GetFilterExpression($_filters[$i]);
                array_push($_parsed_query["WHERE"],array("expr_type"=>"colref","base_expr"=>$_epx["field"],"sub_tree"=>false));
                array_push($_parsed_query["WHERE"],array("expr_type"=>"operator","base_expr"=>$_epx["expression"],"sub_tree"=>false));
                array_push($_parsed_query["WHERE"],array("expr_type"=>"const","base_expr"=>$_epx["value"],"sub_tree"=>false));
            }           
        }               
        //Sort
        $_sorts = $this->Sorts;
        if(count($_sorts)>0)
        {
            for($i=0;$i<sizeof($_sorts);$i++)
            {
                if (!isset($_parsed_query["ORDER"]))
                {
                    $_parsed_query["ORDER"]=array();
                }
                array_push($_parsed_query["ORDER"],array("expr_type"=>"colref","base_expr"=>$_sorts[$i]->Field,"sub_tree"=>false,"direction"=>$_sorts[$i]->Order));
            }           
        }               

        //Group
        $_groups = $this->Groups;
        if(count($_groups)>0)
        {
            for($i=0;$i<sizeof($_groups);$i++)
            {
                if (!isset($_parsed_query["GROUP"]))
                {
                    $_parsed_query["GROUP"]=array();
                }
                array_push($_parsed_query["GROUP"],array("expr_type"=>"colref","base_expr"=>$_groups[$i]->Field,"sub_tree"=>false));
            }           
        }               
        
        //SELECT
        $_parsed_query["SELECT"] = array(array("expr_type"=>"colref","base_expr"=>"{arggregate}","sub_tree"=>false,"alias"=>false));
        $_text = "";
        foreach($_arr as $_aggregate)
        {
            if (strpos("-|min|max|first|last|count|sum|avg|","|".strtolower($_aggregate["Aggregate"])."|")>0)
            {
                $_text .=  ", ".$_aggregate["Aggregate"]."(".$_aggregate["DataField"].") as ".$_aggregate["Key"];               
            }
        }
        
        $_agg_result = array();
        
        if ($_text!="")
        {
            $_text = substr($_text,2);
            $_creator = new PHPSQLCreator($_parsed_query);
            $_select_command = $_creator->created;
            $_select_command = str_replace("{arggregate}",$_text,$_select_command);
            
            // echo $_select_command."<br>";
            
            $_agg_result = array();
            $_st_id = oci_parse($this->_Link, $_select_command );
            if( $_st_id )
            {
                oci_execute($_st_id);
                $_agg_result = oci_fetch_array( $_st_id, OCI_BOTH+OCI_RETURN_NULLS );
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
                $_insert_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",addslashes($_value)."$2",$_insert_commands[$i]); 
                $_insert_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*$)/",addslashes($_value)."$2",$_insert_commands[$i]);
            }
            
        }
        foreach($_insert_commands as $_insert_command)
        {
            $_st_id = oci_parse($this->_Link, $_insert_command );
            if (oci_execute($_st_id)==false)
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
                $_update_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",addslashes($_value)."$2",$_update_commands[$i]); 
                $_update_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*$)/",addslashes($_value)."$2",$_update_commands[$i]);
            }
        }
        //echo sizeof($_update_commands);
        foreach($_update_commands as $_update_command)
        {
            $_st_id = oci_parse($this->_Link, $_update_command );
            if (oci_execute($_st_id)==false)
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
                $_delete_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",addslashes($_value)."$2",$_delete_commands[$i]); 
                $_delete_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*$)/",addslashes($_value)."$2",$_delete_commands[$i]);
            }
        }
        foreach($_delete_commands as $_delete_command)
        {
            $_st_id = oci_parse($this->_Link, $_delete_command );
            if ( oci_execute($_st_id)==false)
            {
                return false;
            }
        }
        return true;
    }

    function GetError()
    {
        return oci_error($this->_Link);
    }
    function SetCharSet($_charset)
    {
    }   
}

?>
