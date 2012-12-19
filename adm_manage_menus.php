<?php
// Manage Top Menus
// Initial Writing: ericm
// Date: 2/19/2012
// License: Dual licensed under the MIT and GPL license
/*
Manage Top Menus
*/
// History/Customizations:
/*
                        
*/
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);
include($php_filsysapi);
include($php_loggers);
include($php_daclib);

//session context
session_start();  //required in order to get generated session key
date_default_timezone_set('America/Los_Angeles');

$traceflg = 'y';
$trace = '';
$helpstr = '';
$msg = '';

$m1 = ''; 
$m2 = ''; 
$m3 = '';
$m4 = '';
$m5 = '';
$m6 = '';
$m7 = '';
$m8 = '';

$myDbgateway = new dbgateway;

if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}

getMmnuForm();

if ($_REQUEST['p'] == 'updmnu') {
  updMmnuForm();
  getMmnuForm();
}

  


//------------------------------------------------------------------------------  
function getMmnuForm()
{
  global $trace;
  global $helpstr;
  global $m1;
  global $m2;
  global $m3;
  global $m4;
  global $m5;
  global $m6;
  global $m7;
  global $m8;
  global $myDbgateway;

  $helpstr = '
  <ul class="style2">
    <li class="style3">You may have up to 8 top menu items.</li>
    <li class="style3">To disable a menu item remove the name and click update.</li>
    <li class="style3">You have 15 characters max for your menu name.  </li>
    <li class="style3">After making changes and clicking &quot;Update&quot; you need to refresh the browser in order to see the changes. </li>
  </ul>   
  ';
  $frm = ""; 
  $uid = $_SESSION['uid'];
  $query = 'SELECT member_uid,mnu_itm1,archive_flg1,mnu_itm2,archive_flg2,mnu_itm3,archive_flg3,mnu_itm4,archive_flg4,mnu_itm5,archive_flg5,mnu_itm6,archive_flg6,mnu_itm7,archive_flg7,mnu_itm8,archive_flg8 FROM lnks_itm where member_uid = \'' . $uid . '\'';
  //$trace = $query . "<br />";

  $result = $myDbgateway->readSQL($query,"hash");

  $m1 = $result['mnu_itm1']; 
  $m2 = $result['mnu_itm2']; 
  $m3 = $result['mnu_itm3'];
  $m4 = $result['mnu_itm4'];
  $m5 = $result['mnu_itm5'];
  $m6 = $result['mnu_itm6'];
  $m7 = $result['mnu_itm7'];
  $m8 = $result['mnu_itm8'];

  return;
}

function updMmnuForm()
{	
  global $trace;
  global $msg;
  global $handle;
  global $myDbgateway;

	$query = "UPDATE lnks_itm SET mnu_itm1 = '"; 
	$query .= $_REQUEST['mi1'] ;
	$query .= "'";

	$query .= ",mnu_itm2 = '";
	$query .= $_REQUEST['mi2'] ;
	$query .= "'";

	$query .= ",mnu_itm3 = '";
	$query .= $_REQUEST['mi3'] ;
	$query .= "'";

	$query .= ",mnu_itm4 = '";
	$query .= $_REQUEST['mi4'] ;
	$query .= "'";
	
	$query .= ",mnu_itm5 = '";
	$query .= $_REQUEST['mi5'] ;
	$query .= "'";	

	$query .= ",mnu_itm6 = '";
	$query .= $_REQUEST['mi6'] ;
	$query .= "'";

	$query .= ",mnu_itm7 = '";
	$query .= $_REQUEST['mi7'] ;
	$query .= "'";

	$query .= ",mnu_itm8 = '";
	$query .= $_REQUEST['mi8'] ;
	$query .= "'";

  $query .= " where member_uid = "; 
  $query .= $_SESSION['uid'] ;
  if ($traceflg != ''){ $trace .= $query . "<br />"; } 
  //$msg = $query;

  $result = $myDbgateway->writeSQL($query);

// and for net new menu items we need to build out the LIBRARY root dir and the two eDMS files eDoccon_* and lib-*
// $retv does not matter. the exchange gets logged to eLog/applog.txt
$retv = new_eDMS_cat( $_REQUEST['mi1']);  
$retv = new_eDMS_cat( $_REQUEST['mi2']);
$retv = new_eDMS_cat( $_REQUEST['mi3']);
$retv = new_eDMS_cat( $_REQUEST['mi4']);
$retv = new_eDMS_cat( $_REQUEST['mi5']);
$retv = new_eDMS_cat( $_REQUEST['mi6']);
$retv = new_eDMS_cat( $_REQUEST['mi7']);
$retv = new_eDMS_cat( $_REQUEST['mi8']);
	
	return $result;
}	

//----------------------------------------------------------------------------//
 function new_eDMS_cat($menunm)
//----------------------------------------------------------------------------//
 { 	
   global $LIBRARY;
   global $stubs;
   global $eDMS;
   global $url;
   global $buildname;
   global $logapp;
   $logapp = 'y'; //turn on logging
   $logwrt;
   
 //substitute spaces with underscores as it is our convention to do so as directory
 //names with spaces is a bad idea
   $menunm = preg_replace('/\s+/','_',$menunm);
   $checkdir = $LIBRARY . $menunm;
 //check to see that directory exists
   $rslt = checkFileExists($checkdir);
  //if yes do nothing 
   if ($rslt == 'y') {
 	    $logwrt = "directory $checkdir already exists";
 	    eAppLog($logwrt);
 	 //if no, create it...
   } else {	
       mkdir($checkdir, 0777);
       $logwrt = "directory $checkdir created";       
  	   eAppLog($logwrt);
  //...then create eDoccon_* to eDMS
       $doccontemplate = $stubs . "eDoccon_TEMPLATE.php";  
       //get eDoccon_TEMPLATE.php file contents
       $doccon_txt = getFileContents($doccontemplate);
       //transform
       $doccon_txt = preg_replace('/~~name_us~~/',$menunm,$doccon_txt);
       $doccon_txt = preg_replace('/~~baseurl~~/',$url,$doccon_txt);
       $doccon_txt = preg_replace('/~~build~~/',$buildname,$doccon_txt);      
       //save
       $newdocconfil = $eDMS . "eDoccon_" . $menunm . ".php";
       $retfs = createFile($doccon_txt,$newdocconfil);
       $logwrt = $retfs;       
  	   eAppLog($logwrt);
  //...then create lib_* file to eDMS
       $libtemplate = $stubs . "lib_TEMPLATE.html";  
       //get eDoccon_TEMPLATE.php file contents
       $lib_txt = getFileContents($libtemplate);
       //transform
       //underscores back to spaces
       $mnunm_wus = $menunm;
       $mnunm_wus = preg_replace('/[_]/',' ',$mnunm_wus);
       $lib_txt = preg_replace('/~~name_wus~~/',$mnunm_wus,$lib_txt);
       $lib_txt = preg_replace('/~~name_us~~/',$menunm,$lib_txt);
       //save
       $newlibfil = $eDMS . "lib_" . $menunm . ".html";
       $retfs2 = createFile($lib_txt,$newlibfil);
       $logwrt = $retfs;       
  	   eAppLog($retfs2);  
     }

  $logapp = ''; //turn off logging
  return "see applog.txt for status";
 
 }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" /

<!-- note: i modified nestedmenu and ui.tabs to add z-index so top menu renders over tabs. -->
	
	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->
			
	<script type="text/javascript" src="jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="jquery/jquery.dropdownPlain.js"></script>

<link media="print, projection, screen" href="jquery/stylesheet/ui.tabs.css" type=text/css rel=stylesheet>
<script src="jquery/jquery182.min.js" type=text/javascript></script>
<script src="jquery/ui.core16rc5.js" type=text/javascript></script>
<script src="jquery/ui.tabs16rc5.js" type=text/javascript></script>

<script type=text/javascript>
            $(function() {
                $('#etabs> ul').tabs({ fx: { opacity: 'toggle' } });
            });
</script>

<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style2 {font-family: Arial, Helvetica, sans-serif}
.style3 {font-size: 14px}

#showhelp {
	position:absolute;
	width:121px;
	height:28px;
	z-index:1;
	left: 520px;
	top: 103px;
}
#helptxt {
	position:absolute;
	width:373px;
	height:291px;
	z-index:2;
	left: 520px;
	top: 140px;
}
#updaltmnu {
	position:absolute;
	width:212px;
	height:246px;
	z-index:1;
	left: 377px;
	top: 62px;
}
#addaltmnu {
	position:absolute;
	width:267px;
	height:281px;
	z-index:2;
	left: 28px;
	top: 63px;
}
#mainmnuDiv {
	position:absolute;
	width:419px;
	height:272px;
	z-index:1;
	left: 36px;
	top: 100px;
}
-->
</style>

<script language="javascript"> 
function eToggle(anctag,darg) 
{
  //MsgBox(darg);
  var ele = document.getElementById(darg);
  var text = document.getElementById(anctag);
  if(ele.style.display == "block") 
  {
    ele.style.display = "none";
	text.innerHTML = "Show Help";
  }
  else 
  {
	ele.style.display = "block";
	text.innerHTML = "Hide Help";
  }
} 
</script>
</head>
<body>
<br />	
<div id=etabs>
<ul>
  <li><a href="#tab-1"><span>Main Menu Items</span></a> 
</ul>

<div id="tab-1">

<div id="showhelp">
<a id="atag" href="javascript:eToggle('atag','helptxt');">Show Help</a>
</div>
<h3>Manage My Menu Items</h3>

<div id="mainmnuDiv">
<form name='mnmnu' action='adm_manage_menus.php?p=updmnu' method='POST'>
<table width="425" border="0" cellspacing="6" cellpadding="1">
  <tr>
    <td width="225px">Menu Item </td>
  </tr>
  <tr>
    <td><input type='text' name='mi1' value='<?php echo $m1; ?>' size='27' maxlength='15' /></td>
  </tr>
  <tr>
    <td><input type='text' name='mi2' value='<?php echo $m2; ?>' size='27' maxlength='15' /></td>
  </tr>
  <tr>
    <td><input type='text' name='mi3' value='<?php echo $m3; ?>' size='27' maxlength='15' /></td>
  </tr>
  <tr>
    <td><input type='text' name='mi4' value='<?php echo $m4; ?>' size='27' maxlength='15' /></td>
  </tr>
  <tr>
    <td><input type='text' name='mi5' value='<?php echo $m5; ?>' size='27' maxlength='15' /></td>
  </tr>
  <tr>
    <td><input type='text' name='mi6' value='<?php echo $m6; ?>' size='27' maxlength='15' /></td>
  </tr>
  <tr>
    <td><input type='text' name='mi7' value='<?php echo $m7; ?>' size='27' maxlength='15' /></td>
  </tr>
  <tr>
    <td><input type='text' name='mi8' value='<?php echo $m8; ?>' size='27' maxlength='15' /></td>
  </tr>
</table>
<br />
<input name='Submit' type='submit' value='Update'>
</form>
<?php echo $msg; ?>
</div>

<div id="helptxt" style="display: none">
<?php echo $helpstr; ?>
</div>



</body>
</html>