<?php
/*
 * This file is ready to run as standalone example. However, please do:
 * 1. Add tags <html><head><body> to make a complete page
 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
 */

$KoolControlsFolder = "../../../../KoolControls"; //Relative path to "KoolPHPSuite/KoolControls" folder

require $KoolControlsFolder . "/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder . "/KoolAjax";

require $KoolControlsFolder."/KoolPivotTable/koolpivottable.php";

class simpleFirstLetterMap implements PivotIValueMap
{
    function map($_value)
    {
        $_s = strtoupper(substr($_value, 0, 1));
        return array(
            "First letter" => $_s
        );
    }
    
    function getMapFields()
    {
        return array(
            "First letter" 
        );
    }    
}

$ds = new MySQLiPivotDataSource($db_con); //This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php

$ds->select("products.productLine AS product_Line , "
    . "customerName, "
    . "orderdetails.quantityOrdered * orderdetails.priceEach AS dollar_sales,"
    . "products.productName AS productName");

$ds->from("customers")
    ->join("orders")->on("orders.customerNumber = customers.customerNumber")
    ->join("orderdetails")->on("orders.orderNumber = orderdetails.orderNumber")
    ->join("products")->on("products.productCode = orderdetails.productCode");

$pivots = array();
for ($i=0; $i<2; $i++) 
{
    $pivot = new KoolPivotTable("pivot" . $i);
    $pivot->scriptFolder = $KoolControlsFolder."/KoolPivotTable";
    $pivot->styleFolder = "office2007";
    $pivot->DataSource = $ds;
    $pivot->AjaxEnabled = true;
    $pivot->Width = "800px";
    $pivot->HorizontalScrolling = true;
    
    $pivot->VerticalScrolling = true;
    $pivot->AllowFiltering = true;
    $pivot->AllowSorting = true;
    $pivot->AllowSortingData = true;
    $pivot->AllowReorder = true;
    $pivot->Pager = new PivotPrevNextAndNumericPager();
    $pivot->Pager->PageSize = 20;
    $pivot->AllowCaching = true;

    //Data Field
    $field = new PivotSumField("dollar_sales");
    $field->Text = "Dollar Sales";
    $field->FormatString = "\${n}";
    $field->AllowReorder = false;
    $pivot->AddDataField($field);

    $field = new PivotField("customerName");
    $field->Text = "Customer";
    if ($i == 0)
    {
        $pivot->Height = "450px";
        $field->setValueMap(new simpleFirstLetterMap());
    }
    else
    {
        //The class firstLetterMap is included in KoolPivotTable/IValueMap.php
        $field->setValueMap(new firstLetterMap("customerName"));
        $pivot->Height = "650px";
    }
    $pivot->AddRowField($field);
    $field = $pivot->GetRowField("First letter");
    $field->Expand = true;

    $field = new PivotField("product_Line");
    $field->Text = "Product Line";
    $pivot->AddColumnField($field);

    $field = new PivotField("productName");
    $field->Text = "Product";
    $pivot->AddColumnField($field);

    $pivot->Process();   
    
    $pivots[$i] = $pivot;
}

?>

<form id="form1" method="post">

    <?php
        echo $koolajax->Render();
    ?>
    
    <b>Map customer's name to the first letter:</b>

    <div style="padding-top:10px;">
        <?php
            echo $pivots[0]->Render();
        ?>
    </div>
    
    <br><br>
    <b>Map customer's name to the first letter and then the name:</b>

    <div style="padding-top:10px;">
        <?php
            echo $pivots[1]->Render();
        ?>
    </div>
    
</form>
