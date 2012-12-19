<?php
// Add Links
// Initial Writing: ericm
// Date: 5/14/2010
// License: Dual licensed under the MIT and GPL license
/*
Add Links
*/
// History/Customizations:
/*
   modified for navTango desktop edition 3/30/2012                        
*/
//-------------MAIN-----------------------------------------------------------//
//lib code / includes
//session context
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);

include($php_applib);
include($php_daclib);
//session context
session_start();  //required in order to get generated session key


$uimsg = '';
$traceflg = '';
$trace = '';
$mnuitms = '';
$zfrm = '';
$zfrmprep = '';
$processFrm = '';
$uid = $_SESSION['uid'];
//for insert
$pddm = ''; //menu selection
$cddm = '';
$lnk = '';
$lnklbl = '';

$myDbgateway = new dbgateway;

//--MAIN---------------//
if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}
// HANDLE USER INPUT
// get link data for synced listboxes
   $rs = get_syncedDDMdata();
   list($ddtb_parent,$childarrsjs,$parentarr) = syncedDDM($rs);
// since above only return menu items that have links, get alt pulldown, 
// which contains all top menu items
   $ddtb_parent2 = get_AllMnuItems(); 
// error handle user input (handle "Add" click)
  if ($_REQUEST['p'] == 'additm')
  {
   $uimsg = checkUserInput();
   if (trim($uimsg) == '')
   {
     // INSERT INTO DATABASE 
     $uimsg = addNewLink(); 
     //clear context
     $_REQUEST['tb_mnuadd_child'] = '';
     $_REQUEST['tb_link_label'] = ''; 	
     $_REQUEST['tb_link'] = ''; 	 	
   }	
  } 
//---END MAIN----------//

//--FUNCTIONS----------------------------------------

function addNewLink()
{
  global $uid;
  global $trace;
  global $traceflg;
  global $pddm;
  global $cddm;
  global $lnk;
  global $lnklbl;
  global $myDbgateway;
  
  //process new window flag
  if ($_REQUEST['cb_new_window_flg'] == 'ON')
  {
  	$new_window_flg = 'Y';
  }
  else
  {
  	$new_window_flg = '';
  }
  //generate a guid
  $tmpguid = generateGUID();

  $query = "INSERT INTO lnks (member_uid, link_itm, guid, mnu_cat, link, link_label, new_window_flg, entrydate)
  VALUES ('$uid', '$pddm', '$tmpguid', '$cddm',  '$lnklbl', '$lnk', '$new_window_flg', NOW() )";
  if ($traceflg != ''){ $trace .= $query . "<br />"; }

  $result = $myDbgateway->writeSQL($query);
  $uimsg = "$result Item added <br />";
  
  return $uimsg;
}  


function checkUserInput()
{
  global $uid;
  global $trace;
  global $traceflg;
  global $pddm;
  global $cddm;
  global $lnk;
  global $lnklbl;
//did they select a menu item?  
  if (rtrim($_REQUEST['parentDDM']) == '' and rtrim($_REQUEST['parentDDM2']) == '')
  {
  	$uimsg .= "- You must make a menu item selection.<br>" . "\n";
  }	
  else
  {
    //which one did they use?
    if (rtrim($_REQUEST['parentDDM']) != '') //this is preferred
    {
     //this is gnarley. since we need to sync-up drop down menus, what we have
     //in this case is a number. Hence, we need to use the hidden value from
     //form.
    	$pddm = rtrim($_REQUEST['h_link_itm']);
    	if ($traceflg != ''){ $trace .= $pddm . "<br />";}
    }
    else //it must be parentDDM2
    {
    	$pddm = rtrim($_REQUEST['parentDDM2']);
    	if ($traceflg != ''){ $trace .= $pddm . "<br />"; }
    }		
  }	  	
//did they select a menu item? 
   if (rtrim($_REQUEST['tb_mnuadd_child']) == '' and rtrim($_REQUEST['ddm_child']) == '')
   {
  	$uimsg .= "- You must select or enter a category.<br>" . "\n";   	
   }
   else
   {
      if (rtrim($_REQUEST['tb_mnuadd_child']) != '') //trumps drop down
      {
   	   $cddm = $_REQUEST['tb_mnuadd_child'];
       if ($traceflg != ''){ $trace .= $cddm . "<br />"; }
      }	
      else
      {
   	   $cddm = $_REQUEST['ddm_child'];
       if ($traceflg != ''){ $trace .= $cddm . "<br />"; }
      }
   }	  
//did they select a url and url label?
   if (rtrim($_REQUEST['tb_link_label']) == '')
   {
  	$uimsg .= "- You must enter a Link Label.<br>" . "\n";   	
   }
   else
   {
    $lnk = $_REQUEST['tb_link_label'];
    if ($traceflg != ''){ $trace .= $lnk . "<br />"; }  	
   }	
   if (rtrim($_REQUEST['tb_link']) == '')
   {
  	$uimsg .= "- You must enter a URL.<br>" . "\n";   	
   } 
   else
   {
    $lnklbl = $_REQUEST['tb_link'];
    if ($traceflg != ''){ $trace .= $lnklbl . "<br />"; }  	
   }
   //note, we are maintaining field context directly in the form
      
   return $uimsg;
}	

function get_AllMnuItems()
{
  global $uid;
  global $trace;
  $mnudm2 = '<select name="parentDDM2";><option></option>';	
 	//$mnudm2 .= '<option>' . $_SESSION['mnu_itm2'] . '</option>' . '<br />' . "\n";
  //$mnudm2 .= '</select>';	
  $tmparr = $_SESSION['mnuarr'];  //set in topmnu.php
  $cnt =  count($tmparr);
  for($i=0;$i<$cnt;$i++)
  {
  	if ($tmparr[$i] != 'Admin')
  	{
  	 $mnudm2 .= '<option>' . $tmparr[$i] . '</option>' ;
  	} 
  }	
  $mnudm2 .= '</select>';  
  
  return $mnudm2;
}	


function get_syncedDDMdata()
{
  global $uid;
  global $trace;
  global $myDbgateway;

  $query = 'SELECT distinct link_itm, mnu_cat FROM lnks where member_uid = \'' . $uid . '\'' . ' order by link_itm, mnu_cat';

  $result = $myDbgateway->readSQL($query,"delim");
  return $result;
}


function syncedDDM($result)
{
 global $trace;
//create synchronized drop down menus
$ddtb_parent_hdr = 'Menu Item:&nbsp;<select name="parentDDM" onchange="getDDMvals()";><option></option>';
$ddtb_close = '</select>';
$ddtb_parent .= $ddtb_parent_hdr; 
 
  $av = 1;
  $tmpkey = '';
  $tmpi=1;
  $parentarr = '';
  $childarrays = '';
  $childarrsjs = '';
  $child_itm = '';
  $child_itm_cntr = 0;

//we always want to get the synched drop down menu data  
  $rarrcnt = count($result);
  //^ $trace .= "rarrcnt is " . $rarrcnt . "<br />";
if ($result != '')
{
  foreach ($result as $key => $value)
  {
    $child_itm_cntr++;
  	$tval = trim($value);
    $v = preg_split("/[|]/", $tval);
    if ($tmpkey == '')
    {
  	  $ddtb_parent .= "\n" . '<option value="' . $av . '">' . $v[0] . '</option>';
  	  $parentarr[$av] = $v[0];
     	$av++;
  	  $child_itm = '"' . $v[1] . '"';
  	  $childarrays = $child_itm;
  	}
  	else if ($tmpkey != $v[0])
  	{
   	  $ddtb_parent .= "\n" . '<option value="' . $av . '">' . $v[0] . '</option>';
   	  $parentarr[$av] = $v[0];
   	  $av++; 
   // var syncDDM1 = new Array("Apple", "Orange", "Kiwi", "Grapes");
      $childarrsjs .= 'var syncDDM' . $tmpi . ' = new Array(' . $childarrays . ');' . "\n";
   	///$trace .= $tmpi . " " . $childarrays . "<br />";
   	  $tmpi++;
      $childarrays = '';
      $child_itm = '"' . $v[1] . '"'; 
      $childarrays = $child_itm;	  	
  	}
  	else if ($tmpkey == $v[0])
  	{
  		$child_itm = ',"' . $v[1] . '"';
  		$childarrays .= $child_itm;
  	}		
  	
  	$tmpkey = $v[0];
  	
  	if ($child_itm_cntr == $rarrcnt)
  	{
   // var syncDDM1 = new Array("Apple", "Orange", "Kiwi", "Grapes");
      $childarrsjs .= 'var syncDDM' . $tmpi . ' = new Array(' . $childarrays . ');' . "\n";
  	///$trace .= $tmpi . " " . $childarrays . "<br />";
    } 
  }	
}   
  $ddtb_parent .= $ddtb_close;	
	return array($ddtb_parent,$childarrsjs,$parentarr);
}	

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" />
<script language="javascript"> 
<?php echo $childarrsjs; ?>

function getDDMvals() {
  var select_parent = document.myform.parentDDM ;
  var select_vals = document.myform.ddm_child;
  var parent_val = select_parent.options[select_parent.selectedIndex].value;

 if(document.all){
  document.forms[0].h_link_itm.value = select_parent.options[select_parent.selectedIndex].innerText;
 }else {
  document.forms[0].h_link_itm.value = select_parent.options[select_parent.selectedIndex].textContent;
 }

  select_vals.options.length=0;
  if (parent_val == "1")
  {
    for(var i=0; i<syncDDM1.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM1[i]);
  }
  else if (parent_val == "2")
  {
    for(var i=0; i<syncDDM2.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM2[i]);
  }
  else if (parent_val == "3")
  {
    for(var i=0; i<syncDDM3.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM3[i]);
  }  
  else if (parent_val == "4")
  {
    for(var i=0; i<syncDDM4.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM4[i]);
  }  
  else if (parent_val == "5")
  {
    for(var i=0; i<syncDDM5.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM5[i]);
  }  
  else if (parent_val == "6")
  {
    for(var i=0; i<syncDDM6.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM6[i]);
  } 
  else if (parent_val == "7")
  {
    for(var i=0; i<syncDDM7.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM7[i]);
  }
  else if (parent_val == "8")
  {
    for(var i=0; i<syncDDM8.length; i++)
    select_vals.options[select_vals.options.length] = new Option(syncDDM8[i]);
  }

}
</script>

</head>
<body>
 
<h3>Add a Link</h3>

<?php echo $trace; ?>
<form name="myform" method="POST" action="admadd.php?p=additm">
<p><?php echo $ddtb_parent; ?>&nbsp;or make selection from this menu:&nbsp;<?php echo $ddtb_parent2; ?></p>
  <input type="hidden" name="h_link_itm">
  <p>Category:&nbsp;<select name="ddm_child"></select> 
     or new <input type="text" name="tb_mnuadd_child" size="15"  value="<?php if (trim($uimsg) != ''){ echo $_REQUEST['tb_mnuadd_child'];} ?>">
     &nbsp;Select from dropdown or enter new item.  25 charactors max.</p>
  <p>Link Label:&nbsp;<input type="text" name="tb_link_label" size="25"  value="<?php if (trim($uimsg) != ''){ echo $_REQUEST['tb_link_label'];} ?>">
  	&nbsp;Must enter label for url. 25 charactors max.</p>
  <p>URL:&nbsp;
  <input type="text" name="tb_link" size="80" value="<?php if (trim($uimsg) != ''){ echo $_REQUEST['tb_link'];} ?>">
  &nbsp;Must enter full URL.</p>
  <p>Open link in new window? <input type="checkbox" name="cb_new_window_flg" value="ON"></p>
  <p><input type="submit" value="Add" name="addlink"></p>

</form>
<?php echo $zfrm; ?>
<?php echo $uimsg; ?>
</body>
</html>