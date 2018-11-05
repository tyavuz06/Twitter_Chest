<?php
/*
 * This file is ready to run as standalone example. However, please do:
 * 1. Add tags <html><head><body> to make a complete page
 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
 */

$KoolControlsFolder = "../../../../KoolControls"; //Relative path to "KoolPHPSuite/KoolControls" folder
require $KoolControlsFolder."/KoolGrid/koolgrid.php";
require $KoolControlsFolder."/KoolGrid/ext/datasources/MySQLiDataSource.php";

require $KoolControlsFolder . "/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder . "/KoolAjax";

$ds = new MySQLiDataSource($db_con); //This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
$ds->SelectCommand = "SELECT * FROM kcb_tbstates";
$ds->UpdateCommand = "UPDATE kcb_tbstates SET StateName = '@StateName', Seasons = '@Seasons', Color = '@Color' WHERE ID='@ID'";
$ds->DeleteCommand = "DELETE FROM kcb_tbstates WHERE ID='@ID'";
$ds->InsertCommand = "INSERT INTO kcb_tbstates (ID, StateName, Seasons, Color) VALUES ('@ID', '@StateName', '@Seasons', '@Color');";
$ds->SetCharSet('utf8');

$grid = new KoolGrid("grid");
$grid->scriptFolder = $KoolControlsFolder . "/KoolGrid";
$grid->styleFolder = "sunset";
$grid->AjaxEnabled = false;
$grid->DataSource = $ds;
$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
$grid->MasterTable->Pager->PageSize = 15;
$grid->Width = "755px";
$grid->ColumnWrap = true;
$grid->AllowEditing = true;
$grid->AllowDeleting = true;
$grid->RowAlternative = true;
$grid->ShowFooter = true;
$grid->RowAlternative = true;
$grid->AllowFiltering = true;
$grid->MasterTable->ShowFunctionPanel = true;
// $grid->MasterTable->EditSettings->Mode = "form";

$column = new GridBoundColumn();
$column->DataField = "ID";
$column->HeaderText = "ID";
$grid->MasterTable->AddColumn($column);

$column = new GridBoundColumn();
$column->DataField = "StateName";
$column->HeaderText = "StateName";
$grid->MasterTable->AddColumn($column);

$column = new GridOptionsColumn();
$column->DataField = "Seasons";
$column->HeaderText = "Seasons";
$column->AddOption('Winter,Spring,Summer,Autumn,Wet,Hot');
$column->AddDefaultOption('Spring,Autumn');       
$grid->MasterTable->AddColumn($column);

$column = new GridOptionsColumn();
$column->DataField = "Color";
$column->HeaderText = "Color";
$column->ChoiceType = "RadioButtons";
$column->AddOption('Blue,Red,Purple');
$column->AddDefaultOption('Purple');       
$grid->MasterTable->AddColumn($column);

$column = new GridEditDeleteColumn();
$column->HeaderText = "Edit/Delete";
$column->Align = "center";
$grid->MasterTable->AddColumn($column);

$grid->Process();
?>
<form id="form1" method="post">
  <?php echo $koolajax->Render(); ?>
  <?php echo $grid->Render(); ?>
</form>
