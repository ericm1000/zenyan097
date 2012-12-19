<?php
   session_start();
   
//  
   require('eConfig/envref.php');
   include($php_cLib);
   include($php_envvars);
   include($php_dbms);  //dbms specific to app
   include($php_applib);
   include($php_loggers);  
  
   $_SESSION['oldebug'] = "";
   $_SESSION['tmp'] = $debugapp;
   
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
<!--  Integrator: Eric Matthews  -->
<!--  Integration into the zenyan framework  -->
<!--  Example: Using JQuery to create accordian on div tag  -->	
<!--  Credit:  John Resig for his JQuery api       -->
<!--  License: Dual licensed under the MIT and GPL license  -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Simple JQuery Accordion Only Using special class DIV and JQuery API</title>

	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->

<script type="text/javascript" src="jquery/jquery182.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="jquery/stylesheet/accordian.css">
<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">

<script type="text/javascript">
$(document).ready(function(){ 
	 $(".accordion div").hide(); // close accordian
	 $(".accordion div").eq(2).show();   //open a default  

$(".accordion h3").click(function(){
// in order to allow for any html within the accordian you need to wrap your 
// markup within a div tag.	
		$(this).next("div").slideToggle("slow")	
	});
});
</script>

<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:285px;
	height:214px;
	z-index:1;
	left: 20px;
	top: 19px;
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

<!-- Our content. Straight html for SEO. The php version of this allows for dynamicc content -->	
<div class="accordion">

<!-- Div1 -->	
 <h3>pre tag (div 1)</h3>
<div class="accordiandata" id="1">
  <pre>START TRANSACTION
DELETE FROM courses
WHERE  course_designater = 'Excel101' 
GO
 </pre>
</div>

<!-- Div2 -->
 <h3>Unordered List (div 2)</h3>
<div class="accordian2data" id="2">
<ul>
  <li>One
  <li>Two
  <li>Three		
</ul>	
</div>

<!-- Div3 -->
 <h3>p tag (div 3)</h3>
<div class="accordian2data" id="3">
<p>
 DATE      YYYY-MM-DD<br /> 
 DATETIME  YYYY-MM-DD HH:MM:SS<br /> 
 TIMESTAMP YYYYMMDDHHMMSS<br /> 
 TIME      HH:MM:SS<br />
</p>
</div>

<!-- Div4 Table -->
 <h3>table (div 4)</h3>
 <div class="accordian2data" id="4">
 <h4>table time</h4>	
 <table>
  <tr valign="top">
    <td width="184" bgcolor="#000000"><p><font face="Arial" color=#FFFFFF><b>Description</b></font></p></td>
    <td width="183" bgcolor="#000000"><p><font face="Arial" color=#FFFFFF><b>Function</b></font></p></td>
  </tr>
  <tr valign="top">
    <td bgcolor=""#CCFFCC""><font face="Arial">Get date</font></td>
    <td bgcolor=""#CCFFCC""><h3><font face=Courier New, Courier, monospace>curdate()</font></h3></td>
  </tr>
  <tr valign="top">
    <td bgcolor="#CCFFCC"><font face="Arial">Get time</font></td>
    <td bgcolor="#CCFFCC"><h3><font face=Courier New, Courier, monospace>curtime()</font></h3></td>
  </tr>
  <tr valign="top">
    <td bgcolor="#CCFFCC"><font face="Arial">Extract day name from date </font></td>
    <td bgcolor="#CCFFCC"><h3><font face=Courier New, Courier, monospace>dayname(<i>string</i>)</font></h3></td>
  </tr>
  <tr valign="top">
    <td bgcolor="#CCFFCC"><font face="Arial">Extract day number from date </font></td>
    <td bgcolor="#CCFFCC"><h3><font face=Courier New, Courier, monospace>dayofweek(<i>string</i>)</font></h3></td>
  </tr>
  <tr valign="top">
    <td bgcolor="#CCFFCC"><font face="Arial">Extract month from date </font></td>
    <td bgcolor="#CCFFCC"><h3><font face=Courier New, Courier, monospace>monthname(<i>string</i>)</font></h3></td>
  </tr> 
</table>
</div>

<!-- Div5 plural tags -->
 <h3>Use any html markup (div 5)</h3>
<div class="accordian2data" id="5">
<h1>H1 Tag</h1>
<h1>H2 Tag</h1>
<pre>
 DATE      YYYY-MM-DD<br /> 
 DATETIME  YYYY-MM-DD HH:MM:SS<br /> 
 TIMESTAMP YYYYMMDDHHMMSS<br /> 
 TIME      HH:MM:SS<br />
</pre>
</div> 
 
<!-- closing accoridian div tag -->
</div>


</div>


</body>
</html>
