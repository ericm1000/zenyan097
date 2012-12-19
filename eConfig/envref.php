<?php
/* 
following allows us to configure filesystem path references (mostly for 
includes). Since we have multiple directories in different paths that need to
access common infrastructure we need to code full path references. This is where
we deal with all this. This is not everything! Due to the nature of the 
DataMiner application interface there is a great deal of indirection going on.
Certain paths are coded in certain programs to avoid circular references. 
Everything is spelled out in the implementation guide.
*/
// History/Customizations:
/*
 02/06/2012: Norm Zemke: Fix path to cLib
                         Added $php_loginlib and $php_usrgrplib
*/
$drive = 'c:/';
$rootwspath = 'webroot/public_html/';
$rootdir = 'zenyan097/';
$buildname = 'zenyan097';
$libpath = 'eLib/';
$clibpath = 'cLib/';
$fullpath = $drive . $rootwspath . $rootdir . $libpath;
$croot = $drive . $rootwspath . $rootdir . "croot/";
$LIBRARY = $croot . "LIBRARY/";
$stubs = $drive . $rootwspath . $rootdir . "stubs/";
$eDMS = $drive . $rootwspath . $rootdir . "eDMS/";

//certain environment vars
$php_envvars        =  $fullpath . 'envvars.php'; 
//excel/pdf wrapper to excel api
$php_excelWrapper   =  $fullpath . 'excelWrapper.php' ;//path to excel object wrapper

$php_excelbinderd   =  $fullpath . 'excelbinderd.php' ;//path to dynamic excel object binder
//excel infrastructure
$php_excelbinderss  =  $fullpath . 'excelbinderx.php' ;//path to excel odbc object binder
$php_excelbindermy  =  $fullpath . 'excelbindermy.php' ;//path to excel local mysql object binder
//pdf infrastructure
$php_excelbindersspdf =  $fullpath . 'excelbinderxpdf.php' ;//path to pdf odbc object binder
$php_excelbindermypdf =  $fullpath . 'excelbindermypdf.php' ;//path to pdf local mysql object binder
//error handling
$php_loggers        =  $fullpath . 'loggers.php' ;//DataMiner logging subsystem
//app dev / other apis
$php_cLib           =  $drive . $rootwspath . $rootdir . $clibpath . 'clvars.php';
$php_applib         =  $fullpath . 'applib.php'  ;//application lib
$php_daclib         =  $fullpath . 'daclib.php'  ;//application lib
$php_loginlib       =  $fullpath . 'loginlib.php'  ;//application lib
$php_filsysapi      =  $fullpath . 'filio.php' ;//path to filesys lib
$php_usrgrplib      =  $fullpath . 'usrgrplib.php'  ;//user/group admin lib
$php_triframe       =  $fullpath . 'triframe.php'  ;//DataMiner triframe lib
$php_pChart         =  $drive . $rootwspath . $rootdir . $libpath . 'pChart/pChart.class'; //Server side graph/chart api
$php_pData          =  $drive . $rootwspath . $rootdir . $libpath . 'pChart/pData.class'; //Server side graph/chart api
$php_dicers         =  $fullpath . 'dicers.php'; // virtual recordset
//direct mysql api
$php_dbiom          =  $fullpath . 'o_dbiomyp.php' ;//path to mysql lib
//generic odbc api
$php_dbiox          = $fullpath . 'o_dbiox.php' ;//path to generic odbc lib
//path to non-scalable jdbc wrapper
$php_dbioaj         =  $fullpath . 'o_dbioaj.php' ;//path to jdbc lib
//following is var that can be used for indirection
// example: $php_dbms = $php_dbiom;
// $php_dbms = "$php_dbiox";   // use this one for ODBC
 $php_dbms = "$php_dbiom";   // use this one for MySQL
 
