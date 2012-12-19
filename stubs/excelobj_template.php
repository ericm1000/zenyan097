<?php 
//suppress extraneous noise
error_reporting (E_ERROR ^ E_NOTICE);

include('/webroot/public_html/zenyan097/eConfig/envref.php');

require($php_excelWrapper);

require(~~BINDERTYPE~~);
$odbcnamexls = ~~ODBCNAME~~;
$logonxls = ~~LOGON~~;
$passwordxls = ~~PASSWORD~~;

include($php_loggers);

$logapp = 'y';
//set excel params
$testwrapper = new excelWrapper();
// name for excel file?
$xls = $testwrapper->setXLS('~~SPREADSHEETFILENAME~~');
$logstr = "excel file name and path " . $xls . "<br />";
eAppLog($logstr);
// query you want to create excel spreadsheet for
$qry = $testwrapper->setQRY('~~QUERYFILENAME~~');
$testwrapper->setWS0Title = "~~WSTITLE~~";
$logstr =  "query including path " . $qry . "<br />";
eAppLog($logstr);

// this flag determines if we are using row one for data aggregation of certain 
// cols. 
$testwrapper->rowoneAggFlg = '~~AGGFLAG~~';
// note to me. need to add flag to process freeze frames. also need to 
// add array to deal with how to agg cols
$testwrapper->freezepanecell = '~~FREEZECELL~~';
$testwrapper->colhdrbg = '~~HDRCOLBG~~';
~~AGGROWSTUB~~
//which is 1 or more of below
//$testwrapper->setAggregationRowHashVal('D','SUM');


//call api to create excel spreadsheet from results of query
genXLS($testwrapper);

?>

