<?php
session_start();

/*
Our goal here is to take 1c and morph it to add object location context. The
context will be managed from the server.
*/
$_SESSION['tmp'] = '';

$data1 = "Data Object One";
$data2 = "Data Object Two";
$data3 = "Data Object Three";
$data4 = "Data Object Four";
$data5 = "Data Object Five";

//visual data container for drop-n-drag operations. simple, but mondo powerful
$_SESSION['vDC1'] = '<p id="vDC1" class="ui-state-default">' . $data1 . '</p>';
$_SESSION['vDC2'] = '<p id="vDC2" class="ui-state-default">' . $data2 . '</p>';
$_SESSION['vDC3'] = '<p id="vDC3" class="ui-state-default">' . $data3 . '</p>';
$_SESSION['vDC4'] = '<p id="vDC4" class="ui-state-default">' . $data4 . '</p>';
$_SESSION['vDC5'] = '<p id="vDC5" class="ui-state-default">' . $data5 . '</p>';
//-----------------------------------------------------------------------------


//object context management
   if (isset($_SESSION['vObj_init'])) {

     //is ui calling?
     $_SESSION['vObj_init'] = $_SESSION['vObj_init'] + 1;
 
     if ($_REQUEST['ddEvent'] == 'OK') {

       if (trim($_REQUEST['tb_ddWrap1']) == '' and 
           trim($_REQUEST['tb_ddWrap2']) == '' and
           trim($_REQUEST['tb_ddWrap3']) == '') {
          // status quo, do nothing      	
        }    	
        else {
        // process each vObj
           if (trim($_REQUEST['tb_ddWrap1'] != '')) {
               $_SESSION['vLC1'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap1']);
               set_vDC_ObjectContext($rHsh,'vLC1');
           } else { $_SESSION['vLC1'] = "";}  	

           if (trim($_REQUEST['tb_ddWrap2'] != '')) {
               $_SESSION['vLC2'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap2']);
               set_vDC_ObjectContext($rHsh,'vLC2');
           } else { $_SESSION['vLC2'] = "";} 

           if (trim($_REQUEST['tb_ddWrap3'] != '')) {
               $_SESSION['vLC3'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap3']);
               set_vDC_ObjectContext($rHsh,'vLC3');
           } else { $_SESSION['vLC3'] = "";} 
        }
     }	//end click event  
    } //end isset test

   // deal with first time access
   else {
          $_SESSION['vObj_init'] = 0;
        	$_SESSION['vLC1'] = '';  	
        	$_SESSION['vLC2'] = $_SESSION['vDC5'] ;
        	$_SESSION['vLC3'] = $_SESSION['vDC4'] . $_SESSION['vDC1'] . $_SESSION['vDC2'] . $_SESSION['vDC3'] ;  	
   }	

//_____________FUNCTIONS______________________________________________________//

//-----------------------------------------------------------------------------
function set_vDC_ObjectContext ($hsh,$vLC)
//-----------------------------------------------------------------------------
{
   foreach( $hsh as $k => $v) {
     $s = preg_split("/##/", $k);
     if (preg_match('/vDC1/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC1'];}  
     if (preg_match('/vDC2/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC2'];} 
     if (preg_match('/vDC3/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC3'];}                  
     if (preg_match('/vDC4/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC4'];} 
     if (preg_match('/vDC5/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC5'];}                 
   }	
}	


//-----------------------------------------------------------------------------
function vObjDetectorDecoupler ($objStr)
//-----------------------------------------------------------------------------
/*
role: determine atomicity of string and decouple and return as a hash. we will
potentially encounter: 0 objects; 1 object within a container; multiple objects
within a container. how we determine if we have 1 or multiple is by the 
presence of ~~ which is our object delimiter. The atomicity of an object
itself is determined by the ## delimiter.  
*/
{
  $vObjHash;
  //first, am i single or plural
  // i am plural, further slicing, then hash me
  if (preg_match('/~~/', $objStr)) { 
     //slash me 
     $s = preg_split("/~~/", $objStr);
     //hash me 
     $cntr = 0;
     foreach ($s as $kvp) { 
       // $_SESSION['tmp'] .= "<br />counter outside loops is" . $cntr++ . "<br />";
       if (preg_match('/##/', $kvp))	{
       	  // $_SESSION['tmp'] .= "counter inside loops is" . $cntr++ . "<br />";
          $v = preg_split("/``/", $kvp);
          // $_SESSION['tmp'] .= $v[0] . $v[1]; 
          $vObjHash[$v[0]] = $v[1];
       }    	 
     }		
  }
  else {  // i am singular, hash me
    if (preg_match('/##/', $objStr))	{
      $v = preg_split("/``/", $objStr);
      $vObjHash[$v[0]] = $v[1];
    }
  }		

//returned hash matches pattern key= ddWrap<ltr><n>##vDC<ltr><n> value= $data<n>	
	return $vObjHash;
	
}	


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
		var ddW = $("#ddWrap1").attr('id');
		var vObj;
	  $("#ddWrap1 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap1').val(arr.join('~~'));
  }	

	function updLoc2() { 
		var arr = [];
		var ddW = $("#ddWrap2").attr('id');
		var vObj;
	  $("#ddWrap2 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap2').val(arr.join('~~'));
  }	
  
	function updLoc3() { 
		var arr = [];
		var ddW = $("#ddWrap3").attr('id');
		var vObj;
	  $("#ddWrap3 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap3').val(arr.join('~~'));
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
	
	
#vLC1 {
	cursor: pointer; 
	position:absolute;
	width:300px;
	z-index:1;
	left: 10px;
	top: 10px;
}
#vLC2 {
	cursor: pointer;
	position:absolute;
	width:300px;
	z-index:1;
	left: 400px;
	top: 10px;
}
#vLC3 {
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

#ddWrap1 {  }
#ddWrap2 {  }
#ddWrap3 {  }

#vDC1 {  }
#vDC2 {  }
#vDC3 {  }
#vDC4 {  }
#vDC5 {  }
</style>

</head>

<body>

<div id="vLC1">
<h2>Visual Location Container 1</h2>
<table class="tblVessel">
 <tr><td class="droptrue" id="ddWrap1" name="ddWrap1">
<?php echo $_SESSION['vLC1']; ?>
 </td></tr>
   </table> 
</div>
 
<div id="vLC2">
<h2>Visual Location Container 2</h2>
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap2" name="ddWrap2">
<?php echo $_SESSION['vLC2']; ?>  	
</td></tr>
</table> 
</div>
 
<div id="vLC3">
<h2>Visual Location Container 3</h2>
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap3" name="ddWrap3">  
<?php echo $_SESSION['vLC3']; ?> 
</td></tr>
</table> 
</div>

<div id="vObjConsole">
<h2>Event Console</h2>
<form name="form1" method="POST" action="jquery_events_drop_drag1d.php">
   <p>
	   <label>tb_ddWrap1:&nbsp;</label>
	   <input id="tb_ddWrap1" size="90" type="text" name="tb_ddWrap1"><br />

	   <label>tb_ddWrap2:&nbsp;</label>
	   <input id="tb_ddWrap2" size="90" type="text" name="tb_ddWrap2"><br />

	   <label>tb_ddWrap3:&nbsp;</label>
	   <input id="tb_ddWrap3" size="90" type="text" name="tb_ddWrap3"><br />
   </p>
<input name="ddEvent" id="ddEvent" type="submit" value="OK"><br />
    <?php echo '$_SESSION[\'vObj_init\']=' . $_SESSION['vObj_init'] . '<br />'; ?>
    <?php echo '$_SESSION[\'tmp\']=' . $_SESSION['tmp'] . '<br />'; ?>
</form>	
</div>

</body>
</html>
