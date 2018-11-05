<?php

    //Relative path to "KoolPHPSuite/KoolControls" folder
    $KoolControlsFolder = "../../../../KoolControls";
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
    require $KoolControlsFolder."/KoolTreeGrid/kooltreegrid.php";

    $info = array(
        'id' => 'KoolTreeGrid1',
        'width' => '780px',
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
    
    $rows = KoolTreeGrid::csvToArray('data.csv', ';');
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
    <?php 
        echo $treeGrid->render();
    ?>
</form> 
