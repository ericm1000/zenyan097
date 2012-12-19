<?php
// zenyan Login Module
// Initial Writing: eric matthews
// Date: june 30, 2010
// License: Dual licensed under the MIT and GPL license
/*
// History/Customizations:
/*
 02/14/2012: Norm Zemke: Changed function getAdminToc()
   Added entries into $toccontent
   Limit entries added to $toccontent based on value in admin_flg 
 02/21/2012 Code cleanup from some of my legacy code
 */
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);
include($php_daclib);

//session context
session_start();  //required in order to get generated session key


$msg = '';
$tochdr = '';
$toccontent = '';

if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}

$myDbgateway = new dbgateway;

//this is where we will add the skin login

//////////////////////////////////////////


   $userIsaGroupAdmin = 'n';
   if ($_SESSION['admin_flg'] == 'g' or $_SESSION['admin_flg'] == 'y' or $_SESSION['admin_flg'] == 'z') {  
     $userIsaGroupAdmin = 'y';
   } else {
     // if user logon, see if user is set to group admin in gategrps.db   
     $tmpQuery = "SELECT parent_uid FROM gategrps WHERE "
       . "(inactive_flg is NULL or inactive_flg <> 'y') and "
       . "admin_flg = 'y' and child_uid = '" . $_SESSION['uid'] . "'" ;
     $tmpResult = $myDbgateway->readSQL($tmpQuery,"hash");
     if ($tmpResult) {
         $userIsaGroupAdmin = 'y';
     }
   }

   if ($_REQUEST['v'] == 'admin')  {
      getAdminToc();
   } else {
       $tochdr = $_REQUEST['v'];
       getTocData($handle);
   }    
  

//----------------------------------------------------------------------------//
function getAdminToc()
//----------------------------------------------------------------------------//
{
  global $tochdr;
  global $toccontent; 
  $tochdr = 'Admin';
  $toccontent .= '</div>';
  $toccontent .= '<p class=clsTopicNormal onclick="toggle(sub2);">Manage My Links<div id=sub2 class=clsHidden>';				
  $toccontent .= '<p><a href="admadd.php"            TARGET="main" onClick=getURL(this);>Add Link</a></p>';
  $toccontent .= '<p><a href="admmod.php"            TARGET="main" onClick=getURL(this);>Modify Links</a></p>';
  $toccontent .= '<p><a href="admdel.php"            TARGET="main" onClick=getURL(this);>Delete Links</a></p>';
  $toccontent .= '</div>';

  $toccontent .= '</div>';
  $toccontent .= '<p class=clsTopicNormal onclick="toggle(sub2b);">Manage My Menus<div id=sub2b class=clsHidden>';			
  $toccontent .= '<p><a href="adm_manage_menus.php"            TARGET="main" onClick=getURL(this);>Manage Menus</a></p>';
  $toccontent .= '<p><a href="adm_manage_icons.php"            TARGET="main" onClick=getURL(this);>Manage Icons</a></p>';
  $toccontent .= '</div>';

  $toccontent .= '</div>';
  $toccontent .= '<p class=clsTopicNormal onclick="toggle(sub2c);">Manage My Access<div id=sub2c class=clsHidden>';	
  $toccontent .= '<p><a href="user_change_password.php"  TARGET="main" onClick=getURL(this);>Change my password</a></p>';	
  $toccontent .= '</div>';  

  
  global $userIsaGroupAdmin;
  if ($userIsaGroupAdmin == 'y') {
    $toccontent .= '<p class=clsTopicNormal onclick="toggle(sub3);">Group Admin<div id=sub3 class=clsHidden>';
    $toccontent .= '<p><a href="adm_group_loginmgmt.php" TARGET="main" onClick=getURL(this);>Group Login Mgmt</a></p>';		
    $toccontent .= '<p><a href="adm_group_group_mgmt.php" TARGET="main" onClick=getURL(this);>Group Management</a></p>';				
    $toccontent .= '</div>';
  }
  if ($_SESSION['admin_flg'] == 'y' or $_SESSION['admin_flg'] == 'z') {  
    $toccontent .= '<p class=clsTopicNormal onclick="toggle(sub4);">System Admin<div id=sub4 class=clsHidden>';
    $toccontent .= '<p><a href="adm_sysad_loginmgmt.php" TARGET="main" onClick=getURL(this);>User/Group Login Mgmt</a></p>';		
    $toccontent .= '<p><a href="adm_sys_group_mgmt.php" TARGET="main" onClick=getURL(this);>Group Management</a></p>';						
    $toccontent .= '</div>'; 

  }
}	

//----------------------------------------------------------------------------//
function getTocData($handle)
//----------------------------------------------------------------------------//
{
  global $trace;
  global $loginmsg;
  global $loginerr;
  global $tochdr;
  global $toccontent;
  global $myDbgateway;
  
  $query = 'SELECT mnu_cat, link, link_label, new_window_flg FROM lnks where member_uid = ' . $_SESSION['uid'] . ' and link_itm = \'' . $tochdr . '\' ';
  $result = $myDbgateway->readSQL($query,"hash");
  //$trace = $result; 
  $mnu = '';
  $nbr = 1;
  $turn = '';
  $newwndflg = ($result['new_window_flg']);
  if ($newwndflg != 'Y')
  {
    $target = 'main';
  }
  else
  {
    $target = '_blank';
  }

  $mnucat = ($result['mnu_cat']);
  $link = ($result['link']);
  $linklabel = ($result['link_label']);
  if ($mnu == '')
  {  	
     $accordianstub .= '<p class=clsTopicNormal onclick="toggle(sub';
     $accordianstub .= $nbr ;
     $accordianstub .= ');">'  . "\n";
     $accordianstub .= $mnucat . "\n";
     $accordianstub .= '<div id=sub' ;
     $accordianstub .= $nbr;
     $accordianstub .= ' class=clsHidden>' . "\n";
     $toccontent .= $accordianstub;

     $accordianitm .= '<p><a href="';
     $accordianitm .= $link;
     $accordianitm .= '"  TARGET="';
     $accordianitm .= $target;
     $accordianitm .= '" onClick=getURL(this);>';
     $accordianitm .= $linklabel;
     $accordianitm .= '</a></p>' . "\n";
   	 $toccontent .= $accordianitm;
   	 //// $trace .= $mnu . '~' . $mnucat . '|';
   	 $mnu = $mnucat;
   	 $nbr++;
   	 $accordianstub = '';
   	 $accordianitm = '';
  } 
  else if ($mnu != $result['mnu_cat'])
  {
     $accordianstub .= '</div>' . "\n";
     $accordianstub .= '<p class=clsTopicNormal onclick="toggle(sub';
     $accordianstub .= $nbr ;
     $accordianstub .= ');">'  . "\n";
     $accordianstub .= $mnucat . "\n";;
     $accordianstub .= '<div id=sub';
     $accordianstub .= $nbr ;
     $accordianstub .= ' class=clsHidden>'  . "\n";
     $toccontent .= $accordianstub;

     $accordianitm .= '<p><a href="';
     $accordianitm .= $link;
     $accordianitm .= '"  TARGET="';
     $accordianitm .= $target;
     $accordianitm .= '" onClick=getURL(this);>';
     $accordianitm .= $linklabel;
     $accordianitm .= '</a></p>' . "\n";
   	 $toccontent .= $accordianitm;
   	 //// $trace .= "<br />" . $mnu . '>' . $mnucat . '|';
   	 $mnu = $mnucat;	 
   	 $nbr++;
   	 $accordianstub = '';
   	 $accordianitm = '';
  }
  else if ($mnu == $result['mnu_cat'])
  {
     $accordianitm  = '<p><a href="';
     $accordianitm .= $link;
     $accordianitm .= '"  TARGET="';
     $accordianitm .= $target;
     $accordianitm .= '" onClick=getURL(this);>';
     $accordianitm .= $linklabel;
     $accordianitm .= '</a></p>' . "\n";
   	 $toccontent .= $accordianitm;
   	 $mnu = $mnucat;
   	 $accordianitm = '';
  }		                             
   $accordianitm  .= '</div>';
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet/toc.css"></link>
<script language="JavaScript1.2" type="text/javascript" src="scripts/verticaltree.js"></script>

<script language="javascript">
function getURL(focurl)
{
//tested works with firefox, ie, opera, safari, chrome
   //alert(focurl); 
   parent.cmd.document.getElementById('myurl').innerHTML = focurl; //working  
}
</script>	

<style type="text/css">
/* CSS Tabs */
h2 {
font-family: Cursive, Arial; 
text-align: center; 
font-size: 11pt;
font-weight: normal;
border-style: solid;
border-bottom-width: thin;
border-left: none;
border-right: none;
border-top-width: thin;
border-color: black; 
background-color: none;
margin-left: 0px;
text-transform: uppercase;
}
</style>

<title></title>
</head>
<body <?php echo $bodybgcolor;?> >
<p><?php echo  $msg; ?></p>

<?php echo $trace	; ?>

<h2><?php echo  $tochdr; ?></h2>
<?php echo  $toccontent; ?>  
</body>
</html>