<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolSlideMenu/koolslidemenu.php";
		
	$ksm = new KoolSlideMenu("ksm");
	$ksm->scriptFolder =  $KoolControlsFolder."/KoolSlideMenu";	
	$ksm->addParent("root","company","Company",null,true);
	$ksm->addChild("company","about","About Us");
	$ksm->addChild("company","news","Company News");
	$ksm->addChild("company","contact","Contact us");

	$ksm->addParent("root","products","Products");
	$ksm->addChild("products","koolajax","KoolAjax");
	$ksm->addChild("products","kooltreeview","KoolTreeView");
	$ksm->addChild("products","KoolSlideMenu","KoolSlideMenu");	

	$ksm->addParent("root","services","Services");
	$ksm->addChild("services","outsourcing","Out-sourcing");
	$ksm->addChild("services","freelancer","Free-lancer");
	
	$ksm->singleExpand = true;
	$ksm->width="200px";
	
	$style_select = ( isset($_POST['style_select']) ) ? $_POST['style_select'] : "bluearrow";
	$ksm->styleFolder = $KoolControlsFolder."KoolSlideMenu/styles/$style_select";
?>
<form id="form1" method="post">
	<style type="text/css">
		.box
		{
			float:left;
			width:280px;
			height:180px;
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
		#style_select
		{
			width:100px;	
		}		
	</style>

	<div class="box">
		<?php echo $ksm->Render();?>		
	</div>
	<div class="box focus">	
		Select style:
		<select id="style_select" name="style_select" onchange="submit();">
			<option value="bluearrow"   <?php echo ( $style_select =='bluearrow') ? 'selected' : '' ;?> >Bluearrow</option>
			<option value="redgray"   <?php echo ( $style_select =='redgray') ? 'selected' : '' ;?> >Redgray</option>
			<option value="vista" <?php echo ( $style_select =='vista') ? 'selected' : '' ;?> >Vista</option>
			<option value="black" <?php echo ( $style_select =='black') ? 'selected' : '' ;?> >Black</option>
			<option value="redcaro" <?php echo ( $style_select =='redcaro') ? 'selected' : '' ;?> >Redcaro</option>
			<option value="darkgray" <?php echo ( $style_select =='darkgray') ? 'selected' : '' ;?> >Darkgray</option>
			<option value="green"   <?php echo ( $style_select =='green') ? 'selected' : '' ;?> >Green</option>
			<option value="outlook" <?php echo ( $style_select =='outlook') ? 'selected' : '' ;?> >Outlook</option>
			<option value="apple" <?php echo ( $style_select =='apple') ? 'selected' : '' ;?> >Apple</option>
			<option value="violet" <?php echo ( $style_select =='violet') ? 'selected' : '' ;?> >Violet</option>
			<option value="hay" <?php echo ( $style_select =='hay') ? 'selected' : '' ;?> >Hay</option>
			<option value="inox" <?php echo ( $style_select =='inox') ? 'selected' : '' ;?> >Inox</option>
			<option value="office2007" <?php echo ( $style_select =='office2007') ? 'selected' : '' ;?> >Office2007</option>
			<option value="silver" <?php echo ( $style_select =='silver') ? 'selected' : '' ;?> >Silver</option>
			<option value="simple" <?php echo ( $style_select =='simple') ? 'selected' : '' ;?> >Simple</option>
		</select>
	</div>
	<div class="clear"></div>
</form>
