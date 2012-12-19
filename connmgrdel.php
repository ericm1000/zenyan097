<?php
//-------------MAIN-----------------------------------------------------------//
//lib code / includes
//session context
session_start();  //required in order to get generated session key
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);
include($php_daclib);

$_SESSION['initentry'] = 0;
$_SESSION['lname'] = '';
$_SESSION['cntxt'] = '';
$_SESSION['membermsg'] = '';
// $_SESSION['uid'] 
// $_SESSION['guid']
// $_SESSION['logtoken']

$uimsg = '';
$traceflg = '';
$trace = '';
$tb_link_label = $_REQUEST['tb_link_label'];
$uid = $_SESSION['uid'];
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
  global $tb_link_label;
  global $myDbgateway;
                
  $delquery	= "DELETE FROM connmgr WHERE conn_name = '" . $tb_link_label . "'"; 
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

  $query = "SELECT conn_name,host,conn_type,dbms,inactive_flg FROM connmgr order by dbms";
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
       document.forms[0].tb_link_label.value = cels[0].innerText;
//for firefox and safari       
} else{           
       document.forms[0].tb_link_label.value = cels[0].textContent;
}           
   }
 }
}
</script>

</head>
<body>
<h1>Delete a Registered Connection</h1>
<p>Note: This physically deletes the row! It does not delete the actual connection itself.</p>
<?php echo $trace; ?>

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
  <td class="table-page:next" style="cursor:pointer;" width='150'><img src="eUI/script/images/arrow_right.gif" /></td>
  <td style="text-align:left;" width='75'>Page <span id="t1page"></span>&nbsp;of <span id="t1pages"></span></td>
  <td width='175'></td>
  <td width='100'></td>
 </tr>
 <tr>
  <th class="table-sortable:default" width='225'>Conn Name</th>
  <th class="table-sortable:default" width='150'>Host</th>
  <th class="table-filterable table-sortable:default" width='75'>Type</th> 
  <th class="table-filterable table-sortable:default" width='175'>DBMS</th>
  <th class="table-filterable table-sortable:default" width='100'>Inactive?</th>
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($lugrid)){echo $lugrid;} ?>
</tbody>
</table>

<form name="delurl" method="POST" action="connmgrdel.php?p=delrow">
<table>
<tr>
<td width="225" align="right">Item to Delete:&nbsp;</td>
<td width="500"><input type="text" name="tb_link_label" size="25"  /></td>
</tr>
<td><input type="submit" name="Submit" value="&nbsp;&nbsp;Delete&nbsp;&nbsp;" /></td>
</tr>	
</table>	
</form>
<?php echo $uimsg; ?>
</body>
</html>