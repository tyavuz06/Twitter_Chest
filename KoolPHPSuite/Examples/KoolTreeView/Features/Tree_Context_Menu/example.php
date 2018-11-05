<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */
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

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
    require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
    require $KoolControlsFolder."/KoolMenu/koolmenu.php";

    $treeview = new KoolTreeView("mytreeview");
    $treeview->scriptFolder = $KoolControlsFolder."/KoolTreeView";
    $treeview->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
    $treeview->styleFolder="default";
    $treeview->showLines = true;
    $root = $treeview->getRootNode();
    $root->text = "My Properties";
    $root->expand=true;
    $root->image="woman2S.gif";


    # Context Menu
    $context = new KoolContextMenu("mycontextmenu");
    $context->scriptFolder = $KoolControlsFolder."/KoolMenu";
    $context->styleFolder = "default";

    $img = $treeview->imageFolder."/triangle_blueS.gif";
    $context->Add("root", "0", "Hello, ", "javascript:GetId(0)", $img);
    $context->Add("root", "1", "Goodbye, ","javascript:GetId(1)", $img);
    $context->Add("root", "2", "Nice to see you, ", "javascript:GetId(2)", $img);
    $context->Add("root", "3", "Clear event box", "javascript:GetId(3)", $img);


    $level = 1;
    $_span = "<span class='mytreenode' id='{id}'>";
    $_spanend = "</span>";
    $_ids = "";
    
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
            $_ids .= $spanid . ",";
        }
        if ($values[3]=='true') $values[3] = TRUE; else $values[3] = FALSE;
        if (!empty($values[5]) && $values[5]=='subnode.php') $values[5] = $values[5]."?level=".($level+1);

        $a = array("parentId"=>$values[0], "id"=>$values[1], "text"=>$values[2], "expand"=>$values[3], "img"=>$values[4], "sublink"=>$values[5]);

        array_push($node_data, $a);
    }
    $context->AttachTo = $_ids;

    foreach ($node_data as $node) $treeview->Add($node["parentId"], $node["id"], $node["text"], $node["expand"], $node["img"], $node["sublink"]);

?>

<style type="text/css">
    .box
    {
        float:left;
        margin:10px;
        padding:10px;
    }
    .focus
    {
        background:#DFF3FF;
        border:solid 1px #C6E1F2;           
    }
    .clear
    {
        clear:both;
    }
    #eventlog
    {
        overflow:auto;
        overflow-x:hidden;
        height : 150px;
        /*width : 200px;*/
    }   
</style>

<?php echo $koolajax->Render();?>

<div class="box">
    <?php echo $treeview->Render();?>
    <?php echo $context->Render();?>    
</div>

<div class="box focus">
    <b>Context menu</b> and <b>Menu item id</b> selected: <hr/>
    <div id="eventlog">
        
    </div>       
</div>

<div class="clear"></div>
    
    
<script type="text/javascript">
    function GetId(option)
        {
            s = "";
            switch (option) {
                case 0: s = "Hello, "; break;
                case 1: s = "Goodbye, "; break;
                case 2: s = "Nice to see you, "; break;
                case 3: clear(); return 0;
                default: break;
            }
            writelog(s+mycontextmenu.targetId);
        } 

        function writelog(_text)
        {
            var _eventlog = document.getElementById("eventlog");
            _eventlog.innerHTML +="<div style='white-space:nowrap;'>"+_text+"</div>";
            _eventlog.scrollTop = 9999;
        } 
        function clear()
        {
            document.getElementById("eventlog").innerHTML = "";
        }      
                
        function OnSubTreeLoad_handle(sender, arg)
        {
            s="";
            treenodes = document.getElementsByClassName('mytreenode');
            for (var i=0; i<treenodes.length; i++) s += treenodes[i].id+",";
            mycontextmenu.attachTo(s);
        }
        
        mytreeview.registerEvent("OnSubTreeLoad", OnSubTreeLoad_handle);        

</script>
