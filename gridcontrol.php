<?php
session_start();

require('eConfig/envref.php');

include($php_envvars);
include($php_dbms);  //dbms specific to app
include($php_daclib);
include($php_applib);
include($php_loggers);

$_SESSION['oldebug'] = "";
$lugrid = "foo";

$_SESSION['tmp'] = $debugapp;
$mtd = "";
$status = '';
$logonerror = '';
$fullrefpg = $_SERVER['HTTP_REFERER'];

//get only page name.
if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
$refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);

//// commented out during development ////
check_referring_pg($refpg);
//// commented out during development ////

 function check_referring_pg($refpg){
 	global $lugrid;  
  global $Scontxttoll;
  //if referring page context is required you code conditional here as wrapper to below conditional                
    if ( $_SESSION['initentry'] == $Scontxttoll) {
     	//in-context... presuming me
     	$lugrid = getGridData();
    } else { header("Location: login.php");  }
  }

  function getGridData(){ 
    $querymysql = 'SELECT uid,lname,requestdate,pwd,admin_flg FROM gate LIMIT 100';
    $query = $querymysql;
    $myDbgateway = new dbgateway;
    $rs = $myDbgateway->readSQL($query,"trrow");
 
    foreach ($rs as $arritm) {
      $tmpstr .= $arritm;
    }
  
    return $tmpstr;
  
  }
 
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Grid Control Example (MySQL Data)</title>
	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->		
	<script type="text/javascript" src="jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="jquery/jquery.dropdownPlain.js"></script>

<link rel="stylesheet" type="text/css" href="stylesheet/gridcontrol.css" media="all" />
<script type="text/javascript" src="eUI/gridcontrol.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
<style type="text/css">
<!--
#debug {
	position:absolute;
	width:780px;
	height:96px;
	z-index:1;
	left: 20px;
	top: 408px;
}
#Layer1 {
	position:absolute;
	width:725px;
	height:149px;
	z-index:2;
	left: 37px;
	top: 53px;
}
-->
</style>
</head>

<body>
<?php
  include('jquery/topmenu.php');
?> 	
<!--  Header  -->
<br /><br />	

<!-- comment out or remove me for production -->
<div id="Layer1">
<h1>Grid Control Example (MySQL Data)</h1>
<div id="pgContent">
<table id="t1" class="example table-autosort 
                              table-autofilter 
                              table-autopage:5 
                              table-stripeclass:alternate 
                              table-page-number:t1page 
                              table-page-count:t1pages 
                              table-filtered-rowcount:t1filtercount 
                              table-rowcount:t1allcount">
<thead>
 <tr>
  <th class="table-sortable:default" width='50'>UID</th>
  <th class="table-sortable:default" width='150'>User Name</th>
  <th class="table-sortable:default" width='125'>Request Date</th>  
  <th class="table-sortable:default" width='210'>Password</th>
  <th class="table-sortable:default" width='75'>Admin Flg</th>
<!--EndSet-->           
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid)){echo $lugrid;} ?>
</tbody>
<tfoot>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_left.gif"></td>
  <td colspan="3" style="text-align:center;">Page <span id="t1page" width='150'></span>&nbsp;of <span id="t1pages"></span></td>
  <td class="table-page:next" style="cursor:pointer;" width='100'><img src="eUI/script/images/arrow_right.gif"></td>
 </tr>
</tfoot>
</table>
</div>





<div id="debug">
<?php echo $_SESSION['oldebug']; ?>
</div>
	
</body>

</html>
