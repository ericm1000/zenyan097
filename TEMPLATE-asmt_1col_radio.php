<?php
/* 
This template is for zenyan - Single Column Radio List for Assessments.
// Initial Writing: eric matthews
// Date: dec 9, 2010
// License: Dual licensed under the MIT and GPL license
*/
 session_start();
 

 require('eConfig/envref.php');
 include($php_cLib);
 include($php_envvars);
 include($php_dbms);  //dbms specific to app
 include($php_applib);
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

check_referring_pg($refpg);

function check_referring_pg($refpg){  
   global $Scontxttoll;
 //if referring page context is required you code conditional here as wrapper to below conditional                
//// commented out during development ////
   if ($_SESSION['initentry'] == $Scontxttoll) { }
   else {  $_SESSION['loginerr'] = 'Login required to access page';  header("Location: login.php");  exit; }
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>zenyan 1-col Assessment Template</title>
	
	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->
			
	<script type="text/javascript" src="jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="jquery/jquery.dropdownPlain.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
<style type="text/css">
<!--
.tblcolhdg {
   vertical-align:text-top;
   font-size:  font-size: .90em;;
   font-family: Arial, Helvetica, sans-serif;
   color:blue;
   background-color:#99CCCC;
   text-align:center;
}
.tblcollbl {
   text-align:right;
   vertical-align:text-top;
   font-size:  font-size: .90em;;
   font-family: Arial, Helvetica, sans-serif;
}
.tblcoldta {
   text-align:left;
   vertical-align:text-top;
   font-size:  font-size: .90em;
   font-family: Arial, Helvetica, sans-serif;
   font-weight: bold;
}
.tblcoldiv { text-align:left; 

}

#Layer1 {
	position:absolute;
	width:983px;
	height:52px;
	z-index:1;
	left: 15px;
	top: 20px;
}

-->
</style>
</head>

<body>
<?php
  include('jquery/topmenu.php');
?> 	

<div id="Layer1">
<!--  Header  -->

<!-- pg content here  -->
<h1>1-Col Radio Assessment Template</h1>

<form name="formelements" action="TEMPLATE-asmt_1col_radio.php" method="POST" >
<table width="200" border="0" cellspacing="2" cellpadding="3">
<!-- header -->
  <tr>
    <td>
Yes&nbsp;&nbsp;&nbsp;No   	
    </td>
  </tr>
  <tr>
<!-- form data -->
    <td  width="200">
<input type="radio" name="rbtn1" value="a" <?php if ($_POST['rbtn1'] == "a") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn1" value="b" <?php if ($_POST['rbtn1'] == "b") { echo " checked"; }  ?>  />&nbsp;&nbsp;
One&nbsp;&nbsp    	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn2" value="a" <?php if ($_POST['rbtn2'] == "a") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn2" value="b" <?php if ($_POST['rbtn2'] == "b") { echo " checked"; }  ?>  />&nbsp;&nbsp;
Two&nbsp;&nbsp     
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn3" value="a" <?php if ($_POST['rbtn3'] == "a") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn3" value="b" <?php if ($_POST['rbtn3'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Three&nbsp;&nbsp   
    </td>
  </tr>
  <tr>
   <td>
<input type="radio" name="rbtn4" value="a" <?php if ($_POST['rbtn4'] == "a") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn4" value="b" <?php if ($_POST['rbtn4'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Four&nbsp;&nbsp   
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn5" value="a" <?php if ($_POST['rbtn5'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn5" value="b" <?php if ($_POST['rbtn5'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Five&nbsp;&nbsp  
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn6" value="a" <?php if ($_POST['rbtn6'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn6" value="b" <?php if ($_POST['rbtn6'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Six&nbsp;&nbsp   	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn7" value="a" <?php if ($_POST['rbtn7'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn7" value="b" <?php if ($_POST['rbtn7'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Seven&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn8" value="a" <?php if ($_POST['rbtn8'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn8" value="b" <?php if ($_POST['rbtn8'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Eight&nbsp;&nbsp 
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn9" value="a" <?php if ($_POST['rbtn9'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn9" value="b" <?php if ($_POST['rbtn9'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Nine&nbsp;&nbsp  	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn10" value="a" <?php if ($_POST['rbtn10'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn10" value="b" <?php if ($_POST['rbtn10'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Ten&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn11" value="a" <?php if ($_POST['rbtn11'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn11" value="b" <?php if ($_POST['rbtn11'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Eleven&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn12" value="a" <?php if ($_POST['rbtn12'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn12" value="b" <?php if ($_POST['rbtn12'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twelve&nbsp;&nbsp	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn13" value="a" <?php if ($_POST['rbtn13'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn13" value="b" <?php if ($_POST['rbtn13'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Thirteen&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn14" value="a" <?php if ($_POST['rbtn14'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn14" value="b" <?php if ($_POST['rbtn14'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Fourteen&nbsp;&nbsp
    </td>
  </tr> 
  <tr>
    <td>
<input type="radio" name="rbtn15" value="a" <?php if ($_POST['rbtn15'] == "a") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn15" value="b" <?php if ($_POST['rbtn15'] == "b") { echo " checked"; }  ?> />&nbsp;&nbsp;
Fifteen&nbsp;&nbsp
    </td>
  </tr> 
</table>
<br />
<p><input type="submit" value="Done" name="environassessmnt"></p>
</form>

<p>&nbsp;</p>
<p>
  <!-- comment out or remove me for production -->
  <?php echo $_SESSION['oldebug']; ?>
</p>
</div>

</body>

</html>
