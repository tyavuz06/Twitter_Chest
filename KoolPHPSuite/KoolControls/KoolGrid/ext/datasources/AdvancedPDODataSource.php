<?php
require_once (dirname(__FILE__) . '/parser/php-sql-parser.php');
require_once (dirname(__FILE__) . '/parser/php-sql-creator.php');
class AdvancedPDODataSource extends DataSource
{
    var $SelectCommand;
    var $UpdateCommand;
    var $InsertCommand;
    var $DeleteCommand;
    public $seperator;
    public $donotUpdateFields;
    public $donotInsertFields;
    var $_PDO;
    
    function __construct($_pdo) {
        $this->_PDO = $_pdo;
        $this->seperator = "+"; // alt+ 457                
    }

    function GetError() {
        return $this->_PDO->errorInfo();
    }

    function SetCharSet($_charset) {
        //Set in the pdo connection.
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
        
        $_statement = $this->_PDO->prepare($_count_command);

        $_statement->execute();

        $_result = $_statement->fetch(PDO::FETCH_NUM);

        return $_result[0];
    }   
    
    function GetFields()
    {
        $_fields = array();
        $_statement = $this->_PDO->prepare($this->SelectCommand);
        $_statement->execute();

        foreach (range(0, $_statement->columnCount() - 1) as $column_index) {
            try {
                $meta = $_statement->getColumnMeta($column_index);
            } catch (Exception $e) {
                $meta = array("Name" => $column_index, "Type" => "string", "Not_Null" => false);
            }
            $_field = array("Name" => $meta["name"], "Type" => $meta["native_type"], "Not_Null" => false);
            array_push($_fields, $_field);
        }
        return $_fields;
    }
    
    function GetData($_start=0,$_count=9999999)
    {
        
        $_parser = new PHPSQLParser();
        $_parser->parse($this->SelectCommand);
        $_parsed_query = $_parser->parsed;

        //Limit
        if ($this->_PDO->getAttribute(PDO::ATTR_DRIVER_NAME)=="mysql") $_parsed_query["LIMIT"] = array("offset"=>$_start,"rowcount"=>$_count);
        else $_parsed_query["LIMIT"] = NULL;
                 
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
        if (count($_sorts)>0)
        {
            for($i=0;$i<sizeof($_sorts);$i++)
            {
                if (($this->_PDO->getAttribute(PDO::ATTR_DRIVER_NAME)=="mysql")  || ($this->_PDO->getAttribute(PDO::ATTR_DRIVER_NAME)=="pgsql")) {
                    if (!isset($_parsed_query["ORDER"]))
                    {
                        $_parsed_query["ORDER"]=array();
                    }
                    array_push($_parsed_query["ORDER"],array("expr_type"=>"colref","base_expr"=>$_sorts[$i]->Field,"sub_tree"=>false,"direction"=>$_sorts[$i]->Order));                    
                }
                else $_orders .= $_sorts[$i]->Field." ".$_sorts[$i]->Order.",";    
            }  
            $_orders = trim($_orders,", ");         
        }  
        
        if (empty($_orders)) $_orders = $_parsed_query["SELECT"][0]["base_expr"]; 
        $_expr = "ROW_NUMBER() OVER (ORDER BY ".$_orders.")";
        
        switch ($this->_PDO->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case "mssql":
            case "sqlsrv":
                array_push($_parsed_query["SELECT"], array("expr_type"=>"colref", "alias"=>array("as"=>1, "name"=>$_row_order), "base_expr"=>$_expr, "sub_tree"=>false));
                $_parsed_query["ORDER"] = null;
                break;
            case "oci":
                array_push($_parsed_query["SELECT"], array("expr_type"=>"colref", "alias"=>array("as"=>1, "name"=>$_row_order), "base_expr"=>$_expr, "sub_tree"=>false));
                $_parsed_query["ORDER"] = null;
                break;
            default:
                break;
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
        
        $_creator = new PHPSQLCreator($_parsed_query);
        $_select_command = $_creator->created;
        
        if ($this->_PDO->getAttribute(PDO::ATTR_DRIVER_NAME)=="pgsql") $_select_command .= " LIMIT ".$_count." OFFSET ".$_start;
        
        // echo $_select_command."<br>";
        
        $_statement = $this->_PDO->prepare($_select_command);
        $_statement->execute();

        $_rows = array();
        while ($_row = $_statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
        {
            foreach ($_row as $_column => & $_value)
                $_value = $this->getMappedValue($_value, $_column);
            array_push($_rows, $_row);
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
            
            $_statement = $this->_PDO->prepare($_select_command);
            $_statement->execute();

            $_agg_result = $_statement->fetch(PDO::FETCH_ASSOC);
            //-----
        }
        foreach ($_agg_result as $_column => & $_value)                
            $_value = $this->getMappedValue($_value, $_column);
        return $_agg_result;
    }
    
    function Insert($_associate_array) { 
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
            $_st_id = $this->_PDO->prepare($_insert_commands);
            if ($_st_id->execute()==false)
            {
                return false;
            }
        }
        return true;
    } //eof insert

    function Update($_associate_array) {
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
            $_st_id = $this->_PDO->prepare($_update_command);
            if ($_st_id->execute()==false)
            {
                return false;
            }
        }
        return true;
    }//

    function Delete($_associate_array) {
        $_delete_commands = explode(";", $this->DeleteCommand);

        foreach ($_associate_array as $_key => $_value) {
            $_value = $this->getInverseMappedValue($_value, $_key);
            for ($i = 0; $i < sizeof($_delete_commands); $i++) {
                $_delete_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*[\s;,])/",addslashes($_value)."$2",$_delete_commands[$i]); 
                $_delete_commands[$i] = preg_replace("/(@".$_key.")([\)\'\"]*$)/",addslashes($_value)."$2",$_delete_commands[$i]);
            }
        }
        foreach ($_delete_commands as $_delete_command) {
            $_statement = $this->_PDO->prepare($_delete_command);
            if ($_statement->execute() == false) {
                return false;
            }
        }
        return true;
    } 
}

?>
