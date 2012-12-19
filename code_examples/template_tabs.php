<?php
/* 
Initital Writing: Eric Matthews
This template extends the baseline template "mstrtmplt_base.php". It offers 
three tabs. This can be readily tweaked to increase or reduce the number.
The tabs can be populated through variables. Or, if SEO is desired
the data can be populated inline (though there should be a relationship 
between data within tabs or this could actually detract from SEO score).
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
//// commented out during development ////
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
<!-- note: i modified nestedmenu and ui.tabs to add z-index so top menu renders over tabs. -->
	
	<link rel="stylesheet" href="../jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="../jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->
			
	<script type="text/javascript" src="../jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="../jquery/jquery.dropdownPlain.js"></script>

<link media="print, projection, screen" href="../jquery/stylesheet/ui.tabs.css" type=text/css rel=stylesheet>
<script src="../jquery/ui.core16rc5.js" type=text/javascript></script>
<script src="../jquery/ui.tabs16rc5.js" type=text/javascript></script>

<script type=text/javascript>
            $(function() {
                $('#etabs> ul').tabs({ fx: { opacity: 'toggle' } });
            });
</script>

<link rel="stylesheet" type="text/css" media="screen" href="../stylesheet/mncontent_sansserif.css">
</head>

<body>

<?php
  include('../jquery/topmenu.php');
?> 
<!-- adequate spacing between top menu and start of tabs -->	
<br /><br /><br />

<!--
Below is section where you implement the tabs. Add or subtract tabs as needed.
The tab name goes between the span tag.  
-->
<div id=etabs>
<ul>
  <li><a
  href="#tab-1"><span>One</span></a> 
  <li><a
  href="#tab-2"><span>Two</span></a> 
  <li><a
  href="#tab-3"><span>Three</span></a> 
</ul>

<!--
Below is where content goes for each tab. Adding/Subtracting to tabs above and
you will need to add/substract references here as applicable.
-->
<div id="tab-1">
<p>tab one</p> 
</div>

<div id="tab-2">
<p>tab two</p> 
</div>

<div id="tab-3">
<p>tab three</p> 	
</div>
	
</body>

</html>