<?php
$data = <<<xml
    <data>
        <node>root, Hardware, Hardware, false, xpNetwork.gif, </node>
        <node>root, Software, Software, false, ie.gif, </node>
        <node>root, dynload, Load the same tree using dynamic loading, false, tree.gif, subnode.php</node>
        <node>root, Books, Books, false, book.gif, book</node>
        <node>Hardware, laptop, HP dv2500 Laptop, false, square_blueS.gif, </node>
        <node>Hardware, desktop, Lenovo desktop, false, square_greenS.gif, </node>
        <node>Hardware, lcd, Asus 19\ LCD, false, square_redS.gif, </node>
        <node>Software, os, Operating System, false, bfly.gif, </node>
        <node>Software, office, Office, false, doc.gif, </node>
        <node>Software, burning, Burn CD/DVD, false, xpShared.gif, </node>
        <node>Software, imageeditor, Image editors, false, goblet_bronzeS.gif, </node>
        <node>Books, ajax, Ajax For Dummies, false, BookY.gif, </node>
        <node>Books, csharp, Mastering C#, false, BookY.gif, </node>
        <node>Books, flash, Flash 8 Bible, false, BookY.gif, </node>
        <node>os, linux, Ubuntu 13.10, false, ball_redS.gif, </node>
        <node>os, windows, Windows 8 Home Edition, false, ball_blueS.gif, </node>
        <node>office, msoffice, Microsoft Office 2013, false, square_redS.gif, </node>
        <node>office, ooffice, Open Office 2.4, false, square_greenS.gif, </node>
        <node>burning, nero, Nero 8, false, triangle_yellowS.gif, </node>
        <node>burning, k3b, K3B <i>(on Ubuntu)</i>, false, triangle_blueS.gif, </node>
        <node>imageeditor, photoshop, Photoshop 10, false, ball_glass_blueS.gif, </node>
        <node>imageeditor, gimp, GIMP 2.3.4, false, ball_glass_greenS.gif, </node>
    </data>   
xml;

	$KoolControlsFolder = "../../../../KoolControls";
	require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
    
	$treeview = new KoolTreeView("treeview");
	$treeview->scriptFolder = $KoolControlsFolder."/KoolTreeView";
	$treeview->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	$treeview->styleFolder="default";
		
    $level = $_GET['level'];
    $_span = "<span class='mytreenode' id='{id}'>";
    $_spanend = "</span>";
    
    $node_data = array();
    $doc = new DOMDocument();
    $doc->loadXML($data);
    $nodes = $doc->getElementsByTagName('node');
    foreach ($nodes as $node) {
        $values = explode(",", $node->nodeValue);
        foreach ($values as & $value) $value = trim($value);
        
        if (!empty($values[0]) && $values[0]!='root') $values[0] = $values[0].$level;
        if (!empty($values[1]) && $values[1]!='root') $values[1] = $values[1].$level;
        if (!empty($values[2])) {
            $spanid = "id_".$values[1];
            $values[2] = str_replace("{id}", $spanid, $_span).$values[2]."(".$spanid.")".$_spanend;
        }
        if ($values[3]=='true') $values[3] = TRUE; else $values[3] = FALSE;
        if (!empty($values[5]) && $values[5]=='subnode.php') $values[5] = $values[5]."?level=".($level+1);
        
        $a = array("parentId"=>$values[0], "id"=>$values[1], "text"=>$values[2], "expand"=>$values[3], "img"=>$values[4], "sublink"=>$values[5]);
        
        array_push($node_data, $a);
    }
    
    foreach ($node_data as $node) $treeview->Add($node["parentId"], $node["id"], $node["text"], $node["expand"], $node["img"], $node["sublink"]);
    
	sleep(0.3);//Slow down response	
	$treeview->isSubTree = true;
	$treeview->width="250px";
	echo $treeview->Render();
?>