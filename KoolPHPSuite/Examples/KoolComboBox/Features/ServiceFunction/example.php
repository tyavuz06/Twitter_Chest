<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolComboBox/koolcombobox.php";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";

	$kcb = new KoolComboBox("kcb");
	$kcb->scriptFolder = $KoolControlsFolder."/KoolComboBox";
	$kcb->itemTemplate = "<table><tr><td valign='middle' style='width:22px;height:20px;'><img src='../../Resources/Flags/{flagimage}' alt='{text}' title='{text}' /></td><td valign='middle'>{text}</td></tr></table>";



	$kcb->width = "200px";
	$kcb->styleFolder="inox";
	
	function funcService($text)
	{
    $db_con = $GLOBALS["db_con"];
		$itemlist = array();
		$result = mysqli_query($db_con, "select CountryID,CountryName,FlagImage from kcb_tbcountries where CountryName LIKE '$text%';");
		while($row = mysqli_fetch_assoc($result))
		{
			$item = array("text"=>$row["CountryName"],"value"=>$row["CountryID"],"flagimage"=>$row["FlagImage"]);
			array_push($itemlist,$item);
		}
		return $itemlist;		
	}	
	$koolajax->enableFunction("funcService");
	$kcb->serviceFunction = "funcService";
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>

	<div style="padding-left:10px;padding-bottom:10px;">	
		Choose a nation:
	</div>
	<div style="padding-left:10px;padding-bottom:50px;">
		<?php echo $kcb->Render();?>
	</div>

</form>
