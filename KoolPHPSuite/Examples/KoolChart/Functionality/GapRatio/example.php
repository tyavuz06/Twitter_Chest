<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
    require $KoolControlsFolder . "/KoolChart/koolchart.php";
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
    require $KoolControlsFolder."/KoolTreeGrid/kooltreegrid.php";
    
    //Column chart
	$chart = new KoolChart("KoolChart1");
	$chart->scriptFolder=$KoolControlsFolder."/KoolChart";	
	$chart->Title->Text = "Sales report for 2012";
	$chart->Width = 660;
	$chart->Height = 460;
	$chart->PlotArea->XAxis->Title = "Quarters";
	$chart->PlotArea->XAxis->Set(array("Q1","Q2","Q3","Q4"));
	$chart->PlotArea->YAxis->Title = "Sales (.million)";
	$chart->PlotArea->YAxis->LabelsAppearance->DataFormatString = "$ {0}";
   
	$series = new ColumnSeries();
	$series->Name = "TVs";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(20,30,40,70));
	$chart->PlotArea->AddSeries($series);
    
	$series = new ColumnSeries();
	$series->Name = "Computers ";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(34,55,10,40));
	$chart->PlotArea->AddSeries($series);
    
	$series = new ColumnSeries();
	$series->Name = "Tablets, e-readers, everything else";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(56,23,56,80));
	$chart->PlotArea->AddSeries($series);
    $chart->set(array(
        'pad' => [20, 20, 20, 20],
        'Transitions' => FALSE,
    ));
    $info = array(
        'id' => 'KoolTreeGrid1',
        'style' => 'outlook',
        'width' => '400px',
        'columns' => array(
            array(
                'field' => 'prop',
                'headerText' => 'Property',
                'width' => '200px',
            ),
            array(
                'field' => 'value',
                'headerText' => 'Value',
                'width' => '120px',
            ),
            array(
                'field' => 'type',
                'headerText' => 'Type',
                'width' => '50px',
            ),
            array(
                'field' => 'desc',
                'headerText' => 'Description',
                'visible' => false,
            ),
        ),
    );
    $treeGrid = KoolTreeGrid::newTreeGrid($info);
    $metaField = 'meta';
    $rows = KoolTreeGrid::csvToArray('data.csv', ';');
    foreach ($rows as & $row) 
        foreach ($row as $field => & $value)
            if ($field===$metaField) 
                $value = json_decode($value, true);
    
    $treeGrid->set(array(
        'ArrayData' => $rows,
        'idField' => 'id',
        'parentField' => 'parentId',
        'metaField' => $metaField,
    ));
    $treeGrid->process();
    
    //Pie chart    
    $chart2 = new KoolChart("KoolChart2");
	$chart->scriptFolder=$KoolControlsFolder."/KoolChart";	
	$chart2->Width = 660;
	$chart2->Height = 400;
	$chart2->Title->Text = "Browser Statistics 2012";
	
	$series = new PieSeries("Browsers");	
	$series->LabelsAppearance->DataFormatString="{0}%";
    $series->set(array(
        "ExplodedRatio" => 1.15,
        "PieLabel" => array(
            "ArcTickGap" => 5,
            "ArcTickSize" =>  15,
            "LabelTickGap" => 5,
            "LabelTickSize" => 10,
        ),
    ));
 
	$item = new PieItem(31.8,"Firefox");
    $item->BackgroundColor = "orange";
	$item->Exploded = true;
	$series->AddItem($item);
	$item = new PieItem(16.1,"Internet Explorer");
	$series->AddItem($item);
	$item = new PieItem(44.9,"Chrome");
    $item->BackgroundColor = "green";
	$series->AddItem($item);
	$item = new PieItem(4.3,"Safari");
	$series->AddItem($item);
	$item = new PieItem(2.9,"Opera & Others");	
	$series->AddItem($item);
	$chart2->PlotArea->AddSeries($series);
    $chart2->Transitions = false;
    
    $info = array(
        'id' => 'KoolTreeGrid2',
        'style' => 'outlook',
        'width' => '400px',
        'columns' => array(
            array(
                'field' => 'prop',
                'headerText' => 'Property',
                'width' => '200px',
            ),
            array(
                'field' => 'value',
                'headerText' => 'Value',
                'width' => '120px',
            ),
            array(
                'field' => 'type',
                'headerText' => 'Type',
                'width' => '50px',
            ),
            array(
                'field' => 'desc',
                'headerText' => 'Description',
                'visible' => false,
            ),
        ),
    );
    $treeGrid2 = KoolTreeGrid::newTreeGrid($info);
    $metaField = 'meta';
    $rows = KoolTreeGrid::csvToArray('data2.csv', ';');
    foreach ($rows as & $row) 
        foreach ($row as $field => & $value)
            if ($field===$metaField) 
                $value = json_decode($value, true);
    
    $treeGrid2->set(array(
        'ArrayData' => $rows,
        'idField' => 'id',
        'parentField' => 'parentId',
        'metaField' => $metaField,
    ));
    $treeGrid2->process();

?>
<form id="form1" method="post">
    <?php 
            //Render Ajax functions for KoolTreeView
            echo $koolajax->Render();
    ?>
    <div class="horizontalRule" style="float:left;border-bottom:2px solid #d1d1d1">
        <div id="KoolChart1Div" style="float:left;">
            <?php echo $chart->Render();?>
        </div>

        <div id="KoolTreeGrid1Div" style="float:left; margin: 25px">
            <?php 
                echo $treeGrid->render();
            ?>
            <input type="button" value="Update KoolChart1" onclick="KoolTreeGrid_update('KoolTreeGrid1', 'KoolChart1')"></input>
            <input type="button" value="Reset" onclick="KoolTreeGrid_reset('KoolTreeGrid1', 'KoolChart1')"></input>
        </div>
    </div>
    
    <div>
        <div id="KoolChart2Div" style="float:left">
            <?php echo $chart2->Render();?>
        </div>

        <div id="KoolTreeGrid2Div" style="float:left; margin: 25px">
            <?php 
                echo $treeGrid2->render();
            ?>
            <input type="button" value="Update KoolChart2" onclick="KoolTreeGrid_update('KoolTreeGrid2', 'KoolChart2')"></input>
            <input type="button" value="Reset" onclick="KoolTreeGrid_reset('KoolTreeGrid2', 'KoolChart2')"></input>
        </div>
    </div>

    <script type='text/javascript'>
        
        KoolTreeGrid_update = function(ktgId, kcId) {
            var ktg = KoolTreeGridJS.getTreeGrid(ktgId);
            var treeData = ktg.getCurrentTreeData();
            var chart = KoolChartJS.getChart(kcId);
            var newSetting = ktg.treeDataToSetting(treeData, 'prop', 'value', 'type');
            var chartSetting = chart.getSetting();
            var setting = KoolPHP.recursiveMerge(chartSetting, newSetting);
            chart.setSetting(setting);
            chart.redraw();
        };
        
        KoolTreeGrid_reset = function(ktgId, kcId) {
            var ktg = KoolTreeGridJS.getTreeGrid(ktgId);
            var treeData = ktg.getOriginalTreeData();
            var chart = KoolChartJS.getChart(kcId);
            var newSetting = ktg.treeDataToSetting(treeData, 'prop', 'value', 'type');
            var setting = KoolPHP.recursiveMerge(chart.getSetting(), newSetting);
            chart.setSetting(setting);
            chart.redraw();
            ktg.reRender();
        };
        
    </script>
    
    <div style="clear:left"><i>* <u>Note</u>:</i>Generate your own chart with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/generate_koolchart.php">Code Generator</a></div>
	
</form>