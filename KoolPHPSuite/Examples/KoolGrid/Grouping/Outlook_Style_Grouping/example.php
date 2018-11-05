<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolGrid/ext/datasources/MySQLiDataSource.php";
	$ds = new MySQLiDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select CONCAT(employees.firstName,' ',employees.lastName) as employee_name,addressLine1,CONCAT(reportsTo_employees.firstName,' ',reportsTo_employees.lastName) as supervisor_name,employees.jobTitle from employees,offices,employees as reportsTo_employees where reportsTo_employees.employeeNumber=employees.reportsTo and employees.officeCode=offices.officeCode";
	
	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="sunset";
	$grid->DataSource = $ds;
	$grid->Width = "655px";
	$grid->DataSource = $ds;
	
	$grid->AjaxEnabled = true;
	$grid->AjaxLoadingImage =  $KoolControlsFolder."/KoolAjax/loading/2.gif";

	$column = new GridBoundColumn();
	$column->DataField = "employee_name";
	$column->HeaderText = "Name";	
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "jobTitle";
	$column->HeaderText = "Title";	
	$grid->MasterTable->AddColumn($column);

	
	$column = new GridBoundColumn();
	$column->DataField = "supervisor_name";
	$column->HeaderText = "Supervisor";	
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "addressLine1";
	$column->HeaderText = "Office Address";	
	$grid->MasterTable->AddColumn($column);

	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	
	$grid->AllowGrouping = true; //Allow Grouping
	$grid->MasterTable->ShowGroupPanel = true; //Show Group Panel
		
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
	<div style="margin-top:10px;"><i>* <u>Note</u>:</i>Generate your own grid with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/grid/">Code Generator</a></div>
</form>
