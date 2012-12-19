<?php
$url = 'http://127.0.0.1/';
$url = strtolower($url);
$dns = 'localhost';
$ip  = '127.0.0.1';
$testmodeval = "1";
$status_flag_loc = 'S';
$t1 = "0";
$t2 = "0";
$applogger = "0";
$fw_host = "127.0.0.1";
$fw_db = "elixir";
$fw_odbcname = "elixirss";
$fw_delimsymb = "|";
// use the following 3 settings for ODBC (SQL Server)
$fw_logon = "sa";  
$fw_password = "sa";  
$fw_typesql = "ODBC";  
// use the following 3 settings for MySQL
$fw_logon = "root"; 
$fw_password = "mysqldev";  
$fw_typesql = "MySQL";   

$Scontxttoll = 8224;
//login vars
$loghistory = 'y';
$maxloginattemps = 500; 
$minloginnm = '6';
$maxloginnm = '35';
$minpwd = '8';
$maxpwd = '10';
$logincharset = "^[A-Za-z0-9]{6,35}";  //be aware this is used in a regex class!
$pwdcharset1 = "^[A-Za-z0-9*#~_]{8,10}"; //be aware this is used in a regex class!
$pwdcharset2 = "[A-Z]{1,1}";             //be aware this is used in a regex class!
$pwdcharset3 = "[a-z]{1,1}";             //be aware this is used in a regex class!
$pwdcharset4 = "[0-9]{1,1}";             //be aware this is used in a regex class!
//login for ALL registered entities!!!
$seedset = '';
//never modify any seed values once in production or you will disable all logins!!!
//max val = 20!
$seed1 = '4';
$seed2 = '14';
$seed3 = '19';
//other
$svrsidechartloc = "svrsidecharts";
$dflt_skin_bg = '';
$dflt_skin_nntabs = 'a';
$loginmailflg = '';
$maxrowlimit = ' limit 100 ';  //to cap return from % queries
?>