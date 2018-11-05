<?php
/*
 * This file is ready to run as standalone example. However, please do:
 * 1. Add tags <html><head><body> to make a complete page
 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
 */

$KoolControlsFolder = "../../../../KoolControls"; //Relative path to "KoolPHPSuite/KoolControls" folder
require $KoolControlsFolder."/KoolGrid/koolgrid.php";
require $KoolControlsFolder."/KoolGrid/ext/datasources/MySQLiDataSource.php";

require $KoolControlsFolder . "/KoolAutoComplete/koolautocomplete.php";

require $KoolControlsFolder . "/KoolCalendar/koolcalendar.php";

require $KoolControlsFolder . "/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder . "/KoolAjax";

function service($text) {
  $db_con = $GLOBALS["db_con"];
  $items = array();
  $result = mysqli_query($db_con, "select customerNumber,customerName from customers where customerName like '$text%'");
  while ($row = mysqli_fetch_assoc($result)) {
    $item = array("text" => $row["customerName"], "customerNumber" => $row["customerNumber"]);
    array_push($items, $item);
  }
  return $items;
}

class MyEditTemplate implements GridTemplate {

  function Render($_row) {
    $template = '';
    $master_table = $_row->GetTableView();
    $columns = $master_table->GetInstanceColumns();
    foreach ($columns as $col)
      if ($col->HiddenDataField === 'customerNumber')
        $template .= $col->FormEditRender($_row);
    $template .= "<br><input type='button' value='Confirm' onclick='grid_confirm_edit(this)'/>"; //Render confirm button.
    $template .= "&nbsp;&nbsp;<input type='button' value='Cancel' onclick='grid_cancel_edit(this)'/>"; //Render cancel button.
    return $template;
  }

  function GetData($_row) {
    $master_table = $_row->GetTableView();
    $columns = $master_table->GetInstanceColumns();
    foreach ($columns as $col)
      if ($col->HiddenDataField === 'customerNumber') {
        $rowId = $_row->GetUniqueID();
        $colId = $col->GetUniqueID();
        return array("customerNumber" => $_POST[$rowId . "_" . $colId . "_hidden_input"]);
      }
  }

}

$ds = new MySQLiDataSource($db_con); //This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
$ds->SelectCommand = "select orderNumber,orderDate,status, o.customerNumber, c.customerName from orders o left join customers c on o.customerNumber = c.customerNumber order by o.orderNumber";
$ds->UpdateCommand = "update orders set orderDate = '@orderDate', status = '@status', customerNumber='@customerNumber' where orderNumber=@orderNumber";
$ds->DeleteCommand = "delete from orders where orderNumber=@orderNumber";
$ds->InsertCommand = "insert into orders (orderDate, status, customerNumber) values ('@orderDate', '@status', '@customerNumber');";
$ds->SetCharSet('utf8');

$grid = new KoolGrid("grid");
$grid->scriptFolder = $KoolControlsFolder . "/KoolGrid";
$grid->styleFolder = "sunset";
$grid->AjaxEnabled = true;
$grid->DataSource = $ds;
$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
$grid->Width = "655px";
$grid->ColumnWrap = true;
$grid->AllowEditing = true;
$grid->AllowDeleting = true;
$grid->RowAlternative = true;
$grid->ShowFooter = true;
$grid->RowAlternative = true;
$grid->AllowFiltering = true;
$grid->MasterTable->ShowFunctionPanel = true;
$grid->MasterTable->EditSettings->Mode = "form";
$grid->MasterTable->EditSettings->Template = new MyEditTemplate();

$column = new GridBoundColumn();
$column->DataField = "orderNumber";
$column->HeaderText = "Order Number";
$column->ReadOnly = true;
$grid->MasterTable->AddColumn($column);

$column = new GridBoundColumn();
$column->DataField = "status";
$column->HeaderText = "Status";
$column->setLengthErrorMessage('To many characters, 10 is maximum.');
$grid->MasterTable->AddColumn($column);

$column = new GridDateTimeColumn();
$column->DataField = "orderDate";
$column->HeaderText = "Order Date";
$column->FormatString = "M d, Y";
$column->Picker = new KoolDatePicker();
$column->Picker->scriptFolder = $KoolControlsFolder . "/KoolCalendar";
$column->Picker->styleFolder = "sunset";
$column->Picker->DateFormat = "M d, Y";
$column->Picker->CalendarSettings->FirstDayOfWeek = 1;
$grid->MasterTable->AddColumn($column);

$column = new GridAutoCompleteColumn();
$column->HeaderText = "Customer Name";
$column->DataField = "customerName";
$column->HiddenDataField = 'customerNumber';
$column->serviceFunction = 'service';
$koolajax->enableFunction('service');
$column->itemTemplate = "{text}";
$column->saveTemplate = "{customerNumber}";
$column->defaultSave = "0";
$column->KoolAutoCompleteFolder = $KoolControlsFolder . "/KoolAutoComplete";
$column->ClientEvents['OnChange'] = 'Handle_OnChange';
$column->ClientEvents['OnOpen'] = 'Handle_OnOpen';
$grid->MasterTable->AddColumn($column);

$column = new GridEditDeleteColumn();
$column->HeaderText = "Edit/Delete";
$column->Align = "center";
$grid->MasterTable->AddColumn($column);

$grid->Process();
?>
<script type="text/javascript">
  function Handle_OnChange(kac) {
    console.log('Text changed. ');
    console.log(kac);
  }
  function Handle_OnOpen(kac) {
    console.log('List Opened. ');
  }
</script>
<form id="form1" method="post">
  <?php echo $koolajax->Render(); ?>
  <?php echo $grid->Render(); ?>
</form>
