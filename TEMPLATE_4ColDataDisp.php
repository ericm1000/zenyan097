<?php
/* 
This is template zenyan - 4 Column Data Display Pattern.
// Initial Writing: eric matthews
// Date: sep 9, 2010
// License: Dual licensed under the MIT and GPL license
*/
 session_start();
 

 require('eConfig/envref.php');
 include($php_cLib);
 include($php_envvars);
 include($php_dbms);  //dbms specific to app
 include($php_applib);
 include($php_daclib);
 include($php_loggers);  
 
 $myDbgateway = new dbgateway;

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
  $_SESSION['prog'] = 'TEMPLATE_4ColDataDisp.php'; //me

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

   //Execute Query
 if ($query != "") {
   $rs = $myDbgateway->readSQL($query,"hash");
   // mapping query to display  
   //  $cxHash['1a'] = $rs['colnamegoeshere'];
   //  $cxHash['1b'] = $rs['colnamegoeshere'];
 }  

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
//col c
    $lblHash['1c']  = 'Label 1c:&nbsp;';            $cxHash['1c'];
    $lblHash['2c']  = 'Label 2c:&nbsp;';            $cxHash['2c'];
    $lblHash['3c']  = 'Label 3c:&nbsp;';            $cxHash['3c'];
    $lblHash['4c']  = 'Label 4c:&nbsp;';            $cxHash['4c'];
    $lblHash['5c']  = 'Label 5c:&nbsp;';            $cxHash['5c'];
    $lblHash['6c']  = 'Label 6c:&nbsp;';            $cxHash['6c'];
    $lblHash['7c']  = 'Label 7c:&nbsp;';            $cxHash['7c'];
    $lblHash['8c']  = 'Label 8c:&nbsp;';            $cxHash['8c'];
    $lblHash['9c']  = 'Label 9c:&nbsp;';            $cxHash['9c'];
    $lblHash['10c'] = 'Label 10c:&nbsp;';          $cxHash['10c'];
    $lblHash['11c'] = 'Label 11c:&nbsp;';          $cxHash['11c'];
    $lblHash['12c'] = 'Label 12c:&nbsp;';          $cxHash['12c'];
    $lblHash['13c'] = 'Label 13c:&nbsp;';          $cxHash['13c'];
    $lblHash['14c'] = 'Label 14c:&nbsp;';          $cxHash['14c'];
    $lblHash['15c'] = 'Label 15c:&nbsp;';          $cxHash['15c'];
    $lblHash['16c'] = 'Label 16c:&nbsp;';         $cxHash['16c'];
    $lblHash['17c'] = 'Label 17c:&nbsp;';         $cxHash['17c'];
    $lblHash['18c'] = 'Label 18c:&nbsp;';         $cxHash['18c'];
    $lblHash['19c'] = 'Label 19c:&nbsp;';         $cxHash['19c'];  
    $lblHash['20c'] = 'Label 20c:&nbsp;';         $cxHash['20c'];
    $lblHash['21c'] = 'Label 21c:&nbsp;';         $cxHash['21c'];
    $lblHash['22c'] = 'Label 22c:&nbsp;';         $cxHash['22c'];
    $lblHash['23c'] = 'Label 23c:&nbsp;';         $cxHash['23c'];
    $lblHash['24c'] = 'Label 24c:&nbsp;';         $cxHash['24c'];
    $lblHash['25c'] = 'Label 25c:&nbsp;';         $cxHash['25c'];                                    
    $lblHash['26c'] = 'Label 26c:&nbsp;';         $cxHash['26c'];
    $lblHash['27c'] = 'Label 27c:&nbsp;';         $cxHash['27c'];
    $lblHash['28c'] = 'Label 28c:&nbsp;';         $cxHash['28c'];
    $lblHash['29c'] = 'Label 29c:&nbsp;';         $cxHash['29c']; 
    $lblHash['30c'] = 'Label 30c:&nbsp;';         $cxHash['30c'];
    $lblHash['31c'] = 'Label 31c:&nbsp;';         $cxHash['31c'];
    $lblHash['32c'] = 'Label 32c:&nbsp;';         $cxHash['32c'];
    $lblHash['33c'] = 'Label 33c:&nbsp;';         $cxHash['33c'];
    $lblHash['34c'] = 'Label 34c:&nbsp;';         $cxHash['34c'];
    $lblHash['35c'] = 'Label 35c:&nbsp;';         $cxHash['35c'];
    $lblHash['36c'] = 'Label 36c:&nbsp;';         $cxHash['36c'];
    $lblHash['37c'] = 'Label 37c:&nbsp;';         $cxHash['37c'];
    $lblHash['38c'] = 'Label 38c:&nbsp;';         $cxHash['38c'];
    $lblHash['39c'] = 'Label 39c:&nbsp;';         $cxHash['39c'];
    $lblHash['40c'] = 'Label 40c:&nbsp;';         $cxHash['40c'];
    $lblHash['41c'] = 'Label 41c:&nbsp;';         $cxHash['41c'];
    $lblHash['42c'] = 'Label 42c:&nbsp;';         $cxHash['42c'];
    $lblHash['43c'] = 'Label 43c:&nbsp;';         $cxHash['43c'];
    $lblHash['44c'] = 'Label 44c:&nbsp;';         $cxHash['44c'];
    $lblHash['45c'] = 'Label 45c:&nbsp;';         $cxHash['45c'];
//col d
    $lblHash['1d']  = 'Label 1d:&nbsp;';            $cxHash['1d'];
    $lblHash['2d']  = 'Label 2d:&nbsp;';            $cxHash['2d'];
    $lblHash['3d']  = 'Label 3d:&nbsp;';            $cxHash['3d'];
    $lblHash['4d']  = 'Label 4d:&nbsp;';            $cxHash['4d'];
    $lblHash['5d']  = 'Label 5d:&nbsp;';            $cxHash['5d'];
    $lblHash['6d']  = 'Label 6d:&nbsp;';            $cxHash['6d'];
    $lblHash['7d']  = 'Label 7d:&nbsp;';            $cxHash['7d'];
    $lblHash['8d']  = 'Label 8d:&nbsp;';            $cxHash['8d'];
    $lblHash['9d']  = 'Label 9d:&nbsp;';            $cxHash['9d'];
    $lblHash['10d'] = 'Label 10d:&nbsp;';          $cxHash['10d'];
    $lblHash['11d'] = 'Label 11d:&nbsp;';          $cxHash['11d'];
    $lblHash['12d'] = 'Label 12d:&nbsp;';          $cxHash['12d'];
    $lblHash['13d'] = 'Label 13d:&nbsp;';          $cxHash['13d'];
    $lblHash['14d'] = 'Label 14d:&nbsp;';          $cxHash['14d'];
    $lblHash['15d'] = 'Label 15d:&nbsp;';          $cxHash['15d'];
    $lblHash['16d'] = 'Label 16d:&nbsp;';         $cxHash['16d'];
    $lblHash['17d'] = 'Label 17d:&nbsp;';         $cxHash['17d'];
    $lblHash['18d'] = 'Label 18d:&nbsp;';         $cxHash['18d'];
    $lblHash['19d'] = 'Label 19d:&nbsp;';         $cxHash['19d'];  
    $lblHash['20d'] = 'Label 20d:&nbsp;';         $cxHash['20d'];
    $lblHash['21d'] = 'Label 21d:&nbsp;';         $cxHash['21d'];
    $lblHash['22d'] = 'Label 22d:&nbsp;';         $cxHash['22d'];
    $lblHash['23d'] = 'Label 23d:&nbsp;';         $cxHash['23d'];
    $lblHash['24d'] = 'Label 24d:&nbsp;';         $cxHash['24d'];
    $lblHash['25d'] = 'Label 25d:&nbsp;';         $cxHash['25d'];                                    
    $lblHash['26d'] = 'Label 26d:&nbsp;';         $cxHash['26d'];
    $lblHash['27d'] = 'Label 27d:&nbsp;';         $cxHash['27d'];
    $lblHash['28d'] = 'Label 28d:&nbsp;';         $cxHash['28d'];
    $lblHash['29d'] = 'Label 29d:&nbsp;';         $cxHash['29d']; 
    $lblHash['30d'] = 'Label 30d:&nbsp;';         $cxHash['30d'];
    $lblHash['31d'] = 'Label 31d:&nbsp;';         $cxHash['31d'];
    $lblHash['32d'] = 'Label 32d:&nbsp;';         $cxHash['32d'];
    $lblHash['33d'] = 'Label 33d:&nbsp;';         $cxHash['33d'];
    $lblHash['34d'] = 'Label 34d:&nbsp;';         $cxHash['34d'];
    $lblHash['35d'] = 'Label 35d:&nbsp;';         $cxHash['35d'];
    $lblHash['36d'] = 'Label 36d:&nbsp;';         $cxHash['36d'];
    $lblHash['37d'] = 'Label 37d:&nbsp;';         $cxHash['37d'];
    $lblHash['38d'] = 'Label 38d:&nbsp;';         $cxHash['38d'];
    $lblHash['39d'] = 'Label 39d:&nbsp;';         $cxHash['39d'];
    $lblHash['40d'] = 'Label 40d:&nbsp;';         $cxHash['40d'];
    $lblHash['41d'] = 'Label 41d:&nbsp;';         $cxHash['41d'];
    $lblHash['42d'] = 'Label 42d:&nbsp;';         $cxHash['42d'];
    $lblHash['43d'] = 'Label 43d:&nbsp;';         $cxHash['43d'];
    $lblHash['44d'] = 'Label 44d:&nbsp;';         $cxHash['44d'];
    $lblHash['45d'] = 'Label 45d:&nbsp;';         $cxHash['45d'];
//---------------------------------------------------------

  return $status; 

} //end function

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>4-Col Data Display Template</title>
	
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
	width:283px;
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
<h1>4-Col Data Display Template</h1>
<h2>Review</h2>
<table width="1040" border="0" cellspacing="2" cellpadding="3">
  <tr>
    <td class="tblcollbl" width="100"><?php echo $lblHash['1a']; ?></td>
    <td class="tblcoldta" width="150"><?php echo $cxHash['1a']; ?></td>
    <td class="tblcoldiv" width="10">&nbsp;</td>
    <td class="tblcollbl" width="100"><?php echo $lblHash['1b']; ?></td>
    <td class="tblcoldta" width="150"><?php echo $cxHash['1b']; ?></td>
    <td class="tblcoldiv" width="10">&nbsp;</td>
    <td class="tblcollbl" width="100"><?php echo $lblHash['1c']; ?></td>
    <td class="tblcoldta" width="150"><?php echo $cxHash['1c']; ?></td>
    <td class="tblcoldiv" width="10">&nbsp;</td>
    <td class="tblcollbl" width="100"><?php echo $lblHash['1d']; ?></td>
    <td class="tblcoldta" width="150"><?php echo $cxHash['1d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['2a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['2a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['2b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['2b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['2c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['2c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['2d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['2d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['3a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['3a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['3b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['3b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['3c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['3c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['3d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['3d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['4a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['4a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['4b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['4b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['4c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['4c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['4d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['4d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['5a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['5a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['5b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['5b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['5c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['5c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['5d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['5d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['6a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['6a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['6b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['6b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['6c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['6c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['6d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['6d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['7a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['7a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['7b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['7b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['7c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['7c']; ?></td>
    <td class="tblcoldiv" width="10">&nbsp;</td>    
    <td class="tblcollbl"><?php echo $lblHash['7d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['7d']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['8a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['8a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['8b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['8b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['8c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['8c']; ?></td>
    <td class="tblcoldiv" width="10">&nbsp;</td>    
    <td class="tblcollbl"><?php echo $lblHash['8d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['8d']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['9a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['9a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['9b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['9b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['9c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['9c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['9d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['9d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['10a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['10a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['10b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['10b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['10c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['10c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['10d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['10d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['11a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['11a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['11b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['11b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['11c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['11c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['11d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['11d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['12a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['12a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['12b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['12b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['12c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['12c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['12d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['12dd']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['13a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['13a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['13b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['13b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['13c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['13c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['13d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['13d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['14a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['14a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['14b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['14b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['14c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['14c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['14d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['14d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['15a']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['15a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['15b']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['15b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['15c']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['15c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['15d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['15d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['16a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['16a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['16b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['16b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['16c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['16c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['16d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['16dd']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['17a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['17a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['17b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['17b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['17c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['17c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['17d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['17d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['18a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['18a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['18b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['18b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['18c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['18c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['18d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['18dd']; ?></td>
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['19a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['19a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['19b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['19b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['19c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['19c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['19d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['19d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['20a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['20a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['20b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['20b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['20c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['20c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['20d']; ?></td>
    <td class="tblcoldta"><?php echo $cxHash['20d']; ?></td>
  </tr>   
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['21a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['21a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['21b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['21b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['21c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['21c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['21d']; ?></td> 
     <td class="tblcoldta"><?php echo $cxHash['21d']; ?></td> 
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['22a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['22a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['22b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['22b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['22c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['22c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['22d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['22d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['23a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['23a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['23b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['23b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['23c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['23c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['23d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['23d']; ?></td>
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['24a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['24a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['24b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['24b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['24c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['24c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['24d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['24d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['25a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['25a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['25b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['25b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['25c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['25c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['25d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['25d']; ?></td>
  </tr>  
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['26a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['26a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['26b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['26b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['26c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['26c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['26d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['26d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['27a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['27a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['27b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['27b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['27c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['27c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['27d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['27d']; ?></td> 
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['28a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['28a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['28b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['28b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['28c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['28c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['28d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['28d']; ?></td> 
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['29a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['29a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['29b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['29b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['29c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['29c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['29d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['29d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['30a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['30a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['30b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['30b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['30c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['30c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['30d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['30d']; ?></td>
  </tr>  
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['31a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['31a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['31b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['31b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['31c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['31c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['31d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['31d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['32a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['32a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['32b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['32b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['32c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['32c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['32d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['32d']; ?></td> 
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['33a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['33a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['33b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['33b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['33c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['33c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['33d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['33d']; ?></td> 
  </tr>
   <tr>
    <td class="tblcollbl"><?php echo $lblHash['34a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['34a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['34b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['34b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['34c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['34c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['34d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['34d']; ?></td>
  </tr>
  <tr>
    <td class="tblcollbl"><?php echo $lblHash['35a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['35a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['35b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['35b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['35c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['35c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['35d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['35d']; ?></td>
  </tr>      
<tr>
    <td class="tblcollbl"><?php echo $lblHash['36a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['36a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['36b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['36b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['36c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['36c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['36d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['36d']; ?></td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['37a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['37a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['37b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['37b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['37c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['37c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['37d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['37d']; ?></td> 
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['38a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['38a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['38b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['38b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['38c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['38c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['38d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['38d']; ?></td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['39a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['39a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['39b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['39b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['39c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['39c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['39d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['39d']; ?></td> 
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['40a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['40a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['40b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['40b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['40c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['40c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['40d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['40d']; ?></td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['41a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['41a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['41b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['41b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['41c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['41c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['41d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['41d']; ?></td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['42a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['42a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['42b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['42b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['42c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['42c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['42d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['42d']; ?></td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['43a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['43a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['43b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['43b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['43c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['43c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['43d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['43d']; ?></td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['44a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['44a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['44b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['44b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['44c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['44c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['44d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['44d']; ?></td>
  </tr>
    <tr>
    <td class="tblcollbl"><?php echo $lblHash['45a']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['45a']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['45b']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['45b']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['45c']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['45c']; ?></td>
    <td class="tblcoldiv">&nbsp;</td>
    <td class="tblcollbl"><?php echo $lblHash['45d']; ?></td>
     <td class="tblcoldta"><?php echo $cxHash['45d']; ?></td>
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
