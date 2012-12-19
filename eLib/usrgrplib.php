<?php

//         Version:  1.10                                                         
//            Date:  2012-02-10                                                          
// Initial Writing:  Norm Zemke
//         Purpose:  Misc lib functions useful for systems and group administration.
//
// History/Customizations:
/*
  added: function to createNewUser() to write row to lnks_itm [ericm 2/16/12)
*/

//!!!! TEMP NOTE: We do not use select * in queries in code. Also see notes below

//----------------------------------------------------------------------------//
function addGateHistory ($inLname, $inCrudtype, $myDbgateway) {
//----------------------------------------------------------------------------//
  $query = "SELECT * FROM gate WHERE lname = '" . $inLname . "'";
  $rs = $myDbgateway->readSQL($query,"hash"); 

  $uid = ($rs['uid']);
  $pwd = ($rs['pwd']);
  $firstname = ($rs['firstname']);
  $lastname = ($rs['lastname']);
  $curr_email_addr = ($rs['curr_email_addr']);
  $inactive_flg = ($rs['inactive_flg']);
  $guid = ($rs['guid']);
  $mbrshpstat = ($rs['mbrshpstat']);
  $entity_typ_flg = ($rs['entity_typ_flg']);
  $admin_flg = ($rs['admin_flg']);

  $insertQuery = "INSERT INTO gatehist (uid,lname,requestdate,pwd,firstname,lastname,curr_email_addr,
                                   inactive_flg,guid,mbrshpstat,entity_typ_flg,admin_flg,crudtype) 
  VALUES ('$uid','$inLname',current_timestamp,'$pwd','$firstname','$lastname','$curr_email_addr',
                   '$inactive_flg','$guid','$mbrshpstat','$entity_typ_flg','$admin_flg','$inCrudtype')";
  $result = $myDbgateway->writeSQL($insertQuery);   
  return $result; //!!! with rare exceptions empty returns are not ok in lib code. i have made changes, remove this comment after reviewing
}

//----------------------------------------------------------------------------//
function getRowFromGate($inLname, $myDbgateway) {
//----------------------------------------------------------------------------//
    $query = "SELECT * FROM gate WHERE lname = '" . $inLname . "'";
    $rs = $myDbgateway->readSQL($query,"hash"); 
    return $rs;
}

//----------------------------------------------------------------------------//
function validateNewLoginName($login, $myDbgateway)
//----------------------------------------------------------------------------//
{        
  if (trim($login) == '') {return "no login name entered";}

  $query = "SELECT lname FROM gate WHERE lname = '$login'";
   
  $rs = $myDbgateway->readSQL($query,"hash"); 
  $lnameret = $rs['lname']; 
    
   if (trim($lnameret) == trim($login)) {
     return 'That name is already taken, pick a different name'; 
   }  

  //validate username to rules   
  global $minloginnm;
  global $logincharset;

  if (strlen($login) < $minloginnm) { return "<br />Name MUST be at least $minloginnm characters!<br />";}

  if (preg_match("/$logincharset/", $login)) {
     return 'ok';
  } 
  return '<br />Name MUST contain only valid characters!<br />'; 
}	 	

//----------------------------------------------------------------------------//
function createNewUser($newlogin,$newpwd,$newfirstname,$newlastname,$newcurr_email_addr,
   $newentity_typ_flg,$newadmin_flg,$myDbgateway)
//----------------------------------------------------------------------------//
{
   $guid = generateGUID();

   $epwd = computePassword($newpwd, $guid);
   $skin_tabs = 'A';
   $inactive_flg = '';
   $mbrshpstat = 'y';
   $insertQuery = "INSERT INTO gate (uid,lname,requestdate,pwd,firstname,lastname,curr_email_addr," .
               "inactive_flg,guid,mbrshpstat,entity_typ_flg,admin_flg,skin_tabs)" .  
               " VALUES (0,'$newlogin',current_timestamp,'$epwd','$newfirstname','$newlastname'," .
               "'$newcurr_email_addr','$inactive_flg','$guid','$mbrshpstat','$newentity_typ_flg'," .
               "'$newadmin_flg','$skin_tabs')";
   $result = $myDbgateway->writeSQL($insertQuery);   
               
   $row = getRowFromGate($newlogin, $myDbgateway);
   $uid = $row['uid'];
   $insertQuery = "INSERT INTO gategrps (parent_uid,child_uid,admin_flg) " .
                  " VALUES ('$uid','$uid','y')";
   $result = $myDbgateway->writeSQL($insertQuery);   

   $insertQuerylnks_itm = "INSERT INTO lnks_itm (member_uid) " .
                  " VALUES ('$uid')";
   $result = $myDbgateway->writeSQL($insertQuerylnks_itm); 

   addGateHistory($newlogin,"i",$myDbgateway);
   return "User $newlogin registered"; 	
}	


?>
