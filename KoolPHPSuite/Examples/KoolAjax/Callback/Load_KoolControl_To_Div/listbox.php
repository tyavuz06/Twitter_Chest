<?php
				$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder

				require $KoolControlsFolder."/KoolListBox/koollistbox.php";
				$control = new KoolListBox("control");
				$control->styleFolder ="default";
				$control->AddItem(new ListBoxItem("Agentina"));
				$control->AddItem(new ListBoxItem("Australia"));
				$control->AddItem(new ListBoxItem("Brazil"));
				$control->AddItem(new ListBoxItem("Canada"));
				$control->AddItem(new ListBoxItem("Chile"));
				$control->AddItem(new ListBoxItem("China"));
				$control->AddItem(new ListBoxItem("Egypt"));
				$control->AddItem(new ListBoxItem("England"));
				$control->AddItem(new ListBoxItem("France"));
				$control->AddItem(new ListBoxItem("Germany"));
				$control->AddItem(new ListBoxItem("India"));
				$control->AddItem(new ListBoxItem("Indonesia"));
				$control->AddItem(new ListBoxItem("Kenya"));
				$control->AddItem(new ListBoxItem("Mexico"));
				$control->AddItem(new ListBoxItem("New Zealand"));
				$control->AddItem(new ListBoxItem("South Africa"));
				$control->AddItem(new ListBoxItem("USA"));
				
				$control->ButtonSettings->ShowDelete = true;
				$control->ButtonSettings->ShowReorder = true;
				
				$control->Init();
				echo $control->Render();
?>
