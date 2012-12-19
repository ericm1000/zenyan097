<?php
 session_start();
 

require('eConfig/envref.php');
include($php_envvars);
include($php_dbms);
$fullrefpg = $_SERVER['HTTP_REFERER'];


$_SESSION['oldebug'] = '';
$_SESSION['lname'] = '';
$_SESSION['cntxt'] = '';
$_SESSION['membermsg'] = '';

// going to define active patient data session context here. will later farm out
// to a different location (example: loaded library from patient activate fcn.
$_SESSION['actvPatient'] = ''; //hash hold other hashes
// mockup and hardcode for now
/// Patient ///
$patient['firstname'] = "Edward";
$patient['lastname'] = "Ucator";
$patient['mrn'] = "ZX15-45613";
$patient['dob'] = "1/12/1958";
$patient['age'] = "53";
$patient['gender'] = "M";
$_SESSION['actvPatient'] = $patient;
/// Admission Info ///
$adminfo['admdate'] = "12-15-2010";
$adminfo['admtime'] = "12:30pm";
$adminfo['facility'] = "zenyan Medical Center";
$adminfo['location'] = "CCU";
$adminfo['room'] = "4 West";
$adminfo['bed'] = "4-14a";
$_SESSION['actvP_adminfo'] = $adminfo;
/// Vitals Array Data ///
//// find in nas_iv.php
/// IV Administration Data ///

$uimsg = '';
$traceflg = '';
$trace = '';

//get only page name.
if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
$refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);
check_referring_pg($refpg);

function check_referring_pg($refpg){ 
	  global $Scontxttoll; 
 //if referring page context is required you code conditional here as wrapper to below conditional                
//// commented out during development ////
   if ($_SESSION['initentry'] == $Scontxttoll) { }
   else {  $_SESSION['loginerr'] = 'Login required to access page';  header("Location: login.php");  exit; }
}


// real pita as we need to deal with html markup, escaped markeup and 
// synchronization of context of ui on browser 
if (trim($_REQUEST['htb_dSect1_esc']) != "") {
 $_SESSION['htb_dSect1_esc'] = $_REQUEST['htb_dSect1_esc'];
 $_SESSION['htb_dSect1_esc'] = htmlspecialchars($_SESSION['htb_dSect1_esc']);
 $dcHtml1 = htmlspecialchars_decode($_REQUEST['htb_dSect1_esc']);
 $_SESSION['htb_dSect1'] = $dcHtml1 ;
} 

if (trim($_REQUEST['htb_dSect2_esc']) != "") { 
 $_SESSION['htb_dSect2_esc'] = $_REQUEST['htb_dSect2_esc'];
 $_SESSION['htb_dSect2_esc'] = htmlspecialchars($_SESSION['htb_dSect2_esc']);
 $dcHtml2 = htmlspecialchars_decode($_REQUEST['htb_dSect2_esc']);
 $_SESSION['htb_dSect2'] = $dcHtml2 ;
}

if (trim($_REQUEST['htb_dSect3_esc']) != "") { 
 $_SESSION['htb_dSect3_esc'] = $_REQUEST['htb_dSect3_esc'];
 $_SESSION['htb_dSect3_esc'] = htmlspecialchars($_SESSION['htb_dSect3_esc']);
 $dcHtml3 = htmlspecialchars_decode($_REQUEST['htb_dSect3_esc']);
 $_SESSION['htb_dSect3'] = $dcHtml3 ;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Inline Editing Using DIV Tags and CKEditor</title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />

	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->

	<script type="text/javascript" src="jquery/jquery182.min.js"></script>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="sample.js" type="text/javascript"></script>
	<link href="sample.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
	<script type="text/javascript">
	//<![CDATA[

   $(document).ready(function(){
      $('#notes1div').show();
      $('#notes2div').show();
      $('#notes3div').show();
      $('#clsed1').hide();
      $('#clsed2').hide();
      $('#clsed3').hide();
 
   });  //close document.ready

	 var config = {
      toolbarCanCollapse : true,
      toolbarStartupExpanded : false,
      width: 700,
		  toolbar :
		  [
		  	[ 'Bold', 'Italic', 'Strike', 'Subscript', 'Superscript', '-', 'TextColor','BGColor', '-', 'NumberedList', 'BulletedList', '-', 'Link']
		  ]	 	
	 };
   var editor1;
   var editor2;
   var editor3;   

// my seem like redundant code, but desire total independence. once i get the 
// gist of use, we shall try to consolidate and refactor this code
function createEditor1()
{
	if ( editor1 ) {
		return;
  } else {   
      $('#clsed1').show();
      $('#aded1').hide();
      $('#notes1div').hide();
      
	    var html = document.getElementById( 'notes1editor' ).innerHTML;
	    // Create a new editor inside the <div id="editor">, setting its value to html
	    editor1 = CKEDITOR.appendTo( 'editor1', config, html );
  }
}

function removeEditor1()
{
	if ( !editor1 ) {
		return;
  } else {
      $('#clsed1').hide();
      $('#aded1').show();
      $('#notes1div').show();

	    // Retrieve the editor contents. In an Ajax application, this data would be
	    // sent to the server or used in any other way.
	    document.getElementById( 'notes1editor' ).innerHTML = editor1.getData();
	    document.getElementById( 'notes1div' ).style.display = '';
	    var tDta1 = CKEDITOR.tools.htmlEncode(editor1.getData());
      $('#htb_dSect1_esc').val(tDta1);
	    // Destroy the editor.
	    editor1.destroy();
	    editor1 = null;
  }
}

////////////////////

function createEditor2()
{
	if ( editor2 ) {
		return;
  } else {
      $('#clsed2').show();
      $('#aded2').hide();
      $('#notes2div').hide(); 
        
	    var html = document.getElementById( 'notes2editor' ).innerHTML;
	    // Create a new editor inside the <div id="editor">, setting its value to html
	    editor2 = CKEDITOR.appendTo( 'editor2', config, html );
  }
}

function removeEditor2()
{
	if ( !editor2 ) {
		return;
  } else {
      $('#clsed2').hide();
      $('#aded2').show();
      $('#notes2div').show();

	    // Retrieve the editor contents. In an Ajax application, this data would be
	    // sent to the server or used in any other way.
	    document.getElementById( 'notes2editor' ).innerHTML = editor2.getData();
	    document.getElementById( 'notes2div' ).style.display = '';
 	    var tDta2 = CKEDITOR.tools.htmlEncode(editor2.getData());
      $('#htb_dSect2_esc').val(tDta2);
	    // Destroy the editor.
	    editor2.destroy();
	    editor2 = null;
  }
}

////////////////////

function createEditor3()
{
	if ( editor3 ) {
		return;
  } else {
      $('#clsed3').show();
      $('#aded3').hide();
      $('#notes3div').hide();
          
	    var html = document.getElementById( 'notes3editor' ).innerHTML;
	    // Create a new editor inside the <div id="editor">, setting its value to html
	    editor3 = CKEDITOR.appendTo( 'editor3', config, html );
  }
}

function removeEditor3()
{
	if ( !editor3 ) {
		return;
  } else {
      $('#clsed3').hide();
      $('#aded3').show();
      $('#notes3div').show();

	    // Retrieve the editor contents. In an Ajax application, this data would be
	    // sent to the server or used in any other way.
	    document.getElementById( 'notes3editor' ).innerHTML = editor3.getData();
	    document.getElementById( 'notes3div' ).style.display = '';
	    var tDta3 = CKEDITOR.tools.htmlEncode(editor3.getData());
      $('#htb_dSect3_esc').val(tDta3);
	    // Destroy the editor.
	    editor3.destroy();
	    editor3 = null;
  }
}

	//]]>
	</script>
<style type="text/css">
<!--

#notes1Container {
	z-index:1;
	left: 14px;
}
#notes1Control {
	position:absolute;
	width:224px;
	height:44px;
	z-index:2;
	left: 778px;
	top: 138px;
}

#notes2Container {
	z-index:1;
	left: 10px;
}
#notes2Control {
	position:absolute;
	width:224px;
	height:44px;
	z-index:2;
	left: 778px;
	top: 230px;
}

#notes3Container {
	z-index:1;
	left: 10px;
}
#notes3Control {
	position:absolute;
	width:224px;
	height:44px;
	z-index:2;
	left: 778px;
	top: 324px;
}
#ckeForm {
	position:absolute;
	width:540px;
	height:27px;
	z-index:10;
	left: 85px;
	top: 41px;
}
#pgtitle {
	position:absolute;
	width:620px;
	height:29px;
	z-index:11;
	left: 4px;
	top: 2px;
}
table {
	margin-left: 18px;
}
td {
	font-family: arial;
}

.datatbl {
	font-family: arial;
}
.datatbl th {
		text-align: left;
}	
.datatbl td {
		text-align: left;
}			
#Layer1 {
	position:absolute;
	width:1010px;
	height:395px;
	z-index:3;
	left: 9px;
	top: 30px;
}
-->
</style>
</head>
<body>
<?php
  include('jquery/topmenu.php');
?> 
<div id="Layer1">
<br />
<br />		
  <?php echo $_SESSION['oldebug']; ?>
<form id="sectnotes" method="POST"  action="nas_admassessment.php">
<!-- form name="ckePForm" action="" --> 
		 <input id="htb_dSect1_esc" type="hidden" name="htb_dSect1_esc" value="<?php echo $_SESSION['htb_dSect1_esc']; ?>" >
	   <input id="htb_dSect2_esc" type="hidden" name="htb_dSect2_esc" value="<?php echo $_SESSION['htb_dSect2_esc']; ?>" >
	   <input id="htb_dSect3_esc" type="hidden" name="htb_dSect3_esc" value="<?php echo $_SESSION['htb_dSect3_esc']; ?>" >
<button class="button positive"> <img src="images/blue-folder-horizontal.png" alt="folder" /> Update Notes </button>
<!-- input name="submit" id="ddEvent" class="button" type="submit" value="Update Notes" / -->
</form>

<div id="notes1Control">
	<p>
	  <input id="aded1" onclick="createEditor1();" type="button" value="Case Notes" />
	  <input id="clsed1" onclick="removeEditor1();" type="button" value="Close Case Notes Editor" />
  </p>    
</div>

<h2>Patient Admission Report</h2>
<table width="530" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="60">Patient:</td>
    <td width="200"><b>
<?php echo trim($_SESSION['actvPatient']['firstname']) . " " . trim($_SESSION['actvPatient']['lastname']); ?>
	</b></td>
    <td width="50">MRN:</td>
    <td width="150"><b>
<?php echo $_SESSION['actvPatient']['mrn']; ?>
	</b></td>
    <td width="40">Sex: </td>
    <td width="30"><b>
<?php echo $_SESSION['actvPatient']['gender']; ?>
	</b></td>
  </tr>
</table>
<br />
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="150">Admission Date/Time:</td>
    <td><b>
<?php echo $adminfo['admdate']; ?> &nbsp;&nbsp;&nbsp; <?php echo $adminfo['admtime']; ?>	
    </b></td>
    <td width="80"><div align="center">Location:</div></td>
    <td width="200"><b>
<?php echo $adminfo['facility']; ?>	
  </b></td>
  </tr>
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    <td width="270"><b>
<?php echo $adminfo['location']; ?>	&nbsp;&nbsp;&nbsp; <?php echo $adminfo['room']; ?>
	</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    <td><b>
<?php echo $adminfo['bed']; ?>	
	</b></td>
  </tr>
</table> 
	<!-- This div will hold the editor. -->
<div id="notes1Container">
	<div id="editor1">
	</div>
	<div id="notes1div" style="display: none">
		<p><i>General Case Notes:</i></p>
		<!-- This div will be used to display the editor contents. -->
		<div id="notes1editor">
       <?php echo $_SESSION['htb_dSect1']; ?>
		</div>
	</div>    
</div>

<div id="notes2Control">
	<p>
	  <input id="aded2" onclick="createEditor2();" type="button" value="Clinical Notes" />
	  <input id="clsed2" onclick="removeEditor2();" type="button" value="Close Clinical Notes Editor" />
  </p>    
</div>

<div id="notes2Container">
	<!-- This div will hold the editor. -->
	<div id="editor2">
	</div>
	<div id="notes2div" style="display: none">
		<p><i>Clinical Notes:</i></p>
		<!-- This div will be used to display the editor contents. -->
		<div id="notes2editor">
       <?php echo $_SESSION['htb_dSect2']; ?>
		</div>
	</div>    
</div>

<div id="notes3Control">
	<p>
	  <input id="aded3" onclick="createEditor3();" type="button" value="IV Notes" />
	  <input id="clsed3" onclick="removeEditor3();" type="button" value="Close IV Notes Editor" />
  </p>    
</div>

<div id="notes3Container">
<h4>IV Administration Record</h4>
<table width="765" border="0" cellspacing="0" cellpadding="3" class="datatbl">
  <tr>
    <th width="138"><strong>IV Details </strong></th>
    <th width="295">&nbsp;</th>
    <th width="39">&nbsp;</th>
    <th width="56"><strong>Bag</strong></th>
    <th width="54"><strong>Rate</strong></th>
    <th width="109">&nbsp;</th>
    <th width="54"><strong>Vol</strong></th>
  </tr>
  <tr>
    <th><strong>Date/Time</strong></th>
    <th><strong>Type</strong></th>
    <th><strong>Bag#</strong></th>
    <th><strong>Vol (ml) </strong></th>
    <th><strong>(ml/hr)  </strong></th>
    <th><strong>Dose</strong></th>
    <th><strong>Inf (ml) </strong></th>
  </tr>
  <tr>
    <td><hr /></td>
    <td><hr /></td>
    <td><hr /></td>
    <td><hr /></td>
    <td><hr /></td>
    <td><hr /></td>
    <td><hr /></td>
  </tr>
  <!-- DO BELOW INTO A TEMPLATE -->
  <?php if ($_SESSION['ivadmin']) { foreach ($_SESSION['ivadmin'] as $v) { echo $v ;} } ?>
</table>

<br /><br />
	<!-- This div will hold the editor. -->
	<div id="editor3">
	</div>
	<div id="notes3div" style="display: none">
		<p><i>IV Administration Notes:</i></p>
		<!-- This div will be used to display the editor contents. -->
		<div id="notes3editor">
       <?php echo $_SESSION['htb_dSect3']; ?>
		</div>
	</div>    
</div>
</div>



</body>
</html>
