<?php
/* 
This is 3-col form template for zenyan.
// Initial Writing: eric matthews
// Date: aug 5, 2010
// License: Dual licensed under the MIT and GPL license.
*/
 session_start();
 

 require('eConfig/envref.php');
 include($php_cLib);
 include($php_envvars);
 include($php_dbms);  //dbms specific to app
 include($php_applib);
 include($php_daclib);
 include($php_loggers);  

 $_SESSION['oldebug'] = "";
 $_SESSION['tmp'] = $debugapp;
 
 $cxHash = '';
 /* cxHash naming nomanclature = 
    <nbr><letter> where number is the row# and letter is the column (like a spreadsheet)  
 */
 $mtd = "";
 $status = '';
 $logonerror = '';

  //get only page name
  $fullrefpg = $_SERVER['HTTP_REFERER'];
  if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
  $refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);
  $_SESSION['refpgnm'] = $refpg;

  $myDbgateway = new dbgateway;

  check_referring_pg($refpg);

function check_referring_pg($refpg){  
   global $Scontxttoll;
 //if referring page context is required you code conditional here as wrapper to below conditional                
//// commented out during development ////
   if ($_SESSION['initentry'] == $Scontxttoll) { 
     $stat = getDataRSHash1();	
   }
   else {  $_SESSION['loginerr'] = 'Login required to access page';  header("Location: login.php");  exit; }
}
  

//----------------------------------------------------------------------------//
function getDataRSHash1()
//----------------------------------------------------------------------------//
{        
  global $cxHash;
  
  global $locdebugstatus;
  global $locdebug;
  global $myDbgateway;

//---QUERY-------------------------------------------------
  $query = "";
//---------------------------------------------------------

  //Execute Query
  if ($query != "") {
    $rs = $myDbgateway->readSQL($query,"hash");
  }

//---RS to UI Mapping--------------------------------------
    $cxHash['1a'] = $rs[''];
    $cxHash['1b'] = $rs[''];
    $cxHash['1c'] = $rs[''];
    $cxHash['2a'] = $rs[''];
    $cxHash['2b'] = $rs[''];
    $cxHash['2c'] = $rs[''];
    $cxHash['3a'] = $rs[''];
    $cxHash['3b'] = $rs[''];
    $cxHash['3c'] = $rs[''];
    $cxHash['4a'] = $rs[''];
    $cxHash['4b'] = $rs[''];
    $cxHash['4c'] = $rs[''];
    $cxHash['5a'] = $rs[''];
    $cxHash['5b'] = $rs[''];
    $cxHash['5c'] = $rs[''];
    $cxHash['6a'] = $rs[''];
    $cxHash['6b'] = $rs[''];
    $cxHash['6c'] = $rs[''];
    $cxHash['7a'] = $rs[''];
    $cxHash['7b'] = $rs[''];
    $cxHash['7c'] = $rs[''];
    $cxHash['8a'] = $rs[''];
    $cxHash['8b'] = $rs[''];
    $cxHash['8c'] = $rs[''];
    $cxHash['9a'] = $rs[''];
    $cxHash['9b'] = $rs[''];
    $cxHash['9c'] = $rs[''];
    $cxHash['10a'] = $rs[''];
    $cxHash['10b'] = $rs[''];
    $cxHash['10c'] = $rs[''];
    $cxHash['11a'] = $rs[''];
    $cxHash['11b'] = $rs[''];
    $cxHash['11c'] = $rs[''];
    $cxHash['12a'] = $rs[''];
    $cxHash['12b'] = $rs[''];
    $cxHash['12c'] = $rs[''];
    $cxHash['13a'] = $rs[''];
    $cxHash['13b'] = $rs[''];
    $cxHash['13c'] = $rs[''];
    $cxHash['14a'] = $rs[''];
    $cxHash['14b'] = $rs[''];
    $cxHash['14c'] = $rs[''];
    $cxHash['15a'] = $rs[''];
    $cxHash['15b'] = $rs[''];
    $cxHash['15c'] = $rs[''];
//---------------------------------------------------------

  return $status; 

} //end function


?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>3-Col From Template</title>
	
	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->
			
	<script type="text/javascript" src="jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="jquery/jquery.dropdownPlain.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
<style type="text/css">
<!--
.tblcol { text-align:right; }

#Layer1 {
	position:absolute;
	width:978px;
	height:52px;
	z-index:1;
	left: 15px;
	top: 20px;
}

-->
</style>
</head>

<body>

<!--
To implement the menus for your application you need to go open the file
referenced below and modify to reflect your application.
-->
<?php
  include('jquery/topmenu.php');
?> 	


<div id="Layer1">
<!--  Header  -->

<!-- pg content here  -->
<h1>Three Column Form Template</h1>

<h2>Form Name</h2>
<form id="form1" name="form1" method="post" action="">
<table width="900" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td class="tblcol"  width="300"><label>Test Box 1a:&nbsp;<input type="text" name="tb1a" id="tb1a" value='<?php echo $cxHash['1a']; ?>' /></label></td>
    <td class="tblcol"   width="300"><label>Test Box 1b:&nbsp;<input type="text" name="tb1b" id="tb1b" value='<?php echo $cxHash['1b']; ?>' /></label></td>
    <td class="tblcol"   width="300"><label>Test Box 1c:&nbsp;<input type="text" name="tb1c" id="tb1c" value='<?php echo $cxHash['1c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 2a:&nbsp;<input type="text" name="tb2a" id="tb2a" value='<?php echo $cxHash['2a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 2b:&nbsp;<input type="text" name="tb2b" id="tb2b" value='<?php echo $cxHash['2b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 2c:&nbsp;<input type="text" name="tb2c" id="tb2c" value='<?php echo $cxHash['2c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 3a:&nbsp;<input type="text" name="tb3a" id="tb3a" value='<?php echo $cxHash['3a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 3b:&nbsp;<input type="text" name="tb3b" id="tb3b" value='<?php echo $cxHash['3b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 3c:&nbsp;<input type="text" name="tb3c" id="tb3c" value='<?php echo $cxHash['3c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 4a:&nbsp;<input type="text" name="tb4a" id="tb4a" value='<?php echo $cxHash['4a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 4b:&nbsp;<input type="text" name="tb4b" id="tb4b" value='<?php echo $cxHash['4b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 4c:&nbsp;<input type="text" name="tb4c" id="tb4c" value='<?php echo $cxHash['4c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 5a:&nbsp;<input type="text" name="tb5a" id="tb5a" value='<?php echo $cxHash['5a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 5b:&nbsp;<input type="text" name="tb5b" id="tb5b" value='<?php echo $cxHash['5b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 5c:&nbsp;<input type="text" name="tb5c" id="tb5c" value='<?php echo $cxHash['5c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 6a:&nbsp;<input type="text" name="tb6a" id="tb6a" value='<?php echo $cxHash['6a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 6b:&nbsp;<input type="text" name="tb6b" id="tb6b" value='<?php echo $cxHash['6b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 6c:&nbsp;<input type="text" name="tb6c" id="tb6c" value='<?php echo $cxHash['6c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 7a:&nbsp;<input type="text" name="tb7a" id="tb7a" value='<?php echo $cxHash['7a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 7b:&nbsp;<input type="text" name="tb7b" id="tb7b" value='<?php echo $cxHash['7b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 7c:&nbsp;<input type="text" name="tb7c" id="tb7c" value='<?php echo $cxHash['7c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 8a:&nbsp;<input type="text" name="tb8a" id="tb8a" value='<?php echo $cxHash['8a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 8b:&nbsp;<input type="text" name="tb8b" id="tb8b" value='<?php echo $cxHash['8b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 8c:&nbsp;<input type="text" name="tb8c" id="tb8c" value='<?php echo $cxHash['8c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 9a:&nbsp;<input type="text" name="tb9a" id="tb9a" value='<?php echo $cxHash['9a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 9b:&nbsp;<input type="text" name="tb9b" id="tb9b" value='<?php echo $cxHash['9b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 9c:&nbsp;<input type="text" name="tb9c" id="tb9c" value='<?php echo $cxHash['9c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 10a:&nbsp;<input type="text" name="tb10a" id="tb10a" value='<?php echo $cxHash['10a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 10b:&nbsp;<input type="text" name="tb10b" id="tb10b" value='<?php echo $cxHash['10b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 10c:&nbsp;<input type="text" name="tb10c" id="tb10c" value='<?php echo $cxHash['10c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 11a:&nbsp;<input type="text" name="tb11a" id="tb11a" value='<?php echo $cxHash['11a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 11b:&nbsp;<input type="text" name="tb11b" id="tb11b" value='<?php echo $cxHash['11b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 11c:&nbsp;<input type="text" name="tb11c" id="tb11c" value='<?php echo $cxHash['11c']; ?>' /></label></td>
  </tr>
  <tr>
    <td class="tblcol" ><label>Text Box 12a:&nbsp;<input type="text" name="tb12a" id="tb12a" value='<?php echo $cxHash['12a']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 12b:&nbsp;<input type="text" name="tb12b" id="tb12b" value='<?php echo $cxHash['12b']; ?>' /></label></td>
    <td class="tblcol" ><label>Test Box 12c:&nbsp;<input type="text" name="tb12c" id="tb12c" value='<?php echo $cxHash['12c']; ?>' /></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="btn1" id="btn1" value="Submit" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

<p>&nbsp;</p>


<!-- comment out or remove me for production -->
<?php echo $_SESSION['oldebug']; ?>
</div>
	
</body>

</html>
