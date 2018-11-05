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

$ds = new MySQLiPivotDataSource($db_con); //This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php

$ds->select("products.productLine AS product_Line , "
    . "customerName, "
    . "orderdetails.quantityOrdered * orderdetails.priceEach AS dollar_sales,"
    . "products.productName AS productName");

$ds->from("customers")
    ->join("orders")->on("orders.customerNumber = customers.customerNumber")
    ->join("orderdetails")->on("orders.orderNumber = orderdetails.orderNumber")
    ->join("products")->on("products.productCode = orderdetails.productCode");

$pivot = new KoolPivotTable("pivot" . $i);
$pivot->scriptFolder = $KoolControlsFolder."/KoolPivotTable";
$pivot->styleFolder = "office2007";
$pivot->DataSource = $ds;
$pivot->AjaxEnabled = true;
$pivot->Width = "800px";
$pivot->Height = "450px";
$pivot->HorizontalScrolling = true;
$pivot->VerticalScrolling = true;
$pivot->AllowFiltering = true;
$pivot->AllowSorting = true;
$pivot->AllowSortingData = true;
$pivot->AllowReorder = true;
$pivot->Pager = new PivotPrevNextAndNumericPager();
$pivot->Appearance->RowHeaderMinWidth = "250px";
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
$field->AddFilter(array("top_N", "5"));
$pivot->AddRowField($field);

$field = new PivotField("product_Line");
$field->Text = "Product Line";
$pivot->AddColumnField($field);

$field = new PivotField("productName");
$field->Text = "Product";
$pivot->AddColumnField($field);

$pivot->SetInitSortedGroup("Classic Cars");
$field = $pivot->GetRowField("customerName");

$pivot->Process();   
?>

<form id="form1" method="post">

    <?php
        echo $koolajax->Render();
    ?>
    
    <div style="padding-top:10px;">
        <?php
            echo $pivot->Render();
        ?>
    </div>
    
</form>
