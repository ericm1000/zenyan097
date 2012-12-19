<?php
// Delete Links
// Initial Writing: ericm
// Date: 2/19/2012
// License: Dual licensed under the MIT and GPL license
/*
Delete Links
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
include($php_daclib);

$uimsg = '';
$traceflg = '';
$trace = '';
$tb_link_label = $_REQUEST['tb_link_label'];
$tb_link = $_REQUEST['tb_link'];
$uid = $_SESSION['uid'];
$link_itm = $_REQUEST['link_itm'];
$mnu_cat = $_REQUEST['mnu_cat'];
$lugrid = '';
$myDbgateway = new dbgateway;

//--MAIN---------------//
if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}
  //delete item. we do this first so we can keep grid in-sync with any deletes

 $uimsg = deleteRow();
 if ($_REQUEST['p'] == 'delrow')
 {
  if ($traceflg != ''){ $trace .= "p is " . $_REQUEST['p'] . "<br />"; }  	
  if (trim($_REQUEST['tb_link']) != '')
  {
  	//delete the row
  	$uimsg = deleteRow();
  	if ($traceflg != ''){ $trace .= "dataif..." . $_REQUEST['tb_link'] . $_REQUEST['tb_link_label'] . "<br />"; }
  }
  else
  {
   	if ($traceflg != ''){ $trace .= "dataelse..." . $_REQUEST['tb_link'] . $_REQUEST['tb_link_label'] . "<br />"; } 	
  }	
 } 
		
  //get selection grid. we always display the grid
  $uimsg = populateGrid();
//---END MAIN----------//

//--FUNCTIONS----------------------------------------

function deleteRow()
{
  global $uid;
  global $trace;
  global $traceflg;   
  global $uid;
  global $link_itm;
  global $mnu_cat;
  global $myDbgateway;

  $h_link_label = $_REQUEST['h_link_label'];
  $h_link  = $_REQUEST['h_link']; 
  
  $delquery	= "DELETE FROM lnks WHERE member_uid = '" . $uid . "' " .  " AND link_itm = '" . $link_itm . "' AND mnu_cat = '" . $mnu_cat . "' AND link_label = '" . $h_link_label . "'"; 
  if ($traceflg != ''){ $trace .= $delquery . "<br />"; }
  $result = $myDbgateway->writeSQL($delquery);
  $uimsg .= $result . " Row deleted";
  return $uimsg;
}

function populateGrid()
{
  global $uid;
  global $trace;
  global $traceflg;
  global $lugrid;
  global $myDbgateway;

  $query = "SELECT link_itm, mnu_cat, link_label, link FROM lnks where member_uid ='" . $uid . "' order by link_itm, mnu_cat";
  $lugrid = $myDbgateway->readSQL($query,"grid");

  if ($traceflg != ''){ $trace .= $query . "<br />"; }
}

?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" />
<link rel="stylesheet" type="text/css" href="stylesheet/gridcontrol.css" media="all" />
<script type="text/javascript" src="eUI/script/gridcontrol.js"></script>
<script type="text/javascript">
onload = function() {
if (! document.getElementsByTagName || ! document.createTextNode){ return; }
var rows = document.getElementById('t1').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
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
       document.forms[0].link_itm.value = cels[0].innerText;
       document.forms[0].mnu_cat.value = cels[1].innerText;             
       document.forms[0].tb_link_label.value = cels[2].innerText;
       document.forms[0].h_link_label.value = cels[2].innerText;       
       document.forms[0].tb_link.value = cels[3].innerText;
       document.forms[0].h_link.value = cels[3].innerText;
//for firefox and safari       
} else{
       document.forms[0].link_itm.value = cels[0].textContent;
       document.forms[0].mnu_cat.value = cels[1].textContent;             
       document.forms[0].tb_link_label.value = cels[2].textContent;
       document.forms[0].h_link_label.value = cels[2].textContent;
       document.forms[0].tb_link.value = cels[3].textContent;
       document.forms[0].h_link.value = cels[3].textContent;
}           
   }
 }
}
</script>

</head>
<body>
<h3>Delete an Object</h3>
<?php echo $trace; ?>

<table id="t1" class="example table-autosort 
                              table-autofilter 
                              table-autopage:8 
                              table-stripeclass:alternate 
                              table-page-number:t1page 
                              table-page-count:t1pages 
                              table-filtered-rowcount:t1filtercount 
                              table-rowcount:t1allcount">
<thead>
 <tr>
  <td class="table-page:previous" style="cursor:pointer;" width='125'><img src="eUI/script/images/arrow_left.gif" /></td>
  <td class="table-page:next" style="cursor:pointer;" width='125'><img src="eUI/script/images/arrow_right.gif" /></td>
  <td style="text-align:left;" width='175'>Page <span id="t1page"></span>&nbsp;of <span id="t1pages"></span></td>
  <td width='275'></td>
 </tr>
 <tr>
  <th class="table-filterable table-sortable:default" width='125'>Menu Item</th>
  <th class="table-filterable table-sortable:default" width='125'>Category</th>
  <th class="table-sortable:default" width='175'>Item</th>
  <th class="table-sortable:default" width='275'>URL</th>
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid)){echo $lugrid;} ?>
</tbody>
</table>

<form name="delurl" method="POST" action="admdel.php?p=delrow">
<table>
<tr>
<td width="225" align="right">Item:&nbsp;</td>
<td width="500"><input type="text" name="tb_link_label" size="25"  /></td>
</tr>
<tr>
<td align="right">URL:&nbsp;</td>
<td><input type="text" name="tb_link" size="80"  /></td>
</tr>
<tr>
<td>
<input type="hidden" name="h_link_label" />
<input type="hidden" name="h_link" />	
<input type="hidden" name="link_itm" />
<input type="hidden" name="mnu_cat" />	
</td>
<td><input type="submit" name="Submit" value="&nbsp;&nbsp;Delete&nbsp;&nbsp;" /></td>
</tr>	
</table>	
</form>
<?php echo $uimsg; ?>
</body>
</html>