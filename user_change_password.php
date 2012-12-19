<?php
// zenyan Login Module
// Initial Writing: Norm Zemke
// Date: Feb 3, 2012
// License: Dual licensed under the MIT and GPL license
/*
This is the baseline login module for zenyan. Baseline is the key term here!
There is a great deal of flexibility in using this module.
*/
// History/Customizations:
/*
 02/03/2012: Norm Zemke: Initial writing, based on program register.php
*/

require('eConfig/envref.php');
include($php_envvars);
include($php_dbms); 
include($php_applib);
include($php_daclib);
include($php_loginlib);
include($php_usrgrplib);
include($php_loggers);

session_start();
 

if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
} 

$myDbgateway = new dbgateway;

$selected_lname = $_REQUEST['selected_lname'];
if (! trim($selected_lname)) {
  $selected_lname = $_SESSION['login'];
}

if ($_REQUEST['submitfrm'] == 'ok') {
  $replyMessage = changePassword($selected_lname,$myDbgateway);
}

$result = getListOfGroups($myDbgateway);

function getListOfGroups($myDbgateway) {
  global $fw_delimsymb;
  $select_cmd = "SELECT uid, admin_flg FROM gate WHERE lname  = '" . $_SESSION['login'] . "'"; 
  $readSQL_out = $myDbgateway->readSQL($select_cmd,"delim");
  $readSQL_out_array = explode($fw_delimsymb,$readSQL_out[0]);
  $login_uid  = $readSQL_out_array[0];      
  $login_admin_flg = trim($readSQL_out_array[1]);      
  $query;
  if ($login_admin_flg == 'z' or $login_admin_flg == 'y') {
    $query .= "SELECT lname FROM gate WHERE "
      . "entity_typ_flg = 'group'" 
      . " or lname = '" . $_SESSION['login'] . "'"
      . " order by lname";
  } else {
    $tmpQuery = "SELECT parent_uid FROM gategrps WHERE "
      . "(inactive_flg is NULL or inactive_flg <> 'y') and "
      . "admin_flg = 'y' and child_uid = '" . $login_uid . "'" ;
    $tmpResult = $myDbgateway->readSQL($tmpQuery,"hash"); 
    $query .= "SELECT lname FROM gate WHERE ";
    $or;
    if ($tmpResult) {
      while($rowa = mysql_fetch_array($tmpResult, MYSQL_ASSOC)) {
        $query .= $or . "uid = '" . $rowa['parent_uid'] . "'";
        $or = " or ";
      } 
    } else { return;}
    $query .= " or lname = '" . $_SESSION['login'] . "'";
    $query .= " order by lname";
  }
  $queryResult = $myDbgateway->readSQL($query,'delim');
  if (! $queryResult) {return false;}
  if (count($queryResult) == 1) {return false;}
  return $queryResult;
}	

function changePassword($lname,$myDbgateway) {
  global $fw_delimsymb;
   
  // verify that the user entered his password correctly
  $select_cmd = "SELECT pwd, guid FROM gate WHERE lname  = '" . $lname . "'"; 
  $readSQL_out = $myDbgateway->readSQL($select_cmd,"delim");
  $readSQL_out_array = explode($fw_delimsymb,$readSQL_out[0]);
  $gatePwd  = $readSQL_out_array[0];      
  $gateGuid  = $readSQL_out_array[1];      
  $epwd = computePassword($_REQUEST['oldpwd'], $gateGuid);
  if ($epwd != $gatePwd) { 
    return "Please re-enter your current password";      
  }
  $replyCode = validateNewPassword(trim($_REQUEST['pwd']),trim($_REQUEST['pwd2']),trim($lname));
  if ($replyCode != 'ok') {return $replyCode;}

  // we have cleared input checking of the password, we can now update password on gate.db
  $epwd = computePassword($_REQUEST['pwd'], $gateGuid);
  $updquery = "UPDATE gate SET pwd = '" . $epwd . "' WHERE lname = '" . $lname . "'"; 
  $result = $myDbgateway->writeSQL($updquery);   
  addGateHistory($lname,"u",$myDbgateway);
  unset ($_REQUEST['oldpwd'],$_REQUEST['pwd'],$_REQUEST['pwd2']);
  return "Password changed for $lname";
} 

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet/mncontent.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>zenyan Registration Module</title>
</head>
<body>
<!-- License: Dual licensed under the MIT and GPL license -->
<form id="form1" name="form1" method="post" action="user_change_password.php">
  <h1 id="headingMessage">Password Change</h1>
  <p>Use the tab key to switch fields</p>
  <hr />

<?php 
  if ($result) {
    echo 'Select user or group for password change:';    
    echo '  <select size="1" name="selected_lname"> ';
    foreach ($result as $resultLname) {
      $resultLname = trim($resultLname);
      if ($selected_lname == $resultLname) {
        echo '    <option value="' . $resultLname .'" >'. $resultLname . '</option>' ;
      } else {    
        echo '    <option value="' . $resultLname .'" >'. $resultLname . '</option>' ;
      }
    }
    echo '  </select>';
    echo '<br />';
    echo '<br />';
  }
?>
  
  <label>Enter Old password
    <input name="oldpwd" type="password" id="pwd" size="10" maxlength="10" 
      value="<?php echo $_REQUEST['oldpwd']; ?>"/>    
  
  <label><br /><br />
     Enter New Password
    <input name="pwd" type="password" id="pwd" size="10" maxlength="10" 
      value="<?php echo $_REQUEST['pwd']; ?>"/>    
  </label>
  <a href="#" tabindex=-1 title="8 to 10 characters; Characters 0-9, A-Z, a-z, +,-,_,+ (not the comma or semi-colon) are acceptable; at least one number, one lowercase letter, and one uppercase letter are required.">password help</a>
  
  <label><br />
     Reenter New Password
    <input name="pwd2" type="password" id="pwd2" size="10" maxlength="10" 
      value="<?php echo $_REQUEST['pwd2']; ?>"/>
  </label><br />
  <br />

  <br /> 
  <input type="submit" name="submitfrm" id="submitfrm" value="ok" />
  </label>
</form> 
<?php echo $replyMessage; ?> 
</body>
</html>