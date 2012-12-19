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
 02/06/2012: Norm Zemke: Use computePassword function to verify password  
*/
//-------------MAIN-----------------------------------------------------------//
//lib code includes
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms); //specific to dbms implementation
include($php_applib);
include($php_daclib);
include($php_loginlib);
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

$ip = getIP();
//->
if ($locdebugstatus != '') { $locdebug .= '$ip=' . $ip . "<br />"; 
	                           $_SESSION['bugout'] = $locdebug; }

//->
if ($locdebugstatus != '') { $locdebug .= '$_SESSION[\'lattmpt\']=' . $_SESSION['lattmpt'] . "<br />"; 
	                           $_SESSION['bugout'] = $locdebug; }

//->
if ($locdebugstatus != '') { $locdebug .= 
	'$_REQUEST[\'lname\']=' . $_REQUEST['lname'] . "<br />" .
	'$_REQUEST[\'pwd\']=' . $_REQUEST['pwd'] . "<br />"; 
	$_SESSION['bugout'] = $locdebug; }
	
$x3Dorothy = validategate($_REQUEST['lname'],$_REQUEST['pwd']);

// well... we're waiting...
 if ($x3Dorothy == 'ether') 
 { 
      $_SESSION['loginerr'] = '';
      header("Location:mainpg.php");
 }
 else
 {
      // header("Location: mainpg.php"); //dev!!!
       	if ($_SESSION['lattmpt'] > ($maxloginattemps + 5))
       	{
           header("Location: loginhackattempt.php");
        }
        else
        {
       	  header("Location: login.php");         	
        }
 }


//----------------------------------------------------------------------------//
function getIP()
//----------------------------------------------------------------------------//
{
	$ipaddr = "";
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
	{ $ipaddr = $_SERVER['HTTP_CLIENT_IP']; }
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{ $ipaddr = $_SERVER['HTTP_X_FORWARDED_FOR']; }
	else { $ipaddr = $_SERVER['REMOTE_ADDR']; }
	
	return $ipaddr;
}	


//--Login Processing------------------------------------------------------------ 
//----------------------------------------------------------------------------//
function validategate($login, $password)
//----------------------------------------------------------------------------//
{        
  $_SESSION['lattmpt'] += 1;
  global $maxloginattemps;
  global $locdebugstatus;
  global $locdebug;
  global $seed1;
  global $seed2;
  global $seed3;
  global $Scontxttoll;

  $rguid = '';
  $rpwd = '';
  $ruid = '';
  $rlname = '';
  
  $logstat = '';
  
  $query = "SELECT * FROM gate WHERE lname = '$login'";

  if ($locdebugstatus != '') { $locdebug .= '$query=' . $query . "<br />"; 
	                           $_SESSION['bugout'] = $locdebug; } 

if (trim($login) != '' and trim($password) != '')
{
  $myDbgateway = new dbgateway;
  $rs = $myDbgateway->readSQL($query,"hash");
  // this version replaced the mysql_association logic
    $rguid = $rs['guid'];
    $rlname = $rs['lname'];
    $rpwd = $rs['pwd'];     
    $ruid = $rs['uid'];   
    $_SESSION['USRSYSKEY'] =  $ruid;
    $_SESSION['USRNAME'] =  $rlname;
    $_SESSION['loginname'] =  $rs['firstname'] . $rs['lastname'];
    if ($_SESSION['loginname'] == "") {$_SESSION['loginname'] = $rs['lname'];}
    $_SESSION['login'] =  $rs['lname'];
    $_SESSION['skin_tabs'] =  $rs['skin_tabs'];
    $_SESSION['skin_bg'] =  $rs['skin_bg'];
    $_SESSION['admin_flg'] = trim($rs['admin_flg']);
    if ($_SESSION['admin_flg'] == 'y') {$_SESSION['admin_flg'] = 'z';}
    $_SESSION['uid'] =  $rs['uid'];
    $_SESSION['entity_typ_flg'] =  $rs['entity_typ_flg'];
    $_SESSION['guid'] =  "";
    $_SESSION['logtoken'] = $Scontxttoll;
  
    $suspuflg = $row['inactive_flg'];

      if ($locdebugstatus != '') { $locdebug .= 
     	'$rs[\'lname\']=' . $rs['lname'] . "<br />" .
        '$rs[\'pwd\']='    . $rs['pwd']   . "<br />" .
        '$rs[\'uid\']='    . $rs['uid']   . "<br />" .
        '$rs[\'requestdate\']='  . $rs['requestdate']   . "<br />" .
        '$rs[\'guid\']='    . $rs['guid']   . "<br />" .
        '$maxloginattemps='  . $maxloginattemps  . "<br />" .
        '$_SESSION[\'lattmpt\']='  . $_SESSION['lattmpt']  . "<br />" .
        '$rs[\'initentry\']='  . $rs['initentry']  . "<br />" .
        '$rs[\'inactive_flg\']='  . $rs['inactive_flg']  . "<br />" .
        '$suspuflg='  . $suspuflg
        ; 
      }
}
   $epwd = computePassword($password, $rguid);

 /* a level of grace is extended here. it is possible for an end user to leave
 their browser open, logout, but never turns off their computer. technically 
 this would constitute a security problem in my mind. we could have a long
 discussion as many do on this subject and still not come to a consensus.
 The logic below works as follows. if the login attempts exceed $maxloginattemps
 but we are still carrying session context the user will still be able to 
 login. i am doing this for apps that run inside a firewall! However, if the
 user makes a mistake logging in they will be suspended and IT will need to
 reset their login. If this is too liberal a login strategy then all you need
 to do is remove the clause "or $_SESSION['initentry'] != $Scontxttoll" */ 
//   die($epwd . " x " . $rpwd . ' y ' . $rguid . ' z ');
   if ($epwd == $rpwd and trim($suspuflg) == '' and ($_SESSION['lattmpt'] < $maxloginattemps or $_SESSION['initentry'] == $Scontxttoll)) 
   {
     $_SESSION['initentry'] = $Scontxttoll;
     $_SESSION['loginerr'] = '';
     $logstat = 'ether';   
     $_SESSION['lattmpt'] = 0;
     if ($locdebugstatus != '') { $locdebug .= 
         '<br />$_SESSION[\'initentry\']='  . $_SESSION['initentry'] . "<br />" .
         '$logstat='  . $logstat . "<br />" .
         '$_SESSION[\'loginerr\']='  . $_SESSION['loginerr'] . "<br />" .
         '$logstat='  . $logstat . "<br />" .
         '$cpwd='  . $cpwd . "<br />" .
         '$epwd='  . $epwd . "<br />" .
         '$rpwd='  . $rpwd . "<br />" ;    
      } 	
   }
   else
   {     
     $_SESSION['initentry'] = '0';
     $logstat = 'laf'; 
      if ($locdebugstatus != '') { $locdebug .=  
         '<br />$password='  . $password . "<br />" .
         '$_SESSION[\'loginerr\']='  . $_SESSION['loginerr'] . "<br />" .
         '$logstat='  . $logstat . "<br />" .
         '$cpwd='  . $cpwd . "<br />" .
         '$epwd='  . $epwd . "<br />" .
         '$rpwd='  . $rpwd . "<br />" ;    
      }     
      //suspend user due to n unsucessful attempts 
       if ($suspuflg != '') //user account has already been suspended
       {
         $_SESSION['loginerr'] = "Your account has been suspended. Contact support for reactiviation."; 
       }
       else if ($suspuflg == '' and $_SESSION['lattmpt'] > $maxloginattemps) 
       {
         $suspumsg = suspendUser($rlname);
         $_SESSION['loginerr'] = $suspumsg; 
       }	 
      //end suspend user
   }		

   $_SESSION['bugout'] = $locdebug; 
   return $logstat;
}  //end sub
 
//------------------------------------------------------------------------------

//----------------------------------------------------------------------------//
function suspendUser($suspuser)
//----------------------------------------------------------------------------//
{  
   $msg = "Your account has been suspended. Contact support for reactiviation.";   
   $query = "UPDATE gate SET   inactive_flg  =  'y'  WHERE  lname  =  '$suspuser'";
   $myDbgateway = new dbgateway;
   $rs = $myDbgateway->writeSQL($query);
   return $msg;
}	

 
?>
