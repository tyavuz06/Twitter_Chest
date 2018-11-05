<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolForm/koolform.php";
	//Create KoolForm object. The parameter is the name of the form that you want to decorate.
	$myform_manager = new KoolForm("myform");
	$myform_manager->scriptFolder = $KoolControlsFolder."/KoolForm";
	
	
	$form_decoration_enabled = "1";
	if(isset($_POST["form_decoration_enabled"]))
	{
		$form_decoration_enabled = $_POST["form_decoration_enabled"];
	}
	
	$selectStyle = "sunset";
	if(isset($_POST["selectStyle"]))
	{
		$selectStyle = $_POST["selectStyle"];
	}
	
	//Set DecorationEnabled to enable/disable form decoration
	$myform_manager->DecorationEnabled = ($form_decoration_enabled=="1")?true:false;
	//Set the style for the form
	$myform_manager->styleFolder = $selectStyle;
	
	//The form need to be init.
	$myform_manager->Init();
?>
<form id="myform" method="post" class="decoration">
	
	
	<div style="width:660px;margin-bottom:20px;">
		<input id="radioEnabled" type="radio" name="form_decoration_enabled" value="1" onclick="submit()" <?php echo ($form_decoration_enabled=="1")?"checked":""; ?> ><label for="radioEnabled">Enable Form Decoration</label>				
		<input id="radioDisabled" type="radio" name="form_decoration_enabled" value="0" onclick="submit()" <?php echo ($form_decoration_enabled=="0")?"checked":""; ?>  ><label for="radioDisabled">Disable Form Decoration</label>
		<div style="float:right">
				<select id="selectStyle" name="selectStyle" onchange="submit()">
					<option <?php echo ($selectStyle=="default")?"selected":""; ?> value="default">Default</option>
					<option <?php echo ($selectStyle=="forest")?"selected":""; ?> value="forest">Forest</option>
					<option <?php echo ($selectStyle=="hay")?"selected":""; ?> value="hay">Hay</option>
					<option <?php echo ($selectStyle=="office2007")?"selected":""; ?> value="office2007">Office2007</option>
					<option <?php echo ($selectStyle=="office2010blue")?"selected":""; ?> value="office2010blue">Office 2010 Blue</option>
					<option <?php echo ($selectStyle=="office2010silver")?"selected":""; ?> value="office2010silver">Office 2010 Silver</option>
					<option <?php echo ($selectStyle=="outlook")?"selected":""; ?> value="outlook">Outlook</option>
					<option <?php echo ($selectStyle=="sunset")?"selected":""; ?> value="sunset">Sunset</option>
					<option <?php echo ($selectStyle=="vista")?"selected":""; ?> value="vista">Vista</option>
					<option <?php echo ($selectStyle=="web20")?"selected":""; ?> value="web20">Web 2.0</option>
					<option <?php echo ($selectStyle=="windows7")?"selected":""; ?> value="windows7">Windows 7</option>
				</select>	
		</div>
	</div>
	<div style="clear:both;"></div>
	<fieldset style="width:640px;margin-bottom:10px;padding:0px 10px 10px 5px;">
		<legend>Survey form</legend>
		<div style="width:200px;float:left;padding:10px;">
			<h5>What are your hobbies?</h5>
			<hr />
			<input id="check1" type="checkbox" checked /><label for="check1">Football</label>
			<br />
			<input id="check2" type="checkbox" checked /><label for="check2">Soccer</label>
			<br />
			<input id="check3" type="checkbox" /><label for="check3">Tennis</label>
			<br />
			<input id="check4" type="checkbox" /><label for="check4">Basketball</label>
			<br />
			<input id="check5" type="checkbox" /><label for="check5">Volleyball</label>
			<br />			
		</div>
			
		<div style="width:200px;float:right;padding:10px;">
			<h5>What is the best phone?</h5>
			<hr />
			<select id="select">
				<option>Iphone 4S</option>				
				<option>Samsung Galazy S2</option>				
				<option>Nokia Lumia 900</option>				
			</select>
		</div>		

		<div style="padding:10px;">
			<h5>What is your age?</h5>
			<hr />
			<input id="radio1" type="radio" name="age"  /><label for="radio1">Below 18</label>
			<br />
			<input id="radio2" type="radio" name="age" /><label for="radio2">18-22</label>
			<br />
			<input id="radio3" type="radio" name="age" checked /><label for="radio3">23-29</label>
			<br />
			<input id="radio4" type="radio" name="age" /><label for="radio4">30-39</label>
			<br />
			<input id="radio5" type="radio" name="age" /><label for="radio5">40-59</label>
			<br />
			<input id="radio6" type="radio" name="age" /><label for="radio6">60 & above</label>
			<br />
		</div>		
		<div style="clear:both;"></div>
		<input type="submit" value="Submit"/>
	</fieldset>
		
<div style="width:660px;">
	<fieldset style="width:300px;float:left;height:70px;padding:0px 10px 10px 5px;">
		<legend>Textboxes</legend>
		
		<table style="border-collapse:separate;border-spacing:4px;">
			<tr>
				<td>Username:</td>
				<td><input id="txtName" name="txtName" type="text"/></td>				
			</tr>
			<tr>
				<td>Password:</td>
				<td><input id="txtPassword" name="txtAge" type="password"/></td>				
			</tr>		
		</table>
	</fieldset>	
	<fieldset style="width:300px;float:right;height:70px;padding:0px 10px 10px 5px;">
		<legend>Textarea</legend>
		<textarea style="width:250px;height:50px;"> </textarea>
				
	</fieldset>
	<div style="clear:both;"></div>		
</div>
	
		
	
	<?php echo $myform_manager->Render();?>
</form>
