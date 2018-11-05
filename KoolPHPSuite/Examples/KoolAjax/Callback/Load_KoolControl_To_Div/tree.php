<?php
				$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder

				require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";

				$control = new KoolTreeView("control");
				$control->scriptFolder = $KoolControlsFolder."/KoolTreeView";
				$control->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
				$control->styleFolder="default";
				
				$root = $control->getRootNode();
				$root->text = "My Properties";
				$root->expand=true;
				$root->image="woman2S.gif";
				$control->Add("root","hardware","Hardware",false,"xpNetwork.gif","");
				$control->Add("hardware","laptop","HP dv2500 Laptop",false,"square_blueS.gif","");	
				$control->Add("hardware","desktop","Lenovo desktop",false,"square_greenS.gif","");
				$control->Add("hardware","lcd","Asus 19\" LCD",false,"square_redS.gif","");
				
				$control->Add("root","software","Software",true,"ie.gif","");
				$control->Add("software","os","Operating System",true,"bfly.gif","");
				$control->Add("os","linux","Ubuntu 8.10",false,"ball_redS.gif","");
				$control->Add("os","windows","Vista Home Edition",false,"ball_blueS.gif","");
				$control->Add("software","office","Office",false,"doc.gif","");
				$control->Add("office","msoffice","Microsoft Office 2007",false,"square_redS.gif","");
				$control->Add("office","ooffice","Open Office 2.4",false,"square_greenS.gif","");
				$control->Add("software","burning","Burn CD/DVD",false,"xpShared.gif","");
				$control->Add("burning","nero","Nero 8",false,"triangle_yellowS.gif","");
				$control->Add("burning","k3b","K3B <i>(on Ubuntu)</i>",false,"triangle_blueS.gif","");
				$control->Add("software","imageeditor","Image editors",false,"goblet_bronzeS.gif","");
				$control->Add("imageeditor","photoshop","Photoshop 10",false,"ball_glass_blueS.gif","");
				$control->Add("imageeditor","gimp","GIMP 2.3.4",false,"ball_glass_greenS.gif","");
				
				$control->Add("root","book","Books",false,"book.gif","");
				$control->Add("book","ajax","Ajax For Dummies",false,"BookY.gif","");
				$control->Add("book","csharp","Mastering C#",false,"BookY.gif","");
				$control->Add("book","flash","Flash 8 Bible",false,"BookY.gif","");
				$control->showLines = true;

				echo $control->Render();
?>
