<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolSlideMenu/koolslidemenu.php";
	require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
	
	$hardware_tree = new KoolTreeView("hardware_tree");
	$hardware_tree->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	$hardware_tree->styleFolder=$KoolControlsFolder."/KoolTreeView/styles/default";	
    $hardware_tree->getRootNode()->visible = false;
    $hardware_tree->getRootNode()->expand = true;	
	$hardware_tree->Add("root","laptop","HP dv2500 Laptop",false,"square_blueS.gif","");	
	$hardware_tree->Add("root","desktop","Lenovo desktop",false,"square_greenS.gif","");
	$hardware_tree->Add("root","lcd","Asus 19\" LCD",false,"square_redS.gif","");
	$hardware_tree->showLines = true;
	
	//Create software treeview
	$software_tree = new KoolTreeView("software_tree");
	$software_tree->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	$software_tree->styleFolder=$KoolControlsFolder."/KoolTreeView/styles/default";	
    $software_tree->getRootNode()->visible = false;
    $software_tree->getRootNode()->expand = true;	
	$software_tree->Add("root","os","Operating System",true,"bfly.gif","");
	$software_tree->Add("os","linux","Ubuntu 8.10",false,"ball_redS.gif","");
	$software_tree->Add("os","windows","Vista Home Edition",false,"ball_blueS.gif","");
	$software_tree->Add("root","office","Office",false,"doc.gif","");
	$software_tree->Add("office","msoffice","Microsoft Office 2007",false,"square_redS.gif","");
	$software_tree->Add("office","ooffice","Open Office 2.4",false,"square_greenS.gif","");
	$software_tree->Add("root","burning","Burn CD/DVD",false,"xpShared.gif","");
	$software_tree->Add("burning","nero","Nero 8",false,"triangle_yellowS.gif","");
	$software_tree->Add("burning","k3b","K3B <i>(on Ubuntu)</i>",false,"triangle_blueS.gif","");
	$software_tree->Add("root","imageeditor","Image editors",false,"goblet_bronzeS.gif","");
	$software_tree->Add("imageeditor","photoshop","Photoshop 10",false,"ball_glass_blueS.gif","");
	$software_tree->Add("imageeditor","gimp","GIMP 2.3.4",false,"ball_glass_greenS.gif","");
	$software_tree->showLines = true;
	
	//Create books treeview
	$books_tree = new KoolTreeView("books_tree");
	$books_tree->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	$books_tree->styleFolder=$KoolControlsFolder."/KoolTreeView/styles/default";
    $books_tree->getRootNode()->visible = false;
	$books_tree->getRootNode()->expand = true;		
	$books_tree->Add("root","ajax","Ajax For Dummies",false,"BookY.gif","");
	$books_tree->Add("root","csharp","Mastering C#",false,"BookY.gif","");
	$books_tree->Add("root","flash","Flash 8 Bible",false,"BookY.gif","");
	$books_tree->showLines = true;		
	

	//Create SlideMenu
	$ksm = new KoolSlideMenu("sm");
	$ksm->styleFolder = $KoolControlsFolder."/KoolSlideMenu/styles/bluearrow";
	
	//Create parent hardware and add hardware tree inside subpanel
	$ksm->addParent("root","hardware","Hardware","",true);
	$ksm->addPanel("hardware","hardware_tree_panel",$hardware_tree->Render());

	//Create parent software and add software tree inside subpanel
	$ksm->addParent("root","software","Software");
	$ksm->addPanel("software","software_tree_panel",$software_tree->Render());
	//Create parent books and add books tree inside subpanel
	$ksm->addParent("root","books","Books");
	$ksm->addPanel("books","books_tree_panel",$books_tree->Render());
	
	$ksm->singleExpand = true;
	$ksm->width="200px";
	
?>
<form id="form1" method="post">
	<div style="padding-left:10px">
		<?php echo $ksm->Render();?>
	</div>
</form>
