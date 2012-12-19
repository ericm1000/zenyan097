<?php
//-------------MAIN-----------------------------------------------------------//
//lib code / includes
//session context
session_start();  //required in order to get generated session key
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);


$_SESSION['initentry'] = 0;
$_SESSION['lname'] = '';
$_SESSION['cntxt'] = '';
$_SESSION['membermsg'] = '';

$uimsg = '';
$traceflg = '';
$trace = '';

//--MAIN---------------//

?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" />
<link rel="stylesheet" type="text/css" href="stylesheet/gridcontrol.css" media="all" />
<script type="text/javascript" src="eUI/script/gridcontrol.js"></script>
</head>
<body>
<h3>Site Specific Implemented</h3>
<?php echo $trace; ?>
<img src="images/construction.GIF" width="89" height="62" alt="under construction" />
</body>
</html>