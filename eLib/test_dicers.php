<?php

include('o_dbiomyp.php');
include('dicers.php');
include($php_daclib);

$myDbgateway = new dbgateway;

$query = 'SELECT conn_name, host, logn, pwd, db, dbms FROM connmgr WHERE inactive_flg is null ORDER BY dbms';

echo "<h1>Test dicers (pronounced dice rs)</h1>";

$rs1a = $myDbgateway->readSQL($query,"delim2");
$rscnt = 0;
$rscnt = count($rs1a);
$rs = change_delimiter($rs1a,"|",",");
echo "<h2>Test delim2</h2>";

echo "------------------------------------<br />";
echo "Original Array Data<br />";
echo "------------------------------------<br />";
for ($i=0; $i < $rscnt; $i++)
{
	echo $rs1a[$i] . "<br />";
}

echo "<br />";
$diced_rs = delimColDicer($rs1a,"0,1,4,9","|");
$rscnt = 0;
$rscnt = count($diced_rs);
echo "------------------------------------<br />";
echo "Results of delimColDicer() function <br />";
echo "------------------------------------<br />";
for ($i=0; $i < $rscnt; $i++)
{
	echo $diced_rs[$i] . "<br />";
}
// echo $diced_rs;
echo "<br />";

$rscnt = 0;
$rscnt = count($rs);
echo "------------------------------------<br />";
echo "Results of change_delimiter() function <br />";
echo "------------------------------------<br />";
for ($i=0; $i < $rscnt; $i++)
{
	echo $rs[$i] . "<br />";
}

echo "------------------------------------<br />";
echo "Results of convert_array_toString() function <br />";
echo "------------------------------------<br />";
$cstr = convert_array_toString("<br />",$rs1a);
echo $cstr;


echo "<br />";
$rs1b = $myDbgateway->readSQL($query,"trrow");
echo "------------------------------------<br />";
echo "<h2>Test trrow</h2>";
echo "------------------------------------<br />";
$rscnt = 0;
$rscnt = count($rs1b);

echo "------------------------------------<br />";
echo "Results of convert_array_toString() function <br />";
echo "------------------------------------<br />";
$cstr = convert_array_toString("",$rs1b);
echo "<table border='1' cellpadding='0' cellspacing='0' >";
echo $cstr;
echo "</table>";
 
?>
