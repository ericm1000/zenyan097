<?php
/* 
This is mainpg for Data Bridge - Archive.

Reference to topmenu.php is configured one time for menus specific to your
application. 

// Initial Writing: eric matthews
// Date: Feb 28, 2011
// License: Dual licensed under the MIT and GPL license

*/
 session_start();
 

  $_SESSION = array();
  session_unset();
  session_destroy();
  header("Location: login.php");  
  exit;
  
 ?> 
