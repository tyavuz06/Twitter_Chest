<?php
    $KoolControlsFolder = "../../../../KoolControls";
    require $KoolControlsFolder . "/KoolUIControl/KoolUIControl.php";

    $info = array(
        'width' => '300px',
        'height' => '100px',
        'templateSelector' => 'KBarcode t0',
        'showChecksum' => true,
    );
    
    $data = array(
        array(
            'type' => ' ean13 ',
            'value' => '4 003994 15548',
        ),
        array(
            'width' => '200px',
            'type' => 'ean8',
            'value' => '9638507',
        ),
        array(
            'width' => '300px',
            'type' => 'upc',
            'subtype' => 'a',
            'value' => '1 23456 78999',
        ),
        array(
            'width' => '200px',
            'type' => 'upc',
            'subtype' => 'e',
            'value' => '654321',
        ),
        array(
            'width' => '400px',
            'type' => 'code39',
            'value' => 'WIKIPEDIA',
            'showChecksum' => false,
        ),
        array(
            'width' => '300px',
            'type' => 'code128',
            'subtype' => 'b',
            'value' => 'Wikipedia',
            'showChecksum' => false,
        ),
        array(
            'width' => '500px',
            'type' => 'gs1128',
            'value' => '01 95012345678903 3103 000123',
            'showChecksum' => false,
        ),
        array(
            'width' => '300px',
            'type' => 'msi',
            'subtype' => 'mod10',
            'value' => '1234567',
            'showChecksum' => true,
        ),
        array(
            'width' => '200px',
            'type' => 'QRCode',
            'fontSize' => 15,
            'value' => 'http://en.m.wikipedia.org',
        )
    );
    
    for ( $i=0; $i<count( $data ); $i++ ) {
        $ui = KoolUI::newUI($info);
        $data[ $i ][ 'id' ] = 'KoolBarcode' . $i;
        $ui->set( $data[ $i ] );
        $ui->process();
        $data[ $i ]['basedHtml'] = $ui->getBasedHtml();
        $data[ $i ]['startupJS'] = $ui->getStartupJS();
    }
    
    $s = '<script type="text/javascript">var exampleData = {data};</script>';
    $s = str_replace( '{data}', json_encode(
        $data, JSON_HEX_TAG | JSON_HEX_APOS |
        JSON_HEX_QUOT | JSON_HEX_AMP |
        JSON_UNESCAPED_UNICODE), $s );
    echo $s;
?>

<style>
    .clear10px
    {
        clear: both;
        margin-top: 10px;
    }
    .barcodeDiv
    {
        float: left;
        border: 1px solid gray;
    }
    .barcodeDiv, .inputDiv, .typeDiv
    {
        margin: 10px 10px 10px 10px;
    }
</style>

<form id="form1" method="post">
    <div class='barcodeDiv'>
        <div class='typeDiv'></div>
        <div class='typeDiv'></div>
        <div class='inputDiv'>
            Value: <input type='text' />
        </div>
        <div class='inputDiv'>
            Width: <input type='text' />
        </div>
        <div class='inputDiv'>
            Height: <input type='text' />
        </div>
        <div class='inputDiv'>
            Show checksum: <input type='checkbox'>
        </div>
        <div></div>
    </div>
</form> 
<div class='clear10px'></div>

<script>
    var form1 = document.getElementById( 'form1' );
    var tplDiv = form1.children[ 0 ];
    for ( var i=0; i<exampleData.length; i+=1 ) {
        var div = tplDiv.cloneNode( true );
        var renderDiv = div.children[ div.children.length - 1 ];
        renderDiv.innerHTML = exampleData[ i ]['basedHtml'];
        form1.appendChild( div );

        window[ exampleData[ i ]['startupJS'] ]();

        var dom = KoolPHP.domObj( exampleData[ i ]['id'] );
        var kBarcode = KoolUI.getControls( dom ).KBarcode;
        var typeDiv = div.children[ 0 ];
        typeDiv.textContent = 'Barcode type: ' + 
            kBarcode.getBarcodeControlName( exampleData[ i ]['type'] );
        var subtypeDiv = div.children[ 1 ];
        subtypeDiv.textContent = 'Subtype: ' + ( exampleData[ i ]['subtype'] ? 
            exampleData[ i ].subtype.toUpperCase() : 'NA' );
        var setting = kBarcode.getSetting();
        var inputs = [];
        inputs[ 0 ] = div.children[ 2 ].children[ 0 ];
        inputs[ 0 ].value = setting.value;
        inputs[ 1 ] = div.children[ 3 ].children[ 0 ];
        inputs[ 1 ].value = parseFloat( setting.width );
        inputs[ 2 ] = div.children[ 4 ].children[ 0 ];
        inputs[ 2 ].value = parseFloat( setting.height );
        inputs[ 3 ] = div.children[ 5 ].children[ 0 ];
        inputs[ 3 ].checked = setting.showChecksum;
        var getValueChangedListener = function( kBarcode, inputs ) {
            var setting = kBarcode.getSetting();
            return function() {
                setting.value = inputs[ 0 ].value;
                setting.width = inputs[ 1 ].value + 'px';
                setting.height = inputs[ 2 ].value + 'px';
                setting.showChecksum = inputs[ 3 ].checked;
                KoolUI.init( setting );
            };
        };
        for ( var j=0; j<inputs.length; j+=1 ) {
            var event = ( j !== 3 ) ? 'focusout' : 'change';
            KoolPHP.addEventListener( inputs[ j ], event, 
                getValueChangedListener( kBarcode, inputs ));
        }
    }
    form1.removeChild( tplDiv );
</script>
    

