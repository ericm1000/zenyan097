<?php
session_start();  //required in order to get generated session key


include('framework/envvars.php');
include('eLib/dbiom.php');
include('eLib/applib.php');
include($php_daclib);
$traceflg = '';
$trace = '';

$errmsg = '';
$_SESSION['cntr'] = 0;
$myDbgateway = new dbgateway;

//lookup and validate key, set flg, send user to main page
if (trim($_REQUEST['tbf_email']) != '' and trim($_REQUEST['tb_key']) != '')
{
  $retv = getUserReg($_REQUEST['tbf_email']);
  if (traceflg == 'y')
  {
    $errmsg .=  '$emailaddress is ' . $retv['emailaddress'] . "<br />"; 
    $errmsg .=  '$guid is ' . $retv['guid'] . "<br />"; 
    $errmsg .=  '$uid is ' . $retv['uid'] . "<br />";
  }
  $guid = $retv['guid'];      
  $uid = $retv['uid'];
  if ($_REQUEST['tb_key'] == $guid)
  {
    $retr2 = createLnksItmRow($uid);
    $retr = setRegdFlg($uid);
    header("Location: regend.php");  //change dest if already registered
  }
  //else something is wrong keep user on this page
  else
  {
    $errmsg .= 'You did not enter the correct email address or key.';
  }
}	


//------------------------------------------------------------------------------

function getUserReg ($emailv)
{
  global $errmsg;
  global $myDbgateway;
  $maillu = trim($emailv);
  if (traceflg == 'y')
  {
   $errmsg .= $maillu . "<br />";
  }
  $query = "SELECT emailaddress, guid, uid from members where emailaddress = '" . $maillu . "'";
  if (traceflg == 'y')
  {
   $errmsg .= $query . "<br />";
  }

  $result = $myDbgateway->readSQL($query,"hash");

  return $result;
}

function createLnksItmRow ($uid)
{
  global $myDbgateway;
  $query = "INSERT INTO lnks_itm (member_uid) VALUES ('" . $uid . "')";
  $result = $myDbgateway->writeSQL($query);
 
  return $result;	
}	

function setRegdFlg ($uid)
{	             
  global $myDbgateway;
  $query = "UPDATE members SET mbrshpconfirm = 'a' WHERE  uid = '$uid'";
  $result = $myDbgateway->writeSQL($query);

  return $result;	
}
	
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet/mncontent.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>navTango Complete Registration</title>
<style type="text/css">
<!--
.style2 {font-size: small}
-->
</style>
</head>
<body>
<h1>
Complete Registration for navTango
</h1>
<p><?php echo $errmsg; ?></p>
<p>Enter the key provided in email sent to you. If you do not receive an email from us in the next minute or two, check your
email spam folder. It is also possible that you entered an incorrect email address.</p>
<p>It is possible you may have to enter your address a second time to complete registration.</p>
<div align="left">
 <form method="POST" action="regfinalval.php">
  <table border="0" cellspacing="4" width="636">
    <tr>
      <td width="170" height="25">
        <p align="right"><b>Email</b><font color="#FF0000"></font>:      </td>
      <td width="450" height="25">
      	<input type="text" name="tbf_email" size="60" value="<?php echo $_REQUEST['tbf_email']; ?>">      
      </td>
    </tr>    
    <tr>
      <td height="25">
        <p align="right"><b>Registration Key</b>:</td>
      <td height="25"><input type="text" name="tb_key" size="21" value="<?php echo $_REQUEST['tb_key']; ?>"></td>
      </tr>
    <tr>
      <td height="27"></td>
      <td height="27"><input type="submit" value="Complete Registration" name="btnreg"></td>
      </tr>
  </table>
 </form> 
</div>

<p>&nbsp;</p>
</body>
