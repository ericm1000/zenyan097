<?php
//main registration form
session_start();  //required in order to get generated session key

require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);
include($php_daclib);

$uimsg = '';

// turn code trace on: y = enable
$traceflg = '';
$trace = '';
$trace .=  '$_REQUEST[\'lb_dbms1\']       = ' . $_REQUEST['lb_dbms1']       . "<br />";
$trace .=  '$_REQUEST[\'tb_conn_name1\']  = ' . $_REQUEST['tb_conn_name1']  . "<br />";
$trace .=  '$_REQUEST[\'tb_login1\']      = ' . $_REQUEST['tb_login1']      . "<br />";
$trace .=  '$_REQUEST[\'tb_pwd1\']        = ' . $_REQUEST['tb_pwd1']        . "<br />";
$trace .=  '$_REQUEST[\'cb_connverify1\'] = ' . $_REQUEST['cb_connverify1'] . "<br />";
$trace .=  '$_REQUEST[\'tb_conn_name2\']  = ' . $_REQUEST['tb_conn_name2']  . "<br />";
$trace .=  '$_REQUEST[\'tb_login2\']      = ' . $_REQUEST['tb_login2']      . "<br />";
$trace .=  '$_REQUEST[\'tb_pwd2\']        = ' . $_REQUEST['tb_pwd2']        . "<br />";
$trace .=  '$_REQUEST[\'tb_host2\']       = ' . $_REQUEST['tb_host2']       . "<br />";
$trace .=  '$_SESSION[\'uid\']            = ' . $_SESSION['uid']            . "<br />";
$trace .=  '$_REQUEST[\'btnval\']         = ' . $_REQUEST['btnval']         . "<br />";

if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}

$myDbgateway = new dbgateway;

if (trim($_REQUEST['btnval']) != '')
{
  $uimsg = '';

//deal with odbc connection types
  if (trim($_REQUEST['tb_conn_name1']) == '' and $_REQUEST['btnval'] == 'odbc')
  {
  	$uimsg = 'Connection Name is a required field. Try Again';	
  }
  else if (trim($_REQUEST['tb_conn_name1']) != '' and $_REQUEST['btnval'] == 'odbc')
  {
  	$retv = insertRow();
  }		
  
//deal with direct connection types  
  else if ((trim($_REQUEST['tb_conn_name2']) == '' or trim($_REQUEST['tb_host2']) == '' ) 
           and  $_REQUEST['btnval'] == 'direct')
  {
  	$uimsg = 'Connection Name and Host Name are both required field. Try Again';
  }
  else if (trim($_REQUEST['tb_conn_name2']) != '' 
      and  trim($_REQUEST['tb_host2']) != '' 
      and  $_REQUEST['btnval'] == 'direct')
  {
  	$retv = insertRow();
  	$trace .= '$retv for odbc = ' . $retv . "<br />";
  }

}	

//----------------------------------------------------------------------------//
function insertRow()
// Register a new connection
//----------------------------------------------------------------------------//
{
  global $uimsg;
  global $trace;
  global $traceflg;
  global $myDbgateway;
  
  $conn_name = '';
  $host      = '';
  $logn      = '';
  $pwd       = '';
  $conn_type = '';
  $v_user    = '';
  $v_flg     = '';

 // may seem like overkill now, but allows for easier integration of broader 
 // scope jdbc connectivity in future
 if ($_REQUEST['btnval'] == 'odbc')
 {
    $conn_type = 'O';
    if (trim($_REQUEST['lb_dbms1']) == 'SQL Server')
    {
   	$dbms = 'SqlServer-ODBC';
    }	
    else if (trim($_REQUEST['lb_dbms1']) == 'Attunity NonStop') //our one exception, for now
    {
   	$dbms = 'Attunity-JDBC';
   	$conn_type = 'J';
    }
    else if (trim($_REQUEST['lb_dbms1']) == 'Oracle') //our one exception, for now
    {
   	$dbms = 'Oracle-ODBC';
    }
     else if (trim($_REQUEST['lb_dbms1']) == 'MySQL') //our one exception, for now... later we can set a global flag in config if they are using odbc
    {
   	$dbms = 'MySQL-ODBC';
    }   
 //populate other vars for insert     
    $conn_name = $_REQUEST['tb_conn_name1'];
    $logn      = $_REQUEST['tb_login1'];     
    $pwd       = $_REQUEST['tb_pwd1'];       
    $v_flg     = $_REQUEST['cb_connverify1'];
    $v_user    = $_SESSION['uid'];           
 
   }	
 
 // ... or we deal with insert for direct mysql connection type
 else if ($_REQUEST['btnval'] == 'direct')
 {
   $dbms = 'Mysql-Direct';
   $conn_type = 'D';
 //populate other vars for insert
   $conn_name = $_REQUEST['tb_conn_name2']; 
   $logn = $_REQUEST['tb_login2'];     
   $pwd  = $_REQUEST['tb_pwd2'];       
   $host = $_REQUEST['tb_host2']; 
   $v_user = $_SESSION['uid'];
 }	
 
 $insquery	=  "INSERT INTO connmgr 
(
  conn_name,
  host,
  logn,
  pwd,
  db,
  dbms,
  inactive_flg,
  conn_type,
  verify_user,
  verify_flg
) 
VALUES 
(
  '$conn_name',
  '$host',
  '$logn',
  '$pwd',
  '$conn_name',
  '$dbms',
  NULL,
  '$conn_type',
  '$v_user',
  '$v_flg'
)";
 
 if ($traceflg == 'y'){ $trace .=  "<br />" . $insquery . "<br />"; }
 
 $result = $myDbgateway->writeSQL($insquery);

 $uimsg .= $result . " Row inserted";

  return $uimsg;
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet/mncontent.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>DataMiner Connection Manager</title>
<style type="text/css">
<!--
.style2 {font-size: small}
-->
</style>

<script type="text/javascript">
function ShowConnType(op) {
  document.getElementById('ODBC').style.display='none';
  document.getElementById('Direct').style.display='none';

  if (op == 1) {
    document.getElementById('ODBC').style.display="block";
  }
  if (op == 2) {
    document.getElementById('Direct').style.display="block";
  }
}

</script>

</head>
<body>
<h1>
DataMiner Register a Connection with DataMiner
</h1>
<p><i>Note: If registering an ODBC connection, DataMiner assumes you have 
already created and tested your ODBC connection. This is not creating an
ODBC connection</i></p>

<div align="left">
  <table border="0" cellspacing="0" width="680" cellpadding="5">
    <tr>
      <td width="1"></td>
      <td width="552">
<p align="center">

</p>
      </td>
    </tr>
    <tr>
      <td width="1"></td>
      <td width="552">
 <p align="center">

</p>
      </td>
    </tr>
    <tr>
      <td width="1"></td>
      <td width="552">

      </td>
    </tr>
  </table>
</div>
<div align="left">
  <table border="0" cellpadding="0" cellspacing="0" width="700">
    <tr>
      <td>
      </td>
    </tr>
  </table>
</div>
<p><?php echo $_SESSION['errmsg'] ?></p>

  <table border="0" cellpadding="0" cellspacing="0" width="700">
    <tr>
      <td  width="200" align="right" valign="top">Connection Type&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
        <select size="1" name="lb_conn_type" onChange="ShowConnType(this.selectedIndex)">
          <option></option>
<!-- note JDBC is currently available but fixed to NonStop Attunity. 
Maybe we will expand this at a later date -->          
          <option>ODBC</option>
          <option>Direct</option>
        </select>
      </td>  
    </tr>
   </table>


 
<div id="ODBC" style="display:none">
<table border="0" cellpadding="0" cellspacing="0" width="700">
 <form method="POST" action="connmgradd.php?btnval=odbc">
    <tr>
      <td  width="200" align="right" valign="top">DBMS&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
        <select size="1" name="lb_dbms1">
          <option></option>         
          <option>Attunity NonStop</option>
          <option>SQL Server</option>
          <option>Oracle</option>
          <option>MySQL</option>
        </select>
      </td>
    </tr>  
    <tr>
      <td  width="200" align="right" valign="top">Connection Name&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_conn_name1" size="30">&nbsp;&nbsp;<a href="#" title="This is the ODBC name.">help</a>
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Login&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_login1" size="15">
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Password&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="password" name="tb_pwd1" size="10">
    </tr>
    <tr>
      <td  width="300" align="right" valign="top">Have you verified ODBC connectivity?&nbsp;</td>
      <td  width="100" align="left" valign="top">
      <input type="checkbox" name="cb_connverify1" value="y">
    </tr>
    <tr>
    <br />
      <td><input type="submit" value="Register Connection" name="btnreg1"></td>
      <td></td>
    </tr>
   </table>
 </form> 
</div>

<div id="Direct" style="display:none">
<table border="0" cellpadding="0" cellspacing="0" width="700">
 <form method="POST" action="connmgradd.php?btnval=direct"> 
    <tr>
      <td  width="200" align="right" valign="top">Connection Name&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_conn_name2" size="30">&nbsp;&nbsp;<a href="#" title="This is the MySQL database name">help</a>
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Host Name&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_host2" size="50">&nbsp;&nbsp;<a href="#" title="This is the IP address or dns name of the local MySQL Database">help</a>
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Login&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_login2" size="15">
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Password&nbsp;&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="password" name="tb_pwd2" size="10">
    </tr>
    <tr>
    <br />
      <td><input type="submit" value="Register Connection" name="btnreg2"></td>
      <td></td>
    </tr>
   </table>
 </form>
<p>Note: You typically only use this connection type when extending DataMiner functionality.</p>
</div>

<p><?php echo $uimsg;  ?></p>
<p><?php if ($traceflg == 'y') { echo $trace; } ?></p>
<p>&nbsp;</p>
</body>
