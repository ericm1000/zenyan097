<?php
session_start();

/*
This is an enhancement of 1a. It add key/value pair tracking of the TD tags.
the k/v pair is delimited by ##. Since a TD tag can hold multiple data objects
the row delimiter is ~~. We need to pass both the object 
*/

$data1 = "Data Object One";
$data2 = "Data Object Two";
$data3 = "Data Object Three";
$data4 = "Data Object Four";
$data5 = "Data Object Five";

//visual data container for drop-n-drag operations. simple, but mondo powerful
$_SESSION['vDCa1'] = '<p id="vDCa1" class="ui-state-default">' . $data1 . '</p>';
$_SESSION['vDCb1'] = '<p id="vDCb1" class="ui-state-default">' . $data2 . '</p>';
$_SESSION['vDCc1'] = '<p id="vDCc1" class="ui-state-default">' . $data3 . '</p>';
$_SESSION['vDCd1'] = '<p id="vDCd1" class="ui-state-default">' . $data4 . '</p>';
$_SESSION['vDCe1'] = '<p id="vDCe1" class="ui-state-default">' . $data5 . '</p>';
//-----------------------------------------------------------------------------


?>
<!DOCTYPE html>
<html>
<head>
<title>Drop & Drag on to div Event</title>
<meta content="text/html; charset=windows-1252" http-equiv=Content-Type>

<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" />
<link rel=stylesheet type=text/css href="jquery/stylesheet/uidropdragcustom.css">
<script language=JavaScript type=text/javascript src="jquery/jquery182.min.js"></script>
<script language=JavaScript type=text/javascript src="jquery/jquery-ui191.js"></script>

<script language=JavaScript type=text/javascript>
  $(document).ready(function()  {

  });

	$(function() {
		
		$("td.droptrue").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updateLocs 
		});

	});
	
  function updateLocs() {
		updLoc1();
		updLoc2();
		updLoc3();				
  }	

	function updLoc1() { 
		var arr = [];
		var ddW = $("#ddWrapA1").attr('id');
		var vObj;
	  $("#ddWrapA1 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrapA1').val(arr.join('~~'));
  }	

	function updLoc2() { 
		var arr = [];
		var ddW = $("#ddWrapB1").attr('id');
		var vObj;
	  $("#ddWrapB1 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrapB1').val(arr.join('~~'));
  }	
  
	function updLoc3() { 
		var arr = [];
		var ddW = $("#ddWrapC1").attr('id');
		var vObj;
	  $("#ddWrapC1 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrapC1').val(arr.join('~~'));
  }	  
  
 
</script>

<style type=text/css>
.ui-state-default { margin-top: 0px; margin-bottom: 5px; }

.tblVessel table {
	width: 200px;
}

.tblVessel td {
	 background-color: #CCCCCC;	
	 height: 30px;
	 width: 150px;
}
	
	
#vLCa {
	cursor: pointer; 
	position:absolute;
	width:300px;
	z-index:1;
	left: 10px;
	top: 10px;
}
#vLCb {
	cursor: pointer;
	position:absolute;
	width:300px;5
	z-index:1;
	left: 400px;
	top: 10px;
}
#vLCc {
	cursor: pointer;
	position:absolute;
	width:300px;
	z-index:1;
	left: 13px;
	top: 275px;
}
#vObjConsole {
	cursor: pointer;
	position:absolute;
	width:400px;
	z-index:1;
	left: 400px;
	top: 275px;
}

#ddWrapA1 {  }
#ddWrapB1 {  }
#ddWrapC1 {  }

#vDCa1 {  }
#vDCb1 {  }
#vDCc1 {  }
#vDCd1 {  }
#vDCe1 {  }
</style>

</head>

<body>

<div id="vLCa">
<h2>Visual Location Container 1</h2>
<table class="tblVessel">
 <tr><td class="droptrue" id="ddWrapA1" name="ddWrapA1">
   <?php echo $_SESSION['vDCa1']; ?>
   <?php echo $_SESSION['vDCb1']; ?>
   <?php echo $_SESSION['vDCc1']; ?>
   <?php echo $_SESSION['vDCd1']; ?>
 </td></tr>
   </table> 
</div>
 
<div id="vLCb">
<h2>Visual Location Container 2</h2>
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrapB1" name="ddWrapB1">
<?php echo $_SESSION['vDCe1']; ?>  	
</td></tr>
</table> 
</div>
 
<div id="vLCc">
<h2>Visual Location Container 3</h2>
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrapC1" name="ddWrapC1">  
 
</td></tr>
</table> 
</div>

<div id="vObjConsole">
<h2>Event Console</h2>
   <p>
	   <label>tb_ddWrapA1:&nbsp;</label>
	   <input id="tb_ddWrapA1" size="90" type="text" name="tb_ddWrapA1"><br />

	   <label>tb_ddWrapB1:&nbsp;</label>
	   <input id="tb_ddWrapB1" size="90" type="text" name="tb_ddWrapB1"><br />

	   <label>tb_ddWrapC1:&nbsp;</label>
	   <input id="tb_ddWrapC1" size="90" type="text" name="tb_ddWrapC1"><br />
   </p>
	
</div>

</body>
</html>
