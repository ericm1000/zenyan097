<?php
session_start();

/*
The is installment one of JQuery drop-n-drag event. Goal is to build this
example incremental into a generalized design pattern along the way.

--------------------------------------------------------------------------------
Entities consist of (hierarchically top to bottom)
--------------------------------------------------------------------------------
                 #vLC<letter> = div tag id. This is the visual location
                                container. It can be independly sized and
                                located anywhere on the page. It is pretty
                                much a design time entity in terms of 
                                sizing and locating.
                   .tblVessel = css class of table tag. This is the table that
                                lives within each vLC. Keep in mind it is a 
                                class, so its properties apply to each
                                implementation.
      #ddWrap<letter><number> = css id of TD tag. This is the drop-n-drag
                                wrapper. Essentially what we can have are
                                a series of tables where the TD tags can 
                                be moved from table to table.                         
$_SESSION[vDC<letter><number> = session content variable for our data. Note
                                that these are session variables. The data
                                may well be variant, but these are intended 
                                to be entities that are meant to be persistant
                                residing within the UI container. Each of
                                these session variable contains...
         #vDC<letter><number> = this is a css id that allows us the ability
                                to independently style each data visual data
                                object. it is also possible to apply a css class
                                to these session variables to apply a consistent
                                style across data objects.            
                $data<number> = contains data for our drop-n-drap object. its
                                gets bound to an associated session variable.
                                This binding is atomic.

--------------------------------------------------------------------------------
Events 
--------------------------------------------------------------------------------
Since we are dragging TD tags between tables our drop-n-drag event trigger is
the #droptrue id. this will trigger an event every time a TD tag gets dropped 
onto a table. 

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
		});

	});
  
 
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
<tr><td class="droptrue" id="ddWrapB" name="ddWrapB1">
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

</body>
</html>
