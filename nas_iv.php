<?php
session_start();

require('eConfig/envref.php');

include($php_envvars);
include($php_dbms);  //dbms specific to app
include($php_applib);
include($php_loggers);

$_SESSION['oldebug'] = "";
$_SESSION['tmp'] = $debugapp;
$mtd = "";
$status = '';
$logonerror = '';
$fullrefpg = $_SERVER['HTTP_REFERER'];

// $_SESSION['form_cnxt'];

 

//get only page name.
if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
$refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);

//check_referring_pg($refpg);

function check_referring_pg($refpg){  
 //if referring page context is required you code conditional here as wrapper to below conditional                
//// commented out during development ////
   if ($_SESSION['logtoken'] == '8224') { }
   else {  $_SESSION['loginerr'] = 'Login required to access page';  header("Location: topmnu.php");  exit; }
}

/*
notes to me: 

not sure if we want to save context for display grid here beyond
the prototype. it would incur a great deal of additional memory per connection,
but it would save round tripping back to the database. of course keeping such 
a strategy would require knowing when to get and load data or when to get it 
from the session var. at this point my thoughts are to do this for current 
shift iv's (or iv's within a 24hr period). can then provide a review function
if they want to view history to some periodicity.

regarding form context. these are needed as it provides the user with a 
template, saving work. they will be based upon the specific form itself. 
but, i can forsee that this strategy could end up getting expensive in terms
of required session variable. at some point we want to consider a table
driven strategy that will load the inital form context into js objects at
the client. but, this strategy will not work out of the box as clicking on
different workflows will clear the cache, so some local global cache will
be required.

*/


/* form workflow */
/*
Note: this is essentially a visual 2d array that is not a 2d array :-). this
makes our processing life simple. it also give us some flexility in terms of
whether we want our data row in columnar or row presentation. this is the 
first prototype of this type of pattern. ui-wise it is pretty cool. code-wise
it is pretty primitive thus far. i just have not seen enough of the patterns
for use to figure out how/if to wrap it into a generalized control. not to
mention i am too much of a rookie with jquery and js to even build such a 
control at this time.
*/


if ($_REQUEST['addIV'] == "NewIV") {

 shifty ();
/* form data */
// maintain specific form value context, but deal with initial entry to workflow
if (trim($_REQUEST['e1'])   != "") { $_SESSION['e1']   = $_REQUEST['e1'];   }  
$e2 = $_REQUEST['e2'];
if (trim($_REQUEST['e3'])   != "") { $_SESSION['e3']   = $_REQUEST['e3'];   }
if (trim($_REQUEST['e3a'])  != "") { $_SESSION['e3a']  = $_REQUEST['e3a'];  }
if (trim($_REQUEST['e3b'])  != "") { $_SESSION['e3b']  = $_REQUEST['e3b'];  }
if (trim($_REQUEST['e5'])   != "") { $_SESSION['e5']   = $_REQUEST['e5'];   }
if (trim($_REQUEST['e6'])   != "") { $_SESSION['e6']   = $_REQUEST['e6'];   }
if (trim($_REQUEST['e7'])   != "") { $_SESSION['e7']   = $_REQUEST['e7'];   }
if (trim($_REQUEST['e8'])   != "") { $_SESSION['e8']   = $_REQUEST['e8'];   }
if (trim($_REQUEST['e9'])   != "") { $_SESSION['e9']   = $_REQUEST['e9'];   }
if (trim($_REQUEST['e10'])  != "") { $_SESSION['e10']  = $_REQUEST['e10'];  }
if (trim($_REQUEST['e11'])  != "") { $_SESSION['e11']  = $_REQUEST['e11'];  }
if (trim($_REQUEST['e11a']) != "") { $_SESSION['e11a'] = $_REQUEST['e11a']; }
if (trim($_REQUEST['e12'])  != "") { $_SESSION['e12']  = $_REQUEST['e12'];  }
if (trim($_REQUEST['e12a']) != "") { $_SESSION['e12a'] = $_REQUEST['e12a']; }
if (trim($_REQUEST['e13'])  != "") { $_SESSION['e13']  = $_REQUEST['e13'];  }
if (trim($_REQUEST['e13a']) != "") { $_SESSION['e13a'] = $_REQUEST['e13a']; }
if (trim($_REQUEST['e14'])  != "") { $_SESSION['e14']  = $_REQUEST['e14'];  }
if (trim($_REQUEST['e14a']) != "") { $_SESSION['e14a'] = $_REQUEST['e14a']; }

// note: no error handling if data is incomplete
  // do the shifty on our data
    $_SESSION['arr1'][0] = $_SESSION['e1']; 
    $_SESSION['arr1'][1] = $_REQUEST['e2'];
    $_SESSION['arr1'][2] = $_SESSION['e10'];  
    $_SESSION['arr1'][9] = $_SESSION['e3b'];
    $_SESSION['arr1'][3] = $_REQUEST['e4'];		
    $_SESSION['arr1'][4] = $_SESSION['e5'];	
    $_SESSION['arr1'][5] = $_SESSION['e6'];
    $_SESSION['arr1'][6] = $_SESSION['e7'];	
    $_SESSION['arr1'][7] = $_SESSION['e8'];
    $_SESSION['arr1'][8] = $_SESSION['e9'];	     

//conditional based upon selection of other
  if (trim($_SESSION['e11']) != "Other") {
    $_SESSION['arr1'][10] = $_SESSION['e11'];	
  } else {
  	$_SESSION['arr1'][10] = $_SESSION['e11a'];	
  }	

  if (trim($_SESSION['e12']) != "Other") {
    $_SESSION['arr1'][11] = $_SESSION['e12'];	
  } else {
  	$_SESSION['arr1'][11] = $_SESSION['e12a'];	
  }	

  if (trim($_SESSION['e13']) != "Other") {
    $_SESSION['arr1'][12] = $_SESSION['e13'];	
  } else {
  	$_SESSION['arr1'][12] = $_SESSION['e13a'];	
  }	

  if (trim($_SESSION['e14']) != "Other") {
    $_SESSION['arr1'][13] = $_SESSION['e14'];	
  } else {
  	$_SESSION['arr1'][13] = $_SESSION['e14a'];	
  }	

  loadIVarr();   
}	//end outer if   

else if ($_REQUEST['delIV'] == "CancelIV") {
    unshifty ();
    $wcs = array_pop($_SESSION['ivadmin']);
    $_SESSION['ctrows'] - 1;
}


else if ($_REQUEST['updIV'] == "UpdateIV") {
	if ($_REQUEST['ivcol'] == '1') {
		updCol1();
		upIVarr (1);
	}
	else if ($_REQUEST['ivcol'] == '2') {
		updCol2();
		upIVarr (2);
	}	
	else if ($_REQUEST['ivcol'] == '3') {
		updCol3();
		upIVarr (3);
	}	
	else if ($_REQUEST['ivcol'] == '4') {
		updCol4();
		upIVarr (4);
	}	
	else if ($_REQUEST['ivcol'] == '5') {
		updCol5();
		upIVarr (5);
	}	
	else if ($_REQUEST['ivcol'] == '6') {
		updCol6();
		upIVarr (6);
	}		
}

else if ($_REQUEST['resetIVform'] == "ResetForm") {
   resetForm();
   	
}	

//******************************* FUNCTIONS **********************************//

//------------------------------------------------------------------------------
function upIVarr ($ct_num)
//------------------------------------------------------------------------------
{
/*
presently we can have a max 6 items in the crosstab grid. value can be 0-6.
the items are shifted through the crosstab grid so the last one entered is
the first. 

additionally, the assessment documentation can contain more than 6 items. in
fact, there is no limit. and, the order of the documentation is first to last.

as such, we use the following formula to deal with this require synchronization.
$_SESSION['ivadmin'] = total number of iv items in the report
 $_SESSION['ctrows'] = total crosstab rows occupied
            $ct_num  = cross tab row number to update
(<count of $_SESSION['ivadmin']> - <count of $_SESSION['ctrows']>) +
(<count of $_SESSION['ctrows']> - <row to be updated>) + 1
*/
 $updrow = '<tr>' .
'<td>' . trim($_REQUEST['e1'])  . ' ' . trim($_REQUEST['e2']) . '</td>' .
'<td>' . trim($_REQUEST['e10']) . ' ' .  
         trim($_REQUEST['e3'])  . ' - ' .  ' ' . trim($_REQUEST['e14'])  .  ' ' . 
         trim($_REQUEST['e12']) . ' ' . trim($_REQUEST['e13'])   .  ' ' .  trim($_REQUEST['e14']) . '</td>' .
'<td>' . trim($_REQUEST['e4'])  . '</td>' .
'<td>' . trim($_REQUEST['e5'])  . '</td>' .
'<td>' . trim($_REQUEST['e6'])  . '</td>' .
'<td>' . trim($_REQUEST['e7'])  .  '' . trim($_REQUEST['e8']) . '</td>' .
'<td>' . trim($_REQUEST['e9'])  . '</td>' .
'</tr>';
 
  $update_arr_row;
  $cnt_ivadmin = count($_SESSION['ivadmin']);
  $update_arr_row = ($cnt_ivadmin - $_SESSION['ctrows']) + ($_SESSION['ctrows'] - $ct_num) + 1;
  
  $_SESSION['ivadmin'][$update_arr_row] = $updrow;
}

//------------------------------------------------------------------------------
function loadIVarr ()
//------------------------------------------------------------------------------
{

 $newrow = '<tr>' .
'<td>' . trim($_REQUEST['e1'])  . ' ' . trim($_REQUEST['e2']) . '</td>' .
'<td>' . trim($_REQUEST['e10']) . ' ' .  
         trim($_REQUEST['e3'])  . ' - ' .  ' ' . trim($_REQUEST['e14'])  .  ' ' . 
         trim($_REQUEST['e12']) . ' ' . trim($_REQUEST['e13'])   .  ' ' .  trim($_REQUEST['e14']) . '</td>' .
'<td>' . trim($_REQUEST['e4'])  . '</td>' .
'<td>' . trim($_REQUEST['e5'])  . '</td>' .
'<td>' . trim($_REQUEST['e6'])  . '</td>' .
'<td>' . trim($_REQUEST['e7'])  .  '' . trim($_REQUEST['e8']) . '</td>' .
'<td>' . trim($_REQUEST['e9'])  . '</td>' .
'</tr>';

 if ($_SESSION['ivadmin']) {
   $cnt = count($_SESSION['ivadmin']);
   $newitm = $cnt + 1;
   $_SESSION['ivadmin'][$newitm] = $newrow; 
 } else {
 	 $_SESSION['ivadmin'][0] = $newrow;
 }	 

//in order to deal with updating the assessment documentation we need
//know how many rows we have in the crosstab
   if ($_SESSION['ctrows']) {
   	 $_SESSION['ctrows'] = 1;
   } else {	 
           if ($_SESSION['ctrows'] < 6) {
           $_SESSION['ctrows']++;   	
          }
   }
}

//------------------------------------------------------------------------------
function resetForm ()
//------------------------------------------------------------------------------
{
  $_SESSION['e1']   = ""; 
  $_REQUEST['e2']   = "";
  $_SESSION['e3b']  = "";  
  $_REQUEST['e4']   = "";		
  $_SESSION['e5']   = "";	 
  $_SESSION['e6']   = "";   
  $_SESSION['e7']   = "";	 
  $_SESSION['e8']   = "";   
  $_SESSION['e9']   = "";	 
  $_SESSION['e10']  = "";  
  $_SESSION['e11']  = "";	
  $_SESSION['e11a'] = "";	
  $_SESSION['e12']  = "";	
  $_SESSION['e12a'] = "";	
  $_SESSION['e13']  = "";	
  $_SESSION['e13a'] = "";	
  $_SESSION['e14']  = "";	  
  $_SESSION['e14a'] = "";	
}	


//------------------------------------------------------------------------------
function updCol1 ()
//------------------------------------------------------------------------------
{
    $_SESSION['arr1'][0] = $_REQUEST['e1']; 
    $_SESSION['arr1'][1] = $_REQUEST['e2'];
    $_SESSION['arr1'][2] = $_REQUEST['e10'];  
    $_SESSION['arr1'][9] = $_REQUEST['e3b'];
    $_SESSION['arr1'][3] = $_REQUEST['e4'];		
    $_SESSION['arr1'][4] = $_REQUEST['e5'];	
    $_SESSION['arr1'][5] = $_REQUEST['e6'];
    $_SESSION['arr1'][6] = $_REQUEST['e7'];	
    $_SESSION['arr1'][7] = $_REQUEST['e8'];
    $_SESSION['arr1'][8] = $_REQUEST['e9'];	     

//conditional based upon selection of other
  if (trim($_SESSION['e11']) != "Other") {
    $_SESSION['arr1'][10] = $_REQUEST['e11'];	
  } else {
  	$_SESSION['arr1'][10] = $_REQUEST['e11a'];	
  }	

  if (trim($_SESSION['e12']) != "Other") {
    $_SESSION['arr1'][11] = $_REQUEST['e12'];	
  } else {
  	$_SESSION['arr1'][11] = $_REQUEST['e12a'];	
  }	

  if (trim($_SESSION['e13']) != "Other") {
    $_SESSION['arr1'][12] = $_REQUEST['e13'];	
  } else {
  	$_SESSION['arr1'][12] = $_REQUEST['e13a'];	
  }	

  if (trim($_SESSION['e14']) != "Other") {
    $_SESSION['arr1'][13] = $_REQUEST['e14'];	
  } else {
  	$_SESSION['arr1'][13] = $_REQUEST['e14a'];	
  }	
}	

	
//------------------------------------------------------------------------------
function updCol2 ()
//------------------------------------------------------------------------------
{
    $_SESSION['arr2'][0] = $_REQUEST['e1']; 
    $_SESSION['arr2'][1] = $_REQUEST['e2'];
    $_SESSION['arr2'][2] = $_REQUEST['e10'];  
    $_SESSION['arr2'][9] = $_REQUEST['e3b'];
    $_SESSION['arr2'][3] = $_REQUEST['e4'];		
    $_SESSION['arr2'][4] = $_REQUEST['e5'];	
    $_SESSION['arr2'][5] = $_REQUEST['e6'];
    $_SESSION['arr2'][6] = $_REQUEST['e7'];	
    $_SESSION['arr2'][7] = $_REQUEST['e8'];
    $_SESSION['arr2'][8] = $_REQUEST['e9'];	     

//conditional based upon selection of other
  if (trim($_SESSION['e11']) != "Other") {
    $_SESSION['arr2'][10] = $_REQUEST['e11'];	
  } else {
  	$_SESSION['arr2'][10] = $_REQUEST['e11a'];	
  }	

  if (trim($_SESSION['e12']) != "Other") {
    $_SESSION['arr2'][11] = $_REQUEST['e12'];	
  } else {
  	$_SESSION['arr2'][11] = $_REQUEST['e12a'];	
  }	

  if (trim($_SESSION['e13']) != "Other") {
    $_SESSION['arr2'][12] = $_REQUEST['e13'];	
  } else {
  	$_SESSION['arr2'][12] = $_REQUEST['e13a'];	
  }	

  if (trim($_SESSION['e14']) != "Other") {
    $_SESSION['arr2'][13] = $_REQUEST['e14'];	
  } else {
  	$_SESSION['arr2'][13] = $_REQUEST['e14a'];	
  }	
}	

//------------------------------------------------------------------------------
function updCol3 ()
//------------------------------------------------------------------------------
{
    $_SESSION['arr3'][0] = $_REQUEST['e1']; 
    $_SESSION['arr3'][1] = $_REQUEST['e2'];
    $_SESSION['arr3'][2] = $_REQUEST['e10'];  
    $_SESSION['arr3'][9] = $_REQUEST['e3b'];
    $_SESSION['arr3'][3] = $_REQUEST['e4'];		
    $_SESSION['arr3'][4] = $_REQUEST['e5'];	
    $_SESSION['arr3'][5] = $_REQUEST['e6'];
    $_SESSION['arr3'][6] = $_REQUEST['e7'];	
    $_SESSION['arr3'][7] = $_REQUEST['e8'];
    $_SESSION['arr3'][8] = $_REQUEST['e9'];	     

//conditional based upon selection of other
  if (trim($_SESSION['e11']) != "Other") {
    $_SESSION['arr3'][10] = $_REQUEST['e11'];	
  } else {
  	$_SESSION['arr3'][10] = $_REQUEST['e11a'];	
  }	

  if (trim($_SESSION['e12']) != "Other") {
    $_SESSION['arr3'][11] = $_REQUEST['e12'];	
  } else {
  	$_SESSION['arr3'][11] = $_REQUEST['e12a'];	
  }	

  if (trim($_SESSION['e13']) != "Other") {
    $_SESSION['arr3'][12] = $_REQUEST['e13'];	
  } else {
  	$_SESSION['arr3'][12] = $_REQUEST['e13a'];	
  }	

  if (trim($_SESSION['e14']) != "Other") {
    $_SESSION['arr3'][13] = $_REQUEST['e14'];	
  } else {
  	$_SESSION['arr3'][13] = $_REQUEST['e14a'];	
  }	
}	


//------------------------------------------------------------------------------
function updCol4 ()
//------------------------------------------------------------------------------
{
    $_SESSION['arr4'][0] = $_REQUEST['e1']; 
    $_SESSION['arr4'][1] = $_REQUEST['e2'];
    $_SESSION['arr4'][2] = $_REQUEST['e10'];  
    $_SESSION['arr4'][9] = $_REQUEST['e3b'];
    $_SESSION['arr4'][3] = $_REQUEST['e4'];		
    $_SESSION['arr4'][4] = $_REQUEST['e5'];	
    $_SESSION['arr4'][5] = $_REQUEST['e6'];
    $_SESSION['arr4'][6] = $_REQUEST['e7'];	
    $_SESSION['arr4'][7] = $_REQUEST['e8'];
    $_SESSION['arr4'][8] = $_REQUEST['e9'];	     

//conditional based upon selection of other
  if (trim($_SESSION['e11']) != "Other") {
    $_SESSION['arr4'][10] = $_REQUEST['e11'];	
  } else {
  	$_SESSION['arr4'][10] = $_REQUEST['e11a'];	
  }	

  if (trim($_SESSION['e12']) != "Other") {
    $_SESSION['arr4'][11] = $_REQUEST['e12'];	
  } else {
  	$_SESSION['arr4'][11] = $_REQUEST['e12a'];	
  }	

  if (trim($_SESSION['e13']) != "Other") {
    $_SESSION['arr4'][12] = $_REQUEST['e13'];	
  } else {
  	$_SESSION['arr4'][12] = $_REQUEST['e13a'];	
  }	

  if (trim($_SESSION['e14']) != "Other") {
    $_SESSION['arr4'][13] = $_REQUEST['e14'];	
  } else {
  	$_SESSION['arr4'][13] = $_REQUEST['e14a'];	
  }	
}	


//------------------------------------------------------------------------------
function updCol5 ()
//------------------------------------------------------------------------------
{
    $_SESSION['arr5'][0] = $_REQUEST['e1']; 
    $_SESSION['arr5'][1] = $_REQUEST['e2'];
    $_SESSION['arr5'][2] = $_REQUEST['e10'];  
    $_SESSION['arr5'][9] = $_REQUEST['e3b'];
    $_SESSION['arr5'][3] = $_REQUEST['e4'];		
    $_SESSION['arr5'][4] = $_REQUEST['e5'];	
    $_SESSION['arr5'][5] = $_REQUEST['e6'];
    $_SESSION['arr5'][6] = $_REQUEST['e7'];	
    $_SESSION['arr5'][7] = $_REQUEST['e8'];
    $_SESSION['arr5'][8] = $_REQUEST['e9'];	     

//conditional based upon selection of other
  if (trim($_SESSION['e11']) != "Other") {
    $_SESSION['arr5'][10] = $_REQUEST['e11'];	
  } else {
  	$_SESSION['arr5'][10] = $_REQUEST['e11a'];	
  }	

  if (trim($_SESSION['e12']) != "Other") {
    $_SESSION['arr5'][11] = $_REQUEST['e12'];	
  } else {
  	$_SESSION['arr5'][11] = $_REQUEST['e12a'];	
  }	

  if (trim($_SESSION['e13']) != "Other") {
    $_SESSION['arr5'][12] = $_REQUEST['e13'];	
  } else {
  	$_SESSION['arr5'][12] = $_REQUEST['e13a'];	
  }	

  if (trim($_SESSION['e14']) != "Other") {
    $_SESSION['arr5'][13] = $_REQUEST['e14'];	
  } else {
  	$_SESSION['arr5'][13] = $_REQUEST['e14a'];	
  }	
}	


//------------------------------------------------------------------------------
function updCol6 ()
//------------------------------------------------------------------------------
{
    $_SESSION['arr6'][0] = $_REQUEST['e1']; 
    $_SESSION['arr6'][1] = $_REQUEST['e2'];
    $_SESSION['arr6'][2] = $_REQUEST['e10'];  
    $_SESSION['arr6'][9] = $_REQUEST['e3b'];
    $_SESSION['arr6'][3] = $_REQUEST['e4'];		
    $_SESSION['arr6'][4] = $_REQUEST['e5'];	
    $_SESSION['arr6'][5] = $_REQUEST['e6'];
    $_SESSION['arr6'][6] = $_REQUEST['e7'];	
    $_SESSION['arr6'][7] = $_REQUEST['e8'];
    $_SESSION['arr6'][8] = $_REQUEST['e9'];	     

//conditional based upon selection of other
  if (trim($_SESSION['e11']) != "Other") {
    $_SESSION['arr6'][10] = $_REQUEST['e11'];	
  } else {
  	$_SESSION['arr6'][10] = $_REQUEST['e11a'];	
  }	

  if (trim($_SESSION['e12']) != "Other") {
    $_SESSION['arr6'][11] = $_REQUEST['e12'];	
  } else {
  	$_SESSION['arr6'][11] = $_REQUEST['e12a'];	
  }	

  if (trim($_SESSION['e13']) != "Other") {
    $_SESSION['arr6'][12] = $_REQUEST['e13'];	
  } else {
  	$_SESSION['arr6'][12] = $_REQUEST['e13a'];	
  }	

  if (trim($_SESSION['e14']) != "Other") {
    $_SESSION['arr6'][13] = $_REQUEST['e14'];	
  } else {
  	$_SESSION['arr6'][13] = $_REQUEST['e14a'];	
  }	
}	



//------------------------------------------------------------------------------
function shifty ()
//------------------------------------------------------------------------------
{
	//this is the big ugly. but it does the job

  //i am needed to support canceling a new iv!!!
  $_SESSION['arr7'][0]  = 	$_SESSION['arr6'][0] ;
  $_SESSION['arr7'][1]  = 	$_SESSION['arr6'][1] ;
  $_SESSION['arr7'][2]  = 	$_SESSION['arr6'][2] ; 
  $_SESSION['arr7'][3]  = 	$_SESSION['arr6'][3] ;
  $_SESSION['arr7'][4]  = 	$_SESSION['arr6'][4] ;
  $_SESSION['arr7'][5]  = 	$_SESSION['arr6'][5] ; 
  $_SESSION['arr7'][6]  = 	$_SESSION['arr6'][6] ;
  $_SESSION['arr7'][7]  = 	$_SESSION['arr6'][7] ;
  $_SESSION['arr7'][8]  = 	$_SESSION['arr6'][8] ;
  $_SESSION['arr7'][9]  = 	$_SESSION['arr6'][9] ; 
  $_SESSION['arr7'][10] = 	$_SESSION['arr6'][10];
  $_SESSION['arr7'][11] = 	$_SESSION['arr6'][11];
  $_SESSION['arr7'][12] = 	$_SESSION['arr6'][12]; 
  $_SESSION['arr7'][13] = 	$_SESSION['arr6'][13];

  $_SESSION['arr6'][0]  = 	$_SESSION['arr5'][0] ;
  $_SESSION['arr6'][1]  = 	$_SESSION['arr5'][1] ;
  $_SESSION['arr6'][2]  = 	$_SESSION['arr5'][2] ; 
  $_SESSION['arr6'][3]  = 	$_SESSION['arr5'][3] ;
  $_SESSION['arr6'][4]  = 	$_SESSION['arr5'][4] ;
  $_SESSION['arr6'][5]  = 	$_SESSION['arr5'][5] ; 
  $_SESSION['arr6'][6]  = 	$_SESSION['arr5'][6] ;
  $_SESSION['arr6'][7]  = 	$_SESSION['arr5'][7] ;
  $_SESSION['arr6'][8]  = 	$_SESSION['arr5'][8] ;
  $_SESSION['arr6'][9]  = 	$_SESSION['arr5'][9] ; 
  $_SESSION['arr6'][10] = 	$_SESSION['arr5'][10];
  $_SESSION['arr6'][11] = 	$_SESSION['arr5'][11];
  $_SESSION['arr6'][12] = 	$_SESSION['arr5'][12]; 
  $_SESSION['arr6'][13] = 	$_SESSION['arr5'][13];

  $_SESSION['arr5'][0]  = 	$_SESSION['arr4'][0] ;
  $_SESSION['arr5'][1]  = 	$_SESSION['arr4'][1] ;
  $_SESSION['arr5'][2]  = 	$_SESSION['arr4'][2] ; 
  $_SESSION['arr5'][3]  = 	$_SESSION['arr4'][3] ;
  $_SESSION['arr5'][4]  = 	$_SESSION['arr4'][4] ;
  $_SESSION['arr5'][5]  = 	$_SESSION['arr4'][5] ; 
  $_SESSION['arr5'][6]  = 	$_SESSION['arr4'][6] ;
  $_SESSION['arr5'][7]  = 	$_SESSION['arr4'][7] ;
  $_SESSION['arr5'][8]  = 	$_SESSION['arr4'][8] ;
  $_SESSION['arr5'][9]  = 	$_SESSION['arr4'][9] ; 
  $_SESSION['arr5'][10] = 	$_SESSION['arr4'][10];
  $_SESSION['arr5'][11] = 	$_SESSION['arr4'][11];
  $_SESSION['arr5'][12] = 	$_SESSION['arr4'][12]; 
  $_SESSION['arr5'][13] = 	$_SESSION['arr4'][13];

  $_SESSION['arr4'][0]  = 	$_SESSION['arr3'][0] ;
  $_SESSION['arr4'][1]  = 	$_SESSION['arr3'][1] ;
  $_SESSION['arr4'][2]  = 	$_SESSION['arr3'][2] ; 
  $_SESSION['arr4'][3]  = 	$_SESSION['arr3'][3] ;
  $_SESSION['arr4'][4]  = 	$_SESSION['arr3'][4] ;
  $_SESSION['arr4'][5]  = 	$_SESSION['arr3'][5] ; 
  $_SESSION['arr4'][6]  = 	$_SESSION['arr3'][6] ;
  $_SESSION['arr4'][7]  = 	$_SESSION['arr3'][7] ;
  $_SESSION['arr4'][8]  = 	$_SESSION['arr3'][8] ;
  $_SESSION['arr4'][9]  = 	$_SESSION['arr3'][9] ; 
  $_SESSION['arr4'][10] = 	$_SESSION['arr3'][10];
  $_SESSION['arr4'][11] = 	$_SESSION['arr3'][11];
  $_SESSION['arr4'][12] = 	$_SESSION['arr3'][12]; 
  $_SESSION['arr4'][13] = 	$_SESSION['arr3'][13];
  
  $_SESSION['arr3'][0]  = 	$_SESSION['arr2'][0] ;
  $_SESSION['arr3'][1]  = 	$_SESSION['arr2'][1] ;
  $_SESSION['arr3'][2]  = 	$_SESSION['arr2'][2] ; 
  $_SESSION['arr3'][3]  = 	$_SESSION['arr2'][3] ;
  $_SESSION['arr3'][4]  = 	$_SESSION['arr2'][4] ;
  $_SESSION['arr3'][5]  = 	$_SESSION['arr2'][5] ; 
  $_SESSION['arr3'][6]  = 	$_SESSION['arr2'][6] ;
  $_SESSION['arr3'][7]  = 	$_SESSION['arr2'][7] ;
  $_SESSION['arr3'][8]  = 	$_SESSION['arr2'][8] ;
  $_SESSION['arr3'][9]  = 	$_SESSION['arr2'][9] ; 
  $_SESSION['arr3'][10] = 	$_SESSION['arr2'][10];
  $_SESSION['arr3'][11] = 	$_SESSION['arr2'][11];
  $_SESSION['arr3'][12] = 	$_SESSION['arr2'][12]; 
  $_SESSION['arr3'][13] = 	$_SESSION['arr2'][13];
  
  $_SESSION['arr2'][0]  = 	$_SESSION['arr1'][0] ;
  $_SESSION['arr2'][1]  = 	$_SESSION['arr1'][1] ;
  $_SESSION['arr2'][2]  = 	$_SESSION['arr1'][2] ; 
  $_SESSION['arr2'][3]  = 	$_SESSION['arr1'][3] ;
  $_SESSION['arr2'][4]  = 	$_SESSION['arr1'][4] ;
  $_SESSION['arr2'][5]  = 	$_SESSION['arr1'][5] ; 
  $_SESSION['arr2'][6]  = 	$_SESSION['arr1'][6] ;
  $_SESSION['arr2'][7]  = 	$_SESSION['arr1'][7] ;
  $_SESSION['arr2'][8]  = 	$_SESSION['arr1'][8] ;
  $_SESSION['arr2'][9]  = 	$_SESSION['arr1'][9] ; 
  $_SESSION['arr2'][10] = 	$_SESSION['arr1'][10];
  $_SESSION['arr2'][11] = 	$_SESSION['arr1'][11];
  $_SESSION['arr2'][12] = 	$_SESSION['arr1'][12]; 
  $_SESSION['arr2'][13] = 	$_SESSION['arr1'][13];   
	
}	

//------------------------------------------------------------------------------
function unshifty ()
//------------------------------------------------------------------------------
{
	//this is the big ugly. but it does the job

  //i am needed to support canceling a new iv!!!
  $_SESSION['arr1'][0]  = 	$_SESSION['arr2'][0] ;
  $_SESSION['arr1'][1]  = 	$_SESSION['arr2'][1] ;
  $_SESSION['arr1'][2]  = 	$_SESSION['arr2'][2] ; 
  $_SESSION['arr1'][3]  = 	$_SESSION['arr2'][3] ;
  $_SESSION['arr1'][4]  = 	$_SESSION['arr2'][4] ;
  $_SESSION['arr1'][5]  = 	$_SESSION['arr2'][5] ; 
  $_SESSION['arr1'][6]  = 	$_SESSION['arr2'][6] ;
  $_SESSION['arr1'][7]  = 	$_SESSION['arr2'][7] ;
  $_SESSION['arr1'][8]  = 	$_SESSION['arr2'][8] ;
  $_SESSION['arr1'][9]  = 	$_SESSION['arr2'][9] ; 
  $_SESSION['arr1'][10] = 	$_SESSION['arr2'][10];
  $_SESSION['arr1'][11] = 	$_SESSION['arr2'][11];
  $_SESSION['arr1'][12] = 	$_SESSION['arr2'][12]; 
  $_SESSION['arr1'][13] = 	$_SESSION['arr2'][13];

  $_SESSION['arr2'][0]  = 	$_SESSION['arr3'][0] ;
  $_SESSION['arr2'][1]  = 	$_SESSION['arr3'][1] ;
  $_SESSION['arr2'][2]  = 	$_SESSION['arr3'][2] ; 
  $_SESSION['arr2'][3]  = 	$_SESSION['arr3'][3] ;
  $_SESSION['arr2'][4]  = 	$_SESSION['arr3'][4] ;
  $_SESSION['arr2'][5]  = 	$_SESSION['arr3'][5] ; 
  $_SESSION['arr2'][6]  = 	$_SESSION['arr3'][6] ;
  $_SESSION['arr2'][7]  = 	$_SESSION['arr3'][7] ;
  $_SESSION['arr2'][8]  = 	$_SESSION['arr3'][8] ;
  $_SESSION['arr2'][9]  = 	$_SESSION['arr3'][9] ; 
  $_SESSION['arr2'][10] = 	$_SESSION['arr3'][10];
  $_SESSION['arr2'][11] = 	$_SESSION['arr3'][11];
  $_SESSION['arr2'][12] = 	$_SESSION['arr3'][12]; 
  $_SESSION['arr2'][13] = 	$_SESSION['arr3'][13];

  $_SESSION['arr3'][0]  = 	$_SESSION['arr4'][0] ;
  $_SESSION['arr3'][1]  = 	$_SESSION['arr4'][1] ;
  $_SESSION['arr3'][2]  = 	$_SESSION['arr4'][2] ; 
  $_SESSION['arr3'][3]  = 	$_SESSION['arr4'][3] ;
  $_SESSION['arr3'][4]  = 	$_SESSION['arr4'][4] ;
  $_SESSION['arr3'][5]  = 	$_SESSION['arr4'][5] ; 
  $_SESSION['arr3'][6]  = 	$_SESSION['arr4'][6] ;
  $_SESSION['arr3'][7]  = 	$_SESSION['arr4'][7] ;
  $_SESSION['arr3'][8]  = 	$_SESSION['arr4'][8] ;
  $_SESSION['arr3'][9]  = 	$_SESSION['arr4'][9] ; 
  $_SESSION['arr3'][10] = 	$_SESSION['arr4'][10];
  $_SESSION['arr3'][11] = 	$_SESSION['arr4'][11];
  $_SESSION['arr3'][12] = 	$_SESSION['arr4'][12]; 
  $_SESSION['arr3'][13] = 	$_SESSION['arr4'][13];

  $_SESSION['arr4'][0]  = 	$_SESSION['arr5'][0] ;
  $_SESSION['arr4'][1]  = 	$_SESSION['arr5'][1] ;
  $_SESSION['arr4'][2]  = 	$_SESSION['arr5'][2] ; 
  $_SESSION['arr4'][3]  = 	$_SESSION['arr5'][3] ;
  $_SESSION['arr4'][4]  = 	$_SESSION['arr5'][4] ;
  $_SESSION['arr4'][5]  = 	$_SESSION['arr5'][5] ; 
  $_SESSION['arr4'][6]  = 	$_SESSION['arr5'][6] ;
  $_SESSION['arr4'][7]  = 	$_SESSION['arr5'][7] ;
  $_SESSION['arr4'][8]  = 	$_SESSION['arr5'][8] ;
  $_SESSION['arr4'][9]  = 	$_SESSION['arr5'][9] ; 
  $_SESSION['arr4'][10] = 	$_SESSION['arr5'][10];
  $_SESSION['arr4'][11] = 	$_SESSION['arr5'][11];
  $_SESSION['arr4'][12] = 	$_SESSION['arr5'][12]; 
  $_SESSION['arr4'][13] = 	$_SESSION['arr5'][13];
  
  $_SESSION['arr5'][0]  = 	$_SESSION['arr6'][0] ;
  $_SESSION['arr5'][1]  = 	$_SESSION['arr6'][1] ;
  $_SESSION['arr5'][2]  = 	$_SESSION['arr6'][2] ; 
  $_SESSION['arr5'][3]  = 	$_SESSION['arr6'][3] ;
  $_SESSION['arr5'][4]  = 	$_SESSION['arr6'][4] ;
  $_SESSION['arr5'][5]  = 	$_SESSION['arr6'][5] ; 
  $_SESSION['arr5'][6]  = 	$_SESSION['arr6'][6] ;
  $_SESSION['arr5'][7]  = 	$_SESSION['arr6'][7] ;
  $_SESSION['arr5'][8]  = 	$_SESSION['arr6'][8] ;
  $_SESSION['arr5'][9]  = 	$_SESSION['arr6'][9] ; 
  $_SESSION['arr5'][10] = 	$_SESSION['arr6'][10];
  $_SESSION['arr5'][11] = 	$_SESSION['arr6'][11];
  $_SESSION['arr5'][12] = 	$_SESSION['arr6'][12]; 
  $_SESSION['arr5'][13] = 	$_SESSION['arr6'][13];
  
  $_SESSION['arr6'][0]  = 	$_SESSION['arr7'][0] ;
  $_SESSION['arr6'][1]  = 	$_SESSION['arr7'][1] ;
  $_SESSION['arr6'][2]  = 	$_SESSION['arr7'][2] ; 
  $_SESSION['arr6'][3]  = 	$_SESSION['arr7'][3] ;
  $_SESSION['arr6'][4]  = 	$_SESSION['arr7'][4] ;
  $_SESSION['arr6'][5]  = 	$_SESSION['arr7'][5] ; 
  $_SESSION['arr6'][6]  = 	$_SESSION['arr7'][6] ;
  $_SESSION['arr6'][7]  = 	$_SESSION['arr7'][7] ;
  $_SESSION['arr6'][8]  = 	$_SESSION['arr7'][8] ;
  $_SESSION['arr6'][9]  = 	$_SESSION['arr7'][9] ; 
  $_SESSION['arr6'][10] = 	$_SESSION['arr7'][10];
  $_SESSION['arr6'][11] = 	$_SESSION['arr7'][11];
  $_SESSION['arr6'][12] = 	$_SESSION['arr7'][12]; 
  $_SESSION['arr6'][13] = 	$_SESSION['arr7'][13];   
	
}	

?>
<!DOCTYPE html>
<html>
<head>
<!--  Author: Eric Matthews  -->
<!--  Description: Nursing Assessment - IV Access  !!!PROTOTYPE!!! -->	
<!--  License: Dual licensed under the MIT and GPL license  -->                               
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>jQuery treeView</title>
	
	<script src="jquery/jquery182.min.js"></script>
	<script type="text/javascript" src="jquery/jquery-ui191.js"></script>   
	<script src="jquery/jquery.cookie.js" type="text/javascript"></script>
	<script src="jquery/jquery.treeview.js" type="text/javascript"></script>
	<script src="jquery/jquery.dropdownPlain.js" type="text/javascript" ></script>
  <script src="jquery/ui.core16rc5.js" type=text/javascript></script>
  <script src="jquery/ui.tabs16rc5.js" type=text/javascript></script>

	<link rel="stylesheet" type="text/css" href="jquery/stylesheet/jquery.treeview.css" /> 	
  <link media="print, projection, screen" href="jquery/stylesheet/ui.tabs.css" type=text/css rel=stylesheet>
	<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" />   
	<link rel="stylesheet" type="text/css" media="screen" href="jquery/stylesheet/jquery-ui191.css">
	
<!-- JQuery nav functions -->
<script type="text/javascript">
$(document).ready(function(){

  $('#etabs> ul').tabs({ fx: { opacity: 'toggle' } });
		
	$("#navigation").treeview({
		collapsed: true,
		unique: true,
		persist: "location"
	});

	$("#browser").treeview({
		animated:"normal",
		persist: "cookie"
	});

	$("#red").treeview({
		animated: "fast",
		collapsed: true,
		control: "#treecontrol"
	});


       $(function() {        
           $( ".datepicker" ).datepicker();    
       });

   if ($('#e11').val() === "Other") {
     $('#e11a').fadeIn(50);
   } else {
   	 $('#e11a').fadeOut(50);
   }	  

   if ($('#e12').val() === "Other") {
     $('#e12a').fadeIn(50);
   } else {
   	 $('#e12a').fadeOut(50);
   }	
   
   if ($('#e13').val() === "Other") {
     $('#e13a').fadeIn(50);
   } else {
   	 $('#e13a').fadeOut(50);
   }	

   if ($('#e14').val() === "Other") {
     $('#e14a').fadeIn(50);
   } else {
   	 $('#e14a').fadeOut(50);
   }
   
});

   function showTb1(op) {
    if (op == "Other") { $('#e11a').fadeIn(50); } else { $('#e11a').fadeOut(50); }
   } 

   function showTb2(op) {
    if (op == "Other") { 
    	$('#e12a').fadeIn(50); } else { $('#e12a').fadeOut(50); 
    };
   }; 

   function showTb3(op) {
    if (op == "Other") { 
    	$('#e13a').fadeIn(50); } else { $('#e13a').fadeOut(50); 
    };
   }; 

   function showTb4(op) {
    if (op == "Other") { 
    	$('#e14a').fadeIn(50); } else { $('#e14a').fadeOut(50);	 
    };
   };    

// need to get vals for first three, right now just copy of ddm4
var syncDDM1 = new Array("", "LR", "NS", "D5LR", "D5NS20K", "NACL3%");
var syncDDM2 = new Array("", "LR", "NS", "D5LR", "D5NS20K", "NACL3%");
var syncDDM3 = new Array("", "LR", "NS", "D5LR", "D5NS20K", "NACL3%");
var syncDDM4 = new Array("", "LR", "NS", "D5LR", "D5NS20K", "NACL3%");

function getDDMvals() {
  var select_parent = document.form1.e3 ;
  var select_vals = document.form1.e3a;
  var parent_val = select_parent.options[select_parent.selectedIndex].value;

  select_vals.options.length=0;
  if (parent_val == "Normal Saline") {
    for(var i=0; i<syncDDM1.length; i++) {
    select_vals.options[select_vals.options.length] =  new Option(syncDDM1[i]);
    };
  };
  if (parent_val == "Dextrose 5%") {
    for(var i=0; i<syncDDM2.length; i++) {
    select_vals.options[select_vals.options.length] =  new Option(syncDDM2[i]);
    };
  };
  if (parent_val == "Cont Med Infusion") {
    for(var i=0; i<syncDDM3.length; i++) {
    select_vals.options[select_vals.options.length] = new Option(syncDDM3[i]);
    };
  };
  if (parent_val == "Chemo/Infusion")  {
    for(var i=0; i<syncDDM4.length; i++) {
     select_vals.options[select_vals.options.length] = new Option(syncDDM4[i]);
    };
  }; 
}; 
   
</script>
<!-- JQuery nav css -->
<style type="text/css">
<--
.treeview ul {
	background-color: white;
	margin-top: 0px;
	margin-left: 15px;
}

.treeview li { 
	padding: 3px 0pt 3px 0px;
	margin-bottom: -6px
}
.filetree li { padding: 0px 0 0px 6px; }
.filetree span.folder { background: url(images/folder.gif) 0 0 no-repeat; }
.filetree li.expandable span.folder { background: url(images/folder-closed.gif) 0 0 no-repeat; }
.filetree span.file { background: url(icons/x16/misc/blank_white1x2.jpg) 0 0 no-repeat; }
 
#nasIVAccess {
	position:absolute;
	width:713px;
	height:347px;
	z-index:4;
	left: 376px;
	top: 98px;	
}
#fldr {
	
}	
#clsfil {
	
}	
#nasIVAccessForm {
	position:absolute;
	width:353px;
	height:350px;
	z-index:5;
	left: 5px;
	top: 95px;
	text-align: right;
}
#pgTitle {
	position:absolute;
	width:334px;
	height:34px;
	z-index:6;
	margin-left: 15px;
	top: 85px;
}
table.assesstbl {
	width:646px;
	border-width: 1px;
	border-spacing: 5px;
	border-style: hidden;
	border-color: black;
	border-collapse: separate;
	background-color: white;
}	
table.assesstbl td {
	border-width: 1px;
	padding: 1px;
	border-style: outset;
	border-color: gray;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}	
table.assesstbl th {
	border-width: 1px;
	padding: 1px;
	border-style: outset;
	border-color: gray;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}	
p {
	font-family: arial;
	margin-right: 200px;
}	
-->
</style>
</head>
	<body>

<!--
Below is section where you implement the tabs. Add or subtract tabs as needed.
The tab name goes between the span tag.  
-->
<div id=etabs>
<ul>
  <li><a
  href="#tab-1"><span>IV Administration</span></a> 
  <li><a
  href="#tab-2"><span>IV Case Studies</span></a> 
  <li><a
  href="#tab-3"><span>Assignments/Study Questions</span></a> 
</ul>		


<div id="tab-1">		
<!-- Page Title -->
  <div id="pgTitle">
<h1>IV Administration</h1>	
  </div>
<!-- IV Access Form -->
    <div id="nasIVAccessForm">
<form name="form1" id="form1" method="get" action="nas_iv.php">

New IV/Change Bag
<ol style="list-style-type:none;">
  <li>
    <input name="e1" id="e1" class="datepicker" value="<?php echo $_SESSION['e1']; ?>" /> 
  </li>
</ol>
Time:
      <input name="e2" type="text" id="e2" size="5" /><br />
IV Type:
	    <select name="e10" id="e10">
        <option value="<?php echo $_SESSION['e10']; ?>" ><?php echo $_SESSION['e10']; ?></option>
 	      <option value="Hep Lock">Heparin Lock</option>
	      <option value="IV">IV</option>
 	      <option value="PAL">PAL</option>
        <option value="PICC">PICC</option>
 	      <option value="Saline Lock">Saline Lock</option> 
	      <option value="Sngl Lumen">Single Lumen</option>
 	      <option value="Dual Lumen">Dual Lumen</option>
        <option value="Trple Lumen">Triple Lumen</option>
 	      <option value="Other">Other</option> 	      
      </select><br />
IV:
	    <select name="e3" id="e3" onchange="getDDMvals()" >
        <option value="<?php echo $_SESSION['e3']; ?>"><?php echo $_SESSION['e3']; ?></option>
 	      <option value="Normal Saline">Normal Saline</option>
	      <option value="Dextrose 5%">Dextrose 5%</option>
 	      <option value="Cont Med Infusion">Cont Med Infusion</option>
        <option value="Chemo/Infusion">Chemo/Infusion</option>&nbsp;	      
      </select>
	    <select name="e3a" id="e3a">
        <option></option>     
      </select>     
    <br />
        <input name="e3b" type="text" id="e3b" size="20" value="<?php echo $_SESSION['e3a']; ?>" />
	  <br />
	  <hr />
Bag #:
	    <select name="e4" id="e4">
	      <option></option>
	      <option value="1">1</option>
	      <option value="2">2</option>
	      <option value="3">3</option>
	      <option value="4">4</option>
	      <option value="5">5</option>
	      <option value="6">6</option>
	      <option value="7">7</option>
	      <option value="8">8</option>
	      <option value="9">9</option>
	      <option value="10">10</option>
        </select><br />
Bag Volume:
	    <select name="e5" id="e5">
	      <option value="<?php echo $_SESSION['e5']; ?>"><?php echo $_SESSION['e5']; ?></option>
	      <option value="1000ml">1000ml</option>
	      <option value="500ml">500ml</option>
	      <option value="250ml">250ml</option>
	      <option value="100ml">100ml</option>
	      <option value="50ml">50ml</option>
        </select><br />
Rate (ml/hr):
	    <select name="e6" id="e6">
	      <option value="<?php echo $_SESSION['e6']; ?>"><?php echo $_SESSION['e6']; ?></option>
	      <option value="40">40</option>
	      <option value="60">60</option>
	      <option value="80">80</option>
	      <option value="100">100</option>
	      <option value="125">125</option>
	      <option value="150">150</option>
	      <option value="Bolus">Bolus</option> 
        </select><br />
Dose:
  <input name="e7" type="text" id="e7"  size="8" value="<?php echo $_SESSION['e7']; ?>" /><br />      
Dose (units):
        <select name="e8" id="e8">
	      <option value="<?php echo $_SESSION['e8']; ?>"><?php echo $_SESSION['e8']; ?></option> 
	      <option value="Mcg/Kg Min">Mcg/Kg Min</option>
	      <option value="Mcg/Min">Mcg/Min</option> 
	      <option value="Mg/KG Min">Mg/Kg Min</option> 
	      <option value="Mc/Min">Mc/Min</option> 
	      <option value="U/Hr">U/Hr</option>
	      <option value="Mg/Hr">Mg/Hr</option> 
	      <option value="Mcg/Hr">Mcg/Hr</option> 	      
        </select><br />
Fluid Vol Infused (ml):
	  <input name="e9" type="text" id="e9" size="6" value="<?php echo $_SESSION['e9']; ?>" /> <br />
Catheter Size:
	    <select name="e11" id="e11" onchange="showTb1(this.options[selectedIndex].text)">
	      <option value="<?php echo $_SESSION['e11']; ?>"><?php echo $_SESSION['e11']; ?></option>
	      <option value="12G">12G - 12 Gauge</option>
	      <option value="14G">14G - 14 Gauge</option>	      
	      <option value="16G">16G - 16 Gauge</option>
	      <option value="18G">18G - 18 Gauge</option>
	      <option value="20G">20G - 20 Gauge</option>
	      <option value="22G">22G - 22 Gauge</option>	      
	      <option value="24G">24G - 24 Gauge</option>	      
	      <option>Multilumen</option>	      
	      <option>Other</option>
      </select>&nbsp;<input name="e11a" type="text" id="e11a" size="15" value="<?php echo $_SESSION['e11a']; ?>" />
	  <br />
Location:
	    <select name="e12" id="e12" onchange="showTb2(this.options[selectedIndex].text)">
	      <option value="<?php echo $_SESSION['e12']; ?>"><?php echo $_SESSION['e12']; ?></option>
	      <option value="Rt Hand">Rt Hand</option>
	      <option value="Lt Hand">Lft Hand</option>
	      <option value="Rt Forearm">Rt Forearm</option>
	      <option value="Lt Forearm">Lft Forearm</option>
	      <option value="Rt Antecub">Rt Antecubital</option>
	      <option value="Lt Antecub">Lft Antecubital</option>
	      <option value="Rt Subclav">Rt Subclavian</option>
	      <option value="Lt Subclav">Lft Subclavian</option>
	      <option value="Rt int jug">Rt Internal Jugular</option>
	      <option value="Lt int jug">Lft Internal Jugular</option>
	      <option value="">Other</option>
      </select>&nbsp;<input name="e12a" type="text" id="e12a" size="15" value="<?php echo $_SESSION['e12a']; ?>" />
	  <br />
Site Condition:
	    <select name="e13" id="e13" onchange="showTb3(this.options[selectedIndex].text)">
	      <option value="<?php echo $_SESSION['e13']; ?>"><?php echo $_SESSION['e13']; ?></option>
	      <option value="WNL">Within Normal Limits</option>
	      <option value="Infiltr Present">Infiltration Present</option>
	      <option value="Occl">Occluded</option>
	      <option value="Phlebitis">Phlebitis</option>
	      <option value="Other">Other</option>
	      <option value="DC">Discountinued</option>
      </select>&nbsp;<input name="e13a" type="text" id="e13a" size="15" value="<?php echo $_SESSION['e13a']; ?>" />
	  <br />
Dressing Type:
	    <select name="e14" id="e14" onchange="showTb4(this.options[selectedIndex].text)">
	      <option value="<?php echo $_SESSION['e14']; ?>" ><?php echo $_SESSION['e14']; ?></option>
	      <option value="4x4">4x4</option>
	      <option value="Occlusive">Occlusive</option>
	      <option value="OTA">OTA - Open to air</option>	      	      
	      <option value="Other">Other</option>
      </select>&nbsp;<input name="e14a" type="text" id="e14a" size="15" value="<?php echo $_SESSION['e14a']; ?>" />
	    <br />
<input type="submit" name="addIV" value="NewIV" />&nbsp;&nbsp;&nbsp;
<input type="submit" name="delIV" value="CancelIV" />
<br /><br /> 
<input type="submit" name="updIV" value="UpdateIV" />&nbsp;&nbsp;&nbsp;
Col # (NOT Bag#):
	    <select name="ivcol" id="ivcol">
	      <option></option>
	      <option value="1">1</option>
	      <option value="2">2</option>
	      <option value="3">3</option>
	      <option value="4">4</option>
	      <option value="5">5</option>
	      <option value="6">6</option>
        </select><br />
<br /><br />
<input type="submit" name="resetIVform" value="ResetForm" />
</form>	
  </div>

<!--  IV Access Crosstab Data Grid -->
    <div id="nasIVAccess">
<ul id="browser" class="filetree">
		<li id="fldr"><span class="folder">IV Access</span>
			<ul id="clsfil">
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;">&nbsp;</td>
    <td  width="83" style="border-style: none;font-weight: bold;text-align:center;">1</td>
    <td  width="83" style="border-style: none;font-weight: bold;text-align:center;">2</td>
    <td  width="83" style="border-style: none;font-weight: bold;text-align:center;">3</td>
    <td  width="83" style="border-style: none;font-weight: bold;text-align:center;">4</td>
    <td  width="83" style="border-style: none;font-weight: bold;text-align:center;">5</td>
    <td  width="83" style="border-style: none;font-weight: bold;text-align:center;">6</td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;">&nbsp;</td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr1'][0]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr2'][0]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][0]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr4'][0]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][0]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr6'][0]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;">&nbsp;</td>
    <td  width="83" style="border-style: none;font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][1]; ?></td>
    <td  width="83" style="border-style: none;font-weight: bold;">&nbsp;<?php echo $_SESSION['arr2'][1]; ?></td>
    <td  width="83" style="border-style: none;font-weight: bold;">&nbsp;<?php echo $_SESSION['arr3'][1]; ?></td>
    <td  width="83" style="border-style: none;font-weight: bold;">&nbsp;<?php echo $_SESSION['arr4'][1]; ?></td>
    <td  width="83" style="border-style: none;font-weight: bold;">&nbsp;<?php echo $_SESSION['arr5'][1]; ?></td>
    <td  width="83" style="border-style: none;font-weight: bold;">&nbsp;<?php echo $_SESSION['arr6'][1]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">IV Type:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][2]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][2]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][2]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][2]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][2]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][2]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">IV:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][9]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][9]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][9]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][9]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][9]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][9]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Bag#:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][3]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][3]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][3]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][3]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][3]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][3]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Bag Vol:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][4]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][4]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][4]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][4]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][4]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][4]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Rate (ml/hr):&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][5]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][5]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][5]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][5]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][5]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][5]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Dose:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][6]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][6]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][6]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][6]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][6]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][6]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Dose Units:&nbsp;</td>
    <td  width="83" style="border-style: none;font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][7]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][7]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][7]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][7]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][7]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][7]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Vol Infused (ml):&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][8]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][8]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][8]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][8]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][8]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][8]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Catheter Size:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][10]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][10]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][10]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][10]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][10]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][10]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Location:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][11]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][11]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][11]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][11]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][11]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][11]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Site Condition:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][12]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][12]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][12]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][12]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][12]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][12]; ?></td>
  </tr>
</table>
				</span></li>
				<li><span class="file">
<table class="assesstbl">
  <tr>
    <td align="right" width="108" style="border-style: none;color: #390;">Dressing Type:&nbsp;</td>
    <td  width="83" style="font-weight: bold;">&nbsp;<?php echo $_SESSION['arr1'][13]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr2'][13]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr3'][13]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr4'][13]; ?></td>
    <td  width="83" style="border-style: none;">&nbsp;<?php echo $_SESSION['arr5'][13]; ?></td>
    <td  width="83" style="border-style: none;background-color:#CFF;">&nbsp;<?php echo $_SESSION['arr6'][13]; ?></td>
  </tr>
</table>
				</span></li>				
			</ul>
		</li>
</ul>
</div> 
<!-- end tab1 --> 
</div> 

<div id="tab-2">
<h1>IV Case Studies</h1>
<h2>Case Studies for Class Discussion</h2>
<h3>Case Study #1</h3>
<p>
Patient in ED received Vitamin K IV Push (10 mg IV); after which time the patient 
became unresponsive. A code was called and CPR attempted, however the patient expired. 
Initially thought to be an adverse drug reaction, however, after further analysis and 
a drug reference search it was realized that the drug should only be given via IV 
piggyback (prepared in the pharmacy) and also orally, subcutaneously or intramuscularly.	
</p>
<h3>Case Study #2</h3>
<p>
An insulin infusion was ordered and started pre-operatively on a patient going 
to the OR for a kidney  transplant. Post-op the patient was received in the ICU 
without the insulin infusion. Patient’s blood glucose was 443 mg/dl with other 
significant electrolyte abnormalities documented. Dialysis was reinstituted on 
patient, who required a lengthened ICU stay.	
</p>	
<h3>Case Study #3</h3>
<p>
Diabetic patient in ICU was receiving an IV of Regular Insulin 1unit/mLat a rate of 
10 units/hour titrated per sliding scale. Upon changing to a new bag of insulin, IV 
pump reset manually to clear prior totals and to enter the new volume to be infused. 
Shortly after the new bag was hung, a nurse noticed that the infusion pump was 
incorrectly set at 150 mL(i.e., 150 units) per hour. 	
</p>	
<h3>Case Study #4</h3>
<p>
Pharmacy prepared IV piggyback of alteplase innormal saline using a 250 mL 
viaflex bag removed150 mL of diluent to make final volumeof 100 mL.Label did 
not indicatethe finaltotal volume. Nurse read the 250 mL total volume on the 
viaflexbag and programmed the pump to deliver 25 mL/hour.Correct rate should 
have been 10 mL/hour.	
</p>	
<h3>Case Study #5</h3>
<p>
ER patient given heparin bolus then started on heparin infusion. Transferred 
to CCU where another MD ordered enoxaparin. Later, an on-call MD, unaware that 
the patient was receiving enoxaparin, re-ordered another heparin infusion. Nurse 
receiving MD call did not inform him of the patient’s other medications. Patient 
received both heparin and enoxaparin for 15 hours.	
</p>		
</div>
<!-- end tab2 --> 
<div id="tab-3">
<h1>NUR151 Nursing Theory and Science I</h1> 
<h2>IV Assessment/Administration Core Competencies - Tie Back to General Course Competencies</h2>
<ul>
<li>Demonstrate caring behaviors using therapeutic communication skills and techniques. (NUR151 #2)</li>
<li>Describe normal and abnormal assessment data related to care of clients with selected health alterations. (NUR151 #7)</li>
<li>Evaluate effects of nursing interventions during client care. (NUR151 #8)</li>
<li>Describe nursing interventions that provide basic care and comfort measures. (NUR151 #12)</li>
<li>Apply principles of safe medication administration for adult and geriatric clients. (NUR151 #15)</li>
<li>Calculate medication dosages safely and accurately. (NUR151 #16)</li>
<li>Apply elements of technology and information management to practice to include documentation, use of online databases, web-based enhancements, and library resources. (NUR151 #21)</li>
<li>Document client findings and conditions through recording and reporting. (NUR151 #22)</li>
</ul>	
<h2>Assignments</h2> 	
<h3>INTRAVENOUS THERAPY VENIPUNCTURE TECHNIQUE</h3>
<p>Upon completion of this learning unit the student should be able to:</p>
<h4>Knowledge Competencies</h4>
<p>Describe the proper technique for adult and pediatric intravenous therapy.</p>
<ul>
<li>Patient assessments</li>
<li>Proper authority</li>
<li>Patient preparation</li>
<li>Equipment assembly</li>
<li>Site selection</li>
<li>BSI precautions</li>
<li>Site selection</li>
<li>Venipuncture performance</li>
<li>Site maintenance</li>
<li>Documentation</li> 
</ul>
<h4>Performance Competencies</h4>
<p>Demonstrate on a mannequin or live model intravenous venipuncture technique for an adult and pediatric patients</p>
<ul>
<li>Patient assessments</li>
<li>Patient consent</li>
<li>Patient preparation</li>
<li>Equipment assembly</li>
<li>Site selection</li>
<li>BSI precautions</li>
<li>Site selection</li>
<li>Venipuncture performance</li>
<li>Site maintenance</li>
<li>Documentation</li>
</ul>


<h3>DRIP RATE CALCULATION</h3>
<h4>Knowledge Competencies</h4>
<ul>
<li>Describe how to convert pounds to kilograms using long division Explain how to convert cc/ml to liters, kg to grams, mg to micrograms</li>
<li>Explain how to calculate amount of medication to patient weight in a acute patient environment</li>
<li>Describe how to calculate physician orders to gtts per minute with macro, micro and blood pump administration sets</li>
<li>Describe the conversion process for a known dose of a medication on hand to desired dose</li>
</ul>
<h4>Performance Competencies</h4>
<ul>
<li>Demonstrate how to convert pounds to kilograms using long division and the three AM rule</li>
<li>Demonstrate how to convert cc/ml to liters, kg to grams, mg to micrograms</li>
<li>Calculate amount of medication to patient weight in a acute patient environment</li>
<li>Calculate physician orders to gtts per minute with macro, micro and blood pump administration sets</li>
<li>Convert known dose of a medication on hand to desired dose</li>
</ul>

<h3>MAINTENANCE OF INTRAVENOUS THERAPY</h3>
<h4>Knowledge Competencies</h4>
<ul>
<li>Describe the need to obtaining vital signs before and after application of the IV</li>
<li>Name three critical changes that occur from fluid administration and the associated changes in the patients vital signs</li> 
<li>Explain how and where to listen to breath sounds</li> 
<li>Identify the breath sounds</li> 
  <ul>
    <li>Rales</li> 
    <li>Rohchi</li> 
    <li>Wheezes</li> 
    <li>Absent breath sounds</li> 
  </ul>
<li>List three indication of fluid overload</li> 
<li>Describe three ways to confirm the patency of an IV</li> 
<li>List three reasons why an IV should be immediately discontinue an IV</li> 
<li>Explain how to correct the flow of an IV that has discontinued flowing</li> 
</ul>
<h4>Performance Competencies</h4>
<ul>
<li>Demonstrate the ability to obtain vital signs before and after application of the IV</li> 
<li>Recognize three critical changes that occur from fluid administration and the associated changes in the patients vital signs</li> 
<li>Demonstrate listening to breath sounds</li> 
<li>Demonstrate three ways to confirm the patency of an IV</li> 
<li>Perform the proper documentation of a IV administration</li> 
<li>Demonstrate how to correct the flow of an IV that has discontinued flowing</li> 
</ul>

<h2>General Study Questions</h2>
<form name="formelements" action="nas_iv_assignments.php" method="POST" >
<table width="500" border="0" cellspacing="2" cellpadding="3">
<!-- header -->
  
<!-- T/F Question -->
<tr><td>(1) &nbsp;PRN medication orders must include the reason for use of the drug.</td></tr>
<tr><td  width="500"><table width="450" border="0" cellspacing="5" cellpadding="0">
<tr><td width="50" scope="col">&nbsp;</td><td width="385" align="left" scope="col">true <input type="radio" name="rbtn1" value="a" <?php if ($_POST['rbtn1'] == "a") { echo " checked"; }   ?> />&nbsp;&nbsp;false <input type="radio" name="rbtn1" value="b" <?php if ($_POST['rbtn1'] == "b") { echo " checked"; }  ?>  />&nbsp;</td></tr>
</table></td></tr></td>
<tr><td id="answer1" name="answer1"><br /><br /></td></tr>
<input id="r1_ans" type="hidden" name="r1_ans" value="b">
<!-- end T/F Question -->

<!-- Multiple Choice Question -->
<tr><td>(2) A PRN order must also include</td></tr>
<tr><td><table width="450" border="0" cellspacing="5" cellpadding="0">
<tr><td width="50" scope="col">&nbsp;</td><td width="400" align="left" scope="col">
a. <input type="radio" name="rbtn2" value="a" <?php if ($_POST['rbtn2'] == "a") { echo " checked"; }  ?> />&nbsp;Reason for administration.<br >
b. <input type="radio" name="rbtn2" value="b" <?php if ($_POST['rbtn2'] == "b") { echo " checked"; }   ?> />&nbsp;Who can administer.<br />
c. <input type="radio" name="rbtn2" value="c" <?php if ($_POST['rbtn2'] == "c") { echo " checked"; }   ?> />&nbsp;An alternate medication if the first is not available.<br />
d. <input type="radio" name="rbtn2" value="d" <?php if ($_POST['rbtn2'] == "d") { echo " checked"; }   ?> />&nbsp;Physician Instructions<br />
e. <input type="radio" name="rbtn2" value="e" <?php if ($_POST['rbtn2'] == "e") { echo " checked"; }   ?> />&nbsp;All of the above<br />
<tr><td>
</table></td></tr>
<tr><td id="answer2" name="answer2"><br /><br /></td></tr>
<input id="r2_ans" type="hidden" name="r2_ans" value="b">
<!-- end Multiple Choice Question -->

<tr><td>(3) NPO refers to food, not to oral medications.</td></tr>  
<tr><td><table width="450" border="0" cellspacing="5" cellpadding="0">
<tr><td width="50" scope="col">&nbsp;</td><td width="385" align="left" scope="col">true <input type="radio" name="rbtn3" value="a" <?php if ($_POST['rbtn3'] == "a") { echo " checked"; }   ?> />&nbsp;&nbsp;false <input type="radio" name="rbtn3" value="b" <?php if ($_POST['rbtn3'] == "b") { echo " checked"; }  ?>  />&nbsp;</td></tr>
</table></td></tr>
<tr><td id="answer3" name="answer3"><br /><br /></td></tr>
<input id="r3_ans" type="hidden" name="r3_ans" value="b">

<!-- Fill-in Question -->
<tr><td>(4) What are some factors on choosing an IV</td></tr>
<tr><td><table width="450" border="0" cellspacing="5" cellpadding="0">
<tr><td width="50" scope="col">&nbsp;</td><td width="385" align="left" scope="col"><textarea name="rbtn4" id="rbtn4" cols="45" rows="5"></textarea></td></tr>
</table></td></tr><tr>
<tr><td id="answer4" name="answer4"><br /><br /></td></tr>
<input id="r4_ans" type="hidden" name="r4_ans" value="b">

    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>   
</table>

<br />
<p><input type="submit" value="Done" name="environassessmnt"></p>
</form>

</div>
<!-- end tab3 -->  
	</body></html>