<?php
session_start();

require('eConfig/envref.php');

include($php_envvars);
include($php_dbms);  //dbms specific to app
include($php_applib);
include($php_daclib);
include($php_loggers);

include($php_pData);
include($php_pChart);
include($php_dicers);

$rand = rand();
$_SESSION['oldebug'] = "";

$_SESSION['tmp'] = $debugapp;
$mtd = "";
$status = '';
$logonerror = '';
$fullrefpg = $_SERVER['HTTP_REFERER'];

//get only page name.
if (preg_match("/[A-Za-z0-9_-]+[.]php.*$/", $fullrefpg, $matches)) {$refpg = $matches[0];}
$refpg = preg_replace("/^([A-Za-z0-9_-]+[.]php)(.*)$/", "$1", $refpg);

$department =  $_POST['dept'];
$myDbgateway = new dbgateway;

//// commented out during development ////
check_referring_pg($refpg);
//// commented out during development ////

 function check_referring_pg($refpg){  
  global $Scontxttoll;
  //if referring page context is required you code conditional here as wrapper to below conditional                
    if ( $_SESSION['initentry'] == $Scontxttoll)
    {
     	//in-context... presuming me
    } else { header("Location: login.php");  }
  }

/*
NOTE: The function call below only retrieves the data. This IS NOT the call
to format the data in the manner required by the chart. The reason is that this
data can come for the result of direct database access, or it can come from 
the dicer recordset library (in cases where one recordset is used to serve 
multiple UI controls.)
*/
$rslt = getDataForChart($department);
//note. would use envvars $fw_delimsymb val, but dicers use can override this value
$duoarr = createSvrsideChartArrays($rslt,"|");

/*
The server side chart creates a png file for the runtime dataset. Since the app
can host multiple users we need a means of not stepping on each other. As such
each logged in user has a unique name. We append this name to the chart name
and this gives us our uniqueness. BUT!!! A server side chart is really a 
transient entity (much like a recordset, or UI form or workflow). The issue
becomes we could technically have a bunch of png files on the system that no
longer serve a useful purpose (example: users no longer exist, users no longer
use said functionality). Since the png file gets generated new if it does not
exist it is recommended that a purge program be run against the server side
chart directory (default location is svrsidecharts). The purge program should
delete png files with a timestamp > n from current datetime. Running this 
program nightly to delete files that are more than one day old would be 
appropriate in most sceanrios.
*/
$mychart = renderChart($_SESSION['USRNAME'],$duoarr[0],$duoarr[1],$department); 
$dispmychart = $mychart . "?" . $rand;
//note $rand appendage is required to refresh the image in the browser!!!

///$_SESSION['oldebug'] .= $tmpvar;


//-----------------------------------------------------------------------------

function createSvrsideChartArrays($c_rs,$dlmtr)
{
/*
We accept a recordset that conforms to the pattern <element><delimiter><data>.
Example: Day Surgery|125. The element represents our chart entity and serves as
our label. The data represents our aggregated value. In order to conform to the
server side charts requirements we break our input array into two output arrays
we return to the caller.
*/
  $hdr = array(); //create empty array
  $dta = array(); //create empty array
  $rarr = array(); //create empty array
  //loop input array
  ///$_SESSION['oldebug'] .= "<br />";
  foreach ($c_rs as $value)
  {
   ///$_SESSION['oldebug'] .= $value;
    $rslts =  preg_split("/[$dlmtr]/", $value, -1, PREG_SPLIT_OFFSET_CAPTURE);
   ///$_SESSION['oldebug'] .= "``" . $rslts[0][0];
   ///$_SESSION['oldebug'] .= "++" . $rslts[1][0] . "~!~<br />";
    array_push($hdr,$rslts[0][0]);
    array_push($dta,$rslts[1][0]);
  }
  array_push($rarr,$hdr);
  array_push($rarr,$dta);
  
  return $rarr;
	
}	


function renderChart($usernm,$hdrstr,$datastr,$dept)
{
  global $svrsidechartloc;

  if ($dept == '')
  {
  	$dept = "Cardiology";
  }	
/*
There are a great many setting for a chart that (at least at this time) do not
lend well to creating dynamically at runtime. Creating your chart is really a
development time activity (height, width, #data elements, etc...). The runtime
activity is getting the data to render in the chart. Hence, if you want a 
chart(s) in your program you will need to inline this function code and tweak
it as you see fit.
*/
  $chrtnm = $svrsidechartloc . '/' . $usernm . 'unitsourcestats.png';
  ///$_SESSION['oldebug'] .= "<br />" . $chrtnm ;

  // Dataset definition 
  $DataSet = new pData;
  $DataSet->AddPoint($datastr,"Serie1");
  $DataSet->AddPoint($hdrstr,"Serie2");
  $DataSet->AddAllSeries();
  $DataSet->SetAbsciseLabelSerie("Serie2");
 
  // Initialise the graph
  $Test = new pChart(480,250);
  $Test->drawFilledRoundedRectangle(7,7,480,243,5,250,250,250);
  $Test->drawRoundedRectangle(5,5,480,245,5,250,250,250);
  $Test->createColorGradientPalette(195,204,56,223,110,41,5);
 
  // Draw the pie chart
  $Test->setFontProperties("Fonts/tahoma.ttf",8);
  $Test->AntialiasQuality = 0;
  $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,130,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
  $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
 
  // Write the title
  $Test->setFontProperties("Fonts/MankSans.ttf",10);
  $Test->drawTitle(10,20,$dept,100,100,100);

  $Test->Render("$chrtnm");
  return $chrtnm;
}	

 
function getDataForChart($bydept)
{
  global $myDbgateway;

  if ($bydept == '')
  {
  	$bydept = "Cardiology";
  }	

  $query = "SELECT 
  Adm_Source as 'Source', 
  Unit_Count as 'Count'   
  FROM   adm_sources
  where Unit = '$bydept'
  ";
  $result = $myDbgateway->readSQL($query,"delim");
  	
  return $result;
}	 
 
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Dynamic Charting Demo</title>
	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->		
	<script type="text/javascript" src="jquery/jquery182.min.js"></script>	
	<script type="text/javascript" language="javascript" src="jquery/jquery.dropdownPlain.js"></script>

<link rel="stylesheet" type="text/css" href="stylesheet/gridcontrol.css" media="all" />
<script type="text/javascript" src="eUI/gridcontrol.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
<style type="text/css">
<!--
#debug {
	position:absolute;
	width:780px;
	height:96px;
	z-index:1;
	left: 20px;
	top: 408px;
}
#Layer1 {
	position:absolute;
	width:725px;
	height:149px;
	z-index:2;
	left: 37px;
	top: 53px;
}
-->
</style>
</head>

<body>
<?php
  include('jquery/topmenu.php');
?> 	
<!--  Header  -->
<br /><br />	

<!-- comment out or remove me for production -->
<div id="Layer1">
<h1>Admission Sources by Department</h1>
<form name="formelements" action="svrside_chart_toy1.php" method="POST" >
For Department: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<select name="dept" selected>
 <option selected></option>		
 <option>Cardiology</option>	
 <option>Dermatology</option>	
 <option>Gynecology</option>	
 <option>ICU</option>
 <option>Obstetrics</option>	
 <option>Oncology</option>
</select> 	
&nbsp;&nbsp;&nbsp;
<input type="submit" value="ok" name="formelements">
</form>

<br /><br />
<img src="<?php echo $dispmychart; ?>" alt="bar1" />
</div>





<div id="debug">
<?php echo $_SESSION['oldebug']; ?>
</div>
	
</body>

</html>
