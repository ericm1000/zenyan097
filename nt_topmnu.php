<?php
// Top Menu for navTango
// Initial Writing: ericm
// Date: 11/10/2011
// License: Dual licensed under the MIT and GPL license
/*
Top Menu for navTango
*/
// History/Customizations:
/*
                        
*/
   session_start();
   

   require('eConfig/envref.php');
   include($php_cLib);
   include($php_envvars);   
   include($php_dbms);  
   include($php_applib);
   include($php_daclib);
   
   $topmnuhsh = '';
   $msg = "";
   $submnu_div_blob;
   $maintoc_div_blob;
   
   $ico1;
   $ico2;
   $ico3;
   $ico4;
   $ico5;
   $ico6;
   $ico7;
   $ico8;   

   if ($_SESSION['initentry'] != $Scontxttoll) { 
     $_SESSION['loginerr'] = 'Login required to access page';
     header("Location: login.php");  
     exit; 
   }
   
  $myDbgateway = new dbgateway;
  getTopmnuData(); 


//----------------------------------------------------------------------------//                     
function getTopmnuData()
//----------------------------------------------------------------------------//
{	
  global $tmnu;
  global $msg;
  global $topmnuhsh;
  global $http; 
  global $submnu_div_blob;
  global $maintoc_div_blob;
  global $ico1;
  global $ico2;
  global $ico3;
  global $ico4;
  global $ico5;
  global $ico6;
  global $ico7;
  global $ico8;            
  global $myDbgateway;

  $query = 'SELECT member_uid,mnu_itm1,public_flg1,archive_flg1,mnu_itm2,public_flg2,archive_flg2,mnu_itm3,public_flg3,archive_flg3,mnu_itm4,public_flg4,archive_flg4,mnu_itm5,public_flg5,archive_flg5,mnu_itm6,public_flg6,archive_flg6,mnu_itm7,public_flg7,archive_flg7,mnu_itm8,public_flg8,archive_flg8,ico1url,ico1img,ico2url,ico2img,ico3url,ico3img,ico4url,ico4img,ico1wndflg,ico2wndflg,ico3wndflg,ico4wndflg,ico5url,ico5img,ico6url,ico6img,ico7url,ico7img,ico8url,ico8img,ico5wndflg,ico6wndflg,ico7wndflg,ico8wndflg,link_flg1,link_flg2,link_flg3,link_flg4,link_flg5,link_flg6,link_flg7,link_flg8,lib_flg1,lib_flg2,lib_flg3,lib_flg4,lib_flg5,lib_flg6,lib_flg7,lib_flg8 FROM lnks_itm 
  where member_uid = ' .  $_SESSION['USRSYSKEY'];  

  $result = $myDbgateway->readSQL($query,"hash");

  $topmnuhsh;
  
    // Deal with the 8 user customizable top icons 
    if ($result['ico1url'] != '') {
    	$topmnuhsh['ico1url'] = $result['ico1url'];
    	$topmnuhsh['ico1img'] = $result['ico1img'];
      $ico1 = buildIcons($topmnuhsh['ico1url'],$topmnuhsh['ico1img'],$result['ico1wndflg']);
      //$ico1 = buildIcons("http://www.facebook.com","icons/facebook.jpg","y");
    }   
    if ($result['ico2url'] != '') {
    	$topmnuhsh['ico2url'] = $result['ico2url'];
    	$topmnuhsh['ico2img'] = $result['ico2img'];
      $ico2 = buildIcons($topmnuhsh['ico2url'],$topmnuhsh['ico2img'],$result['ico2wndflg']);
    }  
    if ($result['ico3url'] != '') {
    	$topmnuhsh['ico3url'] = $result['ico3url'];
    	$topmnuhsh['ico3img'] = $result['ico3img'];
      $ico3 = buildIcons($topmnuhsh['ico3url'],$topmnuhsh['ico3img'],$result['ico3wndflg']);
    }  
    if ($result['ico4url'] != '') {
    	$topmnuhsh['ico4url'] = $result['ico4url'];
    	$topmnuhsh['ico4img'] = $result['ico4img'];
      $ico4 = buildIcons($topmnuhsh['ico4url'],$topmnuhsh['ico4img'],$result['ico4wndflg']);
    }      
    if ($result['ico5url'] != '') {
    	$topmnuhsh['ico5url'] = $result['ico5url'];
    	$topmnuhsh['ico5img'] = $result['ico5img'];
      $ico5 = buildIcons($topmnuhsh['ico5url'],$topmnuhsh['ico5img'],$result['ico5wndflg']);
    }  
    if ($result['ico6url'] != '') {
    	$topmnuhsh['ico6url'] = $result['ico6url'];
    	$topmnuhsh['ico6img'] = $result['ico6img'];
      $ico6 = buildIcons($topmnuhsh['ico6url'],$topmnuhsh['ico6img'],$result['ico6wndflg']);
    }      
    if ($result['ico7url'] != '') {
    	$topmnuhsh['ico7url'] = $result['ico7url'];
    	$topmnuhsh['ico7img'] = $result['ico7img'];
      $ico7 = buildIcons($topmnuhsh['ico7url'],$topmnuhsh['ico7img'],$result['ico7wndflg']);
    }      
     if ($result['ico8url'] != '') {
    	$topmnuhsh['ico8url'] = $result['ico8url'];
    	$topmnuhsh['ico8img'] = $result['ico8img'];
      $ico8 = buildIcons($topmnuhsh['ico8url'],$topmnuhsh['ico8img'],$result['ico8wndflg']);
    }                     


    // Deal with the top mnu
    if ($result['mnu_itm1'] != '') {
       $tmpstr = buildSubmenuStub("1",$result['mnu_itm1']);
       $mnuarr[0] = $result['mnu_itm1'];
       $submnu_div_blob .= $tmpstr; 
       $tmpstr2 = buildTopmenuStub("1",$result['mnu_itm1']);
       $maintoc_div_blob .=  $tmpstr2;  
    }	
    if ($result['mnu_itm2'] != '') {
       $tmpstr = buildSubmenuStub("2",$result['mnu_itm2']);
       $mnuarr[1] = $result['mnu_itm2'];
       $submnu_div_blob .= $tmpstr;      
       $tmpstr2 = buildTopmenuStub("2",$result['mnu_itm2']);
       $maintoc_div_blob .=  $tmpstr2;  
    }
    if ($result['mnu_itm3'] != '') {
       $tmpstr = buildSubmenuStub("3",$result['mnu_itm3']);
       $mnuarr[2] = $result['mnu_itm3'];
       $submnu_div_blob .= $tmpstr;      
       $tmpstr2 = buildTopmenuStub("3",$result['mnu_itm3']);
       $maintoc_div_blob .=  $tmpstr2;  
    }
    if ($result['mnu_itm4'] != '') {
       $tmpstr = buildSubmenuStub("4",$result['mnu_itm4']);
       $mnuarr[3] = $result['mnu_itm4'];
       $submnu_div_blob .= $tmpstr;      
       $tmpstr2 = buildTopmenuStub("4",$result['mnu_itm4']);
       $maintoc_div_blob .=  $tmpstr2;  
    }    
    if ($result['mnu_itm5'] != '') {
       $tmpstr = buildSubmenuStub("5",$result['mnu_itm5']);
       $mnuarr[4] = $result['mnu_itm5'];
       $submnu_div_blob .= $tmpstr;      
       $tmpstr2 = buildTopmenuStub("5",$result['mnu_itm5']);
       $maintoc_div_blob .=  $tmpstr2;  
    }  
    if ($result['mnu_itm6'] != '') {
       $tmpstr = buildSubmenuStub("6",$result['mnu_itm6']);
       $mnuarr[5] = $result['mnu_itm6'];
       $submnu_div_blob .= $tmpstr;      
       $tmpstr2 = buildTopmenuStub("6",$result['mnu_itm6']);
       $maintoc_div_blob .=  $tmpstr2;  
    }  
     if ($result['mnu_itm7'] != '') {
       $tmpstr = buildSubmenuStub("7",$result['mnu_itm7']);
       $mnuarr[6] = $result['mnu_itm7'];
       $submnu_div_blob .= $tmpstr;      
       $tmpstr2 = buildTopmenuStub("7",$result['mnu_itm7']);
       $maintoc_div_blob .=  $tmpstr2;  
    }  
    if ($result['mnu_itm8'] != '') {
       $tmpstr = buildSubmenuStub("8",$result['mnu_itm8']);
       $mnuarr[7] = $result['mnu_itm8'];
       $submnu_div_blob .= $tmpstr;      
       $tmpstr2 = buildTopmenuStub("8",$result['mnu_itm8']);
       $maintoc_div_blob .=  $tmpstr2;  
    }             

   $_SESSION['mnuarr'] = $mnuarr; //for use by add link function in adm_manage_links.php 	  	   	
}	//end function

//----------------------------------------------------------------------------//                     
function buildIcons($icourl,$icoimg,$iconewwnd)
//----------------------------------------------------------------------------//
{
	$finalstub = "";
  $finalstub .= '<a href="';
  $finalstub .= $icourl . '"';
  if ($iconewwnd == "y") {
    $finalstub .= ' target="_BLANK" >';
  } else { $finalstub .= ' target="main"  onClick=getURL(this);>'; }
  $finalstub .=  '<img src="';
  $finalstub .=  $icoimg;
  $finalstub .= '" width="32" height="32" border="0" />'; 

  return $finalstub;
}

//----------------------------------------------------------------------------//                     
function buildTopmenuStub($mnunum,$mnuitmname)
//----------------------------------------------------------------------------//
{
  $topmenustub = '<li rel="~~mnuitmnum~~"><a href="#" >~~mnuitmname~~</a></li>';
  $topmenustub = preg_replace("/~~mnuitmnum~~/",$mnunum,$topmenustub);
  $topmenustub = preg_replace("/~~mnuitmname~~/",$mnuitmname,$topmenustub); 
  $topmenustub = $topmenustub . "\n";	
	return $topmenustub;
}	

//----------------------------------------------------------------------------//                     
function buildSubmenuStub($mnunum,$mnuitmname)
//----------------------------------------------------------------------------//
{
  $stub = "";
	$opendivtag = '<div id="~~mnuitmnum~~" class="submenustyle">';
  $liburl = '<a href="eDMS/lib_~~mnuitmname~~.html"  id="mnusi';
  $liburl .= $mnunum;
  $liburl .= '"  target="toc">Library</a>';
  $linkurl = '<a href="lnktoc.php?v=~~mnuitmname~~" target="toc">Links</a>';
  $enddivtag = '</div>';
    	
  $opendivtag = preg_replace("/~~mnuitmnum~~/",$mnunum,$opendivtag);
  $stub .= $opendivtag . "\n";

  $tmpmnuitmname = $mnuitmname;
  $tmpmnuitmname = preg_replace('/\s+/','_',$tmpmnuitmname);
  $liburl = preg_replace("/~~mnuitmname~~/",$tmpmnuitmname,$liburl);
  $stub .= $liburl . "\n"; 

  $linkurl = preg_replace("/~~mnuitmname~~/",$mnuitmname,$linkurl);
  $stub .= $linkurl . "\n";     
      
  $stub .=  $enddivtag . "\n";
  
  return $stub;
	
}	

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/navtango.css">
	<script type="text/javascript" src="scripts/navtango.js"></script>

<script type="text/javascript" language="JavaScript">
function toggleFrames(){
 if (parent.document.all("TopFrame").rows == "150px,*")
 {
   parent.document.all("TopFrame").rows="70px,*";
   parent.document.all("MiddleFrame").cols="0px,*";
   parent.cmd.document.getElementById('ftgl').innerHTML = '<img border="0" src="icons/tri-show.png" width="32" height="32" />';
 }
 else
 {
   parent.document.all("TopFrame").rows="150px,*";
   parent.document.all("MiddleFrame").cols="175px,*"; 
   parent.cmd.document.getElementById('ftgl').innerHTML = '<img border="0" src="icons/tri-hide.png" width="32" height="32" />';	
 }	  
}

function logOut() { 
//break out of frames and return to main login page
 if (top.location != location) {
    top.location.href = document.location.href="login.php" ;
 } 
}

function getURL(focurl) {
//tested works with firefox, ie, opera, safari, chrome
   //alert(focurl); 
   parent.cmd.document.getElementById('myurl').innerHTML = focurl; //working  
}


</script>


<style type="text/css">
<!--
#personality {
	position:absolute;
	width:193px;
	height:61px;
	z-index:5;
	left: 756px;
	top: -1px;
}

#mnusi1 { margin-left: 0px; }
#mnusi2 { margin-left: 120px; }
#mnusi3 { margin-left: 230px; }	
#mnusi4 { margin-left: 350px; }
#mnusi5 { margin-left: 460px; }
#mnusi6 { margin-left: 580px; }
#mnusi7 { margin-left: 695px; }
#mnusi8 { margin-left: 810px; }

-->
</style>
</head>
<body>

<div id="mnu_buttons" class="topmnustyle">
<ul  id="maintoc">
<?php echo $maintoc_div_blob; ?>
</ul>
</div>

<div id="urlbar">
	<p id="myurl"> <?php echo $msg; ?></p>
</div>

<div id="topico">
  <table width="490" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="35" valign="top"><a href="javascript:toggleFrames();" id="ftgl"><img border="0" src="icons/tri-hide.png" alt="Mode Toggle" width="32" height="32" /></a></td>  
      <td width="35" valign="top"><a href="navtango_home.php" target="main"><img src="icons/home.png" width="32" height="32" border="0"  onClick=getURL('navtango_home.php'); /></a></td>                          
      <td width="35" valign="top"><a href="lnkfavorites.php" target="toc"><img src="icons/user-home.png" width="32" height="32" border="0"  onClick=getURL('lnkfavorites.php'); /></a></td>
      <td width="35" valign="top"><a href="lnktoc.php?v=admin" target="toc"><img src="icons/admin.gif" width="32" height="32" border="0"  onClick=getURL('lnktoc.php?v=admin'); /></td>                          
      <td width="35" valign="top"><a href="logouttg.php" onclick="logOut();" id="loff"><img src="icons/logoff.png" width="32" height="32" border="0" /></td>
      <td width="35" valign="top"><?php echo $ico1; ?></td>
      <td width="35" valign="top"><?php echo $ico2; ?></td>
      <td width="35" valign="top"><?php echo $ico3; ?></td>
      <td width="35" valign="top"><?php echo $ico4; ?></td>
      <td width="35" valign="top"><?php echo $ico5; ?></td>
      <td width="35" valign="top"><?php echo $ico6; ?></td>
      <td width="35" valign="top"><?php echo $ico7; ?></td>
      <td width="35" valign="top"><?php echo $ico8; ?></td>
    </tr>
  </table>
</div>



<script type="text/javascript">
//initialize tab menu, by passing in ID of UL
initalizetab("maintoc")
</script>
<div id="submnudiv">
<?php echo $submnu_div_blob; ?>
</div>

<!--
<div id="personality">
  <form id="form1" name="form1" method="post" action="">
    <p>
      <select name="lstboxsngle" size="3">
           <option value="Development" selected="selected">Development</option>
           <option value="Personal">Personal</option>
      </select> 
      <input type="submit" name="Submit" value="Switch" />
    </p>
  </form>
</div>
-->
</body>
</html>
