<?php 
                                                                         
//         Version:  0.90                                                         
//            Date:  2009-12-01, updated 2010-3-16                                                         
// Initial Writing:  Eric Matthews
//         Project:  Part of DataMiner Infrastructure
//         Purpose:  This is both a wrapper for PhpExcel, and a binder that 
//                   takes the results of a query from the dbios api and
//                   produces an excel spreadsheet. The input argument for 
//                   this is an instance of the excelWrapper class.
//                   this api in conjunction with the wrapper class is 
//                   quite extensible.                                             

require($php_dbiox); 
 
 $rowone = "";
 $rscnt = "";

$odbcnamexls = "";
$logonxls = "";
$passwordxls = "";
$delimsymbxls = "|";

//set to null for production use
 $logapp = 'y'; //set to null for production use
//set to null for production use

function genXLS($excelParms)
{
  global $rowone;
  if ($excelParms->rowoneAggFlg != '')
  {
  	$rowone = 'y';
  }	
	$seltest = getSQLQuery($excelParms->qry);
	$xlsobj = createXlsFromQry($excelParms,$seltest);
}	

//------------------------------------------------------------------------------

function createXlsFromQry($xls,$seltest)
{
  global $rscnt;
  global $odbcnamexls;
  global $logonxls;
  global $passwordxls;
  global $delimsymbxls;
  error_reporting(E_ALL);
// PHPExcel
   require_once '/webroot/public_html/zenyan/eLib/Classes/PHPExcel.php';
// PHPExcel_IOFactory
   require_once '/webroot/public_html/zenyan/eLib/Classes/PHPExcel/IOFactory.php';

//create spreadsheet
// Create new PHPExcel object
  $objPHPExcel = new PHPExcel();

// Set properties  add these to the equation
   $objPHPExcel->getProperties()->setCreator($xls->setCreator)
							 ->setLastModifiedBy($xls->setLastModifiedBy)
							 ->setTitle($xls->setTitle)
							 ->setSubject($xls->setSubject)
							 ->setDescription($xls->setDescription)
							 ->setKeywords($xls->setKeywords)
							 ->setCategory($xls->setCategory);  

// deal with freeze panes for aggregation
/// note: we are not dictating what they set this to, so it could be some 
/// screwed up value. as such you can check the value set in excelWrapper()
/// parm $freezepanecell
  if ($xls->freezepanecell != '')
  {
  	$objPHPExcel->getActiveSheet()->freezePane($xls->freezepanecell);
  }	

// Add some data
//$objPHPExcel->$rcstub;
$cls1 = new dbiox();

$cls1->odbcname = $odbcnamexls;
$cls1->logon = $logonxls;
$cls1->password = $passwordxls;
$cls1->delimsymb = $delimsymbxls;
  $getdata = $cls1->dbread($seltest,"delim2");
  $rcstub = getExcelRowColBlob($getdata,$objPHPExcel,$xls);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
// at moment we are only dealing with singleton worksheets
  $objPHPExcel->setActiveSheetIndex(0);

  $objPHPExcel->getActiveSheet()->setTitle($xls->setWS0Title);

//Set column autosizing for first 26 cols. my premise is this is more than 
//enough for xls output. if greater width is needed, delim output should be used
//can certainly add to this as well.
  for ($i=65; $i<=90; $i++)
  {
  	$objPHPExcel->getActiveSheet()->getColumnDimension(chr($i))->setAutoSize(true); 
  }	 
 
	//build top aggregation rows
	foreach($xls->aggregationColHash as $key => $value)
  {
    $tmpaggstr = "";
  	if (strtolower($value) == 'sum')
  	{
  		$ecell = strtoupper($key) . "1";
   	  //echo "<br />" . $ecell . "<br />"; 		
  	  $tmpaggstr = "=sum(" . strtoupper($key) . '3:' . strtoupper($key) . ($rscnt+1) . ")";
  	  //echo $tmpaggstr . "<br />";
  	  $objPHPExcel->setActiveSheetIndex(0)->setCellValue($ecell, $tmpaggstr); 
  	}
  	else if (strtolower($value) == 'median')
  	{
  		$ecell = strtoupper($key) . "1";
   	  //echo "<br />" . $ecell . "<br />"; 		
  	  $tmpaggstr = "=median(" . strtoupper($key) . '3:' . strtoupper($key) . ($rscnt+1) . ")";
  	  //echo $tmpaggstr . "<br />";
  	  $objPHPExcel->setActiveSheetIndex(0)->setCellValue($ecell, $tmpaggstr); 
  	}
  	else if (strtolower($value) == 'min')
  	{
  		$ecell = strtoupper($key) . "1";
   	  //echo "<br />" . $ecell . "<br />"; 		
  	  $tmpaggstr = "=min(" . strtoupper($key) . '3:' . strtoupper($key) . ($rscnt+1) . ")";
  	  //echo $tmpaggstr . "<br />";
  	  $objPHPExcel->setActiveSheetIndex(0)->setCellValue($ecell, $tmpaggstr); 
  	}
  	else if (strtolower($value) == 'max')
  	{
  		$ecell = strtoupper($key) . "1";
   	  //echo "<br />" . $ecell . "<br />"; 		
  	  $tmpaggstr = "=max(" . strtoupper($key) . '3:' . strtoupper($key) . ($rscnt+1) . ")";
  	  //echo $tmpaggstr . "<br />";
  	  $objPHPExcel->setActiveSheetIndex(0)->setCellValue($ecell, $tmpaggstr); 
  	}
  }	 
          
$logstr = " Set orientation to landscape\n";
eAppLog($logstr);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

//Create spread sheet  write these to logger if enabled
  /// echo date('H:i:s') . " Write to Excel5 format\n";
  echo "spreadsheet created: " . $xls->xls . " based upon the query " . $xls->qry;
//$path .= __FILE__ ;  //the default path and filename which is php script name and same loc
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save(str_replace('.php', '.xls', $xls->xls));

  return $objPHPExcel;
}

function getSQLQuery($qry)
{
	$raw_text = file_get_contents($qry);
	return $raw_text;
}	

function getExcelRowColBlob($getdata,$objPHPExcel,$xls)
{
	global $rscnt;
	global $rowone;
	$doonce = 0;
  $rowcolstub = "setActiveSheetIndex(0)\n ";
  //MAX 26. Can extend by adding to array in conformance with Excel column 
  //formatting. Example, item #27 would be AA move out as global
  $exelcol = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',); //can expand out to max Excel
//standard use of data access api
  $logstr = "Testing delim()" . "\n";
  $erow = 0;
   
  if ($rowone == 'y')
  {
   $erow = 1; //and we also might be freezing panes
  }	
  $erowsz = sizeof($getdata);
  $rscnt = $erowsz; //we set this irrespective of our intent for use
  foreach ($getdata as $value)
  { 	
    $erow++;
  	//print $value . "<br>";
  	$rs_chunk = explode("|", $value);
    $ecolsz = sizeof($rs_chunk);
//now that we have col width this is where we will set row 1 bg color    
if ($doonce == 0) //set once per invocation...
{
  $stopcolltr = $exelcol[$ecolsz-1];
  if ($rowone == 'y')
  {
   $hdrrng = "'A2:" .  $stopcolltr . "2'"; 
   $objPHPExcel->getActiveSheet()->getStyle($hdrrng)->getFill()->setFillType(PhpExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($xls->colhdrbg);
   //!!! FUTURE: set font and related attributes for header row
   $doonce = 1;
  }	 
  else
  {
   $hdrrng = "'A1:" .  $stopcolltr . "1'"; 
   $objPHPExcel->getActiveSheet()->getStyle($hdrrng)->getFill()->setFillType(PhpExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($xls->colhdrbg);  	
   //!!! FUTURE: set font and related attributes for header row
   $doonce = 1;
  }
}  	   
//additionally at this point we also know the #rows so we can also set borders
    
  	//print $rs_chunk[0] . "~" . $rs_chunk[1] . "~" . $rs_chunk[2] . "<br />";
    for ($c=0;$c<$ecolsz;$c++)
    {
    	//  ->setCellValue('A1', 'Hello out there')
    	$logstr .=  "->setCellValue('" .  $exelcol[$c] . $erow . "', '" . $rs_chunk[$c] . "\n";
    	$ecell = $exelcol[$c] . $erow; 
      $rs_chunk[$c] = trim($rs_chunk[$c]); // to avoid issues involving numeric columns!!!
     	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ecell, $rs_chunk[$c]);     	

      if ($xls->bordertypflg != '')
      {
      	$objPHPExcel->setActiveSheetIndex(0)->getStyle($ecell)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->setShowGridlines(true);
      }	

//!!!!!NOTE TO ME
// this would be ideal place for exit stub to fcn to add further row and/or col 
//styling details. ideally this would entail a logic layer so we are not doing 
//invocation on every single loop iteration. still need to think on this a bit 
// more. But, this is where it would be a happening.
//!!!!END NOTE TO ME
    	//$rowcolstub .=  "->setCellValue('" .  $exelcol[$c] . $erow . "', '" . $rs_chunk[$c] . "') \n";
    }	
  }



  eAppLog($logstr);
  return $rowcolstub;
}  

?>
