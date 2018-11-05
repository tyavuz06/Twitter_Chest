<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolChart/koolchart.php";

	$chart = new KoolChart("chart");
	$chart->scriptFolder=$KoolControlsFolder."/KoolChart";	
	$chart->Title->Text = "Sales report for 2012";
	$chart->Width = 680;
	$chart->Height = 480;
	$chart->Legend->Appearance->Position = "top";
	$chart->PlotArea->XAxis->Title = "Quarters";
	$chart->PlotArea->XAxis->Set(array("Q1","Q2","Q3","Q4"));
	$chart->PlotArea->YAxis->Title = "Sales (millions)";
	$chart->PlotArea->YAxis->LabelsAppearance->DataFormatString = "$ {0}";
   
	$series = new BarSeries();
	$series->Name = "TVs";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions";
	$series->ArrayData(array(20,30,40,70));
	$chart->PlotArea->AddSeries($series);
    
	$series = new BarSeries();
	$series->Name = "Computers";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions";
	$series->ArrayData(array(34,55,10,40));
	$chart->PlotArea->AddSeries($series);
    
	$series = new BarSeries();
	$series->Name = "Tablets & e-readers";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions";
	$series->ArrayData(array(56,23,56,80));
	$chart->PlotArea->AddSeries($series);
?>

<form id="form1" method="post">

	<?php echo $chart->Render();?>					
	
	<div><i>* <u>Note</u>:</i>Generate your own chart with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/chart/">Code Generator</a></div>

</form>