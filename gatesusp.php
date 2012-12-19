<?php
// zenyan Login Module
// Initial Writing: eric matthews
// Date: june 30, 2010
// License: Dual licensed under the MIT and GPL license
/*
This is the baseline login module for zenyan. Baseline is the key term here!
There is a great deal of flexibility in using this module.
*/
// History/Customizations:
/*

*/
//-------------MAIN-----------------------------------------------------------//
//lib code includes
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms); //specific to dbms implementation
include($php_applib);
include($php_daclib);
include($php_loggers);

$_SESSION['loginstatus'] = '';

//local dev time debug
$locdebugstatus = '';
$locdebug = '';
$_SESSION['bugout'] = '';

//session context
session_start();  //required in order to get generated session key

$_SESSION['initentry'] = 0;
$_SESSION['lname'] = '';
$myDbgateway = new dbgateway;

$_SESSION['loginerr'] = suspendUser(trim($_REQUEST['lname']));
header("Location: susp.php");

//----------------------------------------------------------------------------//
function suspendUser($suspuser)
//----------------------------------------------------------------------------//
{  
   global $myDbgateway;
   
   $msg = "Account has been suspended.";   
   
   $updqry = "UPDATE gate SET   inactive_flg  =  'y'  WHERE  lname  =  '$suspuser'";

   $result = $myDbgateway->writeSQL($updqry); 

   return $msg;
}	
  
?>

