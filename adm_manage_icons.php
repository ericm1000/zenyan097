<?php
// Manage Top Icons
// Initial Writing: ericm
// Date: 3/1/2012
// License: Dual licensed under the MIT and GPL license
/*
Manage Menus
*/
// History/Customizations:
/*
                        
*/
/*
Implementation Notes: The icons under the accordians are dynamically added.
These directories live under icons/dir_name. Any folder under this path 
will get indexed. There is no cap to the number of folders you can have. 
However, there is a practical limitation regarding the UI. You can have
about 10 folders with about 40 icons per folder and the UI is still
practical. You need to name the folder with the name you want to see
in each accordian title. You must use an underscore for multi-word names.
*/
session_start();  //required in order to get generated session key
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms); 
include($php_applib);
include($php_daclib);
include($php_filsysapi);
include($php_loggers);

$uimsg = '';
$traceflg = '';
$trace = '';

$defaulticon = 'icons/img_missing.png';
$icocheckedstub = 'checked="checked"';

$iconFoldersRoot = 'icons'; //this is a relative path from this program
$accordians = ""; //this holds our accordian stub code which we dynamically generated
$accordians = getLUIcons();

if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}

$myDbgateway = new dbgateway;

$ico1img=''; $ico1url = ''; $ico1flg = '';
$ico2img=''; $ico2url = ''; $ico2flg = '';
$ico3img=''; $ico3url = ''; $ico3flg = '';
$ico4img=''; $ico4url = ''; $ico4flg = '';
$ico5img=''; $ico5url = ''; $ico5flg = '';
$ico6img=''; $ico6url = ''; $ico6flg = '';
$ico7img=''; $ico7url = ''; $ico7flg = '';
$ico8img=''; $ico8url = ''; $ico8flg = '';


//if... is form posted from browser --------------------------------------------

if ($traceflg == 'y') {
	$uimsg .= 'tb_ico1= ' . $_REQUEST['tb_ico1'] . "<br />";
	$uimsg .= 'tbIco1url= ' . $_REQUEST['tbIco1url'] . "<br />";
	$uimsg .= 'cbIco1WndFlg= ' . $_REQUEST['cbIco1WndFlg'] . "<br />";

	$uimsg .= 'tb_ico2= ' . $_REQUEST['tb_ico2'] . "<br />";
	$uimsg .= 'tbIco2url= ' . $_REQUEST['tbIco2url'] . "<br />";
	$uimsg .= 'cbIco2WndFlg= ' . $_REQUEST['cbIco2WndFlg'] . "<br />";

	$uimsg .= 'tb_ico3= ' . $_REQUEST['tb_ico3'] . "<br />";
	$uimsg .= 'tbIco3url= ' . $_REQUEST['tbIco3url'] . "<br />";
	$uimsg .= 'cbIco3WndFlg= ' . $_REQUEST['cbIco3WndFlg'] . "<br />";
	
	$uimsg .= 'tb_ico4= ' . $_REQUEST['tb_ico4'] . "<br />";
	$uimsg .= 'tbIco4url= ' . $_REQUEST['tbIco4url'] . "<br />";
	$uimsg .= 'cbIco4WndFlg= ' . $_REQUEST['cbIco4WndFlg'] . "<br />";	
	
	$uimsg .= 'tb_ico5= ' . $_REQUEST['tb_ico5'] . "<br />";
	$uimsg .= 'tbIco5url= ' . $_REQUEST['tbIco5url'] . "<br />";
	$uimsg .= 'cbIco5WndFlg= ' . $_REQUEST['cbIco5WndFlg'] . "<br />";	
	
	$uimsg .= 'tb_ico6= ' . $_REQUEST['tb_ico6'] . "<br />";
	$uimsg .= 'tbIco6url= ' . $_REQUEST['tbIco6url'] . "<br />";
	$uimsg .= 'cbIco6WndFlg= ' . $_REQUEST['cbIco6WndFlg'] . "<br />";
	
	$uimsg .= 'tb_ico7= ' . $_REQUEST['tb_ico7'] . "<br />";
	$uimsg .= 'tbIco7url= ' . $_REQUEST['tbIco7url'] . "<br />";
	$uimsg .= 'cbIco7WndFlg= ' . $_REQUEST['cbIco7WndFlg'] . "<br />";	

	$uimsg .= 'tb_ico8= ' . $_REQUEST['tb_ico8'] . "<br />";
	$uimsg .= 'tbIco8url= ' . $_REQUEST['tbIco8url'] . "<br />";
	$uimsg .= 'cbIco8WndFlg= ' . $_REQUEST['cbIco8WndFlg'] . "<br />";	
}

if ($_REQUEST['UpdTopico'] == "Update Top Icons") {

 if (trim($_REQUEST['tbIco1url']) != "") {

    $ico1img =  trim($_REQUEST['tb_ico1']);
    if (trim($_REQUEST['tb_ico1']) != "") {
       if (trim($ico1img) != '') {
         $ico1imgstub = '<img id="vDC1" name="vDC1" class="ui-state-default" src="' . $ico1img . '" width="32" height="32" border="0" />';
       } else  { $ico1imgstub = ""; } 
    } else {
    	 $ico1img = $defaulticon;
    	 $ico1imgstub = '<img id="vDC1" name="vDC1" class="ui-state-default" src="' .  $ico1img . '" width="32" height="32" border="0" />';
    }	   

    $ico1url = $_REQUEST['tbIco1url'];
    if ($_REQUEST['cbIco1WndFlg'] == 'chk') { $ico1flgC = $icocheckedstub; $ico1flg = "y"; }	
    }  else {
  	$ico1imgstub = "";
  	$ico1url = "";
  	$ico1flg = "";
   }	

 if (trim($_REQUEST['tbIco2url']) != "") {
    $ico2img =  trim($_REQUEST['tb_ico2']);
    if (trim($_REQUEST['tb_ico2']) != "") {
       if (trim($ico2img) != '') {
         $ico2imgstub = '<img id="vDC2" name="vDC2" class="ui-state-default" src="' .  $ico2img . '" width="32" height="32" border="0" />';
       } else  { $ico2imgstub = ""; } 
    } else {
    	 $ico2img = $defaulticon;
    	 $ico2imgstub = '<img id="vDC2" name="vDC2" class="ui-state-default" src="' .  $ico2img . '" width="32" height="32" border="0" />';
    }	   
    $ico2url = $_REQUEST['tbIco2url'];
    if ($_REQUEST['cbIco2WndFlg'] == 'chk') { $ico2flgC = $icocheckedstub;  $ico2flg = "y"; }	
    }  else {
  	$ico2imgstub = "";
  	$ico2url = "";
  	$ico2flg = "";
   }

 if (trim($_REQUEST['tbIco3url']) != "") {
    $ico3img =  trim($_REQUEST['tb_ico3']);
    if (trim($_REQUEST['tb_ico3']) != "") {
       if (trim($ico3img) != '') {
         $ico3imgstub = '<img id="vDC3" name="vDC3" class="ui-state-default" src="' .  $ico3img . '" width="32" height="32" border="0" />';
       } else  { $ico3imgstub = ""; } 
    } else {
    	 $ico3img = $defaulticon;
    	 $ico3imgstub = '<img id="vDC3" name="vDC3" class="ui-state-default" src="' .  $ico3img . '" width="32" height="32" border="0" />';
    }	   
    $ico3url = $_REQUEST['tbIco3url'];
    if ($_REQUEST['cbIco3WndFlg'] == 'chk') { $ico3flgC = $icocheckedstub;  $ico3flg = "y"; }	
    }  else {
  	$ico3imgstub = "";
  	$ico3url = "";
  	$ico3flg = "";
   }
   
 if (trim($_REQUEST['tbIco4url']) != "") {
    $ico4img =  trim($_REQUEST['tb_ico4']);
    if (trim($_REQUEST['tb_ico4']) != "") {
       if (trim($ico4img) != '') {
         $ico4imgstub = '<img id="vDC4" name="vDC4" class="ui-state-default" src="' .  $ico4img . '" width="32" height="32" border="0" />';
       } else  { $ico4imgstub = ""; } 
    } else {
    	 $ico4img = $defaulticon;
    	 $ico4imgstub = '<img id="vDC4" name="vDC4" class="ui-state-default" src="' .  $ico4img . '" width="32" height="32" border="0" />';
    }	   
    $ico4url = $_REQUEST['tbIco4url'];
    if ($_REQUEST['cbIco4WndFlg'] == 'chk') { $ico4flgC = $icocheckedstub;  $ico4flg = "y"; }	
    }  else {
  	$ico4imgstub = "";
  	$ico4url = "";
  	$ico4flg = "";
   }
      
 if (trim($_REQUEST['tbIco5url']) != "") {
    $ico5img =  trim($_REQUEST['tb_ico5']);
    if (trim($_REQUEST['tb_ico5']) != "") {
       if (trim($ico5img) != '') {
         $ico5imgstub = '<img id="vDC5" name="vDC5" class="ui-state-default" src="' .  $ico5img . '" width="32" height="32" border="0" />';
       } else  { $ico5imgstub = ""; } 
    } else {
    	 $ico5img = $defaulticon;
    	 $ico5imgstub = '<img id="vDC5" name="vDC5" class="ui-state-default" src="' .  $ico5img . '" width="32" height="32" border="0" />';
    }	   
    $ico5url = $_REQUEST['tbIco5url'];
    if ($_REQUEST['cbIco5WndFlg'] == 'chk') { $ico5flgC = $icocheckedstub;  $ico5flg = "y"; }	
    }  else {
  	$ico5imgstub = "";
  	$ico5url = "";
  	$ico5flg = "";
   }

 if (trim($_REQUEST['tbIco6url']) != "") {
    $ico6img =  trim($_REQUEST['tb_ico6']);
    if (trim($_REQUEST['tb_ico6']) != "") {
       if (trim($ico6img) != '') {
         $ico6imgstub = '<img id="vDC6" name="vDC6" class="ui-state-default" src="' .  $ico6img . '" width="32" height="32" border="0" />';
       } else  { $ico6imgstub = ""; } 
    } else {
    	 $ico6img = $defaulticon;
    	 $ico6imgstub = '<img id="vDC6" name="vDC6" class="ui-state-default" src="' .  $ico6img . '" width="32" height="32" border="0" />';
    }	   
    $ico6url = $_REQUEST['tbIco6url'];
    if ($_REQUEST['cbIco6WndFlg'] == 'chk') { $ico6flgC = $icocheckedstub;  $ico6flg = "y";  }	
    }  else {
  	$ico6imgstub = "";
  	$ico6url = "";
  	$ico6flg = "";
   }
   
 if (trim($_REQUEST['tbIco7url']) != "") {
    $ico7img =  trim($_REQUEST['tb_ico7']);
    if (trim($_REQUEST['tb_ico7']) != "") {
       if (trim($ico7img) != '') {
         $ico7imgstub = '<img id="vDC7" name="vDC7" class="ui-state-default" src="' .  $ico7img . '" width="32" height="32" border="0" />';
       } else  { $ico7imgstub = ""; } 
    } else {
    	 $ico7img = $defaulticon;
    	 $ico7imgstub = '<img id="vDC7" name="vDC7" class="ui-state-default" src="' .  $ico7img . '" width="32" height="32" border="0" />';
    }	   
    $ico7url = $_REQUEST['tbIco7url'];
    if ($_REQUEST['cbIco7WndFlg'] == 'chk') { $ico7flgC = $icocheckedstub;  $ico7flg = "y"; }	
    }  else {
  	$ico7imgstub = "";
  	$ico7url = "";
  	$ico7flg = "";
   }
   
 if (trim($_REQUEST['tbIco8url']) != "") {
    $ico8img =  trim($_REQUEST['tb_ico8']);
    if (trim($_REQUEST['tb_ico8']) != "") {
       if (trim($ico8img) != '') {
         $ico8imgstub = '<img id="vDC8" name="vDC8" class="ui-state-default" src="' .  $ico8img . '" width="32" height="32" border="0" />';
       } else  { $ico8imgstub = ""; } 
    } else {
    	 $ico8img = $defaulticon;
    	 $ico8imgstub = '<img id="vDC8" name="vDC8" class="ui-state-default" src="' .  $ico8img . '" width="32" height="32" border="0" />';
    }	   
    $ico8url = $_REQUEST['tbIco8url'];
    if ($_REQUEST['cbIco8WndFlg'] == 'chk') { $ico8flgC = $icocheckedstub;  $ico8flg = "y"; }	
    }  else {
  	$ico8imgstub = "";
  	$ico8url = "";
  	$ico8flg = "";
   }         

  $retvs = updTopIcons();

} //end outer if

//else... is first time load ------------------------------------------------------

else { 

  getTopIcons();

  if (trim($ico1img) != '') {
    $ico1imgstub = '<img id="vDC1" class="ui-state-default" src="'  . $ico1img . '" width="32" height="32" border="0" />';
  } else  { $ico1imgstub = ""; } 
  if ($ico1flg == 'y') {	
    $ico1flgC = $icocheckedstub;
  }  	

  if (trim($ico2img) != '') {
    $ico2imgstub = '<img id="vDC2" class="ui-state-default" src="' .  $ico2img . '" width="32" height="32" border="0" />';
  } else  { $ico2imgstub = ""; } 
  if ($ico2flg == 'y') {	
    $ico2flgC = $icocheckedstub;
  }  	

  if (trim($ico3img) != '') {
    $ico3imgstub = '<img id="vDC3" class="ui-state-default" src="' .  $ico3img . '" width="32" height="32" border="0" />';
  } else  { $ico3imgstub = ""; } 
  if ($ico3flg == 'y') {	
    $ico3flgC = $icocheckedstub;
  } 

  if (trim($ico4img) != '') {
    $ico4imgstub = '<img id="vDC4" class="ui-state-default" src="' .  $ico4img . '" width="32" height="32" border="0" />';
  } else  { $ico4imgstub = ""; } 
  if ($ico4flg == 'y') {	
    $ico4flgC = $icocheckedstub;
  } 	
  
  if (trim($ico5img) != '') {
    $ico5imgstub = '<img id="vDC5" class="ui-state-default" src="' .  $ico5img . '" width="32" height="32" border="0" />';
  } else  { $ico5imgstub = ""; } 
  if ($ico5flg == 'y') {	
    $ico5flgC = $icocheckedstub;
  } 
  
  if (trim($ico6img) != '') {
    $ico6imgstub = '<img id="vDC6" class="ui-state-default" src="' .  $ico6img . '" width="32" height="32" border="0" />';
  } else  { $ico6imgstub = ""; } 
  if ($ico6flg == 'y') {	
    $ico6flgC = $icocheckedstub;
  } 
  
  if (trim($ico7img) != '') {
    $ico7imgstub = '<img id="vDC7" class="ui-state-default" src="' .  $ico7img . '" width="32" height="32" border="0" />';
  } else  { $ico7imgstub = ""; } 
  if ($ico7flg == 'y') {	
    $ico7flgC = $icocheckedstub;
  } 
  
  if (trim($ico8img) != '') {
    $ico8imgstub = '<img id="vDC8" class="ui-state-default" src="' .  $ico8img . '" width="32" height="32" border="0" />';
  } else  { $ico8imgstub = ""; } 
  if ($ico8flg == 'y') {	
    $ico8flgC = $icocheckedstub;
  } 	           
}	


function getLUICons() {
	global $iconFoldersRoot;
	global $accordians;
	global $uimsg;
	global $traceflg;
	

  $icostub = '<img src="~~FULLPATHICON~~" width="32" height="32" />'; 
 
  $stub1 = '<!-- Div~~NUM~~ plural tags -->';
  $stub2 = '<h3>~~DIRNAME~~</h3>';
  $stub3 = '<div class="accordian2data" id="~~NUM~~">';
  $stub4 = '<table width="400" border="0" cellspacing="2" cellpadding="3"><tr><td class="dropnewIco" id="ddWrap3" name="ddWrap3">';
  $stub5 = '</td></tr></table></div>'; 

  $basedirarr = get_base_dirs($iconFoldersRoot);
  $basedircnt = count($basedirarr);
 
  if ($traceflg == 'z') {
   $uimsg .= $basedircnt . "<br />";
  } 

  for ($i=0; $i < $basedircnt; $i++) {
     $tmpstub1 = $stub1;
     $tmpstub2 = $stub2;
     $tmpstub3 = $stub3;
     $tmpstub4 = $stub4;
     $tmpstub5 = $stub5;
     if ($traceflg == 'z') {
 	    $uimsg .= $basedirarr[$i] . "<br />";
  	 }   
     //populate nums
     $tmpstub1 = preg_replace('/~~NUM~~/',$i,$tmpstub1);
     $tmpstub3 = preg_replace('/~~NUM~~/',$i,$tmpstub3);
     //get our accordian header name
     $tmplabel = $basedirarr[$i];
     $tmplabel = preg_replace('/[_]/',' ',$tmplabel);
 	   $tmpstub2 = preg_replace('/~~DIRNAME~~/',$tmplabel,$tmpstub2);
 	   //deal with count
  	 $tmppath = $iconFoldersRoot . "/" . $basedirarr[$i];

 	 //get our icons for the accordian
 	  $basedirfilesarr = get_files_basedir($tmppath);
 	  $basefilcnt = count($basedirfilesarr);
 	  $tmpico = "";
 	  for ($ii=0; $ii < $basefilcnt; $ii++) {	
 	      $tmpicostub = $icostub;
 	      $tmpfullicopath = $tmppath . '/' . $basedirfilesarr[$ii];
        $tmpicostub = preg_replace('/~~FULLPATHICON~~/',$tmpfullicopath,$tmpicostub);
        $tmpicostub .= "\n";
        $tmpico .= $tmpicostub;
 	  	 if ($traceflg == 'z') {
 	  	  $uimsg .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $basedirfilesarr[$ii] . "<br />";
 	  	 }  
 	  }	
  //build accordian bar for this loop iteration
   $accordians .= $tmpstub1 . "\n";
   $accordians .= $tmpstub2 . "\n";
   $accordians .= $tmpstub3 . "\n";
   $accordians .= $tmpstub4 . "\n"; 
   $accordians .= $tmpico;
   $accordians .= $tmpstub5 . "\n\n";
  }
  
  return $accordians;
	
}	

//------------------------------------------------------------------------------  
function getTopIcons()
{
  global $ico1img; global $ico1url; global $ico1flg;
  global $ico2img; global $ico2url; global $ico2flg;
  global $ico3img; global $ico3url; global $ico3flg;
  global $ico4img; global $ico4url; global $ico4flg;
  global $ico5img; global $ico5url; global $ico5flg;
  global $ico6img; global $ico6url; global $ico6flg;
  global $ico7img; global $ico7url; global $ico7flg;
  global $ico8img; global $ico8url; global $ico8flg;
  global $uimsg;
  global $myDbgateway;

  $uid = $_SESSION['uid'];
  $query = 'SELECT ico1url,ico1img,ico1wndflg,ico2url,ico2img,ico2wndflg,ico3url,ico3img,ico3wndflg,ico4url,ico4img,ico4wndflg, 
ico5url,ico5img,ico5wndflg,ico6url,ico6img,ico6wndflg,ico7url,ico7img,ico7wndflg,ico8url,ico8img,ico8wndflg 
FROM lnks_itm WHERE member_uid = ';
  $query .= $_SESSION['USRSYSKEY'];
  
  if ($traceflg == 'd') {
  	$uimsg .=  $query . "<br />";
  }	

  $result = $myDbgateway->readSQL($query,"hash");

  $ico1img = $result['ico1img']; 
  $ico2img = $result['ico2img']; 
  $ico3img = $result['ico3img'];
  $ico4img = $result['ico4img'];
  $ico5img = $result['ico5img'];
  $ico6img = $result['ico6img'];
  $ico7img = $result['ico7img'];
  $ico8img = $result['ico8img'];
  $ico1url = $result['ico1url']; 
  $ico2url = $result['ico2url']; 
  $ico3url = $result['ico3url'];
  $ico4url = $result['ico4url'];
  $ico5url = $result['ico5url'];
  $ico6url = $result['ico6url'];
  $ico7url = $result['ico7url'];
  $ico8url = $result['ico8url'];
  $ico1flg = $result['ico1wndflg']; 
  $ico2flg = $result['ico2wndflg']; 
  $ico3flg = $result['ico3wndflg'];
  $ico4flg = $result['ico4wndflg'];
  $ico5flg = $result['ico5wndflg'];
  $ico6flg = $result['ico6wndflg'];
  $ico7flg = $result['ico7wndflg'];
  $ico8flg = $result['ico8wndflg'];     

  if ($traceflg == 'd') {
    $uimsg .= '$ico1img= ' . $ico1img . "<br />";
    $uimsg .= '$ico2img= ' . $ico2img . "<br />";
    $uimsg .= '$ico3img= ' . $ico3img . "<br />";
    $uimsg .= '$ico4img= ' . $ico4img . "<br />";
    $uimsg .= '$ico5img= ' . $ico5img . "<br />";
    $uimsg .= '$ico6img= ' . $ico6img . "<br />";
    $uimsg .= '$ico7img= ' . $ico7img . "<br />";
    $uimsg .= '$ico8img= ' . $ico8img . "<br />";
    $uimsg .= '$ico1url= ' . $ico1url . "<br />";
    $uimsg .= '$ico2url= ' . $ico2url . "<br />";
    $uimsg .= '$ico3url= ' . $ico3url . "<br />";
    $uimsg .= '$ico4url= ' . $ico4url . "<br />";
    $uimsg .= '$ico5url= ' . $ico5url . "<br />";
    $uimsg .= '$ico6url= ' . $ico6url . "<br />";
    $uimsg .= '$ico7url= ' . $ico7url . "<br />";
    $uimsg .= '$ico8url= ' . $ico8url . "<br />";
    $uimsg .= '$ico1flg= ' . $ico1flg . "<br />";
    $uimsg .= '$ico2flg= ' . $ico2flg . "<br />";
    $uimsg .= '$ico3flg= ' . $ico3flg . "<br />";
    $uimsg .= '$ico4flg= ' . $ico4flg . "<br />";
    $uimsg .= '$ico5flg= ' . $ico5flg . "<br />";
    $uimsg .= '$ico6flg= ' . $ico6flg . "<br />";
    $uimsg .= '$ico7flg= ' . $ico7flg . "<br />";
    $uimsg .= '$ico8flg= ' . $ico8flg . "<br />";
  }

	return;
}

function updTopIcons()
{	

  global $ico1img; global $ico1url; global $ico1flg;
  global $ico2img; global $ico2url; global $ico2flg;
  global $ico3img; global $ico3url; global $ico3flg;
  global $ico4img; global $ico4url; global $ico4flg;
  global $ico5img; global $ico5url; global $ico5flg;
  global $ico6img; global $ico6url; global $ico6flg;
  global $ico7img; global $ico7url; global $ico7flg;
  global $ico8img; global $ico8url; global $ico8flg;
  global $uimsg;
  global $traceflg;
  global $myDbgateway;
  
	$query = "UPDATE lnks_itm SET ico1url = '"; 
	$query .= $ico1url ;
	$query .= "'";

	$query .= ",ico2url = '";
	$query .= $ico2url ;
	$query .= "'";

	$query .= ",ico3url = '";
	$query .= $ico3url ;
	$query .= "'";

	$query .= ",ico4url = '";
	$query .= $ico4url ;
	$query .= "'";
	
	$query .= ",ico5url = '";
	$query .= $ico5url ;
	$query .= "'";	

	$query .= ",ico6url = '";
	$query .= $ico6url ;
	$query .= "'";

	$query .= ",ico7url = '";
	$query .= $ico7url ;
	$query .= "'";

	$query .= ",ico8url = '";
	$query .= $ico8url ;
	$query .= "'";

	$query .= ",ico1img = '";
	$query .= $ico1img ;
	$query .= "'";

	$query .= ",ico2img = '";
	$query .= $ico2img ;
	$query .= "'";

	$query .= ",ico3img = '";
	$query .= $ico3img ;
	$query .= "'";

	$query .= ",ico4img = '";
	$query .= $ico4img ;
	$query .= "'";
	
	$query .= ",ico5img = '";
	$query .= $ico5img ;
	$query .= "'";	

	$query .= ",ico6img = '";
	$query .= $ico6img ;
	$query .= "'";

	$query .= ",ico7img = '";
	$query .= $ico7img ;
	$query .= "'";

	$query .= ",ico8img = '";
	$query .= $ico8img ;
	$query .= "'";

	$query .= ",ico1wndflg = '";
	$query .= $ico1flg ;
	$query .= "'";

	$query .= ",ico2wndflg = '";
	$query .= $ico2flg ;
	$query .= "'";

	$query .= ",ico3wndflg = '";
	$query .= $ico3flg ;
	$query .= "'";

	$query .= ",ico4wndflg = '";
	$query .= $ico4flg ;
	$query .= "'";
	
	$query .= ",ico5wndflg = '";
	$query .= $ico5flg ;
	$query .= "'";	

	$query .= ",ico6wndflg = '";
	$query .= $ico6flg ;
	$query .= "'";

	$query .= ",ico7wndflg = '";
	$query .= $ico7flg ;
	$query .= "'";

	$query .= ",ico8wndflg = '";
	$query .= $ico8flg ;
	$query .= "'";

  $query .= " where member_uid = "; 
  $query .= $_SESSION['uid'] ;
  if ($traceflg == 'u'){ $uimsg .= $query . "<br />"; } 

  $result = $myDbgateway->writeSQL($query);
	
  return $result;
}	



//--MAIN---------------//

?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="jquery/stylesheet/accordian_icons.css">
<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" />
<link rel=stylesheet type=text/css href="jquery/stylesheet/uidropdragcustom.css">
<script language=JavaScript type=text/javascript src="jquery/jquery182.min.js"></script>
<script language=JavaScript type=text/javascript src="jquery/jquery-ui191.js"></script>

<script type="text/javascript">
$(document).ready(function(){ 
	 $(".accordion div").hide(); // close accordian
	 //$(".accordion div").eq(2).show();   //open a default  
	 var vico1 = '<?php echo $ico1img; ?>';
	 var vico2 = '<?php echo $ico2img; ?>';
	 var vico3 = '<?php echo $ico3img; ?>';
	 var vico4 = '<?php echo $ico4img; ?>';
	 var vico5 = '<?php echo $ico5img; ?>';
	 var vico6 = '<?php echo $ico6img; ?>';
	 var vico7 = '<?php echo $ico7img; ?>';
	 var vico8 = '<?php echo $ico8img; ?>';

$(".accordion h3").click(function(){
// in order to allow for any html within the accordian you need to wrap your 
// markup within a div tag.	
		$(this).next("div").slideToggle("slow")	
		
	});

		$("td.droptrue1").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1a 
		});
		$("td.droptrue2").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1b 
		});
		$("td.droptrue3").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1c 
		});
		$("td.droptrue4").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1d 
		});
		$("td.droptrue5").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1e 
		});
		$("td.droptrue6").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1f 
		});
		$("td.droptrue7").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1g 
		});
		$("td.droptrue8").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc1h 
		});														


		$("td.droptrueTrash").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc2 
		});

		$("td.dropnewIco").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updLoc3 
		});


});

  function submitUpdTopico() {
  	$("#UpdTopico").val('Update Top Icons');
  	$("#tb_ico1").val(vico1);
  	$("#tb_ico2").val(vico2);
  	$("#tb_ico3").val(vico3);
  	$("#tb_ico4").val(vico4);
  	$("#tb_ico5").val(vico5);
  	$("#tb_ico6").val(vico6);
   	$("#tb_ico7").val(vico7);
  	$("#tb_ico8").val(vico8); 	
  	document.formUpdTopico.submit();  	
  }	

	function updLoc1a() { 
		var arr = [];
		var ddW = $("#ddWrap1a").attr('id');
		var vObj;
	  $("#ddWrap1a img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico1 = vObj;
	    $("#tb_ico1").val(vObj)
	  });
    	 if ( $("#tbIco1url").val().length > 0) {
    	 	  $("#tbIco1url").val('');
    	 	  $("#cbIco1WndFlg").removeAttr("checked");  
       } 
    }	

  	function updLoc1b() { 
		var arr = [];
		var ddW = $("#ddWrap1b").attr('id');
		var vObj;
	  $("#ddWrap1b img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico2 = vObj;
	    $("#tb_ico2").val(vObj)
	  });
    	 if ( $("#tbIco2url").val().length > 0) {
    	 	  $("#tbIco2url").val('');
    	 	  $("#cbIco2WndFlg").removeAttr("checked");  
       }

    }	

  	function updLoc1c() { 
		var arr = [];
		var ddW = $("#ddWrap1c").attr('id');
		var vObj;
	  $("#ddWrap1c img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico3 = vObj;
	    $("#tb_ico3").val(vObj)
	  });
    	 if ( $("#tbIco3url").val().length > 0) {
    	 	  $("#tbIco3url").val('');
    	 	  $("#cbIco3WndFlg").removeAttr("checked");  
       } ;
    }	

  	function updLoc1d() { 
		var arr = [];
		var ddW = $("#ddWrap1d").attr('id');
		var vObj;
	  $("#ddWrap1d img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico4 = vObj;
	    $("#tb_ico4").val(vObj)
	  });
    	 if ( $("#tbIco4url").val().length > 0) {
    	 	  $("#tbIco4url").val('');
    	 	  $("#cbIco4WndFlg").removeAttr("checked");  
       } 	
   }	

  	function updLoc1e() { 
		var arr = [];
		var ddW = $("#ddWrap1e").attr('id');
		var vObj;
	  $("#ddWrap1e img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico5 = vObj;
	    $("#tb_ico5").val(vObj)
	  });
    	 if ( $("#tbIco5url").val().length > 0) {
    	 	  $("#tbIco5url").val('');
    	 	  $("#cbIco5WndFlg").removeAttr("checked");  
       } 	
    }	

  	function updLoc1f() { 
		var arr = [];
		var ddW = $("#ddWrap1f").attr('id');
		var vObj;
	  $("#ddWrap1f img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico6 = vObj;
	    $("#tb_ico6").val(vObj)
	  });
    	 if ( $("#tbIco6url").val().length > 0) {
    	 	  $("#tbIco6url").val('');
    	 	  $("#cbIco6WndFlg").removeAttr("checked");  
       }
    }	

  	function updLoc1g() { 
		var arr = [];
		var ddW = $("#ddWrap1g").attr('id');
		var vObj;
	  $("#ddWrap1g img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico7 = vObj;
	    $("#tb_ico7").val(vObj)
	  });
    	 if ( $("#tbIco7url").val().length > 0) {
    	 	  $("#tbIco7url").val('');
    	 	  $("#cbIco7WndFlg").removeAttr("checked");  
       } 
   }	

  	function updLoc1h() { 
		var arr = [];
		var ddW = $("#ddWrap1h").attr('id');
		var vObj;
	  $("#ddWrap1h img").each(function(){
	  	vObj = $(this).attr('src');
	  	vico8 = vObj;
	    $("#tb_ico8").val(vObj)
	  });
    	 if ( $("#tbIco8url").val().length > 0) {
    	 	  $("#tbIco8url").val('');
    	 	  $("#cbIco8WndFlg").removeAttr("checked");  
       } 	
   }	

   function updLoc2() { 

   }	
  
   function updLoc3() { 

   }	
  
</script>

<style type="text/css">
<!--
.ui-state-default { margin-top: 1px; margin-bottom: 1px; }

#iconsDiv {
	position:absolute;
	width:356px;
	height:321px;
	z-index:1;
	left: 15px;
	top: 53px;
}

#iconsselDiv {
	position:absolute;
	width:410px;
	height:428px;
	z-index:1;
	left: 450px;
	top: 44px;
}

.droptrue1 {
		cursor: pointer;
	  background-color: #fff;	
}
.droptrue2 {
		cursor: pointer;
	  background-color: #fff;	
}
.droptrue3 {
		cursor: pointer;
	  background-color: #fff;	
}
.droptrue4 {
		cursor: pointer;
	  background-color: #fff;	
}
.droptrue5 {
		cursor: pointer;
	  background-color: #fff;	
}
.droptrue6 {
		cursor: pointer;
	  background-color: #fff;	
}
.droptrue7 {
		cursor: pointer;
	  background-color: #fff;	
}
.droptrue8 {
		cursor: pointer;
	  background-color: #fff;	
}



.dropTrash {
		cursor: pointer;
	  background-color: #fff;	
}		
#Layer1 {
	position:absolute;
	width:417px;
	height:169px;
	z-index:5;
	left: 11px;
	top: 680px;
}

-->
</style>
</head>
<body>
<h3>Manage Icons</h3>

<div id="iconsselDiv">
<div class="accordion">
<!-- starting accoridian div tag -->
<?php echo $accordians; ?> 
<!-- closing accoridian div tag -->
</div>
</div>

<div id="iconsDiv">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
     <table>
     	<tr>
        <td width="200px" height="21" class="droptrueTrash" id="ddWrap2"  style="background-color: #ccc;" name="ddWrap2">&nbsp;<img src="images/trash.png" alt="trash" width="48" height="48" /></td>
      </tr>
     </table> 
    </tr>
  </table>
 <br /><br /> 
<form name="formUpdTopico" id="formUpdTopico" method="post" action="adm_manage_icons.php">
<input name="UpdTopico" id="UpdTopico" type="submit" value="Update Top Icons" onClick="submitUpdTopico();">
<br />
<table width="400" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="40">Icon#</td>
    <td width="35">Icon</td>
    <td width="235">URL</td>
    <td width="30">Win</td>
  </tr>
 
  <tr>
    <td align="center">1</td>
    <td>
	    <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
             <td class="droptrue1" id="ddWrap1a" name="ddWrap1a">&nbsp;<?php echo $ico1imgstub; ?></td>
        </tr>
      </table>
	  </td>
    <td><input name="tbIco1url" id="tbIco1url" type="text" value="<?php echo $ico1url; ?>" size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco1WndFlg" id="cbIco1WndFlg" value="chk" <?php echo $ico1flgC; ?>></td>
  </tr>
 
  <tr>
     <td align="center">2</td>
     <td>
	    <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
           <td class="droptrue2" id="ddWrap1b" name="ddWrap1b">&nbsp;<?php echo $ico2imgstub; ?></td>
        </tr>
      </table>	
	  </td>
    <td><input name="tbIco2url" id="tbIco2url" type="text" value="<?php echo $ico2url; ?>"  size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco2WndFlg" id="cbIco2WndFlg" value="chk" <?php echo $ico2flgC; ?>></td>
  </tr>
 
  <tr>
    <td align="center">3</td>
    <td>
	  <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="droptrue3" id="ddWrap1c" name="ddWrap1c">&nbsp;<?php echo $ico3imgstub; ?></td>
        </tr>
      </table>	
	</td>
    <td><input name="tbIco3url"  id="tbIco3url" type="text" value="<?php echo $ico3url; ?>"  size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco3WndFlg" id="cbIco3WndFlg" value="chk" <?php echo $ico3flgC; ?>></td>
  </tr>
 
  <tr>
    <td align="center">4</td>
    <td>
	  <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="droptrue4" id="ddWrap1d" name="ddWrap1d">&nbsp;<?php echo $ico4imgstub; ?></td>
        </tr>
      </table>	
	</td>
    <td><input name="tbIco4url" id="tbIco4url" type="text" value="<?php echo $ico4url; ?>"  size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco4WndFlg"  id="cbIco4WndFlg" value="chk" <?php echo $ico4flgC; ?>></td>
  </tr>
 
  <tr>
    <td align="center">5</td>
    <td>
	  <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="droptrue5" id="ddWrap1e" name="ddWrap1e">&nbsp;<?php echo $ico5imgstub; ?></td>
        </tr>
      </table>	
	</td>
    <td><input name="tbIco5url" id="tbIco5url" type="text" value="<?php echo $ico5url; ?>"  size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco5WndFlg" id="cbIco5WndFlg" value="chk" <?php echo $ico5flgC; ?>></td>
  </tr>
 
  <tr>
    <td align="center">6</td>
    <td>
	  <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="droptrue6" id="ddWrap1f" name="ddWrap1f">&nbsp;<?php echo $ico6imgstub; ?></td>
        </tr>
      </table>	
	</td>
    <td><input name="tbIco6url" id="tbIco6url" type="text" value="<?php echo $ico6url; ?>"  size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco6WndFlg" id="cbIco6WndFlg" value="chk" <?php echo $ico6flgC; ?>></td>
  </tr>
 
  <tr>
    <td align="center">7</td>
    <td>
	  <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="droptrue7" id="ddWrap1g" name="ddWrap1g">&nbsp;<?php echo $ico7imgstub; ?></td>
        </tr>
      </table>	
	</td>
    <td><input name="tbIco7url" id="tbIco7url" type="text" value="<?php echo $ico7url; ?>"  size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco7WndFlg" id="cbIco7WndFlg" value="chk" <?php echo $ico7flgC; ?>></td>
  </tr>
 
  <tr>
    <td align="center">8</td>
    <td>
	  <table width="34" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="droptrue8" id="ddWrap1h" name="ddWrap1h">&nbsp;<?php echo $ico8imgstub; ?></td>
        </tr>
      </table>	
	</td>
    <td><input name="tbIco8url" id="tbIco8url" type="text" value="<?php echo $ico8url; ?>" size="40" maxlength="225"></td>
    <td><input type="checkbox" name="cbIco8WndFlg" id="cbIco8WndFlg" value="chk" <?php echo $ico8flgC; ?>></td>
  </tr>
</table>
<input id="tb_ico1" size="30" type="hidden" name="tb_ico1" value="<?php echo $ico1img; ?>">
<input id="tb_ico2" size="30" type="hidden" name="tb_ico2" value="<?php echo $ico2img; ?>">
<input id="tb_ico3" size="30" type="hidden" name="tb_ico3" value="<?php echo $ico3img; ?>">
<input id="tb_ico4" size="30" type="hidden" name="tb_ico4" value="<?php echo $ico4img; ?>">
<input id="tb_ico5" size="30" type="hidden" name="tb_ico5" value="<?php echo $ico5img; ?>">
<input id="tb_ico6" size="30" type="hidden" name="tb_ico6" value="<?php echo $ico6img; ?>">
<input id="tb_ico7" size="30" type="hidden" name="tb_ico7" value="<?php echo $ico7img; ?>">
<input id="tb_ico8" size="30" type="hidden" name="tb_ico8" value="<?php echo $ico8img; ?>">
</form>
</div>

<div id="Layer1">
<?php echo $uimsg; ?>
</div>
</body>
</html>