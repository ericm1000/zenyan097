<?php
/* 
This is template for zenyan - 2 Column Data Display Pattern.
// Initial Writing: eric matthews
// Date: sep 9, 2010
// License:  Dual licensed under the MIT and GPL license
*/
   session_start();
   
//  
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
  
  //may need to relocate me based on final coding
    $_SESSION['prog'] = ''; //trust no one
    $_SESSION['prog'] = 'TEMPLATE_2ColDataDisp.php'; //me
  
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
  global $cxHash;   //data
  global $lblHash;  //labels
  
  global $locdebugstatus;
  global $locdebug;
  global $myDbgateway;

//---QUERY-------------------------------------------------
  $query = "";
//---------------------------------------------------------

$_SESSION['oldebug'] .= $query . "<br />";

  //Execute Query
  if ($query != "") {
    $rs = $myDbgateway->readSQL($query,"hash");
    // $cxHash['1a'] = $rs['colnamegoeshere'];
  } 


$_SESSION['oldebug'] .= $rs . "<br />";

//---RS to UI Mapping--------------------------------------
    $lblHash['1a']  = 'Label 1a:&nbsp;';           $cxHash['1a'];
    $lblHash['2a']  = 'Label 2a:&nbsp;';           $cxHash['2a'];
    $lblHash['3a']  = 'Label 3a:&nbsp;';           $cxHash['3a'];
    $lblHash['4a']  = 'Label 4a:&nbsp;';           $cxHash['4a'];
    $lblHash['5a']  = 'Label 5a:&nbsp;';           $cxHash['5a'];
    $lblHash['6a']  = 'Label 6a:&nbsp;';           $cxHash['6a'];
    $lblHash['7a']  = 'Label 7a:&nbsp;';           $cxHash['7a'];
    $lblHash['8a']  = 'Label 8a:&nbsp;';           $cxHash['8a'];
    $lblHash['9a']  = 'Label 9a:&nbsp;';           $cxHash['9a'];
    $lblHash['10a'] = 'Label 10a:&nbsp;';         $cxHash['10a'];
    $lblHash['11a'] = 'Label 11a:&nbsp;';         $cxHash['11a'];
    $lblHash['12a'] = 'Label 12a:&nbsp;';         $cxHash['12a'];
    $lblHash['13a'] = 'Label 13a:&nbsp;';         $cxHash['13a'];
    $lblHash['14a'] = 'Label 14a:&nbsp;';         $cxHash['14a'];
    $lblHash['15a'] = 'Label 15a:&nbsp;';         $cxHash['15a'];                                    
    $lblHash['16a'] = 'Label 16a:&nbsp;';         $cxHash['16a'];
    $lblHash['17a'] = 'Label 17a:&nbsp;';         $cxHash['17a'];
    $lblHash['18a'] = 'Label 18a:&nbsp;';         $cxHash['18a'];
    $lblHash['19a'] = 'Label 19a:&nbsp;';         $cxHash['19a'];  
    $lblHash['20a'] = 'Label 20a:&nbsp;';         $cxHash['20a'];
    $lblHash['21a'] = 'Label 21a:&nbsp;';         $cxHash['21a'];
    $lblHash['22a'] = 'Label 22a:&nbsp;';         $cxHash['22a'];
    $lblHash['23a'] = 'Label 23a:&nbsp;';         $cxHash['23a'];
    $lblHash['24a'] = 'Label 24a:&nbsp;';         $cxHash['24a'];
    $lblHash['25a'] = 'Label 25a:&nbsp;';         $cxHash['25a'];                                    
    $lblHash['26a'] = 'Label 26a:&nbsp;';         $cxHash['26a'];
    $lblHash['27a'] = 'Label 27a:&nbsp;';         $cxHash['27a'];
    $lblHash['28a'] = 'Label 28a:&nbsp;';         $cxHash['28a'];
    $lblHash['29a'] = 'Label 29a:&nbsp;';         $cxHash['29a']; 
    $lblHash['30a'] = 'Label 30a:&nbsp;';         $cxHash['30a'];
    $lblHash['31a'] = 'Label 31a:&nbsp;';         $cxHash['31a'];
    $lblHash['32a'] = 'Label 32a:&nbsp;';         $cxHash['32a'];
    $lblHash['33a'] = 'Label 33a:&nbsp;';         $cxHash['33a'];
    $lblHash['34a'] = 'Label 34a:&nbsp;';         $cxHash['34a'];
    $lblHash['35a'] = 'Label 35a:&nbsp;';         $cxHash['35a'];
    $lblHash['36a'] = 'Label 36a:&nbsp;';         $cxHash['36a'];
    $lblHash['37a'] = 'Label 37a:&nbsp;';         $cxHash['37a'];
    $lblHash['38a'] = 'Label 38a:&nbsp;';         $cxHash['38a'];
    $lblHash['39a'] = 'Label 39a:&nbsp;';         $cxHash['39a'];
    $lblHash['40a'] = 'Label 40a:&nbsp;';         $cxHash['40a'];
    $lblHash['41a'] = 'Label 41a:&nbsp;';         $cxHash['41a'];
    $lblHash['42a'] = 'Label 42a:&nbsp;';         $cxHash['42a'];
    $lblHash['43a'] = 'Label 43a:&nbsp;';         $cxHash['43a'];
    $lblHash['44a'] = 'Label 44a:&nbsp;';         $cxHash['44a'];
    $lblHash['45a'] = 'Label 45a:&nbsp;';         $cxHash['45a'];
//col b
    $lblHash['1b']  = 'Label 1b:&nbsp;';           $cxHash['1b'];
    $lblHash['2b']  = 'Label 2b:&nbsp;';           $cxHash['2b'];
    $lblHash['3b']  = 'Label 3b:&nbsp;';           $cxHash['3b'];
    $lblHash['4b']  = 'Label 4b:&nbsp;';           $cxHash['4b'];    
    $lblHash['5b']  = 'Label 5b:&nbsp;';           $cxHash['5b'];
    $lblHash['6b']  = 'Label 6b:&nbsp;';           $cxHash['6b'];    
    $lblHash['7b']  = 'Label 7b:&nbsp;';           $cxHash['7b'];
    $lblHash['8b']  = 'Label 8b:&nbsp;';           $cxHash['8b'];    
    $lblHash['9b']  = 'Label 9b:&nbsp;';           $cxHash['9b'];
    $lblHash['10b'] = 'Label 10b:&nbsp;';         $cxHash['10b'];        
    $lblHash['11b'] = 'Label 11b:&nbsp;';         $cxHash['11b'];
    $lblHash['12b'] = 'Label 12b:&nbsp;';         $cxHash['12b'];    
    $lblHash['13b'] = 'Label 13b:&nbsp;';         $cxHash['13b'];    
    $lblHash['14b'] = 'Label 14b:&nbsp;';         $cxHash['14b'];    
    $lblHash['15b'] = 'Label 15b:&nbsp;';         $cxHash['15b'];       
    $lblHash['16b'] = 'Label 16b:&nbsp;';         $cxHash['16b'];
    $lblHash['17b'] = 'Label 17b:&nbsp;';         $cxHash['17b'];
    $lblHash['18b'] = 'Label 18b:&nbsp;';         $cxHash['18b'];
    $lblHash['19b'] = 'Label 19b:&nbsp;';         $cxHash['19b'];  
    $lblHash['20b'] = 'Label 20b:&nbsp;';         $cxHash['20b'];
    $lblHash['21b'] = 'Label 21b:&nbsp;';         $cxHash['21b'];
    $lblHash['22b'] = 'Label 22b:&nbsp;';         $cxHash['22b'];
    $lblHash['23b'] = 'Label 23b:&nbsp;';         $cxHash['23b'];
    $lblHash['24b'] = 'Label 24b:&nbsp;';         $cxHash['24b'];
    $lblHash['25b'] = 'Label 25b:&nbsp;';         $cxHash['25b'];                                    
    $lblHash['26b'] = 'Label 26b:&nbsp;';         $cxHash['26b'];
    $lblHash['27b'] = 'Label 27b:&nbsp;';         $cxHash['27b'];
    $lblHash['28b'] = 'Label 28b:&nbsp;';         $cxHash['28b'];
    $lblHash['29b'] = 'Label 29b:&nbsp;';         $cxHash['29b']; 
    $lblHash['30b'] = 'Label 30b:&nbsp;';         $cxHash['30b'];
    $lblHash['31b'] = 'Label 31b:&nbsp;';         $cxHash['31b'];
    $lblHash['32b'] = 'Label 32b:&nbsp;';         $cxHash['32b'];
    $lblHash['33b'] = 'Label 33b:&nbsp;';         $cxHash['33b'];
    $lblHash['34b'] = 'Label 34b:&nbsp;';         $cxHash['34b'];
    $lblHash['35b'] = 'Label 35b:&nbsp;';         $cxHash['35b'];
    $lblHash['36b'] = 'Label 36b:&nbsp;';         $cxHash['36b'];
    $lblHash['37b'] = 'Label 37b:&nbsp;';         $cxHash['37b'];
    $lblHash['38b'] = 'Label 38b:&nbsp;';         $cxHash['38b'];
    $lblHash['39b'] = 'Label 39b:&nbsp;';         $cxHash['39b'];
    $lblHash['40b'] = 'Label 40b:&nbsp;';         $cxHash['40b'];
    $lblHash['41b'] = 'Label 41b:&nbsp;';         $cxHash['41b'];
    $lblHash['42b'] = 'Label 42b:&nbsp;';         $cxHash['42b'];
    $lblHash['43b'] = 'Label 43b:&nbsp;';         $cxHash['43b'];
    $lblHash['44b'] = 'Label 44b:&nbsp;';         $cxHash['44b'];
    $lblHash['45b'] = 'Label 45b:&nbsp;';         $cxHash['45b'];

//---------------------------------------------------------

  return $status; 

} //end function

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>2 Column Data Display Template</title>
	
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
	width:978px;
	height:1062px;
	z-index:1;
	left: 15px;
	top: 17px;
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
<h1>2-Col Data Display Template</h1>
<h2>Review</h2>

<table width="740" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td class="tblcollbl" width="130"><?php echo $lblHash['1a']; ?></td>
    <td class="tblcoldta" width="230"><?php echo $cxHash['1a']; ?></td>
    <td class="tblcoldiv" width="10">&nbsp;</td>
    <td class="tblcollbl" width="130"><?php echo $lblHash['1b']; ?></td>
    <td class="tblcoldta" width="230"><?php echo $cxHash['1b']; ?></td>
    <td class="tblcoldiv" width="10">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['2a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['2a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['2b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['2b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['3a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['3a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['3b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['3b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['4a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['4a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['4b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['4b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['5a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['5a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['5b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['5b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['6a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['6a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['6b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['6b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['7a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['7a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['7b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['7b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['8a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['8a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['8b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['8b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['9a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['9a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['9b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['9b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['10a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['10a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['10b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['10b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['11a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['11a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['11b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['11b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['12a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['12a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['12b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['12b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['13a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['13a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['13b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['13b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['14a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['14a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['14b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['14b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['15a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['15a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['15b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['15b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['16a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['16a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['16b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['16b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['17a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['17a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['17b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['17b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['18a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['18a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['18b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['18b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['19a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['19a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['19b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['19b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['20a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['20a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['20b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['20b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>   
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['21a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['21a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['21b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['21b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['22a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['22a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['22b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['22b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['23a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['23a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['23b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['23b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['24a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['24a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['24b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['24b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['25a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['25a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['25b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['25b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>  
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['26a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['26a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['26b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['26b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['27a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['27a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['27b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['27b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['28a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['28a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['28b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['28b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['29a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['29a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['29b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['29b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['30a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['30a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['30b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['30b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>  
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['31a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['31a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['31b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['31b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['32a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['32a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['32b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['32b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['33a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['33a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['33b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['33b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['34a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['34a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['34b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['34b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['35a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['35a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['35b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['35b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>      
<tr>
    <td class="tblcollbl"><?php echo $lblHash['36a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['36a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['36b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['36b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['37a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['37a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['37b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['37b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['38a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['38a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['38b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['38b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['39a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['39a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['39b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['39b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['40a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['40a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['40b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['40b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['41a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['41a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['41b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['41b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['42a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['42a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['42b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['42b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['43a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['43a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['43b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['43b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['44a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['44a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['44b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['44b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['45a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['45a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['45b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['45b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>    
</table>
<p>&nbsp;</p>
<p>
  <!-- comment out or remove me for production -->
  <?php echo $_SESSION['oldebug']; ?>
</p>

</div>

</body>

</html>
