<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
    require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<script type="text/javascript" src="<?php echo $KoolControlsFolder; ?>/KoolAjax/koolajax_extension.js"></script>
	<style>
		#target
		{
			width:655px;
			border:dotted 1px gray;
			min-height:50px;
			padding:10px;
		}
	</style>
		
		<div id="target"></div>

		<script type="text/javascript">
			function load_treeview()
			{
				koolajax.load("tree.php",handle_ondone);
			}
			function load_listbox()
			{
				koolajax.load("listbox.php",handle_ondone);
			}
			function handle_ondone(result)
			{
				var _target = document.getElementById("target");
				_target.innerHTML = result;
				run_script_in_element("target");//This function is inside koolajax_extension.js
			}
		</script>

		<input type="button" value="Load TreeView" onclick="load_treeview()" />
		<input type="button" value="Load ListBox" onclick="load_listbox()" />

</form>


