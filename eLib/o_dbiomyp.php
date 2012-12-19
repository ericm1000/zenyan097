<?php
/*
Initial Writing: Eric Matthews
Date: Mar 23rd, 2008
*/
class dbiomyp
{

	public $host = "";
	public $db = "";	   
	public $logon = "";
	public $password = ""; 
	public $delimsymb = "";

//---------------------------------------------------------------------------//
function dbwrite($sqlstmt)
//---------------------------------------------------------------------------//
{
	//echo "sql is " . $sqlstmt;
  $handle = mysql_connect($this->host,$this->logon,$this->password);
  $db = mysql_select_db($this->db);
  $result = mysql_query($sqlstmt, $handle);
  return $result;
}


//---------------------------------------------------------------------------//
function dbread($sqlstmt,$outBufTyp)
//---------------------------------------------------------------------------//
/*
INPUT ARGS
$sqlstmt   - Valid SQL Select statement
$outBufTyp - Return buffer type 
Return the following buffer types
// * = coded
   Buffer type RetTyp Input arg         Return Struct  Notes
   ----------- ------ ----------------  -------------  ----------------------------
  *Delimited   Plural 'delim'  					Array          (default) data only
  *Delimited   Plural 'delim2'          Array          data, first elem = col name
  *Delimited   Plural 'delim3'          String         delimited, newline as row seperator
  *2D Array    Plural 'delim4'  				Array          2D Array, data only  
  *Html TR     Plural 'trrow'           Array          used for grid control, returns html table tr stub 
   Html UL     Plural 'tree'            String         used for tree control, returns html ul stub     
  *Hash        Sngltn 'hash'            Assoc Array    Key/Value hash key=col val=data
   Hash        Sngltn 'kvp'             Array          Key/Value pair         
*/
{  
 $handle = mysql_connect($this->host,$this->logon,$this->password);
 $this->db = mysql_select_db($this->db);
 
 if (rtrim($outBufTyp) == 'delim')
 {
 	 $recset = dbiomyp::delimBuffer($sqlstmt,$handle);
 }
 else if (rtrim($outBufTyp) == 'delim2')
 {
 	 $recset = dbiomyp::delimBuffer2($sqlstmt,$handle);
 }
 else if (rtrim($outBufTyp) == 'delim3')
 {
 	 $recset = dbiomyp::delimBuffer3($sqlstmt,$handle);
 }
 else if (rtrim($outBufTyp) == 'delim4')
 {
 	 $recset = dbiomyp::delimBuffer4($sqlstmt,$handle);
 } 
 else if (rtrim($outBufTyp) == 'hash')
 {
 	 $recset = dbiomyp::singletonHash($sqlstmt,$handle);
 }
 else if (rtrim($outBufTyp) == "trrow")
 {
 	 //$recset = delimBuffer2($sqlstmt,$handle);   
   $recset = dbiomyp::trBuffer($sqlstmt,$handle);	
 }  	 	
 else
 {
 	 $recset = "cannot process query request";
 }	
 
 return $recset;
} 

//---------------------------------------------------------------------------//
function delimBuffer($query,$handle)
//---------------------------------------------------------------------------//
{
 $rs='';
 $rarr='';
 $rownum = 0;
 $result = mysql_query($query, $handle);  
 $rowcnt =  mysql_num_rows($result);
 //echo "#Rows= " . $rowcnt . "\n";
 $colcnt =  mysql_num_fields($result);
 //echo "#Columns= " . $colcnt . "\n";
 //echo "Recordset by Conventional Array\n";
 while($row = mysql_fetch_array($result, MYSQL_NUM))
 {
   for ($i=0; $i < $colcnt; $i++)
   {
     if ($i == ($colcnt-1)) 
     { 
     	$rs .= $row[$i] . "\n";
     	$rarr[$rownum++] = $rs;
     	$rs = "";
     }
     else 
     { 
     	$rs .= $row[$i] . $this->delimsymb;
     }  
  }                              
 }	 	 	 

 return $rarr;
}

//---------------------------------------------------------------------------//
function delimBuffer2($query,$handle)
//---------------------------------------------------------------------------//
{
 $rs='';
 $rarr='';
 $rownum = 0;
//extract fields from query, add as elem 0 in array
if (preg_match("/^\s*select\s+(.+)\s+from/i", $query, $matches)) 
{
    $fields =  split(",", $matches[1]);
    $cnt = count($fields);
    $fieldstring = '';
    for($z=0;$z<$cnt;$z++)
    {
     if ($z	!= ($cnt - 1 ))
     { 
    	$fieldstring .= $fields[$z] . "|";
     }
     else
     {
     	$fieldstring .= $fields[$z];
     }		
    }
    //echo $fieldstring . "<br />";
    $rarr[$rownum++] = $fieldstring;
}      
 //echo $rarr[0] . "<br />"; 
 //echo $rownum . "<br />"; 
 $result = mysql_query($query, $handle);  
 $rowcnt =  mysql_num_rows($result);
 //echo "#Rows= " . $rowcnt . "\n";
 $colcnt =  mysql_num_fields($result);
 //echo "#Columns= " . $colcnt . "\n";
 while($row = mysql_fetch_array($result, MYSQL_NUM))
 {
   for ($i=0; $i < $colcnt; $i++)
   {
     if ($i == ($colcnt-1)) 
     { 
     	$rs .= $row[$i] . "\n";
     	$rarr[$rownum++] = $rs;
     	$rs = "";
     }
     else 
     { 
     	$rs .= $row[$i] . $this->delimsymb;
     }  
  }                              
 }	 	 	 

 return $rarr;
}		


//---------------------------------------------------------------------------//
function delimBuffer3($query,$handle)
//---------------------------------------------------------------------------//
{
 $rs='';
 $result = mysql_query($query, $handle);  
 $rowcnt =  mysql_num_rows($result);
 //echo "#Rows= " . $rowcnt . "\n";
 $colcnt =  mysql_num_fields($result);
 //echo "#Columns= " . $colcnt . "\n";
 //echo "Recordset by Conventional Array\n";
 while($row = mysql_fetch_array($result, MYSQL_NUM))
 {
   for ($i=0; $i < $colcnt; $i++)
   {
     if ($i == ($colcnt-1)) 
     { 
     	$rs .= $row[$i] . "\n"; 
     }
     else 
     { 
     	$rs .= $row[$i] . $this->delimsymb;
     }  
  }                              
 }	 	 	 

 return $rs;
}

//---------------------------------------------------------------------------//
function delimBuffer4($query,$handle)
//---------------------------------------------------------------------------//
{
 $rs='';
 $rarr='';
 $rownum = 0;
 $result = mysql_query($query, $handle);  
 $rowcnt =  mysql_num_rows($result);
 //echo "#Rows= " . $rowcnt . "\n";
 $colcnt =  mysql_num_fields($result);
 //echo "#Columns= " . $colcnt . "\n";
 while($row = mysql_fetch_array($result, MYSQL_NUM))
 {
   for ($i=0; $i < $colcnt; $i++)
   {
     $rarr[$rownum][$i] = $row[$i];  
   } 
   $rownum++;                            
 }	 	 	 
 return $rarr;
}

//---------------------------------------------------------------------------//
function singletonHash($query,$handle)
//---------------------------------------------------------------------------//
{
   $result = mysql_query($query, $handle);  
   return $result;
}

//---------------------------------------------------------------------------//
function trBuffer($query,$handle)
//---------------------------------------------------------------------------//
{
 $rs='';
 $rarr=array();
 $idnum = 1;
 $rownum = 0;
 $result = mysql_query($query, $handle);  
 $rowcnt =  mysql_num_rows($result);
 //echo "#Rows= " . $rowcnt . "\n";
 $colcnt =  mysql_num_fields($result);
 //echo "#Columns= " . $colcnt . "\n";
 while($row = mysql_fetch_array($result, MYSQL_NUM))
 {
   $tmpvar = "<tr id='a";
   $tmpvar .= $idnum++;
   $tmpvar .= "'>";
   for ($i=0; $i < $colcnt; $i++)
   {
     if ($i == ($colcnt-1)) 
     { 
     	$tmpvar .= "<td>" .  $row[$i] . "</td></tr>" . "\n";
     }
     else 
     { 
     	$tmpvar .= "<td>" .  $row[$i] . "</td>" ;
     }  
  } 
  array_push($rarr,$tmpvar);                             
 }	 	 	 

 return $rarr;
}

}	      

?>
