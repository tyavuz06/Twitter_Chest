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
	$chart->Width = 770;
	$chart->Height = 480;
	$chart->Title->Text = "Sales and Profits";		
    $chart->PlotArea->XAxis->Title = "Profits (millions)";
    $chart->PlotArea->XAxis->LabelsAppearance->DataFormatString = "$ {0}";
    $chart->PlotArea->YAxis->Title = "Sales ( 000's)";
   
    $series = new ScatterSeries();
    $series->Name = "Product A";
    $series->LabelsAppearance->DataFormatString = "{1} / $ {0}";
    $series->TooltipsAppearance->DataFormatString = "{1} / $ {0}";
    $series->AddItem(new ScatterItem(20,30));
    $chart->PlotArea->AddSeries($series);
   
    $series = new ScatterSeries();
    $series->Name = "Product B";
    $series->LabelsAppearance->DataFormatString = "{1} / $ {0}";
    $series->TooltipsAppearance->DataFormatString = "{1} / $ {0}";
    $series->AddItem(new ScatterItem(50,40));
    $chart->PlotArea->AddSeries($series);
   
    $series = new ScatterSeries();
    $series->Name = "Product C";
    $series->LabelsAppearance->DataFormatString = "{1} / $ {0}";
    $series->TooltipsAppearance->DataFormatString = "{1} / $ {0}";
    $series->AddItem(new ScatterItem(10,10));
    $chart->PlotArea->AddSeries($series);
   
    $series = new ScatterSeries();
    $series->Name = "Product D";
    $series->LabelsAppearance->DataFormatString = "{1} / $ {0}";
    $series->TooltipsAppearance->DataFormatString = "{1} / $ {0}";
    $series->AddItem(new ScatterItem(14,18));
    $chart->PlotArea->AddSeries($series);
   
    $series = new ScatterSeries();
    $series->Name = "Product E";
    $series->LabelsAppearance->DataFormatString = "{1} / $ {0}";
    $series->TooltipsAppearance->DataFormatString = "{1} / $ {0}";
    $series->AddItem(new ScatterItem(34,38));
    $chart->PlotArea->AddSeries($series);
   
    $series = new ScatterSeries();
    $series->Name = "Product F";
    $series->LabelsAppearance->DataFormatString = "{1} / $ {0}";
    $series->TooltipsAppearance->DataFormatString = "{1} / $ {0}";
    $series->AddItem(new ScatterItem(24,20));
    $chart->PlotArea->AddSeries($series);
?>

<form id="form1" method="post">

	<?php echo $chart->Render();?>					
	
	<div><i>* <u>Note</u>:</i>Generate your own chart with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/chart/">Code Generator</a></div>

</form>