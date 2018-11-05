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
    $chart->Height = 450;
    $chart->Width = 500;
	$chart->Title->Text = "Bar Chart with negative values";
    $chart->Legend->Appearance->Visible = false;
    $chart->PlotArea->XAxis->Title = "";
    $chart->PlotArea->XAxis->MajorTickSize = 2;
    $chart->PlotArea->YAxis->Title = "";
    $chart->PlotArea->YAxis->MaxValue = 50;
    $chart->PlotArea->YAxis->MinValue = -30;
    $chart->PlotArea->YAxis->MajorStep = 10;
    $chart->PlotArea->YAxis->MinorStep = 2;
    $series = new BarSeries();
    $series->Appearance->BackgroundColor = "#399C48";
    $series->ArrayData(array(25,-12,39));
    $chart->PlotArea->AddSeries($series);
    $series = new BarSeries();
    $series->Appearance->BackgroundColor = "#28A1DA";
    $series->ArrayData(array(-15,38,-11));
    $chart->PlotArea->AddSeries($series);
	
	
	
    $chart_scatter = new KoolChart("chart_scatter");
	$chart_scatter->scriptFolder=$KoolControlsFolder."/KoolChart";	
	$chart_scatter->Title->Text = "ScatterLine with negative values";
    $chart_scatter->Width = 500;
    $chart_scatter->Legend->Appearance->Visible = false;
    $chart_scatter->PlotArea->XAxis->Title = "";
    $chart_scatter->PlotArea->XAxis->MaxValue = 100;
    $chart_scatter->PlotArea->XAxis->MinValue = -60;
    $chart_scatter->PlotArea->XAxis->MajorStep = 20;
    $chart_scatter->PlotArea->XAxis->MinorStep = 4;
    $chart_scatter->PlotArea->YAxis->Title = "";
    $chart_scatter->PlotArea->YAxis->MaxValue = 60;
    $chart_scatter->PlotArea->YAxis->MinValue = -60;
    $chart_scatter->PlotArea->YAxis->MajorStep = 10;
    $chart_scatter->PlotArea->YAxis->MinorStep = 2;
    
	$series = new ScatterLineSeries();
    $series->Appearance->BackgroundColor = "#90B720";
	$series->LabelsAppearance->DataFormatString = "{0},{1}";
    $series->LabelsAppearance->Position = "Above";
    $series->TooltipsAppearance->DataFormatString = "{0},{1}";
	$series->TooltipsAppearance->BackgroundColor = "#90B720";
    $series->AddItem(new ScatterItem(-27,35));
    $series->AddItem(new ScatterItem(14,2));
    $series->AddItem(new ScatterItem(50,39));
    $chart_scatter->PlotArea->AddSeries($series);
	
    $series = new ScatterLineSeries();
    $series->Appearance->BackgroundColor = "orange";
	
    $series->LabelsAppearance->DataFormatString = "{0},{1}";
    $series->LabelsAppearance->Position = "Above";
    $series->TooltipsAppearance->DataFormatString = "{0},{1}";
	$series->TooltipsAppearance->BackgroundColor = "orange";
    $series->AddItem(new ScatterItem(-33,15));
    $series->AddItem(new ScatterItem(-5,48));
    $series->AddItem(new ScatterItem(60,-42));
    $chart_scatter->PlotArea->AddSeries($series);	
	
	
?>

<form id="form1" method="post">

	<div>
		<?php echo $chart->Render();?>
	</div>			

	
	<div>
		<?php echo $chart_scatter->Render();?>
	</div>			
	
	
	<div><i>* <u>Note</u>:</i>Generate your own chart with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/chart/">Code Generator</a></div>

</form>