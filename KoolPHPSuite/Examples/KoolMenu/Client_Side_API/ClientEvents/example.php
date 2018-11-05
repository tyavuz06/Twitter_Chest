<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolMenu/koolmenu.php";
	
	$km = new KoolMenu("km");
	$km->scriptFolder = $KoolControlsFolder."/KoolMenu";
	$km->styleFolder="default";
	
	$km->Add("root","file","File");
	
	$km->Add("file","new","New...");
	$km->Add("new","newfile","File");
	$km->Add("new","newfolder","Folder");
	$km->AddSeparator("file");
	$km->Add("file","open","Open");
	$km->Add("file","close","Close");
	$km->Add("file","save","Save");
	$item = $km->Add("file","saveas","Save as ...");
	$item->Enabled = false;

	$km->Add("file","permission","Permission");

	$km->Add("permission","unrestrict","Unrestricted Access");
	$km->Add("permission","donotattribute","Do not attribute");
	
	$km->Add("root","edit","Edit");
	
	$km->Add("edit","cut","Cut");
	$km->Add("edit","copy","Copy");
	$km->Add("edit","paste","Paste");

	$km->Add("root","view","View");

	$km->Add("view","normal","Normal");
	$km->Add("view","print","Print");
	$km->Add("view","weblayout","Web Layout");
	
	$item = $km->Add("root","help","Help");
	$item->Enabled = false;	

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
		#eventlog
		{
			overflow:auto;
			overflow-x:hidden;
			height : 150px;
			width : 280px;
		}	
	</style>

	<div class="box">
		<?php echo $km->Render();?>		
	</div>
	<div class="box focus">
		<b>Client-side events:  </b><hr/>
		<div id="eventlog"></div>		
	</div>
	<div class="clear"></div>
		
	<script type="text/javascript">
		km.registerEvent("OnBeforeItemSelect",function(sender,arg){
			
			if (confirm("Select ["+arg.ItemId+"] item?"))
			{
				writelog("Selecting " + arg.ItemId + " was approved");	
				return true;
			}
			else
			{
				writelog("Selecting " + arg.ItemId + " was cancelled");	
				return false;
				
			}						
		});

		km.registerEvent("OnItemSelect",function(sender,arg){
			writelog("<b>" + arg.ItemId + "</b> is selected");
		});
		
		km.registerEvent("OnItemExpand",function(sender,arg){
			writelog("<b>" + arg.ItemId + "</b> is expanded");
		});
		km.registerEvent("OnItemCollapse",function(sender,arg){
			writelog("<b>" + arg.ItemId + "</b> is collapsed.");
		});
		function writelog(_text)
		{
			var _eventlog = document.getElementById("eventlog");
			_eventlog.innerHTML +="<div style='white-space:nowrap;'>"+_text+"</div>";
			_eventlog.scrollTop = 9999;
		}		
	</script>
</form>
