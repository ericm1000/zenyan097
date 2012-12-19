<?php
/* 
Initital Writing: Eric Matthews
adapted from my code base aka 'zenyan'
Date: Jan 2nd, 2009
*/
class dbiox
{
	public $odbcname = "";   
	public $logon = "";
	public $password = ""; 
	public $delimsymb = "";


//---------------------------------------------------------------------------//
function dbread($sqlstmt,$outBufTyp)
//---------------------------------------------------------------------------//
/*
INPUT ARGS
$sqlstmt   - Valid SQL Select statement
$outBufTyp - Return buffer type 
Return the following buffer types
   Buffer type  Input arg         Return Struct  Notes
   -----------  ----------------  -------------  ----------------------------
   Delimited    blank or 'delim'  Array          (default) data only
   Delimited    'delim2'          Array          data, first elem = col name
   Delimited    'delim3'          String         delimited, newline as row seperator
   Raw Data     'raw'             String         raw data
   Hash         'hash'            Assoc Array 
   Html TR      'trrow'           Array          used for grid control, returns html table tr stub
   Html TR      'trrowconcat'     Array          used for grid control, does not add new line
   Xml          'xml'             String         [currently not coded]             
*/
{  
	$rslt = "";                    
  $conn = odbc_connect($this->odbcname,$this->logon,$this->password);
  
  if ($conn) 
  {
   $okay = odbc_exec($conn, $sqlstmt);

   if ($outBufTyp == "" or $outBufTyp == "delim")
   {  
    $rslt = dbiox::delimBuffer($okay);
   }
   else if  ($outBufTyp == "delim2")
   {
    $rslt = dbiox::delimBuffer2($okay);	
   }	  
   else if  ($outBufTyp == "delim3")
   {
    $rslt = dbiox::delimBuffer3($okay);	
   }
   else if  ($outBufTyp == "raw")
   {
    $rslt = dbiox::getRawData($okay);	
   }   
   else if  ($outBufTyp == "hash")
   {
    $rslt = dbiox::hashBuffer($okay);	
   }   	
   else if  ($outBufTyp == "xml")
   {
    $rslt = dbiox::xmlBuffer($okay);	
   } 
   else if  ($outBufTyp == "trrow")
   {
    $rslt = dbiox::trBuffer($okay);	
   } 
   
   else if  ($outBufTyp == "trrowconcat")
   {
    $rslt = dbiox::trBufferconcat($okay);	
   }            

//cleanup  
   odbc_free_result($okay);
   odbc_close($conn); 
  
   return $rslt;
  } 
  
  else 
  {
    return 'could not connect';
  }
  
} //end fcn

//---------------------------------------------------------------------------//
function dbwrite($sqlstmt)
//---------------------------------------------------------------------------//
/*
INPUT ARGS
$sqlstmt   - Valid SQL Delete, Update, Insert statement
Returns status of the operation in case caller care or for error handling           
*/
{ 	                          
  $conn = odbc_connect($this->odbcname,$this->logon,$this->password);
  
  if ($conn) 
  {
   $okay = odbc_exec($conn, $sqlstmt);   

//cleanup  
   odbc_free_result($okay);
   odbc_close($conn); 

   return "data updated";
  }
 
  else 
  {
    return 'could not connect';
  }
}

//---------------------------------------------------------------------------//
function dbwrite2($sqlstmt)
//---------------------------------------------------------------------------//
/*
INPUT ARGS
$sqlstmt   - Valid SQL Delete, Update, Insert statement
Returns status of the operation in case caller care or for error handling           
*/
{	                          
  $conn = odbc_connect($this->odbcname,$this->logon,$this->password);
  
  if ($conn) 
  {
   $okay = odbc_exec($conn, $sqlstmt);   

//cleanup  
   odbc_free_result($okay);
   odbc_close($conn); 
   $retval = odbc_error();
   return $retval;
  }
 
  else 
  {
    return 'could not connect';
  }
}


//---------------------------------------------------------------------------//
function delimBuffer($recset)
//---------------------------------------------------------------------------//
{
 $numcols = odbc_num_fields($recset);
 $delimarr = array(); 
  while (odbc_fetch_row($recset)) 
  {
  	$i = 1;
  	$tmpvar = "";
  	while ($i <= $numcols)
    {
    	if ($i == $numcols)
    	{
     		$tmpvar .= odbc_result($recset,$i++);	  //last col		
    	}
    	else
    	{
    		$tmpvar .= odbc_result($recset,$i++) . $this->delimsymb;	
    	}		  	
    } 
    array_push($delimarr,$tmpvar);
  }	
	return $delimarr;
}	

//---------------------------------------------------------------------------//
function delimBuffer2($recset)
//---------------------------------------------------------------------------//
{
 $numcols = odbc_num_fields($recset);
 $delimarr3 = array(); 
 $delimarr2 = array(); 
 $delimarr  = array(); 

//get column names push to array 
 $getcolnames = dbiox::getColumnNames($recset);
 array_push($delimarr2,$getcolnames);
//get data row concatenate returned array   
 $delimarr3 = dbiox::delimBuffer($recset);

 
 $delimarr = array_merge($delimarr2, $delimarr3);

  
	return $delimarr;
}	

//---------------------------------------------------------------------------//
function getColumnNames($recset)
//---------------------------------------------------------------------------//
{
 $numcols = odbc_num_fields($recset);
 $delimstr = ""; 
    $i = 1;
  	while ($i <= $numcols)
    {
    	if ($i == $numcols)
    	{
     		$delimstr .= odbc_field_name($recset,$i++);	  //last col		
    	}
    	else
    	{
    		$delimstr .= odbc_field_name($recset,$i++) . $this->delimsymb;	
    	}		  	
  }	
	return $delimstr;
}	

//---------------------------------------------------------------------------//
function getRawData($recset)
//---------------------------------------------------------------------------//
{
$numcols = odbc_num_fields($recset);
$delimstr=" "; 
  while (odbc_fetch_row($recset)) 
  {
  	$i = 1;
  	while ($i <= $numcols)
    {  	
      if ($i == $numcols)
      {
       $delimstr .= odbc_result($recset,$i++) . "\n";  //last col
      } 
      else
      {
       $delimstr .= odbc_result($recset,$i++ . "\n");	
      }	
    } 
  }	
	return $delimstr;
}	


//---------------------------------------------------------------------------//
function delimBuffer3($recset)
//---------------------------------------------------------------------------//
{
$numcols = odbc_num_fields($recset);
$delimstr=" "; 
  while (odbc_fetch_row($recset)) 
  {
  	$i = 1;
  	while ($i <= $numcols)
    {  	
      if ($i == $numcols)
      {
       $delimstr .= (odbc_result($recset,$i++) . "\n");  //last col
      } 
      else
      {
       $delimstr .= (odbc_result($recset,$i++) . $this->delimsymb);	
      }	
    } 
  }	
	return $delimstr;
}	

//---------------------------------------------------------------------------//
static function xmlBuffer($recset)
//---------------------------------------------------------------------------//
{
	return "function not currently implemented";
}	


//---------------------------------------------------------------------------//
static function hashBuffer($recset)
//---------------------------------------------------------------------------//
{
 $numcols = odbc_num_fields($recset);
 $hasharr = ''; 
  while (odbc_fetch_row($recset)) 
  {
    $hasharr = '';
  	$i = 1;
  	while ($i <= $numcols)
    { 
        $hasharr[odbc_field_name($recset,$i)] = odbc_result($recset,$i)	;	
        $i++;
    } 
  }	
	return $hasharr;

}


//---------------------------------------------------------------------------//
function trBuffer($recset)
//---------------------------------------------------------------------------//
{
 $numcols = odbc_num_fields($recset);
 $delimarr = array(); 
 $idnum = 1;
  while (odbc_fetch_row($recset)) 
  {
  	$i = 1;
  	$tmpvar = "<tr id='";
  	$tmpvar .= $idnum++;
  	$tmpvar .= "'>";
  	while ($i <= $numcols)
    {
    	if ($i == $numcols)
    	{
     		$tmpvar .=  "<td>" . trim(odbc_result($recset,$i++)) . "</td></tr>" . "\n";	  //last col		
    	}
    	else
    	{
    		$tmpvar .=  "<td>" . trim(odbc_result($recset,$i++)) . "</td>";	
    	}		  	
    } 
    array_push($delimarr,$tmpvar);
  }	
	return $delimarr;
}	

  
//---------------------------------------------------------------------------//
function trBufferconcat($recset)
//---------------------------------------------------------------------------//
{
 $numcols = odbc_num_fields($recset);
 $delimarr = array(); 
 $idnum = 1;
  while (odbc_fetch_row($recset)) 
  {
  	$i = 1;
  	$tmpvar = "<tr id='";
  	$tmpvar .= $idnum++;
  	$tmpvar .= "'>";
  	while ($i <= $numcols)
    {
    	if ($i == $numcols)
    	{
     		$tmpvar .=  "<td>" . trim(odbc_result($recset,$i++)) . "</td>" ;	  //last col		
    	}
    	else
    	{
    		$tmpvar .=  "<td>" . trim(odbc_result($recset,$i++)) . "</td>";	
    	}		  	
    } 
    array_push($delimarr,$tmpvar);
  }	
	return $delimarr;
}

}	
?>
