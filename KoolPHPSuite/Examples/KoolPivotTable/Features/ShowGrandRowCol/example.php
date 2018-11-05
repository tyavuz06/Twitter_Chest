<?php
/*
 * This file is ready to run as standalone example. However, please do:
 * 1. Add tags <html><head><body> to make a complete page
 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
 */

$KoolControlsFolder = "../../../../KoolControls"; //Relative path to "KoolPHPSuite/KoolControls" folder
require_once $KoolControlsFolder . "/KoolPivotTable/koolpivottable.php";

require $KoolControlsFolder . "/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder . "/KoolAjax";

$ds = new MySQLiPivotDataSource($db_con); //This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
$ds->select("products.productLine AS product_Line , "
    . "customerName, "
    . "orderdetails.quantityOrdered * orderdetails.priceEach AS dollar_sales,"
    . "products.productName AS productName"
    . "orderDate"
);

$ds->from("customers")
    ->join("orders")->on("orders.customerNumber = customers.customerNumber")
    ->join("orderdetails")->on("orders.orderNumber = orderdetails.orderNumber")
    ->join("products")->on("products.productCode = orderdetails.productCode");

$pivot = new KoolPivotTable("pivot");
$pivot->styleFolder = "../../../../KoolControls/KoolPivotTable/styles/office2007";
$pivot->DataSource = $ds;
$pivot->AjaxEnabled = true;
$pivot->Width = "800px";
$pivot->HorizontalScrolling = true;
$pivot->Height = "600px";
$pivot->VerticalScrolling = true;
$pivot->AllowFiltering = true;
$pivot->AllowSorting = true;
$pivot->AllowSortingData = true;
$pivot->AllowReorder = true;
//Make the RowHeader wider.
$pivot->Appearance->RowHeaderMinWidth = "250px";
//Use the Prev and Next Numneric Pager
$pivot->Pager = new PivotPrevNextAndNumericPager();
$pivot->Pager->PageSize = 20;
//Turn on caching to help pivot working faster.
$pivot->AllowCaching = true;

if (!isset($_POST["ShowGrandColumn"]))
  $pivot->ShowGrandColumn = false;

if (!isset($_POST["ShowGrandRow"]))
  $pivot->ShowGrandRow = false;

//Data Field
$field = new PivotSumField("dollar_sales");
$pivot->AddDataField($field);
$field = $pivot->GetDataField("dollar_sales");
$field->Text = "Dollar Sales";
$field->FormatString = "\${n}";
$field->AllowReorder = false;
$field->DecimalNumber = 3;

$field = new PivotField("customerName");
$field->Text = "Customer";
$pivot->AddRowField($field);

//Column Fields
$field = new PivotField("product_Line");
$field->Text = "Product Line";
$pivot->AddColumnField($field);

$field = new PivotField("productName");
$field->Text = "Product";
$pivot->AddColumnField($field);

//Process the pivot
$pivot->Process();
?>

<form id="form1" method="post">

  <?php
  $_s = $koolajax->Render();
  echo $_s;
  $_s = $pivot->Render();
  ?>

  <div style="margin-bottom:10px;padding:10px;width:780px;background:#DFF3FF;border:solid 1px #C6E1F2;">
    <input type="checkbox" id="ShowGrandColumn" name="ShowGrandColumn"/> <label for="Show Grand Column">Show grand column</label>
    <input type="checkbox" id="ShowGrandRow"  name="ShowGrandRow"/> <label for="Show Grand Row">Show grand row</label>
    <br/><br/>
    <input type="submit" name="ChangeShowGrand" value = "Change" />
  </div>

  <div style="padding-top:10px;">
    <?php
    echo $_s;
    ?>
  </div>
</form>
