<?php

include('o_dbiox.php');

$cls1 = new dbiox();
$cls1->odbcname = "databridge";
$cls1->logon = "sa";
$cls1->password = "sa";
$cls1->delimsymb = "|";
$rs = $cls1->dbread("select top 6 SYSKEY, EV_ACCT from dbo.micro","delim2");

$cls2 = new dbiox();
$cls2->odbcname = "CourseRegistration";
$cls2->logon = "sa";
$cls2->password = "homeboy1";
$cls2->delimsymb = "|";
$rs2 = $cls2->dbread("select course_designater_fk, teacher_id_fk from dbo.Classes","delim");

echo "<p>Data Follows</p>";

$rscnt = 0;
$rscnt = count($rs);
echo $rscnt . "<br>";
for ($i=0; $i < $rscnt; $i++)
{
	echo $rs[$i] . "<br>";
}	

$rscnt2 = 0;
$rscnt2 = count($rs2);
echo $rscnt2 . "<br>";
for ($i=0; $i < $rscnt2; $i++)
{
	echo $rs2[$i] . "<br>";
}	

?>
