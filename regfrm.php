<?php
//main registration form
session_start();  //required in order to get generated session key

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet/mncontent.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>DataMiner Registration Page</title>
<style type="text/css">
<!--
.style2 {font-size: small}
-->
</style>
</head>
<body>
<h1>
DataMiner User/Group Registration
</h1>

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

<div align="left">
 <form method="POST" action="regfinal.php">
  <table border="0" cellpadding="0" cellspacing="0" width="700">
    <tr>
      <td  width="200" align="right" valign="top">Login Name<font color="#FF0000">*</font>&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_email" size="40" value="<?php if (trim($_SESSION['errmsg']) != ''){ echo $_SESSION['tb_email'];} ?>">
      </td>
    </tr>
    <tr>
      <td  width="200" align="right" valign="top"><i>Re-enter Login Name</i><font color="#FF0000">*</font>&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_reenteremail" size="40">
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Password<font color="#FF0000">*</font>&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="password" name="tb_pwd" size="8">&nbsp;&nbsp;<a href="#" title="Use characters A-Z,a-z, 0-9 in creating your password">help</a>
    </tr>
    </tr>
    <tr>
      <td  width="200" align="right" valign="top"><i>Re-enter Password</i><font color="#FF0000">*</font>&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="password" name="tb_pwdv" size="8">
     <tr>
      <td  width="200" align="right" valign="top">&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <hr />
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">User Name<font color="#FF0000">*</font>&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_username" size="25" value="<?php if (trim($_SESSION['errmsg']) != ''){ echo $_SESSION['tb_username'];} ?>">
     <hr />
    </tr>
    <tr>
      <td>
        <p align="right">Firstname&nbsp;</td>
      <td>
      <input type="text" name="tb_fname" size="18" value="<?php if (trim($_SESSION['errmsg']) != ''){ echo $_SESSION['tb_fname'];} ?>">
      </td>
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Lastname&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_lname" size="25" value="<?php if (trim($_SESSION['errmsg']) != ''){ echo $_SESSION['tb_lname'];} ?>">
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">
        <p align="center">-- OR --</p>
      </td>
      <td  width="500" align="left" valign="top">
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Group Name&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="text" name="tb_gname" size="25" value="<?php if (trim($_SESSION['errmsg']) != ''){ echo $_SESSION['tb_gname'];} ?>">
    </tr>

     <tr>
      <td  width="200" align="right" valign="top">&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <hr />
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">User Type<font color="#FF0000">*</font>&nbsp;</td>
      <td  width="500" align="left" valign="top">
        <select size="1" name="lb_utype">
          <option></option>
          <option>user</option>
          <option>group</option>
        </select>
    </tr>
    <tr>
      <td  width="200" align="right" valign="top">Admin?&nbsp;</td>
      <td  width="500" align="left" valign="top">
      <input type="checkbox" name="cb_admin" value="y">
    </tr>

    <tr>
      <td><input type="submit" value="Register" name="btnreg">&nbsp;&nbsp;<font color="#FF0000">* Required</font>&nbsp;</td>
      <td></td>
    </tr>
  </table>
 </form>
</div>
<p>&nbsp;</p>
</body>
