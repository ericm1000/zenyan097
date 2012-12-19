<?php
/* 
Initital Writing: Eric Matthews
This is an example of the tree control with ability to maintain context via a
cookie in the browser. This is the only example I am offering in Php. My 
rationale with respect to zenyan is as follows...

- I am not offering an example using folders and such as zenyan already offer
a document management api (using these controls) and I do not wish to visually
create confusion between the two.
- I figure this control is full featured enough that you can readily implement 
it and delete the pieces you do not want.

But in the spirit and openness and freedom I desire for zenyan ...

...if you are looking for a toycode example to demonstrate more that is possible
in using this control you can view treeview.html.

*/

?>

<!DOCTYPE html>
<html>
<head>
<!--  Integrator: Eric Matthews  -->
<!--  Integration into the zenyan framework  -->
<!--  Example: Using JQuery treeview api      -->	
<!--  License: Dual licensed under the MIT and GPL license  -->                             
<!--  Credit:  John Resig for his JQuery api        -->
<!--           Jörn Zaefferer for this killer api   -->
<!--           Sample code pretty much intact of original example  -->     
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>jQuery treeView</title>
	
	<link rel="stylesheet" href="../jquery/stylesheet/jquery.treeview.css" />
	<script src="../jquery/jquery182.min.js" type="text/javascript"></script>
	<script src="../jquery/jquery.cookie.js" type="text/javascript"></script>
	<script src="../jquery/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="../treeview.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="../stylesheet/mncontent_sansserif.css">	
	</head>
	<body>

	<h4>Sample - Tree with cookie-based persistance</h4>
  <p>To see, make a change and refresh the browser</p>	

	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="">
			<img src="../jquery/stylesheet/images/minus.gif" />&nbsp;Collapse All&nbsp;&nbsp;</a>
		<a title="Expand the entire tree below" href="">
			<img src="../jquery/stylesheet/images/plus.gif" />&nbsp;Expand All</a>
	</div>
	<ul id="black" class="treeview-black">
		<li>Item One</li>
		<li>
			<span>Item Two</span>
			<ul>
				<li class="closed">
					<span>Item Two (initially closed)</span>
					<ul>
						<li>Item Two, Subitem One</li>
						<li>Item Two, Subitem Two</li>
					</ul>
				</li>
				<li>Item Three</li>
				<li>Item Four</li>
				<li>Item Five</li>
				<li>Item Six</li>
				<li>Item Seven</li>
				<li>Item Eight</li>
				<li>Item Nine</li>
				<li>Item Ten</li>
				<li>
					<span>Item Eleven</span>
					<ul>
						<li>Subitem One</li>
						<li>Subitem Two</li>
						<li>Subitem Three</li>
						<li>Subitem Four</li>
					</ul>
				</li>
				<li>
					<span>Item Twelve</span>
					<ul>
						<li>Subitem One</li>
						<li>Subitem Two</li>
						<li>Subitem Three</li>
						<li>Subitem Four</li>
						<li>Subitem Five</li>
						<li>Subitem Six</li>
					</ul>
				</li>
			</ul>
		</li>
		<li>Item Thirteen</li>
	</ul>	


 
</body></html>