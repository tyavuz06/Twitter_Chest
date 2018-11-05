<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
		
	$ktv1 = new KoolTreeView("ktv1");
	$ktv1->scriptFolder = $KoolControlsFolder."/KoolTreeView";
	$ktv1->imageFolder="Images";
	$ktv1->styleFolder="default";
	$ktv1->showLines = true;
	
	//Create TreeView 1
	$root = $ktv1->getRootNode();
	$root->text = "Personal Folders";
	$root->expand=true;
	$root->image="1PersonalFolders.gif";
	$ktv1->Add("root","deleteditem","Deleted Items (6)",false,"2DeletedItems.gif");
	$ktv1->Add("root","draft","Drafts",false,"3Drafts.gif");
	$ktv1->Add("root","inbox","<b>Inbox (14)</b>",true,"4Inbox.gif");
	$ktv1->Add("inbox","invoice","Invoices",false,"folder.gif");
	
	$ktv1->Add("root","junkemail","Junk E-mail",false,"folder.gif");
	$ktv1->Add("root","outbox","Outbox",false,"outbox.gif");
	$ktv1->Add("root","sentitem","Sent Items",false,"sent.gif");
	$ktv1->Add("root","searchfolder","Search Folder",true,"searchFolder.gif");
	$ktv1->Add("searchfolder","followup","From Follow Up",false,"searchFolder.gif");
	$ktv1->Add("searchfolder","largeemail","Large E-mail",false,"searchFolder.gif");
	$ktv1->Add("searchfolder","unreademail","Unread E-mail",false,"searchFolder.gif");

	$ktv1->DragAndDropEnable = true;

	//Create TreeView 2
	$ktv2 = new KoolTreeView("ktv2");
	$ktv2->scriptFolder = $KoolControlsFolder."/KoolTreeView";
	$ktv2->imageFolder="Images";
	$ktv2->styleFolder="default";
	$ktv2->showLines = true;
	
	$root = $ktv2->getRootNode();
	$root->text = "Personal Folders";
	$root->expand=true;
	$root->image="1PersonalFolders.gif";
	$ktv2->Add("root","deleteditem2","Deleted Items (6)",false,"2DeletedItems.gif");
	$ktv2->Add("root","draft2","Drafts",false,"3Drafts.gif");
	$ktv2->Add("root","inbox2","<b>Inbox (14)</b>",true,"4Inbox.gif");
	$ktv2->Add("inbox2","invoice2","Invoices",false,"folder.gif");
	
	$ktv2->Add("root","junkemail2","Junk E-mail",false,"folder.gif");
	$ktv2->Add("root","outbox2","Outbox",false,"outbox.gif");
	$ktv2->Add("root","sentitem2","Sent Items",false,"sent.gif");
	$ktv2->Add("root","searchfolder2","Search Folder",true,"searchFolder.gif");
	$ktv2->Add("searchfolder2","followup2","From Follow Up",false,"searchFolder.gif");
	$ktv2->Add("searchfolder2","largeemail2","Large E-mail",false,"searchFolder.gif");
	$ktv2->Add("searchfolder2","unreademail2","Unread E-mail",false,"searchFolder.gif");

	$ktv2->DragAndDropEnable = true;

?>


<table style="width:400px;">
	<tr>
		<td style="border-right:solid 1px gray;padding-left:20px;">KoolTreeView 1</td>
		<td style="padding-left:20px;">KoolTreeView 2</td>
	</tr>
	<tr>
		<td valign="top" style="border-right:solid 1px gray;">
			<div style="padding:10px;padding-left:30px;width:170px;">
				<?php echo $ktv1->Render();?>
			</div>			
		</td>
		<td valign="top">
			<div style="padding:10px;padding-left:30px;width:200px;">
				<?php echo $ktv2->Render();?>
			</div>			
		</td>
	</tr>
</table>