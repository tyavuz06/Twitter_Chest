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
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
		
	$ds = new MySQLiDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select customerName,country from customers order by customerNumber desc";
	$ds->InsertCommand = "";// If you set the Insert Command, the new data will be inserted to database.



	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="sunset";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "655px";
	$grid->ColumnWrap = true;
	$grid->AllowInserting = true;

	$grid->AutoGenerateColumns = true;

	function RenderUpdatePanel()
	{
		$html="";
		$html .="<table>";
		$html .="<tr>";
		$html .="<td style='padding:3px;width:50px;'>Continent:</td>";
		$html .="<td  style='padding:3px;'>";
		

		//Continent
		$html .= "<select id='selContinent' name='selContinent' style='width:100px' onchange='do_update()'>";
		$html .= "<option value='--'>--</option>";			

		$result = mysqli_query($db_con, "select ContinentID,ContinentName from kcb_tbcontinents");
		while($row = mysqli_fetch_assoc($result))
		{
			$_selected = false;
			if(isset($_POST["selContinent"]) && $_POST["selContinent"]==$row["ContinentID"])
			{
				$_selected = true;	
			}			
			$html .= "<option value='".$row["ContinentID"]."' ".(($_selected)?"selected":"").">".$row["ContinentName"]."</option>";			
		}
		$html .= "</select>";

		$html .="</td>";		
		$html .="</tr>";		
		$html .="<tr>";
		$html .="<td  style='padding:3px;'>Country:</td>";
		$html .="<td  style='padding:3px;'>";

		
		//Country
		if(isset($_POST["selContinent"]) && $_POST["selContinent"]!="--")
		{
			$html .= "<select id='selCountry' name='selCountry' style='width:100px' >";
			$html .= "<option value='--'>--</option>";			

			$result = mysqli_query($db_con, "select CountryName from kcb_tbcountries where ContinentID=".$_POST["selContinent"]);
			while($row = mysqli_fetch_assoc($result))
			{
				$_selected = false;
				if(isset($_POST["selCountry"]) && $_POST["selCountry"]==$row["CountryName"])
				{
					$_selected = true;	
				}
				
				$html .= "<option value='".$row["CountryName"]."' ".(($_selected)?"selected":"").">".$row["CountryName"]."</option>";			
			}

			$html .= "</select>";
		}
		else
		{
			$html .= "<select id='selCountry' name='selCountries' style='width:100px' disabled></select>";	
		}


		$html .="</td>";	
		$html .="</tr>";		
				
		$html .="</table>";


		$myPanel = new UpdatePanel("myPanel");
		$myPanel->content = $html;
		$myPanel->setLoading("../../../../KoolControls/KoolAjax/loading/5.gif");
		return $myPanel->Render();		
	}


	class MyInsertTemplate implements GridTemplate
	{
		function Render($_row)
		{
			$html = "";
			$html .= "<div style='font-size:12px;font-weight:bold;margin-bottom:10px;'>Inserting a new customer</div>";
			$html .="<table>";
			$html .="<tr>";
			$html .="<td valign='top' style='padding:3px;padding-top:4px;width:50px;'>Name:</td>";
			$html .="<td valign='top' style='padding:3px;padding-top:4px;width:380px;'>";
			$html .="<input type='text' id='txtName' name='txtName'>";
			$html .="</td>";
			
			$html .="<td valign='top'>";
			$html .= RenderUpdatePanel();

			$html .="</td>";
			
			$html .="</tr>";
			$html .="</table>";
			
			$html .= "<div style='font-size:12px;font-weight:bold;margin-top:5px;margin-bottom:5px;'>";
			$html .= "<input type='button' value ='Confirm' onclick='validate_and_confirm(this)'>";
			$html .= "<input type='button' value ='Cancel' onclick='grid_cancel_insert(this)'>";

			$html .= "</div>";

			return $html;
		}
		function GetData($_row)
		{
			return array("customerName"=>$_POST["txtName"],"country"=>$_POST["selCountry"]);
		}
		
	}



	$grid->MasterTable->InsertSettings->Mode = "template";
	$grid->MasterTable->InsertSettings->Template = new MyInsertTemplate();
	$grid->MasterTable->ShowFunctionPanel = true;
	$grid->ClientSettings->ClientEvents["OnConfirmInsert"] = "Handle_OnConfirmInsert";

	
	$grid->Process();
	
	if(isset($_POST['myPanel_is_updating']))
	{
		sleep(1);
		RenderUpdatePanel();
		
	}
	
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<script type="text/javascript">
		function do_update()
		{
			myPanel.attachData("myPanel_is_updating",1);
			myPanel.update();
		
		}
		function validate_and_confirm(_this)
		{
			//Check if country is selected.
			var _selCountry = document.getElementById("selCountry");
			var _txtName = document.getElementById("txtName");
			if(_txtName.value=="")
			{
				alert("Please insert a name");
				_txtName.focus();
				return;
			}
			if(_selCountry.value=="" ||_selCountry.value=="--")
			{
				alert("Please choose a country!");
				return;
			}

			grid_confirm_insert(_this);
		}
		function Handle_OnConfirmInsert(sender,arg)
		{
			alert("In the real application, new customer information will be inserted into database.");
		}
	</script>
	<?php echo $grid->Render();?>
	<div style="margin-top:10px;"><i>* <u>Note</u>:</i>Generate your own grid with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/grid/">Code Generator</a></div>
	
</form>
