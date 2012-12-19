<?php
/* 
Initital Writing: Eric Matthews
This is a baseline template for app with top nested menu. We morph this into
additional UI templates.

Reference to topmenu.php is configured one time for menus specific to your
application. (Designers note: in a later implementation i plan on adding
ability to create menus that can be customized specific to users and groups.)

*/
session_start();

require('../eConfig/envref.php');

include($php_envvars);
include($php_dbiom);  //dbms specific to app
include($php_applib);
include($php_loggers);

$_SESSION['oldebug'] = "";
$_SESSION['tmp'] = $debugapp;
$mtd = "";
$status = '';
$logonerror = '';
$fullrefpg = $_SERVER['HTTP_REFERER'];

//get only page name.
if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
$refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);

//// commented out during development ////
//check_referring_pg($refpg);
//// commented out during development ////

function check_referring_pg($refpg){  
 //if referring page context is required you code conditional here as wrapper to below conditional                
 if ( $_SESSION['initentry'] == $Scontxttoll)
  {
  	//in-context... presuming me

  } else { header("Location: login.php"); }
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Simple jQuery Dropdowns</title>
	
	<link rel="stylesheet" href="../jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="../jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->
			
	<script type="text/javascript" src="../jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="../jquery/jquery.dropdownPlain.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="../stylesheet/mncontent_sansserif.css">
</head>

<body>

<!--
To implement the menus for your application you need to go open the file
referenced below and modify to reflect your application.
-->
<?php
  include('../jquery/topmenu.php');
?> 	

<!-- comment out or remove me for production -->
<?php echo $_SESSION['oldebug']; ?>

	
</body>

</html>