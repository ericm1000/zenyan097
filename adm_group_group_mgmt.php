<?php
// Manage Top Menus
// Initial Writing: ericm
// Date: 2/19/2012
// License: Dual licensed under the MIT and GPL license
/*
Manage Menus
*/
// History/Customizations:
/*
                        
*/
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms); 
include($php_applib);
include($php_daclib);
include($php_loggers);

session_start();
 

$ioretv = "";

//below used (typically) within each tab
$tab1msg = '';
$tab2msg = '';
$tab3msg = '';
$tab4msg = '';
$tab5msg = '';
$tab6msg = '';
$tsttabmsg1 = '';
$tsttabmsg2 = '';
$tsttabmsg3 = '';
$tsttabmsg4 = '';
$tsttabmsg5 = '';
$tsttabmsg6 = '';

$frmgrid1 = 0; //for grid control javascript, set to default value of one of the forms
$frmgrid2 = 1;
$frmgrid3 = 2;
$frmgrid4 = 3;
$frmgrid5 = 4;
$frmgrid6 = 5;

$lasttab = 0; //default to first tab for initial form entry

$myDbgateway = new dbgateway;

if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}
$groupList = getListOfGroups($myDbgateway);
if (! $groupList) {
  $_SESSION['loginerr'] = 'You are not a group administrator, so you do not access group admin function';
  header("Location: login.php");  
  exit; 
}


// add user to group   
if ($_REQUEST['p'] == "form1") { 
  $_SESSION['selected_group_lname'] = $_REQUEST['selected_group_lname'];
  $_SESSION['tb_lname_contains1'] = $_REQUEST['tb_lname_contains1'];
  if ($_REQUEST['submitfrm_add_user']) {
    $tab1msg = addUserToGroup();
  }
  populateAddUserGrid();
  $lasttab = $_REQUEST['tabmrkr1'];
}
// suspend user from group 
else if ($_REQUEST['p'] == "form2") { 
  $_SESSION['selected_group_lname'] = $_REQUEST['selected_group_lname'];
  $_SESSION['tb_lname_contains2'] = $_REQUEST['tb_lname_contains2'];
  if ($_REQUEST['submitfrm_suspend_user']) {
    $tab2msg = alterUserFlagsInGroup('suspend',trim($_REQUEST['tb_suspend_user_lname']));
  }
  $lugrid2 = populateOtherUserGrids('suspend',$_REQUEST['tb_lname_contains2']);
  $lasttab = $_REQUEST['tabmrkr2'];
} 
// unsuspend user from group
else if ($_REQUEST['p'] == "form3") {
  $_SESSION['selected_group_lname'] = $_REQUEST['selected_group_lname'];
  $_SESSION['tb_lname_contains3'] = $_REQUEST['tb_lname_contains3'];
  if ($_REQUEST['submitfrm_unsuspend_user']) {
    $tab3msg = alterUserFlagsInGroup('unsuspend',trim($_REQUEST['tb_unsuspend_user_lname']));
  }
  $lugrid3 = populateOtherUserGrids('unsuspend',$_REQUEST['tb_lname_contains3']);
  $lasttab = $_REQUEST['tabmrkr3'];
} 
// remove user from group
else if ($_REQUEST['p'] == "form4") { 
  $_SESSION['selected_group_lname'] = $_REQUEST['selected_group_lname'];
  $_SESSION['tb_lname_contains4'] = $_REQUEST['tb_lname_contains4'];
  if ($_REQUEST['submitfrm_remove_user']) {
    $tab4msg = removeUserFromGroup(trim($_REQUEST['tb_remove_user_lname']));
  }
  $lugrid4 = populateOtherUserGrids('remove',$_REQUEST['tb_lname_contains4']);

  $lasttab = $_REQUEST['tabmrkr4'];
} 
// assign admin to group
else if ($_REQUEST['p'] == "form5") { 
  $_SESSION['selected_group_lname'] = $_REQUEST['selected_group_lname'];
  $_SESSION['tb_lname_contains5'] = $_REQUEST['tb_lname_contains5'];
  if ($_REQUEST['submitfrm_assign_admin']) {
    $tab5msg = alterUserFlagsInGroup('assign',trim($_REQUEST['tb_assign_admin_lname']));
  }
  $lugrid5 = populateOtherUserGrids('assign',$_REQUEST['tb_lname_contains5']);

  $lasttab = $_REQUEST['tabmrkr5'];
} 
// unassign admin to group
else if ($_REQUEST['p'] == "form6") { 
  $_SESSION['selected_group_lname'] = $_REQUEST['selected_group_lname'];
  $_SESSION['tb_lname_contains6'] = $_REQUEST['tb_lname_contains6'];
  if ($_REQUEST['submitfrm_unassign_admin']) {
    $tab6msg = alterUserFlagsInGroup('unassign',trim($_REQUEST['tb_unassign_admin_lname']));
  }
  $lugrid6 = populateOtherUserGrids('unassign',$_REQUEST['tb_lname_contains6']);

  $lasttab = $_REQUEST['tabmrkr6'];
} 

function addUserToGroup() {
  global $myDbgateway;
  $tb_add_user_lname = trim($_REQUEST['tb_add_user_lname']);
  if ($tb_add_user_lname) {
    // see if this user is already in the group before adding it
    $select_cmd = "SELECT uid FROM gate WHERE lname  = '$tb_add_user_lname'"; 
    $result = $myDbgateway->readSQL($select_cmd,"delim");
    $childUid  = $result[0];      

    $select_cmd = "SELECT uid FROM gate WHERE lname  = '" . 
                  trim($_REQUEST['selected_group_lname']) . "'" ; 
    $result = $myDbgateway->readSQL($select_cmd,"delim");
    $parentUid  = $result[0];      

    $query = "SELECT parent_uid FROM gategrps WHERE parent_uid = '" . $parentUid
          . "' and child_uid = '" . $childUid . "'"; 
    $result = $myDbgateway->readSQL($query,"delim"); 
    if ($result) {
      $tab1msg = "User is already in this group.";
    } else {
      $insertQuery = "INSERT INTO gategrps (parent_uid,child_uid) " .
                " VALUES ('$parentUid','$childUid')";     
      $result = $myDbgateway->writeSQL($insertQuery);   
      $tab1msg = "User $tb_add_user_lname added to group " . $_REQUEST['selected_group_lname']; 
    } 
  }
  return $tab1msg;
}

function populateAddUserGrid() {
  global $lugrid1;
  global $myDbgateway;
  global $tsttabmsg1;
  global $maxrowlimit;
  global $fw_typesql;
  
  $pug_flg = "";
  
  // select users who aren't in group
  $select_cmd = "SELECT uid FROM gate WHERE lname  = '" .       
                $_REQUEST['selected_group_lname'] . "'"; 
  if ($fw_typesql == "MySQL") {
    // the maxrowlimit param is only valid in MySQL
    $select_cmd .= $maxrowlimit;
  }    
  
  if ($pug_flg != "") {  
    $tsttabmsg1 .= $select_cmd . "<br />";
  }  
  
  $result = $myDbgateway->readSQL($select_cmd,"delim");
  $parentUid = $result[0];
  
  $tmpQuery = "SELECT child_uid FROM gategrps WHERE parent_uid = '" . $parentUid . "' ";

  if ($pug_flg != "") {  
    $tsttabmsg1 .= $tmpQuery . "<br />";
  }

  $tmpResult = $myDbgateway->readSQL($tmpQuery,'delim');
  $cnt = count($tmpResult);
 
  if ($pug_flg != "") {  
    $tsttabmsg1 .= $cnt . "<br />";
  }
  
  $query = "SELECT lname,firstname,lastname FROM gate WHERE "
      . "entity_typ_flg = 'user' and uid NOT IN ("; 
  if ($tmpResult) {

  for ($i=0; $i < $cnt; $i++) {
   if ($i != $cnt-1) {
   	 $query .= $tmpResult[$i] . ",";
   }	else {
   	$query .= $tmpResult[$i];
   }
  } 	
   
   $query .= ")" ;
  } //end if
  
  if (trim($_REQUEST['tb_lname_contains1'])) {
    $query .= " and lname like '" . trim($_REQUEST['tb_lname_contains1']) . "'";
  }
  $query .= " order by lname";
  if ($fw_typesql == "MySQL") {
    // the maxrowlimit param is only valid in MySQL
    $query .= $maxrowlimit;
  }    

  if ($pug_flg != "") {  
    $tsttabmsg1 .= $query . "<br />";
  } 
  
  $lugrid1 = $myDbgateway->readSQL($query,'grid');
}

function alterUserFlagsInGroup($typeOfUpdate,$tb_user_lname) {
  global $myDbgateway;
  global $fw_delimsymb;
  if ($tb_user_lname) {
    // verify user is already in the group before changing it
    $select_cmd = "SELECT uid FROM gate WHERE lname  = '$tb_user_lname'"; 
    $result = $myDbgateway->readSQL($select_cmd,"delim");
    $childUid  = $result[0];      

    $select_cmd = "SELECT uid FROM gate WHERE lname  = '" . 
                  trim($_REQUEST['selected_group_lname']) . "'"; 
    $result = $myDbgateway->readSQL($select_cmd,"delim");
    $parentUid  = $result[0];      

    $query = "SELECT parent_uid, inactive_flg FROM gategrps WHERE parent_uid = '" . $parentUid
          . "' and child_uid = '" . $childUid . "'"; 
    $result = $myDbgateway->readSQL($query,"delim"); 
    if (! $result) {
      return "User is not in group.";
    } 

    if ($typeOfUpdate == 'suspend') {
      $setClause = "SET inactive_flg = 'y'";
    } else if ($typeOfUpdate == 'unsuspend') {
      $setClause = "SET inactive_flg = NULL";
    } else if ($typeOfUpdate == 'assign') {
      $setClause = "SET admin_flg = 'y'";
    } else if ($typeOfUpdate == 'unassign') {
      $setClause = "SET admin_flg = NULL";
    }
    $updateQuery = "UPDATE gategrps $setClause WHERE parent_uid = '" . $parentUid 
       . "' and child_uid = '" . $childUid . "'"; 
    $result = $myDbgateway->writeSQL($updateQuery);   
    return "User $tb_user_lname $typeOfUpdate" . "ed in group " . $_REQUEST['selected_group_lname']; 
  }
}

function removeUserFromGroup($tb_user_lname) {
  global $myDbgateway;
  global $fw_delimsymb;
  if ($tb_user_lname) {
    // verify user in group before attempting delete
    $select_cmd = "SELECT uid FROM gate WHERE lname  = '$tb_user_lname'"; 
    $result = $myDbgateway->readSQL($select_cmd,"delim");
    $childUid  = $result[0];      

    $select_cmd = "SELECT uid FROM gate WHERE lname  = '" . 
                  trim($_REQUEST['selected_group_lname']) . "'"; 
    $result = $myDbgateway->readSQL($select_cmd,"delim");
    $parentUid  = $result[0];      

    $query = "SELECT parent_uid FROM gategrps WHERE parent_uid = '" . $parentUid
          . "' and child_uid = '" . $childUid . "'"; 
    $result = $myDbgateway->readSQL($query,"delim"); 
    if (! $result) {
      return "User is not in group.";
    } 
    $updateQuery = "DELETE FROM gategrps WHERE parent_uid = '" . $parentUid 
       . "' and child_uid = '" . $childUid . "'"; 
    $result = $myDbgateway->writeSQL($updateQuery);   
    return "User $tb_user_lname removed from group " . $_REQUEST['selected_group_lname']; 
  }
}


function populateOtherUserGrids($typeOfGrid, $tb_lname_contains) {
  global $myDbgateway;
  global $maxrowlimit;
  global $fw_typesql;

  $select_lname_regexp = ' ';
  if ($tb_lname_contains) {
    $select_lname_regexp = " lname like '" . trim($tb_lname_contains) . "' and  ";
  }

  $select_other_criterion = ' ';
  if ($typeOfGrid == "suspend") {
    $select_other_criterion = " (b.inactive_flg is null or b.inactive_flg <> 'y') and ";
  } else if ($typeOfGrid == "unsuspend") {
    $select_other_criterion = " not (b.inactive_flg is null or b.inactive_flg <> 'y') and ";
  } else if ($typeOfGrid == "remove") {
    $select_other_criterion = " ";
  } else if ($typeOfGrid == "assign") {
    $select_other_criterion = " (b.admin_flg is null or b.admin_flg <> 'y') and ";
  } else if ($typeOfGrid == "unassign") {
    $select_other_criterion = " not (b.admin_flg is null or b.admin_flg <> 'y') and ";
  }
  // select users who are in group
  $select_cmd = "SELECT uid FROM gate WHERE lname  = '" .       
       $_REQUEST['selected_group_lname'] . "'"; 
  $result = $myDbgateway->readSQL($select_cmd,"delim");
  $parentUid = $result[0];

  $query = "SELECT a.lname,a.firstname,a.lastname FROM gate as a, gategrps as b WHERE "
      . " a.lname <> '" . $_SESSION['login'] . "' and "
      . " a.uid = b.child_uid and b.parent_uid = '" . $parentUid . "' and "
      . $select_lname_regexp 
      . $select_other_criterion 
      . "a.entity_typ_flg = 'user' " 
      . " order by a.lname";
  if ($fw_typesql == "MySQL") {
    // the maxrowlimit param is only valid in MySQL
    $query .= $maxrowlimit;
  }    
            
  $lugrid = $myDbgateway->readSQL($query,'grid');
  return $lugrid;  
}

function getListOfGroups($myDbgateway) {
  global $fw_delimsymb;
  $select_cmd = "SELECT uid, admin_flg FROM gate WHERE lname  = '" . $_SESSION['login'] . "'"; 
  $result = $myDbgateway->readSQL($select_cmd,"delim");
  $readSQL_out_array = explode($fw_delimsymb,$result[0]);
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
    $query .= " order by lname";
  }
  return $myDbgateway->readSQL($query,'delim');
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
    getCellValsAddUserToGroup("t1");
    getCellValsSuspendUser("t2");
    getCellValsUnsuspendUser("t3");
    getCellValsRemoveUser("t4");
    getCellValsAssignAdmin("t5");
    getCellValsUnassignAdmin("t6");
}

function getCellValsAddUserToGroup(t_id) {
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
         document.forms[<?php echo $frmgrid1; ?>].tb_add_user_lname.value = cels[0].innerText;
       //for firefox and safari       
       } else{           
         document.forms[<?php echo $frmgrid1; ?>].tb_add_user_lname.value = cels[0].textContent;
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
         document.forms[<?php echo $frmgrid2; ?>].tb_suspend_user_lname.value = cels[0].innerText;
       //for firefox and safari       
       } else{           
         document.forms[<?php echo $frmgrid2; ?>].tb_suspend_user_lname.value = cels[0].textContent;
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
         document.forms[<?php echo $frmgrid3; ?>].tb_unsuspend_user_lname.value = cels[0].innerText;
       //for firefox and safari       
       } else{           
         document.forms[<?php echo $frmgrid3; ?>].tb_unsuspend_user_lname.value = cels[0].textContent;
       }           
    }
  }
}

function getCellValsRemoveUser(t_id) {
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
         document.forms[<?php echo $frmgrid4; ?>].tb_remove_user_lname.value = cels[0].innerText;
       //for firefox and safari       
       } else{           
         document.forms[<?php echo $frmgrid4; ?>].tb_remove_user_lname.value = cels[0].textContent;
       }           
    }
  }
}

function getCellValsAssignAdmin(t_id) {
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
         document.forms[<?php echo $frmgrid5; ?>].tb_assign_admin_lname.value = cels[0].innerText;
       //for firefox and safari       
       } else{           
         document.forms[<?php echo $frmgrid5; ?>].tb_assign_admin_lname.value = cels[0].textContent;
       }           
    }
  }
}

function getCellValsUnassignAdmin(t_id) {
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
         document.forms[<?php echo $frmgrid6; ?>].tb_unassign_admin_lname.value = cels[0].innerText;
       //for firefox and safari       
       } else{           
         document.forms[<?php echo $frmgrid6; ?>].tb_unassign_admin_lname.value = cels[0].textContent;
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

<h1>Sys Admin - Group Management</h1>
<!-- adequate spacing between top menu and start of tabs -->	
<br />

<!--
Below is section where you implement the tabs. Add or subtract tabs as needed.
The tab name goes between the span tag.  
-->
<div id=etabs>
<ul>
  <li><a
  href="#tab-1"><span>Add Users To Group</span></a> 
  <li><a
  href="#tab-2"><span>Suspend Users In Group</span></a> 
  <li><a
  href="#tab-3"><span>Unsuspend Users In Group</span></a>  
</ul>
</div>

<!-- TAB1 ------------------------------------------------------------------ -->
<!-- Need to move this function back to being able to register both a user or a group -->
<div id="tab-1">
<h1>Add Users To Group</h1>	

<table id="t1" class="example table-autosort 
                              table-autofilter 
                              table-autopage:15 
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
  <th class="table-sortable:default" width='225'>Logon Name</th>
  <th class="table-sortable:default" width='150'>First Name</th>
  <th class="table-filterable table-sortable:default" width='75'>Last Name</th> 
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid1)){echo $lugrid1;} ?>
</tbody>
</table>

<form name="form1" id="form1" method="post" action="adm_group_group_mgmt.php?p=form1" >
<input type="hidden" name="tabmrkr1" id="tabmrkr1"  value="0" />
<br />

<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm_add_user" id="submitfrm_add_user" value="Add User To Group" />		
</td>
<td width="175" align="right">Selected User:&nbsp;</td>
<td width="225"><input type="text" name="tb_add_user_lname" size="25"   /></td>
</tr>
</table>

<h2>Lookup User/Group</h2>

<br />
<?php 
  if ($groupList) {
    echo 'Select group to add users to:';    
    echo '  <select size="1" name="selected_group_lname"> ';
    $selected = 'selected';
    foreach ($groupList as $groupListLname) {
      $groupListLname = trim($groupListLname);
      if ($_SESSION['selected_group_lname'] == $groupListLname) {
        echo ' <option value="' . $groupListLname .'" selected >'. $groupListLname . '</option>' ;
      } else {
        echo ' <option value="' . $groupListLname .'" >'. $groupListLname . '</option>' ;
      }
    }
    echo '  </select>';
    echo '<br />';
    echo '<br />';
  }
?>

<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm_add_user_lookup" id="submitfrm_add_user_lookup" 
  value="Lookup User" />		
</td>
<td width="175" align="right">Logon Name contains:&nbsp;</td>
<td width="225"><input type="text" name="tb_lname_contains1" size="25" value="<?php echo $_SESSION['tb_lname_contains1']; ?>" /></td>
</tr>
</table>	
</form>

<?php echo $tab1msg; ?>
<?php echo $tsttabmsg1; ?>	
</div>

<!-- TAB2 ------------------------------------------------------------------ -->
<div id="tab-2">
<h1>Suspend Users From Group</h1>	

<table id="t2" class="example table-autosort 
                              table-autofilter 
                              table-autopage:15 
                              table-stripeclass:alternate 
                              table-page-number:t2page 
                              table-page-count:t2pages 
                              table-filtered-rowcount:t1filtercount 
                              table-rowcount:t1allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='225'><img src="eUI/script/images/arrow_left.gif" /></td>
  <td style="text-align:left;" width='75'>Page <span id="t2page"></span>&nbsp;of <span id="t2pages"></span></td>
  <td class="table-page:next" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_right.gif" /></td>
 </tr>
 <tr>
  <th class="table-sortable:default" width='225'>Logon Name</th>
  <th class="table-sortable:default" width='150'>First Name</th>
  <th class="table-filterable table-sortable:default" width='75'>Last Name</th> 
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid2)){echo $lugrid2;} ?>
</tbody>
</table>

<form name="form2" id="form2" method="post" action="adm_group_group_mgmt.php?p=form2" >
<input type="hidden" name="tabmrkr2" id="tabmrkr2"  value="1" />
<br />

<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm_suspend_user" id="submitfrm_suspend_user" value="Suspend User In Group" />		
</td>
<td width="175" align="right">Selected User:&nbsp;</td>
<td width="225"><input type="text" name="tb_suspend_user_lname" size="25"   /></td>
</tr>
</table>

<h2>Lookup User/Group</h2>

<br />
<?php 
  if ($groupList) {
    echo 'Select group to suspend users from:';    
    echo '  <select size="1" name="selected_group_lname"> ';
    $selected = 'selected';
    foreach ($groupList as $groupListLname) {
      $groupListLname = trim($groupListLname);
      if ($_SESSION['selected_group_lname'] == $groupListLname) {
        echo ' <option value="' . $groupListLname .'" selected >'. $groupListLname . '</option>' ;
      } else {
        echo ' <option value="' . $groupListLname .'" >'. $groupListLname . '</option>' ;
      }
    }
    echo '  </select>';
    echo '<br />';
    echo '<br />';
  }
?>

<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm_suspend_user_lookup" id="submitfrm_suspend_user_lookup" 
  value="Lookup User" />		
</td>
<td width="175" align="right">Logon Name contains:&nbsp;</td>
<td width="225"><input type="text" name="tb_lname_contains2" size="25" value="<?php echo $_SESSION['tb_lname_contains2']; ?>" /></td>
</tr>
</table>	
</form>
<?php echo $tab2msg; ?>
<?php echo $tsttabmsg2; ?>	
</div>

<!-- TAB3 ------------------------------------------------------------------ -->
<div id="tab-3">
<h1>Unsuspend Users From Group</h1>	

<table id="t3" class="example table-autosort 
                              table-autofilter 
                              table-autopage:15 
                              table-stripeclass:alternate 
                              table-page-number:t3page 
                              table-page-count:t3pages 
                              table-filtered-rowcount:t1filtercount 
                              table-rowcount:t1allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='225'><img src="eUI/script/images/arrow_left.gif" /></td>
  <td style="text-align:left;" width='75'>Page <span id="t3page"></span>&nbsp;of <span id="t3pages"></span></td>
  <td class="table-page:next" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_right.gif" /></td>
 </tr>
 <tr>
  <th class="table-sortable:default" width='225'>Logon Name</th>
  <th class="table-sortable:default" width='150'>First Name</th>
  <th class="table-filterable table-sortable:default" width='75'>Last Name</th> 
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid3)){echo $lugrid3;} ?>
</tbody>
</table>

<form name="form3" id="form3" method="post" action="adm_group_group_mgmt.php?p=form3" >
<input type="hidden" name="tabmrkr3" id="tabmrkr3"  value="2" />
<br />

<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm_unsuspend_user" id="submitfrm_unsuspend_user" value="Unsuspend User In Group" />		
</td>
<td width="175" align="right">Selected User:&nbsp;</td>
<td width="225"><input type="text" name="tb_unsuspend_user_lname" size="25"   /></td>
</tr>
</table>

<h2>Lookup User/Group</h2>

<br />
<?php 
  if ($groupList) {
    echo 'Select group to unsuspend users from:';    
    echo '  <select size="1" name="selected_group_lname"> ';
    $selected = 'selected';
    foreach ($groupList as $groupListLname) {
      $groupListLname = trim($groupListLname);
      if ($_SESSION['selected_group_lname'] == $groupListLname) {
        echo ' <option value="' . $groupListLname .'" selected >'. $groupListLname . '</option>' ;
      } else {
        echo ' <option value="' . $groupListLname .'" >'. $groupListLname . '</option>' ;
      }
    }
    echo '  </select>';
    echo '<br />';
    echo '<br />';
  }
?>

<table>
<tr>
<td width="125" align="right">
<input type="submit" name="submitfrm_unsuspend_user_lookup" id="submitfrm_unsuspend_user_lookup" 
  value="Lookup User" />		
</td>
<td width="175" align="right">Logon Name contains:&nbsp;</td>
<td width="225"><input type="text" name="tb_lname_contains3" size="25" value="<?php echo $_SESSION['tb_lname_contains3']; ?>" /></td>
</tr>
</table>	
</form>
<?php echo $tab3msg; ?>
<?php echo $tsttabmsg3; ?>	
</div>


</body>

</html>