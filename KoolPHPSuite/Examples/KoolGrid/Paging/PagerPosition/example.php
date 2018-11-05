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
	
	if(isset($_POST["position_select"]))
	{
		$_SESSION["position_select"] = $_POST["position_select"];
	}
	else
	{
		if (!$koolajax->isCallback)
		{
			//Page Init: show default position as top
			$_SESSION["position_select"] = "top";
		}
	}

	//Pager settings
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->MasterTable->Pager->Position = $_SESSION["position_select"];


	$grid->Process();
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>

	Select position:
	<select id="position_select" name="position_select" onchange="submit();">
		<option value="top"		<?php if ($_SESSION["position_select"]=="top") echo "selected" ?> >Top</option>
		<option value="bottom"		<?php if ($_SESSION["position_select"]=="bottom") echo "selected" ?> >Bottom</option>
		<option value="top+bottom"		<?php if ($_SESSION["position_select"]=="top+bottom") echo "selected" ?> >Top+Bottom</option>
	</select>

	<div style="padding-top:10px;">
		<?php echo $grid->Render();?>
	</div>
	<div style="margin-top:10px;"><i>* <u>Note</u>:</i>Generate your own grid with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/grid/">Code Generator</a></div>
</form>
