<?php
session_start();  //required in order to get generated session key

require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);
include($php_applib);
include($php_daclib);
$traceflg = '';
$trace = '';

$errmsg = '';
$myDbgateway = new dbgateway;
//Verify that user is not already registered!!!
  $retv = checkUserReg($_REQUEST['tb_email']);
  if (trim($retv['emailaddress']) == trim($_REQUEST['tb_email']))
  {
    //user is already registered
    header("Location: regcant.php");  //email addr already registered
  }	
    
  if (traceflg == 'y')
  {
    $errmsg .=  '$emailaddress is ' . $row['emailaddress'] . "<br />"; 
  }

//validate form required fields
$_SESSION['tb_lname'] = $_REQUEST['tb_lname'];
$_SESSION['tb_fname'] = $_REQUEST['tb_fname'];
$tmp = validateEmailAddress();
$errmsg .= $tmp;
$tmp = validateUserName();
$errmsg .= $tmp;
$tmp = validatePassword();
$errmsg .= $tmp;
$tmp = validateAns();  
$errmsg .= $tmp;

if ($errmsg != '')
{
  $_SESSION['errmsg'] = $errmsg;
  header("Location: regfrm.php");  //change dest if already registered
}
else if ($errmsg == '')
{
	$_SESSION['errmsg'] = "";
  $tmp = registerNewMember();
  if (trim($_SESSION['errmsg']))
  {
  	$ret = sendEmail();
  	$_SESSION['errmsg'] = $ret;
	}  
}
	

//------------------------------------------------------------------------------

function checkUserReg ($emailv)
{
  global $errmsg;
  global $myDbgateway;
  
  $maillu = trim($emailv);
  if (traceflg == 'y')
  {
   $errmsg .= $maillu . "<br />";
  }
  $query = "SELECT emailaddress from members where emailaddress = '" . $maillu . "'";
  if (traceflg == 'y')
  {
   $errmsg .= $query . "<br />";
  }
  $result = $myDbgateway->readSQL($query,"hash");
  return $result;
}


function validateEmailAddress()
{
  $status = '';
	//check for valid email address
  if (! ereg('[A-Za-z0-9_-]+\@[A-Za-z0-9_.-]+\.[A-Za-z0-9_-]+', trim($_REQUEST['tb_email'])))
  {
    $status .= '- You did not enter as a valid email address<br />';	
  }
	else
	{
		$_SESSION['tb_email'] = trim($_REQUEST['tb_email']);
	}	

	//check for email address re-entry
	if (trim($_REQUEST['tb_reenteremail']) == '')
	{
    $status .= '- You need to re-enter your email address.<br />';			
	}		
	if (trim($_REQUEST['tb_email']) != trim($_REQUEST['tb_reenteremail']))
	{
    $status .= '- Email addresses do not match.<br />';			
	}	
  return $status;
}

function validateUserName()
{
  $status = '';
	if (trim($_REQUEST['tb_username']) == '')
  {
    $status .= '- User name required (maximum 25 characters).<br />';
  }
	else
	{
		$_SESSION['tb_username'] = trim($_REQUEST['tb_username']);
	}

  return $status;
}

function validatePassword()
{
  $status = '';
	if (strlen(trim($_REQUEST['tb_pwd'])) < 4)
  {
    $status .= '- A minimum of 4 charactors is required for password.<br />'; 
    if (trim($_REQUEST['tb_pwdv']) != trim($_REQUEST['tb_pwd']))
    {
     $status .= '- Re-entry of password does not match.<br />';    	
    }	 	
  } 
  else if (strlen(trim($_REQUEST['tb_pwd'])) > 3 and trim($_REQUEST['tb_pwdv']) != trim($_REQUEST['tb_pwd']))
  {
    $status .= '- Re-entry of password does not match.<br />';    	
  }
  	
  return $status;	
}	

function validateAns()
{
  $status = '';
	if (trim($_REQUEST['tb_ans']) == '')
  {
    $status .= '- Answer to question is required.<br />';
  }
  return $status;	
}	 

function registerNewMember()
{
  global $trace;
  global $traceflg;
  global $myDbgateway;
  
  $tb_email    = $_REQUEST['tb_email'];  
  $tb_pwd      = $_REQUEST['tb_pwd'];                
  $tb_fname    = $_REQUEST['tb_fname'];
  if ($_REQUEST['tb_lname'] != "") 
  {               
   $tb_lname    = $_REQUEST['tb_lname']; 
  }
  if ($_REQUEST['tb_gname'] != "") 
  {               
   $tb_lname    = $_REQUEST['tb_gname']; 
  }                    
  $tb_qst      = $_REQUEST['lb_qst'];                     
  $tb_ans      = $_REQUEST['lb_ans'];                     
  $tb_email    = $_REQUEST['tb_email'];                                          
  $tb_username = $_REQUEST['tb_username'];
  $lb_qst      = $_REQUEST['lb_qst']; 
  $tb_ans      = $_REQUEST['tb_ans']; 
  $lb_ref      = $_REQUEST['lb_ref'];
  $lb_utype    = $_REQUEST['lb_utype'];
  $cb_admin    = $_REQUEST['cb_admin'];
//generate a guid
  $tmpguid = generateGUID();
  $_SESSION['tmpguid'] = $tmpguid;
  $_SESSION['tb_email'] = $tmpemail;

  $query = "
INSERT INTO members                           
     (                             
        emailaddress          ,    
        pwd                   ,    
        requestdate           ,    
        firstname             ,    
        lastname              ,    
        chall_qst             ,    
        chall_ans             ,    
        curr_email_addr       ,    
        confrm_email_sent_flg ,    
        contributor_name      ,    
        guid                  ,
        referral              ,
        entity_typ_flg        ,
        admin_flg    
     )                             
VALUES                             
     (                             
        '$tb_email',  
        '$tb_pwd',               
        NOW(),   
        '$tb_fname',                
        '$tb_lname',                  
        '$lb_qst',                     
        '$tb_ans',                     
        '$tb_email',                     
        'Y',                      
        '$tb_username',                 
        '$tmpguid' ,
        '$lb_ref'  ,
        '$lb_utype',
        '$cb_admin'             
     )                              
";
  //$_SESSION['errmsg'] = $query;
  $result = $myDbgateway->writeSQL($query);

  //now lets select and get the uid so we can do remaining inserts
  $qrysel = "select uid from members where guid = '" . $tmpguid . "'";
  $rr_uid = '';
  $result2 = $myDbgateway->readSQL($qrysel,'hash');
  $_SESSION['errmsg'] .= '$result2= ' . $result2 . "<br />";
  $_SESSION['errmsg'] .= "uid= " . trim($result2['uid']) . "<br />";
  $rr_uid = trim($result2['uid']);
	
  // now we insert a new row into lnks_itm and membrgrps
  $_SESSION['errmsg'] .= $rr_uid . "<br />";
  $qryins2 = "INSERT INTO membrgrps                           
     (                             
        parent_uid,    
        child_uid    
     )                             
VALUES                             
     (                             
        '$rr_uid',  
        '$rr_uid'             
     )                              
";
  $_SESSION['errmsg'] .= $qryins2 . "<br />";

  $result3 = $myDbgateway->writeSQL($qryins2);

  $qryins3 = "INSERT INTO lnks_itm                           
     (                             
        member_uid      
     )                             
VALUES                             
     (                             
        '$rr_uid'            
     )                              
";
  $_SESSION['errmsg'] .= $qryins3 . "<br />";
  $result4 = $myDbgateway->writeSQL($qryins3);
  
  if ($traceflg != ''){ $trace .= $query . "<br />"; }	
	
	return $result;
}	


function getCurrUID($g)
{
  global $myDbgateway;

  $_SESSION['errmsg'] .= '$g= ' . $g . "<br />";
	$qrysel = "select uid from members where guid = '" . $g . "'";
	 
  $_SESSION['errmsg'] .= $qrysel . "<br />";
  $result = $myDbgateway->readSQL($qrysel,"hash");
  $cntr = count($result);
  $_SESSION['errmsg'] .= '$result= ' . $result . "cnt= " . $cntr . "<br />";
  $_SESSION['errmsg'] .= "uid= " . trim($result['uid']) . "<br />";
  $rr_uid = trim($result['uid']);
  
  return $rr_uid;
}	

//note you will need to configure this for your mail servers
function sendEmail() {
	
require_once "Mail.php";

$from = "Joe Dokes <youraddress@youremail.com>";
$to = $_REQUEST['tb_email'];
$subject = "Detail to complete navTango signup";
$body = "Hi " . $_REQUEST['tb_username']. ",\n\n";
$body .= "Thanks for signing up for zenyan\n\n";
$body .= "Your login name is the email address you gave us. \n";
$body .= "Your Key is " . $_SESSION['tmpguid'] . "\n\n";
$body .= "Before you can use navTango we must validate your registration. 
To do so enter the key we have supplied in the field on the screen we took
you to as part of the registration process. If for some reason you are unable
to complete your registration at this time you may complete it later by 
accessing the url http://www.yoururl.com/regfinal.php. \n\n";
$body .= "Your email message goes here tab\n\n";
$body .= "Regards,\n";
$body .= "Joe Dokes";

$host = "mail.yourmailserver.com";
$username = "yourname+yourmailserver.com";
$password = "yourpassword";

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>..." . $mail->getMessage() . "</p>");
 } else {
  echo("<p>An email has been sent to you which includes your registration
  key.</p>");
 }	

}	

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet/mncontent.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>zenyan</title>
<style type="text/css">
<!--
.style2 {font-size: small}
-->
</style>
</head>
<body>
<h1>
You have finished zenyan registration
</h1>
<p><?php if ($traceflg == 'y') {echo $_SESSION['errmsg'];} ?></p>
<p>Enter the key provided in email sent to you. If you do not receive an email from us in the next minute or two, check your
email spam folder. It is also possible that you entered an incorrect email address.</p>
<p>
PLEASE NOTE! You will be required to enter your email address twice and click the button
twice. We are sorry for this inconvenience. We do this to ensure you are a human and not
a bot. 
</p>	
<div align="left">
 <form method="POST" action="regfinalval.php">
  <table border="0" cellspacing="4" width="636">
    <tr>
      <td width="170" height="25">
        <p align="right"><b>Email</b><font color="#FF0000"></font>:      </td>
      <td width="450" height="25">
      	<input type="text" name="tb_email" size="60" value="<?php echo $_SESSION['tb_email']; ?>">      
      </td>
    </tr>    
    <tr>
      <td height="25">
        <p align="right"><b>Registration Key</b>:</td>
      <td height="25"><input type="text" name="tb_key" size="21""></td>
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
