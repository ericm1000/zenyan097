<?php
// Navtango Tri-Frame
// Initial Writing: ericm
// Date: 2/02/2010
// License: Dual licensed under the MIT and GPL license
/*
Navtango Tri-Frame
*/
// History/Customizations:
/*
                        
*/
   session_start();
   
   require('eConfig/envref.php');
   include($php_cLib);
   include($php_envvars);   
   if ($_SESSION['initentry'] != $Scontxttoll) { 
     $_SESSION['loginerr'] = 'Login required to access page';
     header("Location: login.php");  
     exit; 
   }
?>
<!DOCTYPE html>
<html>
<head>
<title>navTango</title>
</head>
<frameset rows="150px,*" id="TopFrame">
   <frame src="nt_topmnu.php" name="cmd" scrolling="no" frameborder="0" noresize>
<frameset cols="175px,*" id="MiddleFrame">
   <frame src="lnkfavorites.php" name="toc"  frameborder="0" >
   <frame src="navtango_home.php" name="main" scrolling="auto" frameborder="0">
</frameset>
</frameset>
<noframes>
<body topmargin="0" leftmargin="4">
<p>This page uses frames, but your browser doesn't support
them. Very odd in this day and age.</p>
</body>
</noframes>
</html>