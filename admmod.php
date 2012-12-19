<?php
// Modify Links
// Initial Writing: ericm
// Date: 2/19/2012
// License: Dual licensed under the MIT and GPL license
/*
Modify Links
*/
// History/Customizations:
/*
    modified for navTango desktop edition 3/30/2012                       
*/
//-------------MAIN-----------------------------------------------------------//
//lib code / includes
//session context
session_start();  //required in order to get generated session key
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);

include($php_applib);
include($php_daclib);


$uimsg = '';
$traceflg = '';
$trace = '';
$uid = $_SESSION['uid'];
$link_itm = $_REQUEST['link_itm'];
$h_link_itm = $_REQUEST['h_link_itm'];
$link_label = $_REQUEST['link_label'];
$h_link_label = $_REQUEST['h_link_label'];
$mnu_cat = $_REQUEST['mnu_cat'];
$h_mnu_cat = $_REQUEST['h_mnu_cat'];
$new_window_flg = $_REQUEST['new_window_flg'];
$linkurl = $_REQUEST['linkurl']; 

//--MAIN---------------//
if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}
$myDbgateway = new dbgateway;

  //do delete and insert.
  if (trim($_REQUEST['updUrl']) != '')
  {
    $delquery	= 'DELETE FROM lnks WHERE member_uid = \'' . $uid . '\'' .  " AND link_itm = '$h_link_itm' AND mnu_cat = '$h_mnu_cat' AND link_label = '$h_link_label'"; 
    if ($traceflg != ''){ $trace .= $delquery . "<br />"; }
    $result = $myDbgateway->writeSQL($delquery); 
  //reinsert row
    $tmpguid = generateGUID();
    $insquery = "INSERT INTO lnks (member_uid, link_itm, guid, mnu_cat, link, link_label, new_window_flg, entrydate)
    VALUES ('$uid', '$link_itm', '$tmpguid', '$mnu_cat', '$linkurl', '$link_label' ,'$new_window_flg', NOW() )";
    if ($traceflg != ''){ $trace .= $insquery . "<br />"; }

    $result = $myDbgateway->writeSQL($insquery); 
  }	  
//order of all this is so we see changes reflected in the grid
  //get selection grid. we always display the grid
  $uimsg = populateLnkModifyGrid();
  //get our syncronized grid
  list($ddtb_parent,$childarrsjs) = syncedDDMFromModLink($ddtb_parent);

//---END MAIN----------//

//--FUNCTIONS----------------------------------------

function populateLnkModifyGrid()
{
  global $uid;
  global $trace;
  global $traceflg;
  global $lugrid;
  global $myDbgateway;

  $query = "SELECT link_itm, mnu_cat, link_label, link, new_window_flg FROM lnks where member_uid ='" . $uid . "' order by link_itm, mnu_cat";

  $lugrid = $myDbgateway->readSQL($query,"grid");

  if ($traceflg != ''){ $trace .= $query . "<br />"; }
}

function syncedDDMFromModLink($ddtb_parent)
{
  global $trace;
  global $traceflg;
  global $myDbgateway;

//create synchronized drop down menus
$ddtb_parent_hdr = 'Select to change menu item:&nbsp;<select name="parentDDM" onchange="getDDMvals()";><option></option>';
$ddtb_close = '</select>';
$ddtb_parent .= $ddtb_parent_hdr;

  $uid = $_SESSION['uid'];
  $query = 'SELECT distinct link_itm, mnu_cat FROM lnks where member_uid = \'' . $uid 
          . '\'' . ' order by link_itm, mnu_cat';

  $result = $myDbgateway->readSQL($query,"delim");

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
  if ($traceflg != ''){ $trace .= "rarrcnt is " . $rarrcnt . "<br />"; }
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
  	  $child_itm = '"' . "" . '",' . '"' . $v[1] . '"';
      //$child_itm = '"' . $v[1] . '"';  
  	  $childarrays = $child_itm;
  	}
  	else if ($tmpkey != $v[0])
  	{
   	  $ddtb_parent .= "\n" . '<option value="' . $av . '">' . $v[0] . '</option>';
   	  $parentarr[$av] = $v[0];
   	  $av++; 
   // var syncDDM1 = new Array("Apple", "Orange", "Kiwi", "Grapes");
      $childarrsjs .= 'var syncDDM' . $tmpi . ' = new Array(' . $childarrays . ');' . "\n";
   	  //$zfrm .= $tmpi . " " . $childarrays . "<br />";
   	  $tmpi++;
      $childarrays = '';
  	  $child_itm = '"' . "" . '",' . '"' . $v[1] . '"';      
      //$child_itm = '"' . $v[1] . '"'; 
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
  	  //$zfrm .= $tmpi . " " . $childarrays . "<br />";
    } 
  }	   
}
  $ddtb_parent .= $ddtb_close;	
	return array($ddtb_parent,$childarrsjs);
}	

/*
actually because of our pk this is not technically an update. we are deleting, then 
reinserting the row.
*/

//delete row




?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css">
<link rel="stylesheet" type="text/css" href="stylesheet/gridcontrol.css" media="all">

<script type="text/javascript"  language="javascript"> 
<?php echo $childarrsjs; ?>

function getDDMChildMod(){
	var select_child = document.modurl.ddm_childMod; 

if(document.all){
 document.forms[0].mnu_cat.value = select_child.options[select_child.selectedIndex].innerText;;
}else {
 document.forms[0].mnu_cat.value = select_child.options[select_child.selectedIndex].textContent;
}	

}	

function getDDMvals() {
  var select_parent = document.modurl.parentDDM ;
  var select_vals = document.modurl.ddm_childMod;
  var parent_val = select_parent.options[select_parent.selectedIndex].value;

if(document.all){
  document.forms[0].link_itm.value = select_parent.options[select_parent.selectedIndex].innerText;
}else {
 document.forms[0].link_itm.value = select_parent.options[select_parent.selectedIndex].textContent;
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
 
onload = function() {
if (!document.getElementsByTagName || !document.createTextNode) return;

var rows = document.getElementById('t1').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
//no can do below due to IE 6 conditionals in top menu code that create indice displacement
//var rows = document.getElementsByTagName('table')[3].getElementsByTagName('tbody')[0].getElementsByTagName('tr');
for (i = 0; i < rows.length; i++) 
    {
        rows[i].onclick = function() 
        {
            var cels = this.cells;            
            //alert(this.rowIndex - 1 + this.innerText);
            //alert(this.rowIndex - 1 + cels[2].innerText );  
// for ie and chrome        
if(document.all){
       document.forms[0].link_itm.value = cels[0].innerText;
       document.forms[0].h_link_itm.value = cels[0].innerText;
       document.forms[0].mnu_cat.value = cels[1].innerText;
       document.forms[0].h_mnu_cat.value = cels[1].innerText;             
       document.forms[0].link_label.value = cels[2].innerText;
       document.forms[0].h_link_label.value = cels[2].innerText;
       document.forms[0].linkurl.value = cels[3].innerText;
       document.forms[0].new_window_flg.value = cels[4].innerText;
//for firefox and safari       
} else{
       document.forms[0].link_itm.value = cels[0].textContent;
       document.forms[0].h_link_itm.value = cels[0].textContent;
       document.forms[0].mnu_cat.value = cels[1].textContent;
       document.forms[0].h_mnu_cat.value = cels[1].textContent;             
       document.forms[0].link_label.value = cels[2].textContent;
       document.forms[0].h_link_label.value = cels[2].textContent;
       document.forms[0].linkurl.value = cels[3].textContent;
       document.forms[0].new_window_flg.value = cels[4].textContent;
}           
        }
    }

}
 
</script>

<script type="text/javascript" src="eUI/script/gridcontrol.js"></script>
</head>
<body>
<h3>Click on item in grid to modify a link</h3>
<?php echo $trace; ?>

<table id="t1" class="example table-autosort 
                              table-autofilter 
                              table-autopage:5 
                              table-stripeclass:alternate 
                              table-page-number:t1page 
                              table-page-count:t1pages 
                              table-filtered-rowcount:t1filtercount 
                              table-rowcount:t1allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='80'><img src="eUI/script/images/arrow_left.gif"></td>
  <td class="table-page:next" style="cursor:pointer;" width='80'><img src="eUI/script/images/arrow_right.gif"></td>
  <td style="text-align:left;" width='135'>Page <span id="t1page"></span>&nbsp;of <span id="t1pages"></span></td>
  <td width='325'></td>
  <td width='55'></td>
 </tr>
 <tr>
  <th class="table-filterable table-sortable:default" width='80'>Menu Item</th>
  <th class="table-filterable table-sortable:default" width='80'>Category</th>
  <th class="table-sortable:default" width='135'>Item</th>
  <th class="table-sortable:default" width='325'>URL</th>
  <th class="table-filterable table-sortable:default" width='55'>New Window</th>
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid)){echo $lugrid;} ?>
</tbody>
</table>

<h3>Modify an Object</h3>
<form name="modurl" method="get" action="admmod.php">
<table border="0" cellpadding="0" cellspacing="3" width="775">
<tr>
<td width="225" align="right">Menu Item:&nbsp;</td>
<td width="550"><input type="text" name="link_itm" size="15">
&nbsp;&nbsp;<?php echo $ddtb_parent; ?>&nbsp;	
<input type="hidden" name="h_link_itm">
</td>
</tr>
<tr>
<td align="right">Category:&nbsp;</td>
<td><input type="text" name="mnu_cat" size="25">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" title="Select from list or enter new category in text box.">&nbsp;&nbsp;Help</a>&nbsp;
<select name="ddm_childMod" onchange="getDDMChildMod();"></select> 	
<input type="hidden" name="h_mnu_cat">
</td>
</tr>
<tr>
<td align="right">Item:&nbsp;</td>
<td><input type="text" name="link_label" size="25">
<input type="hidden" name="h_link_label">
</td>
</tr>
<tr>
<td align="right">URL:</td>
<td><input type="text" name="linkurl" size="80"></td>
</tr>
<tr>
<td align="right">New Window:&nbsp;</td>
<td><input type="text" name="new_window_flg" size="1">
<a href="#" title="Enter Y to open page in new window">&nbsp;&nbsp;Help</a>
</td>
</tr>
<tr>
<td align="right">
Check to update:&nbsp;<input type="checkbox" name="updUrl" >	
</td>
<td><input type="submit" name="Submit" value="&nbsp;&nbsp;Update&nbsp;&nbsp;"/></td>
</tr>	
</table>	
</form> 

</body>
</html>