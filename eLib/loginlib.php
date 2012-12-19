<?php

//         Version:  1.10                                                         
//            Date:  2012-02-10                                                          
// Initial Writing:  Norm Zemke
//         Purpose:  Misc lib functions useful for login dev.
//
// History/Customizations:
/*
 09/28/2012 Eric Matthews: added max rows param
*/

$loginmgmtMaxRows = 100;

//----------------------------------------------------------------------------//
function validateNewPassword($chkpwd,$chkpwd2,$chkloginnm)
//----------------------------------------------------------------------------//
{
  global $locdebug;
  global $locdebugstatus;
  global $minpwd;
  global $pwdcharset1;
  global $pwdcharset2;
  global $pwdcharset3; 
  global $pwdcharset4;   
   
  $status = '';   	
  $cnt = strlen($chkpwd);

  // flexibility yes, but there are some sacred cows. if you want users to have
  // a password = to their login name you will need to modify the code.
  if ($chkloginnm == $chkpwd) {
    return '<br />Password and Login name cannot be the same!<br />';
  }	
  // validate the password is the same as the re-entered password  
  if ($chkpwd != $chkpwd2) {
    return '<br />Passwords entered are not identical!<br />';
  }
  // validate length 	 
  if ($cnt < $minpwd) {
    return "<br />Password MUST be at least $minpwd characters!<br />";
  }

  // validate acceptable characters
  if (preg_match("/$pwdcharset1/", $chkpwd) and
      preg_match("/$pwdcharset2/", $chkpwd) and
      preg_match("/$pwdcharset3/", $chkpwd) and
      preg_match("/$pwdcharset4/", $chkpwd)) {
        $status = 'ok';
  } else {
        $status = '<br />Password does not conform to the rules!<br />';
  }	
  return $status;
} //end sub 
//------------------------------------------------------------------------------  


//----------------------------------------------------------------------------//
function computePassword ($pwdIn, $guidIn)
//----------------------------------------------------------------------------//
{
  global $seed1; 
  global $seed2; 
  global $seed3; 
  $s1 = substr($guidIn,$seed1,1);
  $s2 = substr($guidIn,$seed2,1);
  $s3 = substr($guidIn,$seed3,1); 
  // prior to first production login you can also reorder s1-s3 to increase
  // salt from external hack. keep in mind if they have access to your system
  // it really is a moot point.  
  $ipwd = trim($pwdIn) . trim($guidIn) . trim($s1) . trim($s2) . trim($s3); 
  $ipwd = trim($ipwd); 
  $newPwd = md5($ipwd); 
  $newPwd = trim($newPwd);  
  return $newPwd;
}



?>