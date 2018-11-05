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
	$ksm->styleFolder = $KoolControlsFolder."KoolSlideMenu/styles/redcaro";
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
	
	$ksm->width="200px";
	$ksm->singleExpand = false;	
?>
<div style="height:250px;width:650px;">
	<style type="text/css">	
	div.fl {	float:left; color:#ccc;}
	.fl a { color:#ccc;  cursor:pointer;}
	.fl a:link { color:#ccc;  }
	.fl a:hover { color:#fff;  }
	</style>	
	<div style="background-color:#343434;  width:600px; height:250px; ">	
		<div class="fl" >
			<?php echo $ksm->Render();?></div>
		<div style="float:left; background-color:#ccc; height:250px;">&nbsp;</div>
		<div class="fl" style=" padding :15px;" id="content">
			Site map : <br /><br />
			<div style="padding-left:15px">
			<a onclick="expand( 'company' );" >Company</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'about' , 'company' )" >About us</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'news' , 'company' )" >Company news</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'contact' , 'company' )" >Contact us</a><br />
			<a onclick="expand( 'products' );" >Products</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'koolajax' , 'products' )" >KoolAjax</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'kooltreeview' , 'products' )" >KoolTreeView</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'koolslidemenu' , 'products' )" >KoolSlideMenu</a><br />
			<a onclick="expand( 'services' );" >Services</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'outsourcing' , 'services' )" >Out-sourcing</a><br />
			&nbsp;&nbsp;|_<a onclick="select( 'freelancer' , 'services' )" >Free-lancer</a>	<br />	
			</div>			
		</div>
	</div>
	<br style="clear:both;" />
</div>
<script language="javascript">
function expand( id ){
	if (ksm.getItem( id ).isExpanded())
	{
		 ksm.getItem( id ).collapse();
	}else{
		ksm.getItem( id ).expand();
	}	
}
function select( id  , parent ){
	ksm.getItem( parent ).expand();
	ksm.getItem( id ).select();
}
</script>

