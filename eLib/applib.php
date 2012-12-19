<?php

//         Version:  1.10                                                         
//            Date:  2009-12-01                                                          
// Initial Writing:  Eric Matthews
//         Purpose:  Misc lib functions useful for app dev.
//       Additions:  The following functions were added by Jim
//                   Quick: parse_phone(); convert_pdate() 

$lustatus = '';
         
function format_time($ptime)
{

	$ptimeStr = (string)$ptime;
	$strlen = strlen($ptimeStr);
   if ($ptime = 0) 
   {
		 $formattedTime = $ptime;
	   return $formattedTime;	  	
   } 
   else
 	{    
	 switch ($strlen){ 
   case 4: 
       $formattedTime = substr($ptimeStr ,0,2) . ':'  . substr($ptimeStr,2,2);
        break;
   case 3 : 
       $formattedTime = ' ' . substr($ptimeStr ,0,1) . ':'  . substr($ptimeStr,1,2);
       break;
   case 2 :
       $formattedTime =  '00:' . substr($ptimeStr ,0,2);
       break;
   case 2 :
       $formattedTime =  '00:0' .$ptimeStr ;
       break;       
  default:
       $formattedTime = $ptimeStr;
  //     break; 
  } 
}

	return $formattedTime;	
}

function parse_phone($phn)                                                                                                                                                                                                                                                                                                                                                                                                                    
{                                                                                                                                                                                                                                                                                                                                                                                                                                             
	$strlen = strlen($phn);                                                                                                                                                                                                                                                                                                                                                                                                                     
                                                                                                                                                                                                                                                                                                                                                                                                                                              
	 switch ($strlen){                                                                                                                                                                                                                                                                                                                                                                                                                          
	 case 0:                                                                                                                                                                                                                                                                                                                                                                                                                                    
       $phnnum = $phn;                                                                                                                                                                                                                                                                                                                                                                                                                        
       break;                                                                                                                                                                                                                                                                                                                                                                                                                                 
   case 10:                                                                                                                                                                                                                                                                                                                                                                                                                                   
       $phnnum = '(' . substr($phn ,0,3) . ')'  . substr($phn,3,3) . '-' . substr($phn ,6,4);                                                                                                                                                                                                                                                                                                                                                 
        break;                                                                                                                                                                                                                                                                                                                                                                                                                                
   case 14 :                                                                                                                                                                                                                                                                                                                                                                                                                                  
       $phnnum = '(' . substr($phn ,0,3) . ')'  . substr($phn,3,3) . '-' .  substr($phn ,6,4) . ' Extension: ' .   substr($phn ,9,4);                                                                                                                                                                                                                                                                                                         
       break;                                                                                                                                                                                                                                                                                                                                                                                                                                 
   case 7 :                                                                                                                                                                                                                                                                                                                                                                                                                                   
       $phnnum =  substr($phn ,0,3) . '-'  . substr($phn,3,3);                                                                                                                                                                                                                                                                                                                                                                                
       break;                                                                                                                                                                                                                                                                                                                                                                                                                                 
  default:                                                                                                                                                                                                                                                                                                                                                                                                                                    
       $phnnum = $phn;                                                                                                                                                                                                                                                                                                                                                                                                                        
  //     break;                                                                                                                                                                                                                                                                                                                                                                                                                               
  }                                                                                                                                                                                                                                                                                                                                                                                                                                           
                                                                                                                                                                                                                                                                                                                                                                                                                                              
 return $phnnum;	                                                                                                                                                                                                                                                                                                                                                                                                                            
}                                                                                                                                                                                                                                                                                                                                                                                                                                             

 
function validSQLServerDate($dte)
{
 $status = 'y'; //assume it is good to begin with
 $DateStr = preg_split('/[-]/', $dte, -1, PREG_SPLIT_OFFSET_CAPTURE);
 if (count($DateStr[1][0]) != 2)
 { $status = 'n'; }	
 
 if (count($DateStr[1][0]) != 2)
 { $status = 'n'; }	

 if (count($DateStr[0][0]) != 4)
 { $status = 'n'; }	

 $validdate = checkdate ( $DateStr[1][0],$DateStr[2][0],$DateStr[0][0] );                                             
  if ($validdate) 
  { $status = 'y'; } 
  else {$status = 'n'; }
 
  return $status;
}

function generateCharacter ()
{
$possible = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
return $char;
}

function generateGUID ()
{
 $GUID = generateCharacter().generateCharacter().generateCharacter();
 $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter();
 $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter();
 $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter();     
 $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter();
 $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter();
 $GUID = $GUID .generateCharacter().generateCharacter().generateCharacter();
return $GUID;
}

//----------------------------------------------------------------------------//
function getSyncList($delimrs,$plist,$clist)
//----------------------------------------------------------------------------//
{
/*
 This is a generalized control. It accepts a delimited array (dbiox function 
 'delim' and returns a synchronized list where the parent list determines what
 is populated in the child list.
  INPUT ARGS: 
    $delimr - delimited array. row delimiter in array is currently |. 
     $plist - row offset that contains data for the parent list (note 0=1)
     $clist - row offset that contains data for the child list (note 0=1)
  RETURNS: An array with two items
      $jsSyncListCode - Javascript code needed for synchronized list
    $syncListCodeStub - HTML code stub for your form  
*/	
//note: plist and clist 0=1 based upon array start indices	
 //change these globals out at end and return two vals from this function to caller
 $tmp = ""; // this holds our array stub	
 $plisthash = '';
 $plistarr = array();
 $plistarrcnt=0;
 $clistarr = array();
 $clistarrcnt=0;
 $rescnt=0;
 $rescnt = count($delimrs);

 $row0 = preg_split('/[|]/', $delimrs[0], -1,PREG_SPLIT_OFFSET_CAPTURE);
 $seed = trim($row0[$plist][0]);

 if ($delimrs != '')
 {
   $ccnt = 0;
   $tmpdb = $seed;  //!!!! get $plist val from $delimrs row 0 and seed
 
   foreach ($delimrs as $key => $value)
   {
     $tmprow = preg_split('/[|]/', $value, -1,PREG_SPLIT_OFFSET_CAPTURE);
     if (trim($tmprow[$plist][0]) == $tmpdb)
     {
       if ($ccnt == 0) 
       {
        $plisthash[trim($tmprow[$plist][0])] = trim($tmprow[$plist][0]);
        $tmp .= '"' . $tmprow[$clist][0] . '"';
       }
       else
       {
       	$plisthash[trim($tmprow[$plist][0])] = trim($tmprow[$plist][0]);
        $tmp .= ',"' . $tmprow[$clist][0] . '"';  
        if ($ccnt == $rescnt-1) // this means we are at the end of the array
        {
       	  // push the final stub to the array
           array_push($clistarr,$tmp);
        }    	
       }	 
     }
     else
     {
     	 $plisthash[trim($tmprow[$plist][0])] = trim($tmprow[$plist][0]);
     	 array_push($clistarr,$tmp);
       //$tmp .= "<br />" . '"' . $tmprow[$clist][0] . '"';
       $tmp = '';
       $tmp .= '"' . $tmprow[$clist][0] . '"';
     }
     $tmpdb = trim($tmprow[$plist][0]);
     $ccnt++;
     
   } //end loop	
 } //end outer if


// deal with the parent list
foreach( $plisthash as $key => $value)
{
  $plistarr[$plistarrcnt] = $key;
  $plistarrcnt++;
}
//since query returned is sorted asc we need to ensure preservation.
sort($plistarr); 

$clistarrcnt = count($clistarr);

/* The presumption is that both are arrays, have the same number of elements,
and that they are aligned properly. */

//!!!!!!!!!!!!!! add crude array count check conditional here
$jsSyncListCode = getJsSyncListCode($clistarr) ;
$syncListCodeStub = getSyncListFormCode($plistarr,"DBMS: ","Database: ");
 
 return array($jsSyncListCode,$syncListCodeStub);

} //end sub

//----------------------------------------------------------------------------//
function getJsSyncListCode($clist)
//----------------------------------------------------------------------------//
{
  $listArrStub = 'var syncDDM~~number~~ = new Array(~~arrayContentStub~~);'; 

  $listProcStub = '
  if (parent_val == "~~number~~")
  {
    for(var i=0; i<syncDDM~~number~~.length; i++)
    select_vals.options[select_vals.options.length] = 
    new Option(syncDDM~~number~~[i]);
  }';

  $jsSyncCode = '
  ~~arrayStub~~
  
  function getDDMvals() {
    var select_parent = document.myform.parentDDM ;
    var select_vals = document.myform.dropDownItems;
    var parent_val = select_parent.options[select_parent.selectedIndex].value;
  
    select_vals.options.length=0;
    ~~arrayProcStub~~
  }';
  
  $listArrTmp = '';
  $listProcTmp = '';
  $clistcnt = count($clist);
  $arrContent = '';
  $procContent = '';

  for ($i=0; $i < $clistcnt; $i++)
  {
    $listArrTmp = $listArrStub;
    $listArrTmp =  preg_replace("/~~number~~/", $i, $listArrTmp);
    $listArrTmp =  preg_replace("/~~arrayContentStub~~/", $clist[$i], $listArrTmp);
    $arrContent .= $listArrTmp . "\n";

    $listProcTmp = $listProcStub;
    $listProcTmp =  preg_replace("/~~number~~/", $i, $listProcTmp);  
    $procContent .=  $listProcTmp . "\n"; 
  }

  $jsSyncCode =  preg_replace("/~~arrayStub~~/", $arrContent, $jsSyncCode);
  $jsSyncCode =  preg_replace("/~~arrayProcStub~~/", $procContent, $jsSyncCode);
  $codeStub = $jsSyncCode;
  return $codeStub;
}	

//----------------------------------------------------------------------------//
function getSyncListFormCode($plist,$plbl,$clbl)
//----------------------------------------------------------------------------//
{
 $optionStub = '<option value="~~number~~">~~dbms~~';
 $SyncListCodeTemplate = '
    ~~ParentLabel~~
    &nbsp;<select name="parentDDM" onchange="getDDMvals()">
    <option>
    ~~optionsStub~~
    </select>&nbsp;&nbsp;
    ~~ChildLabel~~
    &nbsp;<select name="dropDownItems">
    <option>
    </select>';
 $options = '';
 $optionTmp = '';
 $plistcnt = count($plist);

 for ($i=0; $i < $plistcnt; $i++)
 {
   $optionTmp = $optionStub;
   $optionTmp =  preg_replace("/~~number~~/", $i, $optionTmp);
   $optionTmp =  preg_replace("/~~dbms~~/", $plist[$i], $optionTmp);
   $options .= $optionTmp . "\n";
 }
  $SyncListCodeTemplate = preg_replace("/~~ParentLabel~~/", $plbl, $SyncListCodeTemplate);
  $SyncListCodeTemplate = preg_replace("/~~ChildLabel~~/", $clbl, $SyncListCodeTemplate);
  $SyncListCodeTemplate = preg_replace("/~~optionsStub~~/", $options, $SyncListCodeTemplate);

  $codeStub = $SyncListCodeTemplate;
  return $codeStub;
}	

//----------------------------------------------------------------------------//
function cngDelim($rs,$delimtr)
//----------------------------------------------------------------------------//
// modifiy the delimiter in an rs array
{
 $cntretrs = count($rs);
 if ($delimtr == '')
 {
 	$delimtr = ',';
 }	
 for ($i=0; $i < $cntretrs; $i++)
 {
 	  $rs[$i] =  preg_replace("/[|]/", "$delimtr", $rs[$i]);
  	//echo $rsln . "$i - <br />";
 }		
 return $rs;
}	


//----------------------------------------------------------------------------//
function getPageName() {
//----------------------------------------------------------------------------//	
  require('eConfig/envref.php');
  include($php_envvars);

  $fullrefpg = $_SERVER['HTTP_REFERER'];

  // deal with potential ip spoofing
  $pathchk = "";
  if (preg_match("/^http:[\/][\/](.+)[\/](.+)[\/](.+)/", $fullrefpg, $matches2)) {$pathchk = $matches2[1];}
  if ($pathchk != $dns and $pathchk != $ip) {
    die ("Invalid dns and ip >>$matches .. $matches2 xx " . $_SERVER['HTTP_REFERER']);
  }
  
  if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
  $refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);
  return $refpg;
}

?>
