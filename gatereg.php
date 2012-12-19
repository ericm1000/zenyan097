<?php
// zenyan Core Gate Admin Module
// Initial Writing: eric matthews
// Date: jul 1, 2010
// License: Dual licensed under the MIT and GPL license
/*
This is the baseline registration module for zenyan. Baseline is the key term 
here! There is a great deal of flexibility in using this module.
*/
// History/Customizations:
/*

*/
// TO DO:
/*
  - need to add a mechanism to deal with user exceeding maximum allowable attempts
  - change password function
*/
//-------------MAIN-----------------------------------------------------------//
//lib code includes
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms); //specific to dbms implementation
include($php_applib);
include($php_daclib);
include($php_loggers);

$_SESSION['loginerr'] = '';
$_SESSION['loginstatus'] = '';

//local dev time debug
$locdebugstatus = '';

//session context
session_start();  //required in order to get generated session key
$myDbgateway = new dbgateway;

$_SESSION['bugout'] = '';
  
  //get only page name
  $fullrefpg = $_SERVER['HTTP_REFERER'];
  if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
  $refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);
  $_SESSION['refpgnm'] = $refpg;
  
  //-- MAIN CONTROL ------------------------------------------------------------//
  $locdebug = '';
  // deal with potential ip spoofing
  $pathchk = "";
  if (preg_match("/^http:[\/][\/](.+)[\/](.+)[\/](.+)/", $fullrefpg, $matches2)) {$pathchk = $matches2[1];}
  if ($pathchk == $dns or $pathchk == $ip)
  {
     // validate referring page
     if ($_SESSION['refpgnm'] == 'register.php')
     {
      //check to see if username is available
        $ok = checkname($_REQUEST['lname']);
        $pwdstat = '';
        if ($ok == 'n') // 'n' = name does not exist, ok to register
        { 
          // we have cleared input checking of user name, we can now...
          // validate password to rules
          $pwdstat = checkpwd(trim($_REQUEST['pwd']),trim($_REQUEST['lname']));
          if ($locdebugstatus != '') { 
            $locdebug .=  '$pwdstat= ' . $pwdstat . "<br />";
          } 
          // we have cleared input checking of the password, we can now...      
           // create new user
            if ($pwdstat == 'y') //cleared password
            {
             $cuok = createNewUser(trim($_REQUEST['lname']),trim($_REQUEST['pwd']));
             if ($locdebugstatus != '') { 
               $locdebug .=  '$cuok= ' . $cuok . "<br />";
             }  
            }
            else if ($pwdstat == 'n')
            {
              if ($locdebugstatus != '') { 
               $locdebug .=  'could not create new user!' . "<br />";  
              }       	
            }	
        } 
      //->
        if ($locdebugstatus != '') { 
     	   $locdebug .=  '$_SESSION[\'refpgnm\']=' . $_SESSION['refpgnm'] . "<br />";
     	   $locdebug .=  '$pathchk=' . $pathchk ."<br />";
     	   $locdebug .=  '$dns=' . $dns ."<br />";
     	   $locdebug .=  '$ip=' . $ip ."<br />";  
     	   $locdebug .=  '$_SERVER[\'HTTP_REFERER\']=' . $_SERVER['HTTP_REFERER'] ."<br />";
         bugout($locdebug);
        }
     	 //->
   header("Location: register.php");   	   
 }	
//end function processing
 else
 {
   header("Location: byteme.php"); //send the hacker bastards packing
 }	
  } //end outer wrapper

	
//----------------------------------------------------------------------------//
function bugout($debugstr)
//----------------------------------------------------------------------------//
{
	$_SESSION['bugout'] .= $debugstr;
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
function checkname($login)
//----------------------------------------------------------------------------//
{        
   $_SESSION['rattmpt'] += 1;
   global $locdebugstatus;
   global $locdebug;
   global $myDbgateway;
   
   $logstat = '';
    
   $query = "SELECT lname FROM gate WHERE lname = '$login'";
 
 //->
   if ($locdebugstatus != '') { $locdebug .= '$query=' . $query . "<br />"; } 
 //->
 
 // wrapper in case nothing is entered into field
   if (trim($login) != '')
   { 
     $rs = $myDbgateway->readSQL($query,"hash");
     $lnameret = "";
     if ($locdebugstatus != '') { 
       $locdebug .= '$rs[\'lname\']=' . $rs['lname'] . "<br />"; 
     } 
     $lnameret = $rs['lname']; 
    
     if (trim($lnameret) == trim($login))
     { 
       $userexists = 'y'; 
       $_SESSION['loginerr'] = '<br />That name is already taken, pick a new one<br />'; 
     }
     else  
     {  
       $_SESSION['loginerr'] = '';
       // we have a name we can register.
       $userexists = 'n';  
       //validate username to rules
       $ok = checknamerules(trim($login));
     }
   } // end 0 length wrapper
   else
   {
      $_SESSION['loginerr'] = '';
   }	 	
 
   return $userexists;
}  //end sub 
//------------------------------------------------------------------------------  

//----------------------------------------------------------------------------//
function checknamerules($chkloginnm)
//----------------------------------------------------------------------------//
//-- This function is extensible to include whatever processing rules you 
//-- require. The following zenyan environment variables are used 
/*
$minloginnm - minimum login name length
$logincharset - acceptable characters
These can be readily modified without altering any of this code. The $minloginnm 
and the $logincharset params can also be modified against production anytime 
without impacting production.
*/
{ 
   global $locdebug;
   global $locdebugstatus;
   global $minloginnm;
   global $logincharset;

	 $cnt = strlen($chkloginnm);
	 $status = '';

// validate length 	 
	 if ($cnt >= $minloginnm)
	 {
	 	 $status = 'y';
	 	 $_SESSION['loginerr'] = '';
     // validate acceptable characters
        if (preg_match("/$logincharset/", $chkloginnm))
        {
	     	  $status = 'y';
        }
        else
        {
	     	  $status = 'n';
        	$_SESSION['loginerr'] = '<br />Name MUST enter valid characters!<br />';
        }	
      //->
        if ($locdebugstatus != '') { 
     	   $locdebug .=  'Length of name ($cnt)=' . $cnt . "<br />";
     	   $locdebug .=  'Name ($chkloginnm)=' . $chkloginnm . "<br />";
     	   $locdebug .=  'Name ($logincharset)=' . $logincharset . "<br />";
     	  }
     	 //-> 
	 }
	 else if 	($cnt < $minloginnm)
	 {
	 	 $status = 'n';
	 	 $_SESSION['loginerr'] = '<br />Name MUST be at least 6 characters!<br />';
	 }	

   return $status;
}  //end sub 
//------------------------------------------------------------------------------  


//----------------------------------------------------------------------------//
function checkpwd($chkpwd,$chkloginnm)
//----------------------------------------------------------------------------//
{
   global $locdebug;
   global $locdebugstatus;
   global $minpwd;
   global $pwdcharset1;
   global $pwdcharset2;
   global $pwdcharset3; 
   global $pwdcharset4;   
   
	 $cnt = strlen($chkpwd);
	 $status = '';   	

// flexibility yes, but there are some sacred cows. if you want users to have
// a password = to their login name you will need to modify the code.
if ($chkloginnm != $chkpwd)
{
// validate length 	 
	 if ($cnt >= $minpwd)
	 {
	 	 $_SESSION['loginerr'] = '';
     // validate acceptable characters
        if (
            preg_match("/$pwdcharset1/", $chkpwd) and
            preg_match("/$pwdcharset2/", $chkpwd) and
            preg_match("/$pwdcharset3/", $chkpwd) and
            preg_match("/$pwdcharset4/", $chkpwd) 
           )
        {
          $status = 'y';
	     	  $_SESSION['loginerr'] = '<br />User has been registered<br />';
        }
        else
        {
	     	  $status = 'n';
        	$_SESSION['loginerr'] = '<br />Password does not conform to the rules!<br />';
        }	
      //->
        if ($locdebugstatus != '') { 
     	   $locdebug .=  'Length of passwword ($cnt)=' . $cnt . "<br />";
     	   $locdebug .=  'Name ($chkpwd)=' . $chkpwd . "<br />";
     	   $locdebug .=  'Name ($pwdcharset1)=' . $pwdcharset1 . "<br />";
     	   $locdebug .=  'Name ($pwdcharset2)=' . $pwdcharset2 . "<br />";
     	   $locdebug .=  'Name ($pwdcharset3)=' . $pwdcharset3 . "<br />";
     	   $locdebug .=  'Name ($pwdcharset4)=' . $pwdcharset4 . "<br />";
         }
     	 //-> 
	 }
	 else if 	($cnt < $minpwd)
	 {
	 	 $status = 'n';
	 	 $_SESSION['loginerr'] = '<br />Password MUST be at least 8 characters!<br />';
	 }
}	 	
else
{
	$status = 'n';
	$_SESSION['loginerr'] = '<br />Password and Login name cannot be the same!<br />';	
}	

   return $status;
}  //end sub 
//------------------------------------------------------------------------------  


//----------------------------------------------------------------------------//
function createNewUser($newlogin,$newpwd)
//----------------------------------------------------------------------------//
/*
Presumption for reaching this point is that we have validated both the entity
name and the password against the defined rules. It should also be understood
that this is a barebones create new user function. There are many other 
columns that can be added to the registration.
*/
{
	 $status = ''; 

   global $seed1;
   global $seed2;
   global $seed3;
         
   global $locdebugstatus;
   global $locdebug;
   global $loghistory;
   global $myDbgateway;

   $logstat = '';
   
//generate guid
   $g = generateGUID();

  // $salt2 = $seed1 . $seed2 . $seed3;
   $locdebug .=  'guid=' . $g . "<br />";    
//create password
   //salt2 
     $s1 = substr($g,$seed1,1); // start# 0=1!
     $s2 = substr($g,$seed2,1);
     $s3 = substr($g,$seed3,1); 
  // prior to first production login you can also reorder s1-s3 to increase
  // salt from external hack. keep in mind if they have access to your system
  // it really is a moot point.  
   $ipwd = trim($newpwd) . trim($g) . trim($s1) . trim($s2) . trim($s3); 
   $ipwd = trim($ipwd); 
   $epwd = md5($ipwd); 
   $epwd = trim($epwd);   
   if ($locdebugstatus != '') { 
     $locdebug .=  '$newpwd=' . $newpwd . "<br />"; 
     $locdebug .=  '$epwd=' . $epwd . "<br />";    
     $locdebug .=  '$s1=' . $s1 . "<br />"; 
     $locdebug .=  '$s2=' . $s2 . "<br />"; 
     $locdebug .=  '$s3=' . $s3 . "<br />"; 
   }
  $insquery = "INSERT INTO gate (uid,lname,pwd,requestdate,firstname,lastname,curr_email_addr,inactive_flg,guid,mbrshpstat,entity_typ_flg) VALUES 
(0,'$newlogin','$epwd',current_timestamp,'','','','','$g','y','user')";

  $insquery2 = "INSERT INTO gatehist (uid,lname,pwd,requestdate,firstname,lastname,curr_email_addr,inactive_flg,guid,mbrshpstat,entity_typ_flg,crudtype) VALUES 
(0,'$newlogin','$epwd',current_timestamp,'','','','','$g','y','user','i')";

  $insquery3 = "INSERT INTO gategrps (parent_guid,child_guid) VALUES 
('$g','$g')";


  if (trim($newpwd) != '' and trim($newlogin) != '') 
  {
//register entity (including history)
    $result = $myDbgateway->writeSQL($insquery);
    if ($loghistory != '')
    {
      $result = $myDbgateway->writeSQL($insquery2);
    } 
    $result = $myDbgateway->writeSQL($insquery3);
    $status .= $result . "ereg|";
    if ($locdebugstatus != '') { 
      $locdebug .=  '$insquery=' . $insquery . "<br />";
      $locdebug .=  '$insquery2=' . $insquery2 . "<br />";
      $locdebug .=  '$insquery3=' . $insquery3 . "<br />";    
    } 
  }
  else
  {
    $status = 'did not register user';
  }	   

  return $status; 	
}	

?>
