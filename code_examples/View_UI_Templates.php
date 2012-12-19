<?php
/* 
Initital Writing: Eric Matthews
This is the index hosting the available zenyan UI templates.
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

	<h4>zenyan UI Templates</h4>
  <p>These are zenyan UI page templates to morph specific to you application
  	development endeavors and reuse.</p>	
	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="">
			<img src="../jquery/stylesheet/images/minus.gif" />&nbsp;Collapse All&nbsp;&nbsp;</a>
		<a title="Expand the entire tree below" href="">
			<img src="../jquery/stylesheet/images/plus.gif" />&nbsp;Expand All</a>
	</div>
	<ul id="black" class="treeview-black">
		<li><a href="template_base.php" target="_blank">Baseline Template</a></li>
		<li>
			<span>Template Derivations</span>
			<ul>
					<ul>
						<li><a href="template_tabs.php" target="_blank">Baseline Template with three tabs</a></li>
					</ul>
				</li>
	</ul>	
	

 
</body></html>