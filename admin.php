<?php
 session_start();
   
 $_SESSION['asc'] = "999";
 $ltoke = 'n';
 $agt = 'n'; 
 $dout = "";

 require('eLib/asl.php'); 
 
 if (rtrim($_REQUEST['nm']) != "")
 {
  // are they an admin?
  foreach ($anm as $v)
  {
    if (rtrim($_REQUEST['nm']) == rtrim($v))
    {
     $ltoke = 'y';
    }
  }      	
  // do they have the correct password	
     if ( md5($_REQUEST['pwd']) == $apw and $ltoke == 'y')
     {
  	   $agt = 'y';
  	   $_SESSION['asc'] = "111"; 
  	   //they are in, display menu      
       //$dout = '$agt=' . $agt . ' and $ltoke=' . $ltoke;
       $dout = '<h2>User Registration </h2>
       <p><a href="register.php" target="_blank">Register User</a></p>
       <p><a href="susp.php"  target="_blank">Suspend User</a></p>
       <p><a href="unsusp.php" target="_blank">Unsuspend User</a></p>
       <h2>Generate New Admin Password</h2>
       <p><a href="newadmpwd.php" target="_blank">New Admin Password</a>';
  	 }   
     else { 
     	     $agt = 'n';
     	     $_SESSION['asc'] = "000"; 
     	     $dout = "password or login name is incorrect";
     	     //$dout = '$agt=' . $agt . ' and $ltoke=' . $ltoke;     	
     }	  		
 } //end outer if	

 
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet/mncontent.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Data Bridge - Admin</title>
</head>
<body>
  <h1>Data Bridge Admin</h1>
  <?php echo $dout; ?>

  <hr />
<form id="form1" name="form1" method="post" action="admin.php?x=0">
  <label>
    <input name="nm" type="text" id="nm" size="35" maxlength="35" />
  </label>
     <label><br />
    <input name="pwd" type="password" id="pwd" size="12" maxlength="12" />    
  </label>
<br />
  <input type="submit" name="submitfrm" id="submitfrm" value="ok" />
  </label>
</form> 
</body>
</html>