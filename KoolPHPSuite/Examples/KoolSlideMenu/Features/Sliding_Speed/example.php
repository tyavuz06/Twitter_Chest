<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolSlideMenu/koolslidemenu.php";
	$ksm = new KoolSlideMenu("sm");
	$ksm->scriptFolder =  $KoolControlsFolder."/KoolSlideMenu";	
	$ksm->styleFolder = $KoolControlsFolder."KoolSlideMenu/styles/violet";
	$ksm->addParent("root","company","Company");
	$ksm->addChild("company","about","About Us");
	$ksm->addChild("company","news","Company News");
	$ksm->addChild("company","contact","Contact us");

	$ksm->addParent("root","products","Products");
	$ksm->addChild("products","koolajax","KoolAjax");
	$ksm->addChild("products","kooltreeview","KoolTreeView");
	$ksm->addChild("products","koolslidemenu","KoolSlideMenu");	
	
	$ksm->addParent("root","services","Services");
	$ksm->addChild("services","outsourcing","Out-sourcing");
	$ksm->addChild("services","freelancer","Free-lancer");	
	
	$ksm->width="150px";
	$ksm->singleExpand = true;	
	$ksm->slidingSpeed=5;

	
	$ksm2 = new KoolSlideMenu("sm2");	
	$ksm2->scriptFolder =  $KoolControlsFolder."/KoolSlideMenu";	
	$ksm2->styleFolder = $KoolControlsFolder."KoolSlideMenu/styles/violet";
	$ksm2->addParent("root","company2","Company");
	$ksm2->addChild("company2","about2","About Us");
	$ksm2->addChild("company2","news2","Company News");
	$ksm2->addChild("company2","contact2","Contact us");

	$ksm2->addParent("root","products2","Products");
	$ksm2->addChild("products2","koolajax2","KoolAjax");
	$ksm2->addChild("products2","kooltreeview2","KoolTreeView");
	$ksm2->addChild("products2","koolslidemenu2","KoolSlideMenu");	
	
	$ksm2->addParent("root","services2","Services");
	$ksm2->addChild("services2","outsourcing2","Out-sourcing");
	$ksm2->addChild("services2","freelancer2","Free-lancer");	
	
	$ksm2->width="150px";
	$ksm2->singleExpand = true;
	$ksm->slidingSpeed=15;
	
	
	$ksm3 = new KoolSlideMenu("sm3");	
	$ksm3->scriptFolder =  $KoolControlsFolder."/KoolSlideMenu";	
	$ksm3->styleFolder = $KoolControlsFolder."KoolSlideMenu/styles/violet";
	$ksm3->addParent("root","company3","Company");
	$ksm3->addChild("company3","about2","About Us");
	$ksm3->addChild("company3","news2","Company News");
	$ksm3->addChild("company3","contact2","Contact us");

	$ksm3->addParent("root","products3","Products");
	$ksm3->addChild("products3","koolajax2","KoolAjax");
	$ksm3->addChild("products3","kooltreeview2","KoolTreeView");
	$ksm3->addChild("products3","koolslidemenu2","KoolSlideMenu");	
	
	$ksm3->addParent("root","services3","Services");
	$ksm3->addChild("services3","outsourcing2","Out-sourcing");
	$ksm3->addChild("services3","freelancer2","Free-lancer");	
	
	$ksm3->width="150px";
	$ksm3->singleExpand = true;
	$ksm->slidingSpeed=30;
	
?>
<form id="form1" method="post">

	<style type="text/css">
	 .box
	 {
		  float:left;
		  width:200px;
		  height:auto;
		  padding : 10px;
	 }
	 .clear
	 {
	 	clear:both;
	 }
	</style>
	<div class="box">
		<div style="height:25px;" >
			<code style="color:blue;">$ksm->slidingSpeed=5;</code>
		</div>
		<?php echo $ksm->Render();?>
	</div>	
		
	<div class="box">
		<div style="height:25px;" >
			<code style="color:green;">$ksm->slidingSpeed=15;</code>
		</div>
		<?php echo $ksm2->Render();?>
	</div>
	
	<div class="box">
		<div style="height:25px;">
			<code style="color:orange;">$ksm->slidingSpeed=30;</code>
		</div>
		<?php echo $ksm3->Render();?>
	</div>
	<div class="clear"></div>
</form>
