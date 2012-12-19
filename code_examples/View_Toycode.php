<?php
/* 
Initital Writing: Eric Matthews
This is the index hosting the available zenyan UI Toycode.
*/

?>

<!DOCTYPE html>
<html>
<head>  
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>zenyan UI Templates</title>
	
	<link rel="stylesheet" href="../jquery/stylesheet/jquery.treeview.css" />
	
	<script src="../jquery/jquery182.min.js" type="text/javascript"></script>
	<script src="../jquery/jquery.cookie.js" type="text/javascript"></script>
	<script src="../jquery/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="treeview.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="../stylesheet/mncontent_sansserif.css">	
	</head>
	<body>

	<h4>zenyan UI JQuery Toycode Examples</h4>
  <p>
These are zenyan UI toycode examples using JQuery. They will open in a new window or tab
(depending on your browser, and how it is configured.)
</p>	
	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="">
			<img src="../jquery/stylesheet/images/minus.gif" />&nbsp;Collapse All&nbsp&nbsp</a>
		<a title="Expand the entire tree below" href="">
			<img src="../jquery/stylesheet/images/plus.gif" />&nbsp;Expand All</a>
	</div>
	
	<ul id="black" class="treeview-black">

		<li class="open">	
			<span>Date Picker Control</span>
					<ul>
						<li><a href="toycode_ui_datePicker.php" target="_blank">Date Picker</a></li>
						<li><a href="toycode_ui_datePicker_persistence.php" target="_blank">Date Picker with persistance</a></li>
					</ul>
		</li>

		<li class="open">
			<span>Treeviewer Control</span>
			    <ul>
		       <li><a href="toycode_ui_treeview_cookie_persistence.php" target="_blank">Treeview with Persistance</a></li>	
		       <li><a href="treeview.html" target="_blank">Different Treeview examples</a></li>
	        </ul>
		</li>	
		
	</ul>	


 
</body></html>