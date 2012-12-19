<?php
/* 
Initital Writing: Eric Matthews
This control will be unique to each application screen that needs to use it. 
Typical scenarios will be as follows:
- Data Entry where user is asked to enter a date.
- Selection criteria on a screen soliciting a date before or after current date.
- Selection criteria on a screen soliciting a date range.
There can and will be other scenarios for using this control.

It is not yet clear to me what the most optimal (if there is one) means of 
implementing this control for a developer, but still giving them 100%
flexibility regarding its use (which is the core principle of zenyan!). As
such this is currently only presented as toycode. You will need to cut-n-paste
the applicable code into your application if you desire to use this control.
*/
session_start();

require('eConfig/envref.php');

include($php_envvars);
include($php_dbms);  //dbms specific to app
include($php_applib);
include($php_loggers);

$_SESSION['oldebug'] = "";
$_SESSION['tmp'] = $debugapp;
$mtd = "";
$status = '';
$logonerror = '';
$fullrefpg = $_SERVER['HTTP_REFERER'];

$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];

//get only page name.
if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
$refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);
check_referring_pg($refpg);

function check_referring_pg($refpg){  
   global $Scontxttoll;
 //if referring page context is required you code conditional here as wrapper to below conditional                
//// commented out during development ////
   if ($_SESSION['initentry'] == $Scontxttoll) { }
   else {  $_SESSION['loginerr'] = 'Login required to access page';  header("Location: login.php");  exit; }
}

?>
<!DOCTYPE html>
<html>
	<head>
<!--  Integrator: Eric Matthews  -->
<!--  Integration into the zenyan framework  -->
<!--  Example: JQuery Date Picker Plugin Example -->	
<!--  License: Dual licensed under the MIT and GPL license  -->               
<!--  Credit:  John Resig for his JQuery api                -->
<!--           Kelvin Luck for his ROBUST Date Picker api   -->
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">

		<title>jQuery datePicker example</title>

	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->
		
        <!-- jQuery -->
		<script type="text/javascript" src="jquery/jquery182.min.js"></script>
        
        <!-- required plugins -->
		<script type="text/javascript" src="jquery/date.js"></script>
		<script type="text/javascript" src="jquery/jquery.bgiframe.min.js"></script>
        
        <!-- datepicker -->
		<link rel="stylesheet" type="text/css" media="screen" href="jquery/stylesheet/jquery-ui191.css">
 		<script type="text/javascript" src="jquery/jquery-ui191.js"></script>   
     

    <link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">		
        <!-- page specific styles -->

        
        <!-- page specific scripts -->
		<script type="text/javascript" charset="utf-8">
       $(function() {        
           $( ".datepicker" ).datepicker();    
       });
		</script>
		
	    <style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:274px;
	height:132px;
	z-index:1;
	left: 18px;
	top: 49px;
}
#Layer2 {
	position:absolute;
	width:391px;
	height:272px;
	z-index:2;
	left: 273px;
	top: 55px;
}
-->
        </style>
</head>
	<body>

<?php
  include('jquery/topmenu.php');
?> 
<br /><br />

<div id="Layer1">
			<form name="chooseDateForm" id="chooseDateForm" method="get" action="toycode_ui_datePicker_persistence.php">
					<h2>Date Picker Example</h2>
              <label for="date1">Date 1:&nbsp;</label><input name="date1" class="datepicker"  <?php echo 'value="' . $_REQUEST['date1'] . '"'; ?> /><br /><br />
              <label for="date2">Date 2:&nbsp;</label><input name="date2" class="datepicker"  <?php echo 'value="' . $_REQUEST['date2'] . '"'; ?> /><br /><br />
      <input type="submit" name="submit" value="OK" />
			</form>

<br />
        
 <?php echo '$date1 = ' . $date1 . "<br />"; ?>
 <?php echo '$date2 = ' . $date2 . "<br />"; ?>
</div>	
 
	</body>
</html>