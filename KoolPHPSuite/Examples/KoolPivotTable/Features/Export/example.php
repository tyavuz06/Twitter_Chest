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

if (isset($_POST["style_select"]))
{
    $_SESSION["style_select"] = $_POST["style_select"];
} else
{
    if (!$koolajax->isCallback)
    {
        //Page Init: show default style
        $_SESSION["style_select"] = "office2007";
    }
}

$ds = new MySQLiPivotDataSource($db_con); //This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
$ds->select("products.productLine AS product_Line , customerName, orderdetails.quantityOrdered * orderdetails.priceEach AS dollar_sales,products.productName AS productName");
$ds->from("customers")->join("orders")->on("orders.customerNumber = customers.customerNumber")->join("orderdetails")->on("orders.orderNumber = orderdetails.orderNumber")->join("products")->on("products.productCode = orderdetails.productCode");

$pivot = new KoolPivotTable("pivot");
$pivot->scriptFolder = $KoolControlsFolder."/KoolPivotTable";
$pivot->styleFolder = $_SESSION["style_select"];
$pivot->DataSource = $ds;

//Turn on ajax features.
$pivot->AjaxEnabled = true;


//Set the Width of pivot and use horizontal scrolling
$pivot->Width = "800px";
$pivot->HorizontalScrolling = true;

//Set the Height of pivot and use Vertical Scrolling
$pivot->Height = "400px";
$pivot->VerticalScrolling = true;

//Allow filtering
$pivot->AllowFiltering = true;
//Allow sorting
$pivot->AllowSorting = true;
//Allow sorting data
$pivot->AllowSortingData = true;
//Allow reordering
$pivot->AllowReorder = true;


//Make the RowHeader wider.
$pivot->Appearance->RowHeaderMinWidth = "250px";

//Use the Prev and Next Numneric Pager
$pivot->Pager = new PivotPrevNextAndNumericPager();
$pivot->Pager->PageSize = 10;

//Turn on caching to help pivot working faster.
$pivot->AllowCaching = true;

//Data Field
$field = new PivotSumField("dollar_sales");
$field->Text = "Dollar Sales";
$field->FormatString = "{n}";
$field->AllowReorder = false;
$pivot->AddDataField($field);

//Row Fields
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

$_htmlTemplate = <<<EOF
<head>
    <title>An XHTML 1.0 Strict standard template</title>
    <meta http-equiv="content-type" 
            content="text/html;charset=utf-8" />
</head>
    <body>
        My prefix in html code.<br>
    
        {KoolPivotTable}
    
        My postfix in html code.<br>
    </body>
EOF;

$ExSt = $pivot->ExportSettings;
$ExSt->config(array(
                 "fileName" => "MyKoolPivotTableExport",
                 "template" => $_htmlTemplate,
                 "showFilterZone" => FALSE,
                 "caseSensitive" => TRUE,
                 "pdf" => array(
                     "pageOrientation" => "L",
                     "pageDimension" => array(600, 360),
              )));

$ExSt->changeText(array(
                    "cars"=>"Automobiles", 
                    "column fields"=>"Fields column",
                    "Row fields"=>"Fields row",        
                  ));

//htmlStyle() only affects HTML and PDF exported files
$ExSt->htmlStyle(array(
                    "table" => "border:1px solid grey;"
                            .  "border-collapse:collapse;color:black;",
                    "totalRow" => "background-color:lightblue; font-weight:bold;",
                    "totalColumn" => "background-color:lightblue; font-weight:bold;",
                    "dataCell" => "text-align:right;",
                    "emptyDataCell" => "text-align:center;",
                    "cell" => "padding:5px; border:1px solid grey;",
                 ));
$ExSt->htmlProperty(array(
                        "table" => array(
                            "border" => "1", 
                            "cellspacing" => "0",
                    )));

if (isset($_POST["IgnorePaging"]))
{
    $ExSt->IgnorePaging = TRUE;
}

if (isset($_POST["ExportToHTML"]))
{
    ob_end_clean();
    $pivot->ExportToHTML();
}

if (isset($_POST["ExportToPDF"]))
{
    ob_end_clean();
    $pivot->ExportToPDF();
}

if (isset($_POST["ExportToExcel"]))
{
    ob_end_clean();
    $pivot->ExportToExcel();
}
if (isset($_POST["ExportToWord"]))
{
    ob_end_clean();
    $pivot->ExportToWord();
}
?>

<form id="form1" method="post">

<?php echo $koolajax->Render();?>
    
<div style="margin-bottom:10px;padding:10px;width:780px;background:#DFF3FF;border:solid 1px #C6E1F2;">
    <input type="checkbox" id="IgnorePaging"  name="IgnorePaging"/> <label for="IgnorePaging">Ignore Paging</label>
    <br/><br/>
    <input type="submit" name="ExportToHTML" value = "Export to HTML" />
    <input type="submit" name="ExportToExcel" value = "Export to Excel" />
    <input type="submit" name="ExportToWord" value = "Export to Word" />
    <input type="submit" name="ExportToPDF" value = "Export to PDF" />
</div>

<div style="padding-top:10px;">
    <?php echo $pivot->Render();?>
</div>
    
</form>
