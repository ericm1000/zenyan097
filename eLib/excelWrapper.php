<?php

//         Version:  0.90                                                         
//            Date:  2009-12-01                                                          
// Initial Writing:  Eric Matthews
//         Purpose:  This is a class used by the excelbinder api. This class 
//                   contains the excel parameters from the programmer and/or
//                   end-user. It is quite extensible. Just make sure you do 
//                   so without breaking anything :-). 


class excelWrapper
{
/*
 for any oop bigots out there. no way are we going to make get methods for each
 of these values. first and foremost there is no business case to do so. second,
 it bloats the code. i have been doing oop since the wild west days when Java 
 released jdk 1.1. if you have an issue with this refer to the quote "when all
 one has is a hammer..."
  public $xls;
*/
  public $qry;  
  public $qrystr;
  public $setCreator = "EM";
  public $setLastModifiedBy = "EM";
  public $setTitle = "";
  public $setSubject = "";
  public $setDescription = "";
  public $setKeywords = "";
  public $setCategory = ""; 
  public $setWS0Title = "";
  
  public $rowoneAggFlg = "";
  public $freezepanecell = "";
  public $colhdrfont = "00000000";  //default is black
  public $colhdrbg = "FFFFFFFF";  //default is white 
  public $bordertypflg = "BORDER_THIN"; //can override in object instance 

  public $aggregationColHash = ''; //kvp = (k= col letter, v= aggregation function directive )

	public $pathtoq = "\\webroot\\public_html\\zenyan\\reposq\\"; 
	public $pathtoout = "\\webroot\\public_html\\zenyan\\dfltdevoutput\\"; 

  public function setAggregationRowHashVal($ival,$iop)
	{ 
		$this->aggregationColHash[$ival] = $iop;
	}	 

  public function getAggregationRowHashVal($ival)
	{ 
		$rval = $this->aggregationColHash[$ival];
		return $rval;
	}	 

	public function setXLS($xlsfil)
	{
		$xlsfilpath = "";
    $xlsfilpath .= $this->pathtoout . trim($xlsfil);
    $this->xls = $xlsfilpath;
    return $xlsfilpath;	
	}	
	
	public function setQRY($qryfil)
	{
		$qryfilpath = "";
    $qryfilpath .= $this->pathtoq . trim($qryfil);
    $this->qry = $qryfilpath;
    return $qryfilpath;	
	}	
	
}	

?>
