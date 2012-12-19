<?php
// zenyan Login Module
// Initial Writing: Norm Zemke
// Date: Feb 3, 2012
// License: Dual licensed under the MIT and GPL license
/*
Login Management Admin Functions 
*/
// History/Customizations:
/*
 02/03/2012: Norm Zemke: Initial writing, based on program register.php
 02/17/2012: Eric Matthews: Integration of end user functions into tabs
                            Modifed query to prevent sql injection attacks
                            Added code to deal with maintain current tab context after form submit...
Note: While the tab code may seem to not be coded in the most elegant fashion it needs to be understood
that a tab can contain multiple forms within it. Addtionally, it may not be desired to maintained the
same tab context given a specific submit action. For example, one button press we may want to stay one
the current tab, whereas for another button press we may want to transition to a another tab (workflow).                         
So while the code may seem a bit klunky you can see how we gain navigational flexibility by doing it this
way.                          
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
 

$ioretv = "";

$lugrid_resetuserpwd = '';
$lugrid_suspenduser = '';
$lugrid_unsuspenduser = '';
$lugrid_deleteuser = '';

$user_select_errormsg = "You did not select a User.";
$user_lookup_errormsg = "You did not enter any user lookup.";

//below used (typically) within each tab
$tab1msg = '';
$tab2msg = '';
$tab3msg = '';
$tab4msg = '';
$tab5msg = '';
$tsttabmsg1 = '';
$tsttabmsg2 = '';
$tsttabmsg3 = '';
$tsttabmsg4 = '';
$tsttabmsg5 = '';

$lasttab = 0; //default to first tab for initial form entry
$frmgrid = 1; //for grid control javascript, set to default value of one of the forms
$frmgrid2 = 3;
$frmgrid3 = 5;
$frmgrid4 = 7;

$myDbgateway = new dbgateway;

if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}
  
if (!($_SESSION['admin_flg'] == 'z' or $_SESSION['admin_flg'] == 'y')) {
  die("This function restricted to system administrators");
}  
 
//------------------------------------------------------------------------------
//Add User
    if ($_REQUEST['p'] == "form1") { 
      $tab1msg = insertNewUser();
      $lasttab = $_REQUEST['tabmrkr1'];
    } 
//------------------------------------------------------------------------------
// Reset User Password   
    else if ($_REQUEST['p'] == "form_reset_user_pwd") {
      if (trim($_REQUEST['tb_reset_pwd_lname']) != '') {
        $tb_reset_pwd_lname = trim($_REQUEST['tb_reset_pwd_lname']);
        $_SESSION['reset_pwd_lname'] = $tb_reset_pwd_lname;
        $select_cmd = "SELECT guid FROM gate WHERE lname  = '" . $tb_reset_pwd_lname . "'"; 
        $readSQL_out = $myDbgateway->readSQL($select_cmd,"delim");
        $guid = $readSQL_out[0];
        $newpwd = substr(generateGUID(),0,8);  // auto-generated password will be a truncated Guid
        $epwd = computePassword($newpwd, $guid);
        $updateQuery = "UPDATE gate SET pwd = '" . $epwd . "' WHERE lname = '" . $_SESSION['reset_pwd_lname'] . "'"; 
        $result = $myDbgateway->writeSQL($updateQuery);   

        $pfw_email_to = $row['curr_email_addr'];         
        $pfw_header = "Password has been reset";
        $pfw_subject = "Reset password";
        $pfw_message = "Your password has been reset to $newpwd.  Please change it the next time you log on.";

        if ($loginmailflg == 'y'){
          @mail($pfw_email_to, $pfw_subject ,$pfw_message ,$pfw_header ) ;
        }

        $ioretv = addGateHistory($_SESSION['reset_pwd_lname'],"u",$myDbgateway);

        $retv = populateGrid_Gate_ResetUserPwd($_SESSION['reset_pwd_qrysel']);
        $tab2msg = " user password has been reset to $newpwd"; 
        $lasttab = $_REQUEST['tabmrkr2a'];
      } else {
        $lasttab = $_REQUEST['tabmrkr2a'];
        $tab2msg = $user_select_errormsg;
      }  	
    }	
    // Lookup User for Reset User Password    
    else if ($_REQUEST['p'] == "form_reset_user_pwdLU") {
    	  $lasttab = $_REQUEST['tabmrkr2b'];
        if (trim($_REQUEST['tb_lname_contains1']) != '') {
          $_SESSION['reset_pwd_qrysel'] = $_REQUEST['tb_lname_contains1'];
          $retv = populateGrid_Gate_ResetUserPwd($_SESSION['reset_pwd_qrysel']);
        }  else {
        	 $tab2msg = $user_lookup_errormsg;
        }  	  
    }	
//------------------------------------------------------------------------------
// Suspend User   
    else if ($_REQUEST['p'] == "form_suspend_user") {
      if (trim($_REQUEST['tb_suspend']) != '') {
        $_SESSION['suspend_lname'] = trim($_REQUEST['tb_suspend']);

        $select_cmd = "SELECT uid, entity_typ_flg FROM gate WHERE lname  = '" . $_SESSION['suspend_lname'] . "'"; 
        $readSQL_out = $myDbgateway->readSQL($select_cmd,"delim");
        $readSQL_out_array = explode($fw_delimsymb,$readSQL_out[0]);
        $suspend_uid  = $readSQL_out_array[0];      
        $suspend_entity_typ_flg  = $readSQL_out_array[1];      

        $update_gate = "UPDATE gate SET inactive_flg = 'y' WHERE lname = '" . $_SESSION['suspend_lname'] . "'"; 
        $result = $myDbgateway->writeSQL($update_gate);   

        if (trim($suspend_entity_typ_flg) == 'group') {
          $update_gategrps = "UPDATE gategrps SET inactive_flg = 'y' WHERE parent_uid = $suspend_uid"; 
          $result = $myDbgateway->writeSQL($update_gategrps);   
        }

        $ioretv = addGateHistory($_SESSION['suspend_lname'],"u",$myDbgateway);

        $retv = populateGrid_Gate_SuspendUser($_SESSION['suspend_qrysel']);
        $tab3msg = " user " . $_SESSION['suspend_lname'] . " has been suspended";
        $_SESSION['suspend_lname'] = ''; 
        $lasttab = $_REQUEST['tabmrkr3a'];
      } else {
        $lasttab = $_REQUEST['tabmrkr3a'];
        $tab3msg = $user_select_errormsg;
      }  	
    }
    // Lookup User
    else if ($_REQUEST['p'] == "form_suspend_userLU") {
    	  $lasttab = $_REQUEST['tabmrkr3b'];
        if (trim($_REQUEST['tb_lname_contains2a']) != '') {
          $_SESSION['suspend_qrysel'] = $_REQUEST['tb_lname_contains2a'];
          $retv = populateGrid_Gate_SuspendUser($_SESSION['suspend_qrysel']);
        }  else {
        	 $tab3msg = $user_lookup_errormsg;
        }  	  
    }
    
// Unsuspend User   
    else if ($_REQUEST['p'] == "form_unsuspend_user") {
      if (trim($_REQUEST['tb_unsuspend']) != '') {
        $_SESSION['unsuspend_lname'] = trim($_REQUEST['tb_unsuspend']);

        $select_cmd = "SELECT uid, entity_typ_flg FROM gate WHERE lname  = '" . $_SESSION['unsuspend_lname'] . "'"; 
        $readSQL_out = $myDbgateway->readSQL($select_cmd,"delim");
        $readSQL_out_array = explode($fw_delimsymb,$readSQL_out[0]);
        $unsuspend_uid  = $readSQL_out_array[0];      
        $unsuspend_entity_typ_flg  = $readSQL_out_array[1];      

        $update_gate = "UPDATE gate SET inactive_flg = '' WHERE lname = '" . $_SESSION['unsuspend_lname'] . "'"; 
        $result = $myDbgateway->writeSQL($update_gate);   

        if (trim($unsuspend_entity_typ_flg) == 'group') {
          $update_gategrps = "UPDATE gategrps SET inactive_flg = NULL WHERE parent_uid = $unsuspend_uid"; 
          $result = $myDbgateway->writeSQL($update_gategrps);   
        }

        $ioretv = addGateHistory($_SESSION['unsuspend_lname'],"u",$myDbgateway);

        $retv = populateGrid_Gate_UnsuspendUser($_SESSION['unsuspend_qrysel']);
        $tab4msg = " user " . $_SESSION['unsuspend_lname'] . " has been unsuspended"; 

        $_SESSION['unsuspend_lname'] = '';
        $lasttab = $_REQUEST['tabmrkr4a'];
      } else {
        $lasttab = $_REQUEST['tabmrkr4a'];
        $tab4msg = $user_select_errormsg;
      }  	
    }
    // Lookup User
    else if ($_REQUEST['p'] == "form_unsuspend_userLU") {
    	  $lasttab = $_REQUEST['tabmrkr4b'];
        if (trim($_REQUEST['tb_lname_contains2b']) != '') {
          $_SESSION['unsuspend_qrysel'] = $_REQUEST['tb_lname_contains2b'];
          $retv = populateGrid_Gate_UnsuspendUser($_SESSION['unsuspend_qrysel']);
        }  else {
        	 $tab4msg = $user_lookup_errormsg;
        }  	  
    }

// Delete User   
    else if ($_REQUEST['p'] == "form_delete_user") {
      if (trim($_REQUEST['tb_delete']) != '') {
        $_SESSION['delete_lname'] = trim($_REQUEST['tb_delete']);
        //get the uid so we can cleanup gategrps 
        $sel_gate_uid = "SELECT uid FROM gate WHERE lname  = '" . $_SESSION['delete_lname'] . "'"; 
        $gate_uid = $myDbgateway->readSQL($sel_gate_uid,"delim");
        $uid  = (int)$gate_uid[0];      

        $del_gate = "DELETE FROM gate WHERE lname  = '" . $_SESSION['delete_lname'] . "'"; 
        $result = $myDbgateway->writeSQL($del_gate); 
        //remove gategrps rows
        $del_gategrps = "DELETE FROM gategrps WHERE parent_uid  = " . $uid;      
        $result = $myDbgateway->writeSQL($del_gategrps);   
        //remove lnks_itm rows
        $del_lnks = "DELETE FROM lnks WHERE member_uid  = " . $uid;
        $result = $myDbgateway->writeSQL($del_lnks);  
        //remove lnks rows        
        $del_lnks_itm = "DELETE FROM lnks_itm WHERE member_uid  = " . $uid;
        $result = $myDbgateway->writeSQL($del_lnks_itm);         
        //upodate gatehist which we do not delete as part of this function
        $ioretv = addGateHistory($_SESSION['delete_lname'],"u",$myDbgateway);

        $retv = populateGrid_Gate_DeleteUser($_SESSION['delete_qrysel']);
        $tab5msg = " user " . $_SESSION['delete_lname'] . " has been Deleted"; 
        $lasttab = $_REQUEST['tabmrkr5a'];
        $_SESSION['delete_lname'] = '';
      } else {
        $lasttab = $_REQUEST['tabmrkr5a'];
        $tab5msg = $user_select_errormsg;
      }  	
    }
    // Lookup User to Delete
    else if ($_REQUEST['p'] == "form_delete_userLU") {
    	  $lasttab = $_REQUEST['tabmrkr5b'];
        if (trim($_REQUEST['tb_lname_contains3']) != '') {
          $_SESSION['delete_qrysel'] = $_REQUEST['tb_lname_contains3'];
          $retv = populateGrid_Gate_DeleteUser($_SESSION['delete_qrysel']);
        }  else {
        	 $tab5msg = $user_lookup_errormsg;
        }  	  
    }


//End Main Control  

//ADD USER CODE  
function insertNewUser () {
  global $myDbgateway;

  $replyCode = validateNewLoginName($_REQUEST['lname'], $myDbgateway);
  if ($replyCode != 'ok') {return $replyCode;}
  if (!(preg_match("/.+@.+\..+/", $_REQUEST['curr_email_addr']))) {
    return "Invalid email address";
  }

  // we have cleared input checking of login name, we can now validate password to rules
  $newpwd;
  if (!trim($_REQUEST['pwd']) and !trim($_REQUEST['pwd2'])) {
    // if no passwords entered, generate a random password
    $newpwd = substr(generateGUID(),0,8);  
    $_REQUEST['pwd'] = $newpwd;
    $_REQUEST['pwd2'] = $newpwd;
  } else {
    $replyCode = validateNewPassword(trim($_REQUEST['pwd']),trim($_REQUEST['pwd2']),trim($_REQUEST['lname']));
    if ($replyCode != 'ok') {return $replyCode;}
  }
  $entity_typ_flg = trim($_REQUEST['add_entity_typ']);
  if (! $entity_typ_flg) {$entity_typ_flg = 'user';}
  // we have cleared input checking of the password, we can now create new login
  $replyCode = createNewUser(trim($_REQUEST['lname']),trim($_REQUEST['pwd']),
                    trim($_REQUEST['firstname']),trim($_REQUEST['lastname']),
                    trim($_REQUEST['curr_email_addr']),$entity_typ_flg,
                    trim($_REQUEST['add_admin_flg']),$myDbgateway);
   if ($_REQUEST['curr_email_addr']) {
     $pfw_email_to = $_REQUEST['curr_email_addr'];
     $pfw_header = "Login Id Created";
     $pfw_subject = "Your login id is ready";
     $pfw_message = "Your logon id have been created with a login name of "
     . $_REQUEST['lname'] . " and a password of "
     . $_REQUEST['pwd'] . ".  Please change you password the first time you log on.";

     if ($loginmailflg == 'y'){
        @mail($pfw_email_to, $pfw_subject ,$pfw_message ,$pfw_header ) ;
     }   
        
   }
   
   if ($newpwd) {$replyCode .= " with randomly generated password of $newpwd";}
   unset ($_REQUEST['lname'],$_REQUEST['pwd'],$_REQUEST['pwd2'],$_REQUEST['firstname'],
                    $_REQUEST['lastname'],$_REQUEST['curr_email_addr'],
                    $_REQUEST['add_admin_flg']);
   return $replyCode;      
}

//USER LOOKUP FUNCTIONS
function populateGrid_Gate_ResetUserPwd($lname) {
  global $lugrid_resetuserpwd;
  global $myDbgateway;
  global $loginmgmtMaxRows;
  global $fw_typesql;
  
  $query = "SELECT lname,firstname,lastname FROM gate where lname like '" . $lname . "'";   
  if ($fw_typesql == "MySQL") {
    // the loginmgmtMaxRows param is only valid in MySQL
    $query .= " limit $loginmgmtMaxRows";  
  }
  
  $lugrid_resetuserpwd  = $myDbgateway->readSQL($query,'grid');
  
  return $lname;  
}

function populateGrid_Gate_SuspendUser($lname) {
  global $lugrid_suspenduser;
  global $myDbgateway;
  global $loginmgmtMaxRows;  
  global $fw_typesql;

  $query = "SELECT lname,firstname,lastname FROM gate where lname like '" . $lname . 
      "' and inactive_flg = ''";  
  if ($fw_typesql == "MySQL") {
    // the loginmgmtMaxRows param is only valid in MySQL
    $query .= " limit $loginmgmtMaxRows";  
  }

  $lugrid_suspenduser = $myDbgateway->readSQL($query,'grid');
    
  return $lname;  
}

function populateGrid_Gate_UnsuspendUser($lname) {
  global $lugrid_unsuspenduser;
  global $myDbgateway;
  global $loginmgmtMaxRows;  
  global $fw_typesql;

  $query = "SELECT lname,firstname,lastname FROM gate where lname like '" . $lname . 
        "' and inactive_flg = 'y'";  
  if ($fw_typesql == "MySQL") {
    // the loginmgmtMaxRows param is only valid in MySQL
    $query .= " limit $loginmgmtMaxRows";  
  }

  $lugrid_unsuspenduser = $myDbgateway->readSQL($query,'grid');
    
  return $lname;  
}

function populateGrid_Gate_DeleteUser($lname) {
  global $lugrid_deleteuser;
  global $myDbgateway;
  global $loginmgmtMaxRows;  
  global $fw_typesql;

  $query = "SELECT lname,firstname,lastname FROM gate where lname like '" . $lname . "'";  
  if ($fw_typesql == "MySQL") {
    // the loginmgmtMaxRows param is only valid in MySQL
    $query .= " limit $loginmgmtMaxRows";  
  }

  $lugrid_deleteuser = $myDbgateway->readSQL($query,'grid');
  
  return $lname;  
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Sys Admin - Login Management</title>
<!-- note: i modified nestedmenu and ui.tabs to add z-index so top menu renders over tabs. -->
	
	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection">
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" >
    <![endif]-->
			
	<script type="text/javascript" src="jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="jquery/jquery.dropdownPlain.js"></script>

<link media="print, projection, screen" href="jquery/stylesheet/ui.tabs.css" type=text/css rel=stylesheet>
<script src="jquery/jquery182.min.js" type=text/javascript></script>
<script src="jquery/ui.core16rc5.js" type=text/javascript></script>
<script src="jquery/ui.tabs16rc5.js" type=text/javascript></script>

<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css">
<link rel="stylesheet" type="text/css" href="stylesheet/gridcontrol.css" media="all" >


<script type="text/javascript">
onload = function() {	
    getCellValsResetPassword("t1");
    getCellValsSuspendUser("t2");
    getCellValsUnsuspendUser("t3");
    getCellValsDeleteUser("t4")
} 
    
function getCellValsResetPassword(t_id) {
var tid = t_id;
if (! document.getElementsByTagName || ! document.createTextNode){ return; }
var rows = document.getElementById(tid).getElementsByTagName('tbody')[0].getElementsByTagName('tr');
//no can do below due to IE 6 conditionals in top menu code that create indice displacement
//var rows = document.getElementsByTagName('table')[3].getElementsByTagName('tbody')[0].getElementsByTagName('tr');
 for (i=0;i<rows.length;i++) 
 {
   rows[i].onclick = function() 
   {
       var cels = this.cells;            
       //alert(this.rowIndex - 1 + this.innerText);
       //alert(this.rowIndex - 1 + cels[2].innerText ); 
// for ie        
if(document.all){         
       document.forms[<?php echo $frmgrid; ?>].tb_reset_pwd_lname.value = cels[0].innerText;  
//for firefox and safari       
} else{           
       document.forms[<?php echo $frmgrid; ?>].tb_reset_pwd_lname.value = cels[0].textContent;
}           
   }
 }
}

function getCellValsSuspendUser(t_id) {
var tid = t_id;
if (! document.getElementsByTagName || ! document.createTextNode){ return; }
var rows = document.getElementById(tid).getElementsByTagName('tbody')[0].getElementsByTagName('tr');
 for (i=0;i<rows.length;i++) 
 {
   rows[i].onclick = function() 
   {
       var cels = this.cells;            
// for ie        
if(document.all){         
       document.forms[<?php echo $frmgrid2; ?>].tb_suspend.value = cels[0].innerText;  
//for firefox and safari       
} else{           
       document.forms[<?php echo $frmgrid2; ?>].tb_suspend.value = cels[0].textContent;
}           
   }
 }
}

function getCellValsUnsuspendUser(t_id) {
var tid = t_id;
if (! document.getElementsByTagName || ! document.createTextNode){ return; }
var rows = document.getElementById(tid).getElementsByTagName('tbody')[0].getElementsByTagName('tr');
 for (i=0;i<rows.length;i++) 
 {
   rows[i].onclick = function() 
   {
       var cels = this.cells;            
// for ie        
if(document.all){         
       document.forms[<?php echo $frmgrid3; ?>].tb_unsuspend.value = cels[0].innerText;  
//for firefox and safari       
} else{           
       document.forms[<?php echo $frmgrid3; ?>].tb_unsuspend.value = cels[0].textContent;
}           
   }
 }
}

function getCellValsDeleteUser(t_id) {
var tid = t_id;
if (! document.getElementsByTagName || ! document.createTextNode){ return; }
var rows = document.getElementById(tid).getElementsByTagName('tbody')[0].getElementsByTagName('tr');
 for (i=0;i<rows.length;i++) 
 {
   rows[i].onclick = function() 
   {
       var cels = this.cells;            
// for ie        
if(document.all){         
       document.forms[<?php echo $frmgrid4; ?>].tb_delete.value = cels[0].innerText;  
//for firefox and safari       
} else{           
       document.forms[<?php echo $frmgrid4; ?>].tb_delete.value = cels[0].textContent;
}           
   }
 }
}


   $(function() {
      $('#etabs> ul').tabs({ fx: { opacity: 'toggle' } });
   });

    $(function() {
       $("#etabs").tabs({ selected: <?php echo $lasttab; ?> });
    }); 
</script>

<script type="text/javascript" src="eUI/script/gridcontrol.js"></script>
</head>

<body>

<h1>Sys Admin - Login Management</h1>
<!-- adequate spacing between top menu and start of tabs -->	
<br />

<!--
Below is section where you implement the tabs. Add or subtract tabs as needed.
The tab name goes between the span tag.  
-->
<div id=etabs>
<ul>
  <li><a
  href="#tab-1"><span>Add User/Group</span></a> 
  <li><a
  href="#tab-2"><span>Reset User/Group Password</span></a> 
  <li><a
  href="#tab-3"><span>Suspend User/Group</span></a> 
  <li><a
  href="#tab-4"><span>Unsuspend User/Group</span></a>
  <li><a
  href="#tab-5"><span>Delete User/Group</span></a>
</ul>
</div>

<!-- TAB1-------------- REGISTER NEW USER/GROUP ---------------------------- -->
<!-- Need to move this function back to being able to register both a user or a group -->
<div id="tab-1">
<h1>Register New User</h1>
  <br />
<form id="form1" name="form1" method="POST" action="adm_sysad_loginmgmt.php?p=form1">
  <input type="hidden" name="tabmrkr1" id="tabmrkr1" value="0" />
  <label>Enter a user login name
    <input name="lname" type="text" id="lname" size="35" maxlength="35"
      value="<?php echo $_REQUEST['lname']; ?>"/>
  </label>
  <a href="#" tabindex=-1 title="minimum 8 characters, maximun 35 characters.">logon name help</a>
  <br />
  
  <label><br />
     Password
    <input name="pwd" type="password" id="pwd" size="10" maxlength="10" 
      value="<?php echo $_REQUEST['pwd']; ?>"/>    
  </label>
  <a href="#" tabindex=-1 title="8 to 10 characters; Characters 0-9, A-Z, a-z, +,-,_,+ (not the comma or semi-colon) are acceptable; at least one number, one lowercase letter, and one uppercase letter are required.">password help</a>
  
  <label><br />
     Reenter Password
    <input name="pwd2" type="password" id="pwd2" size="10" maxlength="10" 
      value="<?php echo $_REQUEST['pwd2']; ?>"/>
  </label><br />
  <br />

  <label>Enter a first and last names
    <input name="firstname" type="text" id="lname" size="18" maxlength="18" 
      value="<?php echo $_REQUEST['firstname']; ?>"/>
    <input name="lastname" type="text" id="lname" size="25" maxlength="25" 
      value="<?php echo $_REQUEST['lastname']; ?>"/>
  </label><br />
  <label>Enter email address
    <input name="curr_email_addr" type="text" id="lname" size="80" maxlength="80" 
      value="<?php echo $_REQUEST['curr_email_addr']; ?>"/>
  </label><br />

  <label>Enter administator type
        <select size="1" name="add_admin_flg">
          <option></option>
          <option value=" " <?php if ($_REQUEST['add_admin_flg'] <> 'z' and 
                                $_REQUEST['add_admin_flg'] <> 'g') {echo " selected";} ?> 
                      >not an administrator</option>
          <option value="g" <?php if ($_REQUEST['add_admin_flg'] == 'g') {echo " selected";} ?> 
                      >group administrator</option>
          <option value="z" <?php if ($_REQUEST['add_admin_flg'] == 'z') {echo " selected";} ?> 
                      >system administrator</option>
        </select>
  </label><br />

  <label>Enter entity type
        <select size="1" name="add_entity_typ">
          <option></option>
          <option value="user" selected>user</option>
          <option value="group">group</option>
        </select>
  </label><br />
  <br /> 
  <input type="submit" name="submitfrm1" id="submitfrm1" value="Add New User" />
  </label>
</form> 
<?php echo $tab1msg; ?> 
<?php echo $tsttabmsg1; ?> 

</div>

<!-- TAB2-------------- RESET USER/GROUP PASSWORD -------------------------- -->
<div id="tab-2">
<h1>Reset User/Group Password</h1>

<table id="t1" class="example table-autosort 
                              table-autofilter 
                              table-autopage:7
                              table-stripeclass:alternate 
                              table-page-number:t1page 
                              table-page-count:t1pages 
                              table-filtered-rowcount:t1filtercount 
                              table-rowcount:t1allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='225'><img src="eUI/script/images/arrow_left.gif" /></td>
  <td style="text-align:left;" width='75'>Page <span id="t1page"></span>&nbsp;of <span id="t1pages"></span></td>
  <td class="table-page:next" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_right.gif" /></td>
 </tr>
 <tr>
  <th class="table-filterable table-sortable:default" width='225'>Logon Name</th>
  <th class="table-sortable:default" width='150'>First Name</th>
  <th class="table-filterable table-sortable:default" width='75'>Last Name</th> 
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid_resetuserpwd)){echo $lugrid_resetuserpwd;} ?>  
</tbody>
</table>

<form id="form_reset_user_pwd" name="form_reset_user_pwd" method="post" action="adm_sysad_loginmgmt.php?p=form_reset_user_pwd">
  <input type="hidden" name="tabmrkr2a" id="tabmrkr2a"  value="1" />
<br />
<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrmreset_user_pwd" id="submitfrmreset_user_pwd" value="Reset Password" />		
</td>
<td width="175" align="right">Selected User:&nbsp;</td>
<td width="225"><input type="text" name="tb_reset_pwd_lname" size="25" value="<?php echo $_SESSION['reset_pwd_lname']; ?>"  /></td>
</tr>
</table>
</form>

<h2>Lookup User/Group</h2>
<form name="form_reset_user_pwdLU" id="form_reset_user_pwdLU" method="post" action="adm_sysad_loginmgmt.php?p=form_reset_user_pwdLU" >
<input type="hidden" name="tabmrkr2b" id="tabmrkr2b"  value="1" />

<table>
<tr>
<td width="125" align="right">
<input type="submit" "submitfrm2b" id="submitfrm2b" value="Lookup User" />
</td>
<td width="175" align="right">Logon Name contains:&nbsp;</td>
<td width="225"><input type="text" name="tb_lname_contains1" size="25" value="<?php echo $_SESSION['reset_pwd_qrysel']; ?>" /></td>
</tr>
</table>	
</form>

<?php echo $tab2msg; ?>
<?php echo $tsttabmsg2; ?>
</div>

<!-- TAB3-------------- SUSPEND USER/GROUP --------------------------------- -->
<div id="tab-3">

<h1>Suspend User/Group</h1>

<table id="t2" class="example table-autosort 
                              table-autofilter 
                              table-autopage:7
                              table-stripeclass:alternate 
                              table-page-number:t2page 
                              table-page-count:t2pages 
                              table-filtered-rowcount:t2filtercount 
                              table-rowcount:t2allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='225'><img src="eUI/script/images/arrow_left.gif" /></td>
  <td style="text-align:left;" width='75'>Page <span id="t2page"></span>&nbsp;of <span id="t2pages"></span></td>
  <td class="table-page:next" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_right.gif" /></td>
 </tr>
 <tr>
  <th class="table-filterable table-sortable:default" width='225'>Logon Name</th>
  <th class="table-sortable:default" width='150'>First Name</th>
  <th class="table-filterable table-sortable:default" width='75'>Last Name</th> 
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid_suspenduser)){echo $lugrid_suspenduser;} ?>  
</tbody>
</table>

<br />
<form id="form_suspend_user" name="form_suspend_user" method="post" action="adm_sysad_loginmgmt.php?p=form_suspend_user">
  <input type="hidden" name="tabmrkr3a" id="tabmrkr3a"  value="2" />
<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm3a" id="submitfrm3a" value="Suspend User" />		
</td>
<td width="175" align="right">Selected User:&nbsp;</td>
<td width="225"><input type="text" name="tb_suspend" size="25" value="<?php echo $_SESSION['suspend_lname']; ?>"  /></td>
</tr>
</table>
</form>

<h2>Lookup User/Group</h2>
<form name="form_suspend_userLU" id="form_suspend_userLU" method="post" action="adm_sysad_loginmgmt.php?p=form_suspend_userLU" >
<input type="hidden" name="tabmrkr3b" id="tabmrkr3b"  value="2" />

<table>
<tr>
<td width="125" align="right">
<input type="submit" "submitfrm3b" id="submitfrm3b" value="Lookup User" />
</td>
<td width="175" align="right">Logon Name contains:&nbsp;</td>
<td width="225"><input type="text" name="tb_lname_contains2a" size="25" value="<?php echo $_SESSION['suspend_qrysel']; ?>" /></td>
</tr>
</table>	
</form>

<?php echo $tab3msg; ?>
<?php echo $tsttabmsg3; ?>
 	
</div>

<!-- TAB4-------------- UNSUSPEND USER/GROUP ------------------------------- -->
<div id="tab-4">

<h1>Unsuspend User/Group</h1>

<table id="t3" class="example table-autosort 
                              table-autofilter 
                              table-autopage:7
                              table-stripeclass:alternate 
                              table-page-number:t3page 
                              table-page-count:t3pages 
                              table-filtered-rowcount:t3filtercount 
                              table-rowcount:t3allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='225'><img src="eUI/script/images/arrow_left.gif" /></td>
  <td style="text-align:left;" width='75'>Page <span id="t3page"></span>&nbsp;of <span id="t3pages"></span></td>
  <td class="table-page:next" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_right.gif" /></td>
 </tr>
 <tr>
  <th class="table-filterable table-sortable:default" width='225'>Logon Name</th>
  <th class="table-sortable:default" width='150'>First Name</th>
  <th class="table-filterable table-sortable:default" width='75'>Last Name</th> 
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid_unsuspenduser)){echo $lugrid_unsuspenduser;} ?>  
</tbody>
</table>

<form id="form_unsuspend_user" name="form_unsuspend_user" method="post" action="adm_sysad_loginmgmt.php?p=form_unsuspend_user">
  <input type="hidden" name="tabmrkr4a" id="tabmrkr4a"  value="3" />

<br />
<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm4a" id="submitfrm4a" value="Unsuspend User" />		
</td>
<td width="175" align="right">Selected User:&nbsp;</td>
<td width="225"><input type="text" name="tb_unsuspend" size="25" value="<?php echo $_SESSION['unsuspend_lname']; ?>"  /></td>
</tr>
</table>
</form>

<h2>Lookup User/Group</h2>
<form name="form_unsuspend_userLU" id="form_unsuspend_userLU" method="post" action="adm_sysad_loginmgmt.php?p=form_unsuspend_userLU" >
<input type="hidden" name="tabmrkr4b" id="tabmrkr4b"  value="3" />

<table>
<tr>
<td width="125" align="right">
<input type="submit" "submitfrm4b" id="submitfrm4b" value="Lookup User" />
</td>
<td width="175" align="right">Logon Name contains:&nbsp;</td>
<td width="225"><input type="text" name="tb_lname_contains2b" size="25" value="<?php echo $_SESSION['unsuspend_qrysel']; ?>" /></td>
</tr>
</table>	
</form>

<?php echo $tab4msg; ?>
<?php echo $tsttabmsg4; ?>

</div>

<!-- TAB5-------------- DELETE USER/GROUP ---------------------------------- -->
<div id="tab-5">
	
<h1>Delete User/Group</h1>

<table id="t4" class="example table-autosort 
                              table-autofilter 
                              table-autopage:7
                              table-stripeclass:alternate 
                              table-page-number:t4page 
                              table-page-count:t4pages 
                              table-filtered-rowcount:t4filtercount 
                              table-rowcount:t4allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='225'><img src="eUI/script/images/arrow_left.gif" /></td>
  <td style="text-align:left;" width='75'>Page <span id="t4page"></span>&nbsp;of <span id="t4pages"></span></td>
  <td class="table-page:next" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_right.gif" /></td>
 </tr>
 <tr>
  <th class="table-filterable table-sortable:default" width='225'>Logon Name</th>
  <th class="table-sortable:default" width='150'>First Name</th>
  <th class="table-filterable table-sortable:default" width='75'>Last Name</th> 
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid_deleteuser)){echo $lugrid_deleteuser;} ?>  
</tbody>
</table>
<br />
<form id="form_delete_user" name="form_delete_user" method="post" action="adm_sysad_loginmgmt.php?p=form_delete_user">
  <input type="hidden" name="tabmrkr5a" id="tabmrkr5a"  value="4" />
<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm5a" id="submitfrm5a" value="Delete User" />		
</td>
<td width="175" align="right">Selected User:&nbsp;</td>
<td width="225"><input type="text" name="tb_delete" size="25" value="<?php echo $_SESSION['delete_lname']; ?>"  /></td>
</tr>
</table>
</form>

<h2>Lookup User</h2>
<form name="form_delete_userLU" id="form_delete_userLU" method="post" action="adm_sysad_loginmgmt.php?p=form_delete_userLU" >
<input type="hidden" name="tabmrkr5b" id="tabmrkr5b"  value="4" />
<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm5b" id="submitfrm5b" value="Lookup User" />
</td>
<td width="175" align="right">Logon Name contains:&nbsp;</td>
<td width="255"><input type="text" name="tb_lname_contains3" size="25" value="<?php echo $_SESSION['delete_qrysel']; ?>" /></td>
</tr>
</table>
</form>

<?php echo $tab5msg; ?>
<?php echo $tsttabmsg5; ?>
<div>	
	
</body>

</html>