<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
    $SourceKoolControlsFolder = "../../../../Source/KoolChart"; //Relative path to "KoolPHPSuite/KoolControls" folder
//    require $SourceKoolControlsFolder . "/koolchart/koolchart.php";
        
	require $KoolControlsFolder."/KoolChart/koolchart.php";

	$chart = new KoolChart("chart");
//	$chart->scriptFolder=$KoolControlsFolder."/KoolChart";	
	$chart->Title->Text = "Sales report for 2012";
	$chart->Width = 680;
	$chart->Height = 500;
	$chart->PlotArea->XAxis->Title = "Quarters";
	$chart->PlotArea->XAxis->Set(array("Q1","Q2","Q3","Q4"));
	$chart->PlotArea->YAxis->Title = "Sales ( .millions)";
	$chart->PlotArea->YAxis->LabelsAppearance->DataFormatString = "$ {0}";
   
	$series = new ColumnSeries();
    $series->Stacked = TRUE;
	$series->Name = "TVs";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(20,30,40,70));
	$chart->PlotArea->AddSeries($series);
    
	$series = new ColumnSeries();
    $series->Stacked = TRUE;
	$series->Name = "Computers";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(34,55,28,40));
	$chart->PlotArea->AddSeries($series);
    
	$series = new ColumnSeries();
	$series->Name = "Tablets & e-readers";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(26,23,56,80));
	$chart->PlotArea->AddSeries($series);
    
    $chart2 = new KoolChart("chart2");
//	$chart2->scriptFolder=$KoolControlsFolder."/KoolChart";	
	$chart2->Title->Text = "Sales report for 2012";
	$chart2->Width = 680;
	$chart2->Height = 480;
	$chart2->Legend->Appearance->Position = "top";
	$chart2->PlotArea->XAxis->Title = "Quarters";
	$chart2->PlotArea->XAxis->Set(array("Q1","Q2","Q3","Q4"));
	$chart2->PlotArea->YAxis->Title = "Sales (millions)";
	$chart2->PlotArea->YAxis->LabelsAppearance->DataFormatString = "$ {0}";
   
	$series = new BarSeries();
    $series->Stacked = TRUE;
	$series->Name = "TVs";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(20,30,40,70));
	$chart2->PlotArea->AddSeries($series);
    
	$series = new BarSeries();
    $series->Stacked = TRUE;
	$series->Name = "Computers";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(34,55,28,40));
	$chart2->PlotArea->AddSeries($series);
    
	$series = new BarSeries();
    $series->Stacked = TRUE;
	$series->Name = "Tablets & e-readers";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(26,23,56,80));
	$chart2->PlotArea->AddSeries($series);    
?>

<form id="form1" method="post">
	<div>
		<?php echo $chart->Render();?>
	</div>			
	
	<div>
		<?php echo $chart2->Render();?>
	</div>						
	<div><i>* <u>Note</u>:</i>Generate your own chart with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/generate_koolchart.php">Code Generator</a></div>
</form>