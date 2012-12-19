<?php
 require('cLib/clvars.php');
 session_start();
  

  //get only page name
  $fullrefpg = $_SERVER['HTTP_REFERER'];
  if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
  $refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);
  $_SESSION['refpgnm'] = $refpg;

// simple context checking  
  if ( $_SESSION['initentry'] == $Scontxttoll)
  {
  	//in-context... presuming me

  } else { header("Location: login.php"); }	
  
?>

<!DOCTYPE html>
<html>
<head>
<title>PAGE TEMPLATE</title>
<meta HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-8859-1\">
</head>

<body>
<?php echo $_SESSION['bugout']; ?>
<p>PAGE TEMPLATE</p>
<body>
<html>

