<?php
/* 
This is login for zenyan.

// Initial Writing: eric matthews
// Date: aug 5, 2010
// License: Dual licensed under the MIT and GPL license
// history
// page redesign 10/30/2012 ericm
*/
 session_start();
  
 $_SESSION['bugout'] = '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-8859-1\">
<link rel="stylesheet" href="stylesheet/mncontent.css">
<style type="text/css">
<!--
#title {
	position:absolute;
	width:386px;
	height:41px;
	z-index:1;
	left: 30px;
	top: 18px;
}
#loginfrm {
	position:absolute;
	width:345px;
	height:195px;
	z-index:2;
	left: 49px;
	top: 142px;
}
#mnpgimg {
	position:absolute;
	width:202px;
	height:137px;
	z-index:3;
	left: 418px;
	top: 127px;
}
#txtblurb {
	position:absolute;
	width:545px;
	height:50px;
	z-index:4;
	left: 54px;
	top: 60px;
}
#tshoot {
	position:absolute;
	width:580px;
	height:144px;
	z-index:5;
	left: 45px;
	top: 367px;
}
-->
</style>
</head>
<body>
<div id="title">
<h1>zenyan Login</h1>
</div>

<div id="loginfrm">
  <form id="form1" name="form1" method="post" action="gate.php">
    <p align="right">Login:    <input type="text" name="lname" id="lname" size="35" /> </p>
    <p align="right">Password: <input type="password" name="pwd" id="pwd" size="10" /> </p>
    <p align="right"><input type="submit" name="Submit" value="Submit" /></p>
    <p>&nbsp;</p>
     <p><?php if(isset($_SESSION['loginerr'])) { echo $_SESSION['loginerr'];} ?></b></p>
  </form>
</div>

<div id="mnpgimg"><img src="images/Digital_Eye200x133.png" width="200" height="133" /></div>
<div id="txtblurb">
<p>
zenyan is an open source application development framework. Unlike 
most development frameworks, zenyan is very open ended and allows you the greatest
latitude in designing web applications.
</p>
</div>
<div id="tshoot">
<pre><?php if ($_SESSION['bugout']) { echo $_SESSION['bugout']; } ?></pre>
</div>
</body>
</html>

</body>
</html>
