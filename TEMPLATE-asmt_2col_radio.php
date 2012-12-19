<?php
/* 
This template is for zenyan - 2 Column Radio List for Assessments.
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
   if ($_SESSION['initentry'] == $Scontxttoll) { 
   	
   }
   else {  $_SESSION['loginerr'] = 'Login required to access page';  header("Location: login.php");  exit; }
}



?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>zenyan 2-col Assessment Template</title>
	
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
	width:979px;
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
<h1>2-Col Radio Assessment Template</h1>

<form name="formelements" action="TEMPLATE-asmt_2col_radio.php" method="POST" >
<table width="400" border="0" cellspacing="2" cellpadding="3">
<!-- header -->
  <tr>
    <td>
Yes&nbsp;&nbsp;&nbsp;No   	
    </td>
    <td>
Yes&nbsp;&nbsp;&nbsp;No  
    </td>
  </tr>
<!-- form data -->
  <tr>
    <td  width="200">
<input type="radio" name="rbtn1" value="y" <?php if ($_POST['rbtn1'] == "y") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn1" value="n" <?php if ($_POST['rbtn1'] == "n") { echo " checked"; }  ?>  />&nbsp;&nbsp;
One&nbsp;&nbsp    	
    </td>
    <td width="200">
<input type="radio" name="rbtn2" value="y" <?php if ($_POST['rbtn2'] == "y") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn2" value="n" <?php if ($_POST['rbtn2'] == "n") { echo " checked"; }  ?>  />&nbsp;&nbsp;
Two&nbsp;&nbsp     
    </td>
  </tr> 
  <tr>
    <td>
<input type="radio" name="rbtn3" value="y" <?php if ($_POST['rbtn3'] == "y") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn3" value="n" <?php if ($_POST['rbtn3'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Three&nbsp;&nbsp   
    </td>
    <td>
<input type="radio" name="rbtn4" value="y" <?php if ($_POST['rbtn4'] == "y") { echo " checked"; }   ?> />&nbsp;&nbsp;
<input type="radio" name="rbtn4" value="n" <?php if ($_POST['rbtn4'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Four&nbsp;&nbsp   
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn5" value="y" <?php if ($_POST['rbtn5'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn5" value="n" <?php if ($_POST['rbtn5'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Five&nbsp;&nbsp  
    </td>
    <td>
<input type="radio" name="rbtn6" value="y" <?php if ($_POST['rbtn6'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn6" value="n" <?php if ($_POST['rbtn6'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Six&nbsp;&nbsp   	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn7" value="y" <?php if ($_POST['rbtn7'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn7" value="n" <?php if ($_POST['rbtn7'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Seven&nbsp;&nbsp
    </td>
    <td>
<input type="radio" name="rbtn8" value="y" <?php if ($_POST['rbtn8'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn8" value="n" <?php if ($_POST['rbtn8'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Eight&nbsp;&nbsp 
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn9" value="y" <?php if ($_POST['rbtn9'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn9" value="n" <?php if ($_POST['rbtn9'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Nine&nbsp;&nbsp  	
    </td>
    <td>
<input type="radio" name="rbtn10" value="y" <?php if ($_POST['rbtn10'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn10" value="n" <?php if ($_POST['rbtn10'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Ten&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn11" value="y" <?php if ($_POST['rbtn11'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn11" value="n" <?php if ($_POST['rbtn11'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Eleven&nbsp;&nbsp
    </td>
    <td>
<input type="radio" name="rbtn12" value="y" <?php if ($_POST['rbtn12'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn12" value="n" <?php if ($_POST['rbtn12'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twelve&nbsp;&nbsp	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn13" value="y" <?php if ($_POST['rbtn13'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn13" value="n" <?php if ($_POST['rbtn13'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Thirteen&nbsp;&nbsp
    </td>
    <td>
<input type="radio" name="rbtn14" value="y" <?php if ($_POST['rbtn14'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn14" value="n" <?php if ($_POST['rbtn14'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Fourteen&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn15" value="y" <?php if ($_POST['rbtn15'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn15" value="n" <?php if ($_POST['rbtn15'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Fifteen&nbsp;&nbsp	
    <td>
<input type="radio" name="rbtn16" value="y" <?php if ($_POST['rbtn16'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn16" value="n" <?php if ($_POST['rbtn16'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Sixteen&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn17" value="y" <?php if ($_POST['rbtn17'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn17" value="n" <?php if ($_POST['rbtn17'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Seventeen&nbsp;&nbsp
    </td>
    <td>
<input type="radio" name="rbtn18" value="y" <?php if ($_POST['rbtn18'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn18" value="n" <?php if ($_POST['rbtn18'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Eighteen&nbsp;&nbsp	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn19" value="y" <?php if ($_POST['rbtn19'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn19" value="n" <?php if ($_POST['rbtn19'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Nineteen&nbsp;&nbsp
    </td>
    <td>
<input type="radio" name="rbtn20" value="y" <?php if ($_POST['rbtn20'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn20" value="n" <?php if ($_POST['rbtn20'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty&nbsp;&nbsp
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn21" value="y" <?php if ($_POST['rbtn21'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn21" value="n" <?php if ($_POST['rbtn21'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty One&nbsp;&nbsp	
    </td>
    <td>
<input type="radio" name="rbtn22" value="y" <?php if ($_POST['rbtn22'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn22" value="n" <?php if ($_POST['rbtn22'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty Two&nbsp;&nbsp	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn23" value="y" <?php if ($_POST['rbtn23'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn23" value="n" <?php if ($_POST['rbtn23'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty Three&nbsp;&nbsp	
    </td>
    <td>
<input type="radio" name="rbtn24" value="y" <?php if ($_POST['rbtn24'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn24" value="n" <?php if ($_POST['rbtn24'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty Four&nbsp;&nbsp		
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn25" value="y" <?php if ($_POST['rbtn25'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn25" value="n" <?php if ($_POST['rbtn25'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty Five&nbsp;&nbsp	
    </td>
    <td>
<input type="radio" name="rbtn26" value="y" <?php if ($_POST['rbtn26'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn26" value="n" <?php if ($_POST['rbtn26'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty Six&nbsp;&nbsp	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn27" value="y" <?php if ($_POST['rbtn27'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn27" value="n" <?php if ($_POST['rbtn27'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty Seven&nbsp;&nbsp		
    </td>
    <td>
<input type="radio" name="rbtn28" value="y" <?php if ($_POST['rbtn28'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn28" value="n" <?php if ($_POST['rbtn28'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty eight&nbsp;&nbsp	
    </td>
  </tr>
  <tr>
    <td>
<input type="radio" name="rbtn29" value="y" <?php if ($_POST['rbtn29'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn29" value="n" <?php if ($_POST['rbtn29'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Twenty Nine&nbsp;&nbsp	
    </td>
    <td>
<input type="radio" name="rbtn30" value="y" <?php if ($_POST['rbtn30'] == "y") { echo " checked"; }   ?>  />&nbsp;&nbsp;
<input type="radio" name="rbtn30" value="n" <?php if ($_POST['rbtn30'] == "n") { echo " checked"; }  ?> />&nbsp;&nbsp;
Thirty&nbsp;&nbsp		
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
