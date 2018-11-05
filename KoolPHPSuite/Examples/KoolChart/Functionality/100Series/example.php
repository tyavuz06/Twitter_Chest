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
	$chart->Height = 500;
	$chart->PlotArea->XAxis->Title = "Quarters";
	$chart->PlotArea->XAxis->Set(array("Q1","Q2","Q3","Q4"));
	$chart->PlotArea->YAxis->Title = "Sales ( .millions)";
	$chart->PlotArea->YAxis->LabelsAppearance->DataFormatString = "$ {0}";
    $chart->Legend->Appearance->Position = "right"; //"top", "bottom", "left", "right
   
    $numberOfSeries = 100;
    for ($i=0; $i<$numberOfSeries; $i++)
    {
        $series = new ColumnSeries();
        $series->Stacked = TRUE;
        $series->Name = $i;
        $series->TooltipsAppearance->DataFormatString = "$ {0}";
        $d0 = mt_rand(1, 10);
        $d1 = mt_rand(2, 10);
        $d2 = mt_rand(3, 10);
        $d3 = mt_rand(4, 10);
        $series->ArrayData(array($d0,$d1,$d2,$d3));
        $chart->PlotArea->AddSeries($series);    
    }
    $chart->Transitions = false;
    
?>
<form id="form1" method="post">
	<?php echo $chart->Render();?>					
	<div><i>* <u>Note</u>:</i>Generate your own chart with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/generate_koolchart.php">Code Generator</a></div>
</form>