<?php
   session_start();
   
//  
   require('eConfig/envref.php');
   include($php_cLib);
   include($php_envvars);
   include($php_dbms);  //dbms specific to app
   include($php_applib);
   include($php_loggers);  
  
   $_SESSION['oldebug'] = "";
   $_SESSION['tmp'] = $debugapp;

check_referring_pg($refpg);

function check_referring_pg($refpg){  
   global $Scontxttoll;
 //if referring page context is required you code conditional here as wrapper to below conditional                
//// commented out during development ////
   if ($_SESSION['initentry'] == $Scontxttoll) { 
 	
   }
   else {  $_SESSION['loginerr'] = 'Login required to access page';  header("Location: login.php");  exit; }
}   
   
?>
<!DOCTYPE html>
<html>
<head>
<!--  Integrator: Eric Matthews  -->
<!--  Integration into the zenyan framework  -->
<!--  Example: Using JQuery treeview api      -->	
<!--  License: Dual licensed under the MIT and GPL license  -->                             
<!--  Credit:  John Resig for his JQuery api        -->
<!--           J�rn Zaefferer for this killer api   -->
<!--           Sample code pretty much intact of original example  -->     
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>jQuery treeView</title>

	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->

	<link rel="stylesheet" href="jquery/stylesheet/jquery.treeview.css" />
	
	<script src="jquery/jquery182.min.js" type="text/javascript"></script>
	<script src="jquery/jquery.cookie.js" type="text/javascript"></script>
	<script src="jquery/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="treeview.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
	<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:626px;
	height:4097px;
	z-index:1;
	left: 26px;
	top: 23px;
}
-->
    </style>
</head>
	<body>

<?php
  include('jquery/topmenu.php');
?> 
<div id="Layer1">
<h1>Treeviewer Example</h1>

	<div id="main">
	
	<h4>Sample 0 - navigation</h4>
	
	<ul id="navigation">
		<li><a href="?1">Item 1</a>
			<ul>
				<li><a href="?1.0">Item 1.0</a>
					<ul>
						<li><a href="?1.0.0">Item 1.0.0</a></li>
					</ul>
				</li>
				<li><a href="?1.1">Item 1.1</a></li>
				<li><a href="?1.2">Item 1.2</a>
					<ul>
						<li><a href="?1.2.0">Item 1.2.0</a>
						<ul>
							<li><a href="?1.2.0.0">Item 1.2.0.0</a></li>
							<li><a href="?1.2.0.1">Item 1.2.0.1</a></li>
							<li><a href="?1.2.0.2">Item 1.2.0.2</a></li>
						</ul>
					</li>
						<li><a href="?1.2.1">Item 1.2.1</a>
						<ul>
							<li><a href="?1.2.1.0">Item 1.2.1.0</a></li>
						</ul>
					</li>
						<li><a href="?1.2.2">Item 1.2.2</a>
						<ul>
							<li><a href="?1.2.2.0">Item 1.2.2.0</a></li>
							<li><a href="?1.2.2.1">Item 1.2.2.1</a></li>
							<li><a href="?1.2.2.2">Item 1.2.2.2</a></li>
						</ul>
					</li>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="?2">Item 2</a>
			<ul>
				<li><span>Item 2.0</span>
					<ul>
						<li><a href="?2.0.0">Item 2.0.0</a>
						<ul>
							<li><a href="?2.0.0.0">Item 2.0.0.0</a></li>
							<li><a href="?2.0.0.1">Item 2.0.0.1</a></li>
						</ul>
					</li>
					</ul>
				</li>
				<li><a href="?2.1">Item 2.1</a>
					<ul>
						<li><a href="?2.1.0">Item 2.1.0</a>
						<ul>
							<li><a href="?2.1.0.0">Item 2.1.0.0</a></li>
						</ul>
					</li>
						<li><a href="?2.1.1">Item 2.1.1</a>
						<ul>
							<li><a href="?2.1.1.0abc">Item 2.1.1.0</a></li>
							<li><a href="?2.1.1.1">Item 2.1.1.1</a></li>
							<li><a href="?2.1.1.2">Item 2.1.1.2</a></li>
						</ul>
					</li>
						<li><a href="?2.1.2">Item 2.1.2</a>
						<ul>
							<li><a href="?2.1.2.0">Item 2.1.2.0</a></li>
							<li><a href="?2.1.2.1">Item 2.1.2.1</a></li>
							<li><a href="?2.1.2.2">Item 2.1.2.2</a></li>
						</ul>
					</li>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="?3">Item 3</a>
			<ul>
				<li class="open"><a href="?3.0">Item 3.0</a>
					<ul>
						<li><a href="?3.0.0">Item 3.0.0</a></li>
						<li><a href="?3.0.1">Item 3.0.1</a>
							<ul>
								<li><a href="?3.0.1.0">Item 3.0.1.0</a></li>
								<li><a href="?3.0.1.1">Item 3.0.1.1</a></li>
							</ul>
						</li>
						<li><a href="?3.0.2">Item 3.0.2</a>
							<ul>
								<li><a href="?3.0.2.0">Item 3.0.2.0</a></li>
								<li><a href="?3.0.2.1">Item 3.0.2.1</a></li>
								<li><a href="?3.0.2.2">Item 3.0.2.2</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
	
	
	<h4>Sample 1 - default</h4>
	<ul id="browser" class="filetree">
		<li><span class="folder">Folder 1</span>
			<ul>
				<li><span class="file">Item 1.1</span></li>
			</ul>
		</li>
		<li><span class="folder">Folder 2</span>
			<ul>
				<li><span class="folder">Subfolder 2.1</span>
					<ul id="folder21">
						<li><span class="file">File 2.1.1</span></li>
						<li><span class="file">File 2.1.2</span></li>
					</ul>
				</li>
				<li><span class="file">File 2.2</span></li>
			</ul>
		</li>
		<li class="closed"><span class="folder">Folder 3 (closed at start)</span>
			<ul>
				<li><span class="file">File 3.1</span></li>
			</ul>
		</li>
		<li><span class="file">File 4</span></li>
	</ul>
	
	<h4>Sample 2 - fast animations, all branches collapsed at first, red theme, cookie-based persistance</h4>
	<ul id="red" class="treeview-red">
	<li><span>Item 1</span>
		<ul>
			<li><span>Item 1.0</span>
				<ul>
					<li><span>Item 1.0.0</span></li>
				</ul>
			</li>
			<li><span>Item 1.1</span></li>
			<li><span>Item 1.2</span>
				<ul>
					<li><span>Item 1.2.0</span>
					<ul>
						<li><span>Item 1.2.0.0</span></li>
						<li><span>Item 1.2.0.1</span></li>
						<li><span>Item 1.2.0.2</span></li>
					</ul>
				</li>
					<li><span>Item 1.2.1</span>
					<ul>
						<li><span>Item 1.2.1.0</span></li>
					</ul>
				</li>
					<li><span>Item 1.2.2</span>
					<ul>
						<li><span>Item 1.2.2.0</span></li>
						<li><span>Item 1.2.2.1</span></li>
						<li><span>Item 1.2.2.2</span></li>
					</ul>
				</li>
				</ul>
			</li>
		</ul>
	</li>
	<li><span>Item 2</span>
		<ul>
			<li><span>Item 2.0</span>
				<ul>
					<li><span>Item 2.0.0</span>
					<ul>
						<li><span>Item 2.0.0.0</span></li>
						<li><span>Item 2.0.0.1</span></li>
					</ul>
				</li>
				</ul>
			</li>
			<li><span>Item 2.1</span>
				<ul>
					<li><span>Item 2.1.0</span>
					<ul>
						<li><span>Item 2.1.0.0</span></li>
					</ul>
				</li>
					<li><span>Item 2.1.1</span>
					<ul>
						<li><span>Item 2.1.1.0</span></li>
						<li><span>Item 2.1.1.1</span></li>
						<li><span>Item 2.1.1.2</span></li>
					</ul>
				</li>
					<li><span>Item 2.1.2</span>
					<ul>
						<li><span>Item 2.1.2.0</span></li>
						<li><span>Item 2.1.2.1</span></li>
						<li><span>Item 2.1.2.2</span></li>
					</ul>
				</li>
				</ul>
			</li>
		</ul>
	</li>
	<li class="open"><span>Item 3</span>
		<ul>
			<li class="open"><span>Item 3.0</span>
				<ul>
					<li><span>Item 3.0.0</span></li>
					<li><span>Item 3.0.1</span>
					<ul>
						<li><span>Item 3.0.1.0</span></li>
						<li><span>Item 3.0.1.1</span></li>
					</ul>
					
				</li>
					<li><span>Item 3.0.2</span>
					<ul>
						<li><span>Item 3.0.2.0</span></li>
						<li><span>Item 3.0.2.1</span></li>
						<li><span>Item 3.0.2.2</span></li>
					</ul>
				</li>
				</ul>
			</li>
		</ul>
	</li>
	</ul>
	
	<h4>Sample 3 - two trees with one tree control, black and gray theme, cookie-based persistance</h4>
	<div id="treecontrol">
		<a title="Collapse the entire tree below" href="#"><img src="jquery/stylesheet/images/minus.gif" /> Collapse All</a>
		<a title="Expand the entire tree below" href="#"><img src="jquery/stylesheet/images/plus.gif" /> Expand All</a>
		<a title="Toggle the tree below, opening closed branches, closing open branches" href="#">Toggle All</a>
	</div>
	<ul id="black" class="treeview-black">
		<li>Item 1</li>
		<li>
			<span>Item 2</span>
			<ul>
				<li>
					<span>Item 2.1</span>
					<ul>
						<li>Item 2.1.1</li>
						<li>Item 2.1.2</li>
					</ul>
				</li>
				<li>Item 2.2</li>
				<li class="closed">
					<span>Item 2.3 (closed at start)</span>
					<ul>
						<li>Item 2.3.1</li>
						<li>Item 2.3.2</li>
					</ul>
				</li>
			</ul>
		</li>
	</ul>
	<ul id="gray" class="treeview-gray">
		<li>Item 1</li>
		<li>
			<span>Item 2</span>
			<ul>
				<li class="closed">
					<span>Item 2.1 (closed at start)</span>
					<ul>
						<li>Item 2.1.1</li>
						<li>Item 2.1.2</li>
					</ul>
				</li>
				<li>Item 2.2.1</li>
				<li>Item 2.2.2</li>
				<li>Item 2.2.3</li>
				<li>Item 2.2.4</li>
				<li>Item 2.2.5</li>
				<li>Item 2.2.6</li>
				<li>Item 2.2.7</li>
				<li>Item 2.2.8</li>
				<li>
					<span>Item 2.3</span>
					<ul>
						<li>Item 2.3.1</li>
						<li>Item 2.3.2</li>
						<li>Item 2.3.3</li>
						<li>Item 2.3.4</li>
						<li>Item 2.3.5</li>
						<li>Item 2.3.6</li>
						<li>Item 2.3.7</li>
						<li>Item 2.3.8</li>
						<li>Item 2.3.9</li>
					</ul>
				</li>
				<li>
					<span>Item 2.4</span>
					<ul>
						<li>Item 2.4.1</li>
						<li>Item 2.4.2</li>
						<li>Item 2.4.3</li>
						<li>Item 2.4.4</li>
						<li>Item 2.4.5</li>
						<li>Item 2.4.6</li>
						<li>Item 2.4.7</li>
						<li>Item 2.4.8</li>
						<li>Item 2.4.9</li>
					</ul>
				</li>
			</ul>
		</li>
		<li>Item 3</li>
	</ul>	
	
</div>
</div>
 
</body></html>