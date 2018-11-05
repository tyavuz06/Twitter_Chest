<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolForm/koolform.php";	
	$myform_manager = new KoolForm("myform");
	$myform_manager->scriptFolder = $KoolControlsFolder."/KoolForm";	
	$myform_manager->styleFolder = "sunset";
	$myform_manager->DecorationEnabled = true;
	



	$action = new KoolSplitButton("action");

	/*Below are the full API of AddOption method. 
	 * 
	 $action->AddOption(array(	"Text"=>"View order",
									"Value"=>"View",
									"LeftImage"=>"/path/to/leftimage.png")
									"RightImage"=>"/path/to/rightimage.png")
									"LeftImageCss"=>"leftimage_css")
									"RightImageCss"=>"rightimage_css")
									"ButtonCss"=>"button_css")
									"ToolTip"=>"This is the button")
								);

	 */
	$action->AutoPostback = true;

	$action->AddOption(array(	"Text"=>"Accept",
								"Value"=>"accept_order",
								"LeftImage"=> $KoolControlsFolder."/KoolForm/icons/plain/check2.png",
								"ToolTip"=>"Accept the order"));

	$action->AddOption(array(	"Text"=>"View order",
								"Value"=>"view_order",
								"LeftImage"=> $KoolControlsFolder."/KoolForm/icons/plain/text.png",
								"ToolTip"=>"View details of the order"));

	$action->AddOption(array(	"Text"=>"Cancel",
								"Value"=>"cancel_order",
								"LeftImage"=> $KoolControlsFolder."/KoolForm/icons/plain/delete2.png",
								"ToolTip"=>"Cancel the order"));
								
	$action->OnClick = "action_click";							
	$myform_manager->AddControl($action);
	
	//Init form
	$myform_manager->Init();
?>

<form id="myform" method="post" class="decoration">
	
		<fieldset style="width:350px;padding-bottom:10px;padding-left:10px;margin-bottom:50px;">
			<legend><b>New order</b></legend>
			<table>
				<tr>
					<td style="width:70px;"><b>Name:</b></td>
					<td>John Smith</td>
				</tr>
				<tr>
					<td><b>Address:</b></td>
					<td>103 Old MorganTown Road, Bowling Green</td>
				</tr>
				<tr>
					<td><b>Product:</b></td>
					<td>Apple iPhone 4s</td>
				</tr>
			</table>
			<div style="margin-top:10px;">
				<?php echo $action->Render();?>						
			</div>
		</fieldset>

		<script type="text/javascript">
			function action_click(sender,args)
			{
				switch(sender.get_selected_value())
				{
					case "view_order":
						alert("You choose to view order detail.");
						break;
					case "cancel_order":
						alert("The order will be cancelled!");
						break;
					case "accept_order":
						alert("The order will be accepted!");
						break;
				}

			}
		</script>

	
	<?php echo $myform_manager->Render();?>
</form>