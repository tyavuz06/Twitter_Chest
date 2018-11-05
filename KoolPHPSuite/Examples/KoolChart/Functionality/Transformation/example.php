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
        
	$chart = new KoolChart("KoolChart1");
	$chart->scriptFolder=$KoolControlsFolder."/KoolChart";	
	$chart->Title->Text = "Sales report for 2012";
	$chart->Width = 660;
	$chart->Height = 600;
	$chart->PlotArea->XAxis->Title = "Quarters (long string 1 long string 2)";
	$chart->PlotArea->XAxis->Set(array("Q1 (long string 1 long string 2 long string 3)","Q2","Q3","Q4  (long string 1 long string 2)"));
	$chart->PlotArea->YAxis->Title = "Sales (long string 1 long string 2)";
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
	$series->Name = "Tablets & e-readers";
	$series->TooltipsAppearance->DataFormatString = "$ {0} millions {1}";
	$series->ArrayData(array(56,23,56,80));
	$chart->PlotArea->AddSeries($series);
    
    $chart->set(array(
        "BarGapRatio" => 0,
        "CategoryGapRatio" => null,
        'Title' => array(
            'Appearance' => array(
                'Position' => 'toP',
            )
        ),
        'Legend' => array(
            'Appearance' => array(
                'SelfWholeTranslate' => [0/2, 0],
            ),
        ),
        'PlotArea' => array(
            'XAxis' => array(
                'LabelsAppearance' => array(
                    'SelfTranslate' => [1/2, 0],
                    'RotationAngle' => 15,
                    'FullyVisible' => TRUE,
                ),
            ),
            'YAxis' => array(
                'TitleAppearance' => array(
                    'Position' => 'center',
                    'SelfTranslate' => [0, -3/4],
                ),
                'LabelsAppearance' => array(
                    'DataFormatString' => '{0} M (long string 1 long string 2)',
                ),
            ) 
        ),
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

?>
<form id="form1" method="post">
    <?php 
            //Render Ajax functions for KoolTreeView
            echo $koolajax->Render();
    ?>
    
    <div id="KoolChart1Div" style="float:left">
        <?php echo $chart->Render();?>
    </div>
    
    <div id="KoolTreeGrid1Div" style="float:left;margin: 25px">
        <?php 
            echo $treeGrid->render();
        ?>
        <input type="button" value="Update KoolChart" onclick="KoolTreeGrid_update('KoolTreeGrid1', 'KoolChart1')"></input>
        <input type="button" value="Reset" onclick="KoolTreeGrid_reset('KoolTreeGrid1', 'KoolChart1')"></input>
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
    
    <div style="clear:both"><i>* <u>Note</u>:</i>Generate your own chart with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/generate_koolchart.php">Code Generator</a></div>
	
</form>