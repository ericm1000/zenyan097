<?php

//         Version:  1.10                                                         
//            Date:  2009-12-01                                                          
// Initial Writing:  Eric Matthews
//         Purpose:  Misc functions for both logging at runtime and development
//                   time debugging.
//  Note: I recently decoupled the logging functions from the applib library to 
//  create this as a seperate function for better segregation and to reduce 
//  baggage.
                  

$logapp = '';
$debugapp = '';
$lustatus = '';        

function getLogCurrDateTime() {$currdate = date('Y-m-d h:m:s'); return $currdate;}	

function eAppLog($dWrite)
{
 global $logapp;
 if ($logapp != '')
 {
  $currdte = getLogCurrDateTime();
  $logentity =  ("\n" . $currdte . "|" . $dWrite);
  $eLogFile = "\\webroot\\public_html\\zenyan097\\eLog\\applog.txt";
  $fh = fopen($eLogFile, 'a') or die("can't open file");
  fwrite($fh,$logentity);
  fclose($fh); 
 } 
}

function eDebugLog($dWrite)
{
 global $debugapp;
 if ($debugapp != '')
 {
  $currdte = getLogCurrDateTime();
  $logentity =  "\n";
  $logentity .= $currdte;
  $logentity .= "\n"; 
  $logentity .= $dWrite;
  $logentity .=  "--------------";
  $logentity .= "\n"; 
  $debuglog = "eLog\debuglog.txt";
  $fh = fopen($debuglog, 'a') or die("can't open file");
  fwrite($fh,$logentity);
  fclose($fh);
 } 
}

?>
