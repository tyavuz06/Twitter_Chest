<?php

    //Relative path to "KoolPHPSuite/KoolControls" folder
    $KoolControlsFolder = "../../../../KoolControls";
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
    require $KoolControlsFolder."/KoolTreeGrid/kooltreegrid.php";

    $info = array(
        'id' => 'KoolTreeGrid1',
//        'style' => 'sunset',
//        'style' => 'lightsky',
//        'style' => 'office2010blue',
//        'style' => 'outlook',
        'width' => '100%',
        'columns' => array(
            array(
                'field' => 'prop',
                'headerText' => 'Property',
                'width' => '250px',
            ),
            array(
                'field' => 'defaultValue',
                'headerText' => 'Default Value',
                'width' => '120px',
            ),
            array(
                'field' => 'value',
                'headerText' => 'Example Value',
                'width' => '120px',
                'columnEdit' => TRUE,
            ),
            array(
                'field' => 'type',
                'headerText' => 'Type',
                'width' => '50px',
            ),
            array(
                'field' => 'desc',
                'headerText' => 'Description',
            ),
        ),
        'rootIndent' => 20,
        'treeIndent' => 19,
    );
    
    $treeGrid = KoolTreeGrid::newTreeGrid($info);
    
    $metaField = 'meta';
    $rows = KoolTreeGrid::csvToArray('data.csv', ';');
    foreach ($rows as & $row) 
        foreach ($row as $field => & $value)
            if ($field===$metaField) 
                $value = json_decode($value, true);
    
    $treeGrid->addSetting(array(
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
    <div>
        <div style="font-weight: bold">
            Select a style for KoolTreeGrid:
            <select onchange="styleChange(this, 'KoolTreeGrid1')">
                <option value='default'>Default</option>
                <option value='office2010blue'>Office 2010 Blue</option>
                <option value='outlook'>Outlook</option>
                <option value='lightsky'>Light Sky</option>
                <option value='sunset'>Sunset</option>
            </select>
        </div>
    </div>
    <div style="margin-top: 10px"></div>
    <div>
        <?php 
            echo $treeGrid->render();
        ?>    
    </div>

    <script type='text/javascript'>

        styleChange = function(select, treeGridId) {
            var style = select.value;
            var ktg = KoolTreeGridJS.getTreeGrid(treeGridId);
            ktg.setStyle(style);
        };
    </script>
</form> 
