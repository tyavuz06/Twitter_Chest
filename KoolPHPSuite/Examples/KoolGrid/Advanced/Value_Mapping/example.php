<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolGrid/ext/datasources/MySQLiDataSource.php";//    
	
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
    
	$ds = new MySQLiDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select orderNumber,orderDate,status,comments from orders";
	$ds->UpdateCommand = "update orders set orderDate='@orderDate', status='@status', comments='@comments' where orderNumber='@orderNumber'";
	$ds->DeleteCommand = "delete from orders where orderNumber=@orderNumber";
    
    $ds->setValueMap(new ReverseMap());

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="sunset";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "655px";
	$grid->ColumnWrap = true;
	$grid->AllowEditing = true;
	$grid->AllowDeleting = true;

	$column = new GridBoundColumn();
	$column->DataField = "orderNumber";
    $column->HeaderText = "Order Number";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridDateTimeColumn();
	$column->DataField = "orderDate";
	$column->HeaderText = "Order Date";
	$column->FormatString = "Y-m-d";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "sunset";	
	$column->Picker->DateFormat = "Y/m/d";
	
	$grid->MasterTable->AddColumn($column);

	$column = new GridDropDownColumn();
	$column->DataField = "status";
	$column->HeaderText = "Status";
	$column->AddItem("In Process");
	$column->AddItem("On Hold");
	$column->AddItem("Disputed");
	$column->AddItem("Cancelled");	
	$column->AddItem("Resolved");	
	$column->AddItem("Shipped");
	$grid->MasterTable->AddColumn($column);

	$column = new GridTextAreaColumn();
	$column->DataField = "comments";
	$column->HeaderText = "Comments";
	$column->Width = "200px";
//        $column->Visible=FALSE;
	$grid->MasterTable->AddColumn($column);

	$column = new GridEditDeleteColumn();
	$column->Align = "center";
	$grid->MasterTable->AddColumn($column);
	
	$grid->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
	
	$grid->Process();
    
?>
<?php echo $koolajax->Render();?>

<form id="form1" method="post">
    <b>Reverse string in the comments column:</b>
    
    <div style="padding-top:10px;">
        <?php echo $grid->Render();?>
    </div>
</form>
