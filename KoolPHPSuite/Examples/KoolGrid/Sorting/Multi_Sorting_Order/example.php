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
	$ds->SelectCommand = "select customerNumber,customerName,phone,city from customers";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="sunset";
	$grid->DataSource = $ds;
	$grid->Width = "655px";

	$grid->RowAlternative = true;

	$grid->AjaxEnabled = true;
	$grid->AutoGenerateColumns = true;
	
	$grid->AllowSorting = true;//Enable sorting for all rows;
		
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();

    if (isset($_POST["sortOrder"]))
    {
        $_SESSION["sortOrder"] = $_POST["sortOrder"];
    } else
    {
        if (!$koolajax->isCallback)
        {
            //Page Init: show default sort order
            $_SESSION["sortOrder"] = "left-right";
        }
    }
	$grid->MasterTable->MultiSortingOrder = $_SESSION["sortOrder"]; // 'left-right' | 'right-left' | 'FCFS' | 'LCFS'
	
	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
  
	Select multi sorting order:
    <select id="sortOrder" name="sortOrder" onchange="grid.refresh();submit();">
        <option value="left-right"		<?php if ($_SESSION["sortOrder"] == "left-right") echo "selected" ?> >left-right</option>
        <option value="right-left"		<?php if ($_SESSION["sortOrder"] == "right-left") echo "selected" ?> >right-left</option>		
        <option value="FCFS"		<?php if ($_SESSION["sortOrder"] == "FCFS") echo "selected" ?> >First come first served</option>		
        <option value="LCFS"		<?php if ($_SESSION["sortOrder"] == "LCFS") echo "selected" ?> >Last come first served</option>		
    </select>
	
	<div style="padding-bottom:5px;">
		Click column header to sort:
	</div>
	<?php echo $grid->Render();?>
	<div style="margin-top:10px;"><i>* <u>Note</u>:</i>Generate your own grid with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/grid/">Code Generator</a></div>
	
</form>
