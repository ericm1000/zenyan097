<?php

include('o_dbiomyp.php');

$query = 'SELECT conn_name, host, logn, pwd, db, dbms FROM connmgr WHERE inactive_flg is null ORDER BY dbms';

$cls1 = new dbiomyp();
$cls1->host = "127.0.0.1";
$cls1->db = "elixir";
$cls1->logon = "root";
$cls1->password = "mysqldev";
$cls1->delimsymb = "|";
$rs = $cls1->dbread($query,"delim");


echo "<h1>Data Follows</h1>";
echo "<h2>Test delim</h2>";

$rscnt = 0;
$rscnt = count($rs);
echo $rscnt . "<br>";
for ($i=0; $i < $rscnt; $i++)
{
	echo $rs[$i] . "<br />";
}	


$rs1a = $cls1->dbread($query,"delim2");
echo "<h2>Test delim2</h2>";
$rscnt = 0;
$rscnt = count($rs1a);
echo $rscnt . "<br>";
for ($i=0; $i < $rscnt; $i++)
{
	echo $rs1a[$i] . "<br />";
}

$rs1b = $cls1->dbread($query,"delim3");
echo "<h2>Test delim3</h2>";
$rscnt = 0;
$rscnt = count($rs1b);
echo $rscnt . "<br>";
echo $rs1b . "<br />";


$rs1c = $cls1->dbread($query,"trrow");
echo "<h2>Test trrow</h2>";
$rscnt = 0;
$rscnt = count($rs1c);
echo "<table>";
for ($i=0; $i < $rscnt; $i++)
{
	echo $rs1c[$i];
}
echo "</table>";

$login = "eric.matthews@ge.com";
$query2 = 'select emailaddress, pwd, requestdate, inactive_flg, contributor_name, uid, guid, skin_bg, skin_tabs, admin_flg from members where emailaddress =\'' . $login . '\' ';


$cls2 = new dbiomyp();
$cls2->host = "127.0.0.1";
$cls2->db = "dataminer";
$cls2->logon = "root";
$cls2->password = "mysqldev";
$cls2->delimsymb = "|";
$rs2 = $cls2->dbread($query2,"hash");

echo "<h2>Test hash</h2>";
echo "$rs<br />";

while($row = mysql_fetch_array($rs2, MYSQL_ASSOC))
{
	echo $row['emailaddress'];
}		


?>
