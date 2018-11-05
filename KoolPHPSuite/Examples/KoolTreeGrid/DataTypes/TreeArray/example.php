<?php
    //Relative path to "KoolPHPSuite/KoolControls" folder
    $KoolControlsFolder = "../../../../KoolControls";
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
    require $KoolControlsFolder."/KoolTreeGrid/kooltreegrid.php";

    $treeArray = array(
        'row' => array(
            'prop' => 'KoolChart',
        ),
        'children' => array(
            array(
                'row' => array(
                    'prop' => 'id',
                    'value' => 'KoolChart1',
                    'desc' => 'Chart\'s id',
                ),
                'meta' => array(
                    'rowEdit' => array(
                        'value' => true
                    ),
                ),
            ),
            array(
                'row' => array(
                    'prop' => 'width',
                    'value' => '600px',
                    'desc' => 'Chart\'s width',    
                ),
                'meta' => array(
                    'rowEdit' => array(
                        'value' => true
                    ),
                ),
            ),
            array(
                'row' => array(
                    'prop' => 'height',
                    'value' => '400px',
                    'desc' => 'Chart\'s height',    
                ),
                'meta' => array(
                    'rowEdit' => array(
                        'value' => true
                    ),
                ),
            ),
            array(
                'row' => array(
                    'prop' => 'Title',
                    'desc' => 'Chart\'s title',    
                ),
                'meta' => array(),
                'children' => array(
                    array(
                        'row' => array(
                            'prop' => 'Text',
                            'value' => 'My chart',
                            'desc' => 'Title\'s text',
                        ),
                        'meta' => array(
                            'rowEdit' => array(
                                'value' => true
                            ),
                        ),
                    ),
                    array(
                        'row' => array(
                            'prop' => 'Appearance',
                            'value' => '',
                            'desc' => 'Title\'s appearance',
                        ),
                        'meta' => array(
                            'expand' => false,
                        ),
                        'children' => array(
                            array(
                                'row' => array(
                                    'prop' => 'BackgroundColor',
                                    'value' => 'white',
                                    'desc' => 'Set title\'s background color',
                                ),
                                'meta' => array(
                                    'rowEdit' => array(
                                        'value' => true
                                    ),
                                ),
                            ),
                            array(
                                'row' => array(
                                    'prop' => 'Visible',
                                    'value' => 'TRUE',
                                    'desc' => 'Set title visible or not',
                                ),
                                'meta' => array(
                                    'rowEdit' => array(
                                        'value' => array(
                                            'type' => 'checkbox',
                                        ),
                                        'desc' => array(
                                            'type' => 'text'
                                        )
                                    ),
                                ),
                            ),
                            array(
                                'row' => array(
                                    'prop' => 'Position',
                                    'value' => 'top',
                                    'desc' => 'Set title\'s position',
                                ),
                                'meta' => array(
                                    'rowEdit' => array(
                                        'value' => array(
                                            'type' => 'select',
                                            'options' => ['top', 'bottom', 'left', 'right']
                                        ),
                                    ),
                                ),
                            )
                        )
                    ),
                )
            ),
            array(
                'row' => array(
                    'prop' => 'Legend',
                    'value' => '',
                    'desc' => 'Chart\' legend',    
                ),
                'meta' => array(
                    'rowEdit' => array(
                        'desc' => true
                    )
                ),
                'children' => array(
                    array(
                        'row' => array(
                            'prop' => 'Appearance',
                            'value' => '',
                            'desc' => 'Legend\'s appearance',
                        ),
                        'meta' => array(
                            'expand' => false,
                        ),
                        'children' => array(
                            array(
                                'row' => array(
                                    'prop' => 'BackgroundColor',
                                    'value' => 'white',
                                    'desc' => 'Set legend\'s background color',
                                ),
                                'meta' => array(
                                    'rowEdit' => true
                                ),
                            ),
                            array(
                                'row' => array(
                                    'prop' => 'Visible',
                                    'value' => FALSE,
                                    'desc' => 'Set legend visible or not',
                                ),
                                'meta' => array(
                                    'rowEdit' => array(
                                        'value' => array(
                                            'type' => 'checkbox',
                                        ),
                                    ),
                                ),
                            ),
                            array(
                                'row' => array(
                                    'prop' => 'Position',
                                    'value' => 'right',
                                    'desc' => 'Set legend\'s position',
                                ),
                                'meta' => array(
                                    'rowEdit' => array(
                                        'value' => array(
                                            'type' => 'select',
                                            'options' => ['top', 'bottom', 'left', 'right']
                                        ),
                                        'desc' => true
                                    ),
                                ),
                            )
                        )
                    )
                )
            )
        )
    );
    
    $info = array(
        'id' => 'KoolTreeGrid1',
        'width' => '660px',
        'keepSate' => true,
        'columns' => array(
            array(
                'field' => 'prop',
                'headerText' => 'Property',
                'width' => '200px',
            ),
            array(
                'field' => 'value',
                'headerText' => 'Value',
                'width' => '150px',
            ),
            array(
                'field' => 'desc',
                'headerText' => 'Description',
            ),
        ),
    );
    
    $treeGrid = KoolTreeGrid::newTreeGrid($info);
    $treeGrid->set(array(
        'TreeArray' => $treeArray
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
