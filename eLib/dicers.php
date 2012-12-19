<?php
/*
Intial Writing: Eric Matthews
general file library code

Purpose: This is a slicer and dicer for the various recordset api's. There are
a number of reasons to have such an animal. A few are ...
- Ability to further filter the rs about either the vertical or horizonal
  dimensions (mostly the horizontal). Horizonal data dicing allows better 
  use of a resultset against a grid control and a chart without requiring a
  second query. Can also promote other reuse of a recordset, though this is
  usually very overrated as the recordset is highly predicated on the row
  restriction.
- Convert recordset data type. Most obvious use is to convert the trrow array
  into a string for binding with the grid control.  
*/

function change_delimiter($iarr,$delimf,$delimt)
{
	$oarr = $iarr;

  $rscnt = count($oarr);
  for ($i=0; $i < $rscnt; $i++)
  {
// note to self. will need to conditionally determine if one char to use [], 
// but needs to be naked for more complext delim strings
	  $oarr[$i] = preg_replace("/[$delimf]/",$delimt,$oarr[$i]);
  }	
	return $oarr;
}	

function convert_array_toString($rowsep,$iarr)
{
	$convstr = implode($rowsep,$iarr);
	
	return $convstr;
}	

function delimToTrrow($colsep,$iarr)
{
  $trrow = "";
	
	return $trrow;
}

// note regarding $colist 0 equals the first column. 
function delimColDicer($iarr,$colist,$iDelim)
{
  $newiarr = $iarr;
  $retiarr = array();
  $iarr_cnt = count($iarr);
  $tststr = "";
  $colst = explode(",",$colist); //create array from desired collist, delim always a comma
  $colstcnt = count($colst);
  for ($i=0; $i < $iarr_cnt; $i++)  //process each row in array
  {
    //$tststr .= $newiarr[$i] . "<br />";
    $tmpprocarr = explode($iDelim,$newiarr[$i]);  //dump cols to array 
    $tmparrcnt = count($tmpprocarr);
     $retarrcntr = 0;
     $tmprowstr = '';
     // amusing little loop where we process each rows columns against the desired list 
      for ($ii=0; $ii < $colstcnt; $ii++) 
      {
        if ($ii != ($colstcnt - 1))
        {
         $tmprowstr .= $tmpprocarr[$colst[$ii]] . $iDelim; //fetch element in $tmpprocarr
        }
        // this would be the last element in the array
        else if ($ii == ($colstcnt - 1)) 
        {
          // i considered error handling against an out of bound list element here,
          // but since this is a developers api i did not want to obfuscate their attempts
          // to troubeshoot their problems by adding such trapping correction logic
          // if last element is out of bound the symptoms will be a delimiter at the end
          // of the array element string
        	$tmprowstr .= $tmpprocarr[$colst[$ii]];
          array_push($retiarr,$tmprowstr);
        }	 
      }	
  }  

	//return $tststr;  
	//return $newiarr;
	return $retiarr;
}

?>
