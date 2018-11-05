<?php
  $tpl_main = "<table cellpadding='0' cellspacing='0' style='width:100%;height:100%;table-layout: fixed;'><tr><td class='kulContainerCover'>{container}</td></tr><tr><td style='height:40px;' valign='middle'>{btnAdd}{btnUploadAll}{btnClearAll}</td></tr><tr class='kulMessage' style='display:none; height:40px;white-space:normal;'><td></td></tr></table>";
  $tpl_item = "<div class='kulLeft'>{thumbnail}{description}</div><div class='kulRight'>{btnDelete}{btnCancel}{btnUpload}{btnRemove}</div><div class='kulMiddle'>{filename}{progress}{status}</div>";
  $tpl_btnAdd = "<span class='kulText'>{btncontent}</span>";
  $tpl_btnUploadAll = "<span class='kulText'>{btncontent}</span>";
  $tpl_btnClearAll = "<span class='kulText'>{btncontent}</span>";
  $tpl_btnUpload = "<span class='kulText'>{btncontent}</span>";
  $tpl_btnRemove = "<span class='kulText'>{btncontent}</span>";
  $tpl_btnCancel = "<span class='kulText'>{btncontent}</span>";	
  $tpl_btnDelete = "<span class='kulText'>{btncontent}</span>";
  $tpl_AddFileString = "Add file";
  $error_message1 = 'Files for the following descriptions are missing';
  $error_message2 = 'Please upload files for all descriptions before saving, thanks!';
?>