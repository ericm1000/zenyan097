<?php
/* 
This is an inline handler template for zenyan.
This handlers login is based upon account access input, and presumes that the
account selection is coming in via our account selection grid in a request
variable named $_REQUEST['lookupkey'] 
--
you can remove this text in your reuse. instead of a workflow handler that 
services all commands (which certainly has a place in design) this is an inline
handler specific to a command workflow. While this may on face value seem to
be a monolithic and a typical approach based upon conventional wisdom (which 
tends to be black & white, inflexible, based on current fashion, and not always
so wise) this approach is one that is based upon function portability, and 
better lends itself to software scalability. The notion of reuse of this type of
infrastructure is vastly overrated. Management of common code spread among 
monolithic programs if properly done can be easily managed using regular 
expressions. Also, other sourcing techniques can be utilized to manage generic
segments of code.

I have employed both types of implementation and frankly both are viable and 
necessary and appropriately implemented given the development scenario one 
faces. I can say from a great deal of practical experience that this method 
works best for situations where code customization is high, and where the coded
function points to be implemented is highly variable among enterprises.

using the template:
These notes are rather scant and assume you can do a great deal of reading
between the lines in terms of implementation of this template for you own use.
I do not wish to imply if you do not get it that it is your problem or you are
in some way deficient. Assume the deficiency is on my end. Ask your questions
directly to me and I will answer them.

* determine_wf() function takes a conventional array as an argument and returns
  to the caller the workflow array. this is necessary in order to accomodate an
  infinite variety of workflow scenarios
* It is presumed that the user of the template is 100% responsible for array
  unwinding and processing logic for both the call and the return. 

--

// Initial Writing: eric matthews
// Date: oct 22, 2010
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

 $_SESSION['oldebug'] = "";
 $_SESSION['tmp'] = $debugapp;
 $mtd = "";
 $status = '';
 $logonerror = '';
 $myDbgateway = new dbgateway;
 
 // input hash -- common vals
 $ih['acctnbr'] = "";
 $ih['accttyp'] = ""; 
 $ih['patpk'] = "";
 $ih['procflag'] = "";   
// add your kv pairs where applicable in this code

 // output hash -- common vals
 $oh['retmsg'] = ""; 
 $oh['errormsg'] = ""; //DO NOT set me unless there is an error you need to 
                       //handle by the caller!
 $oh['statusflag'] = "";
 $oh['callerprog'] = "patacctselchrginq.php";  // name of calling prog  
 $callerprog = $oh['callerprog'];
 $oh['callprog'] = "patacctselchrginq.php";    // set as default to be safe
// add your kv pairs in function determine_wf()

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

//figure out workflow
   $ih['acctnbr'] = $_REQUEST['lookupkey'];
   $ih['accttyp'] = $_REQUEST['accttype'];
//   $_SESSION['oldebug'] .= $ih['accttyp'] . "<br />";

//Note you may need to relocate logging code based once coded

   
   if (is_numeric($ih['acctnbr']))
   {
     if($oh['errormsg'] == '')
     {
       $oh = determine_wf($ih);
       $dest = $oh['callprog'];
       $_SESSION['loginerr'] = '';
       $_SESSION['prog'] = ''; //trust no one
       $_SESSION['prog'] = 'TEMPLATE_Handler.php'; //me
       archiveLog(' ',' ',$_SESSION['prog']);  
   	   header("Location: $dest");
   	 }
   	 else
   	 {
   	 	 //do your error handling here
   	 }	  
   }
   else	{ 
   	      $_SESSION['prog'] = ''; //trust no one
          $_SESSION['prog'] = 'TEMPLATE_Handler.php'; //me
          archiveLog(' ',' ',$_SESSION['prog']);    
   	      header("Location: $callerprog"); }
 

//----------------------------------------------------------------------------//
function determine_wf($ihsh)
//----------------------------------------------------------------------------//
{
  global $oh;
  global $myDbgateway;
/* 
// db access code in case you need it
  $query = "";
  //Execute Query
  $rs = $myDbgateway->readSQL($query,"hash");
*/

// logic to unwind input hash and create output hash goes here
   if ($ihsh['accttyp'] == 'A' or
       $ihsh['accttyp'] == 'E' or
       $ihsh['accttyp'] == 'I' or
       $ihsh['accttyp'] == 'O' or
       $ihsh['accttyp'] == 'T' 
                                 )
   {
     $oh["callprog"] = "dummyA.php";
   }
   else if ($ihsh['accttyp'] == 'C' or
            $ihsh['accttyp'] == 'S'
                                      )
   {
     $oh['callprog'] = "dummyB.php";  
   }                              

	return $oh;
}	


?>
