<?php
    $KoolControlsFolder = "../../../../KoolControls";
    require $KoolControlsFolder . "/KoolUIControl/KoolUIControl.php";

    $ui = KoolUI::newUI(
        array(
            'id' => 'KBarcode1',
            'width' => '300px',
            'height' => '100px',
            'templateSelector' => 'KBarcode t0',
            'showChecksum' => true,
            'type' => ' ean13 ',
            'value' => '4 003994 15548',
        )
    );
    $ui->process();
    
    $ui2 = KoolUI::newUI(
        array(
            'id' => 'KBarcode2',
            'width' => '200px',
            'height' => '100px',
            'templateSelector' => 'KBarcode t0',
            'showChecksum' => true,
            'type' => ' ean8 ',
            'value' => '9638507',
        )
    );
    $ui2->process();
?>
<form id="form1" method="post">
    <?php 
        echo $ui->render(); 
    ?>
    <?php 
        echo $ui2->getBasedHtml();
        echo "<script type='text/javascript'>
            var startupJS2 = " . $ui2->getStartupJS() . ";
        </script>";
    ?>
    <script type='text/javascript'>
        startupJS2();
    </script>
</form> 
    

