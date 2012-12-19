<?php
/*
Intial Writing: Eric Matthews
general file library code
*/
$layout = '
#topico {
	position:absolute;
	width:305px;
	height:36px;
	z-index:1;
	left: 7px;
	top: 4px;
}
#toplogin {
	position:absolute;
	width:629px;
	height:29px;
	z-index:2;
	left: 300px;
	top: 7px;
}
#topstatusbar {
	position:absolute;
	width:536px;
	height:20px;
	z-index:3;
	left: 14px;
	top: 38px;
}
#topmenu {
	position:absolute;
	width:776px;
	height:36px;
	z-index:4;
	left: 2px;
	top: 71px;
}
.frmlbl {font-size: .7em; font-family: Arial, Helvetica, sans-serif; }
.urlbar {font-size: small; font-family: Arial, Helvetica, sans-serif; }

td {
  width: 35px;
}
#topmsg {
	position:absolute;
	width:180px;
	height:20px;
	z-index:7;
	left: 657px;
	top: 41px;
}
#otherpglnks {
	position:absolute;
	width:46px;
	height:18px;
	z-index:6;
	left: 960px;
	top: 42px;
}
#navtangologo {
	position:absolute;
	width:52px;
	height:54px;
	z-index:4;
	left: 776px;
	top: 46px;
}
#ad1 {
	position:absolute;
	width:122px;
	height:61px;
	z-index:8;
	left: 860px;
	top: 41px;
}
.smlnk {font-size: .8em; font-family: Arial, Helvetica, sans-serif; }
.greeting {font-size: .85em; font-family: Arial, Helvetica, sans-serif; color: #000066; }
.logout {font-size: .72em; font-family: Arial, Helvetica, sans-serif; }
#Layer1 {
	position:absolute;
	width:47px;
	height:21px;
	z-index:9;
	left: 960px;
	top: 41px;
}
#Layer2 {
	position:absolute;
	width:49px;
	height:16px;
	z-index:10;
	left: 959px;
	top: 65px;
}
#Layer3 {
	position:absolute;
	width:50px;
	height:19px;
	z-index:11;
	left: 958px;
	top: 83px;
}
#Layer4 {
	position:absolute;
	width:54px;
	height:19px;
	z-index:9;
	left: 840px;
	top: 41px;
}
';


$nnmnua = '
#mnuwrapper
{
margin: 0;
padding: 0;
height: 22px;
font: 11px Verdana, sans-serif;
width: 100%;
border-bottom: 1px solid #bbb;
list-style-type: none;
background: #fff;
}

#mnuglu
{
margin: 0;
padding: 0 0 20px 10px;
border-bottom: 1px solid #000;
}

#mnuglu ul, #mnuglu li
{
margin: 0;
padding: 0;
display: inline;
list-style-type: none;
}

#mnuglu a:link, #mnuglu a:visited
{
float: left;
line-height: 14px;
font-weight: bold;
margin: 0 10px 4px 10px;
text-decoration: none;
color: #999;
}

#mnuglu a:link#current, #mnuglu a:visited#current, #mnuglu a:hover
{
border-bottom: 4px solid #000;
padding-bottom: 2px;
background: transparent;
color: #000;
}

#mnuglu a:hover { color: #000; }
';

$nnmnua2 = '
#mnuwrapper
{
margin: 0;
padding: 0;
height: 22px;
font: 11px Verdana, sans-serif;
width: 100%;
list-style-type: none;
background: #282828;
}

#mnuglu
{
margin: 0;
}

#mnuglu ul, #mnuglu li
{
margin: 0;
padding: 0;
display: inline;
list-style-type: none;
}

#mnuglu a
{
float: left;
line-height: 14px;
margin: 0 10px 4px 10px;
text-decoration: none;
color: #fff;
}

#mnuglu a:link#current, #mnuglu a:visited#current, #mnuglu a:hover
{
border-bottom: 4px solid #FFC125;
padding-bottom: 2px;
background: transparent;
color: #000;
}

#mnuglu a:hover { 
	color: #fff; 
  font-weight: bold;	
}
';

$nnmnub = '
#mnuwrapper
{
padding: 0;
background: #ccc;
height: 20px;
}

#mnuglu
{
margin: 0px;
padding: 0px 0px;
display: block;
}

#mnuglu li
{
list-style: none;
float: left;
}

#mnuwrapper a
{
margin: 0px;
display: block;
padding: 1px 6px;
text-decoration: none;
background: #ccc;
font: normal 12px verdana, serif;
color: #000;
}

#mnuwrapper a:hover
{
padding: 1px 5px;
background: #FAFAFA;
border-right: 1px solid #333;
border-left: 1px solid #333;
border-top: 1px solid #FAFAFA;
border-bottom: 1px solid #333;
color: #000;
}

#mnuwrapper a#current
{
background: #F6F6F6;
border-top: 1px solid #F6F6F6;
font-weight: bold;
}
';

$nnmnuc = '
#mnuwrapper
{
margin: 0;
padding: 0;
height: 22px;
font: 11px Verdana, sans-serif;
width: 100%;
border-bottom: 1px solid #bbb;
list-style-type: none;
background: #fff;
}

#mnuglu li
{
float: left;
margin: 0;
padding: 0;
width: auto;
display: block;
}

#mnuglu li a, #mnuglu li a:link
{
background: #fff;
color: #555;
text-decoration: none;
padding: 3px 5px 3px 5px;
display: block;
}

#mnuglu li a:hover
{
color: #039;
border-bottom: 3px solid #bbb;
cursor: pointer;
background: #eee;
}

#mnuglu li a#current, #mnuglu li a#current:link
{
color: #000;
cursor: default;
font-weight: bold;
border-bottom: 3px solid #999;
}

#mnuglu li a#current:hover
{
border-bottom: 3px solid #f90;
background: #eee;
}
';

$nnmnud = '
#mnuwrapper
{
margin-left: auto;
margin-right: auto;
margin-bottom: 40px;
border-top: 1px solid #999;
z-index: 1;
}

#mnuwrapper ul
{
list-style-type: none;
text-align: left;
margin-left: 30px;
margin-top: -8px;
padding: 0;
position: relative;
z-index: 2;
}

#mnuwrapper li
{
display: inline;
text-align: center;
margin: 0 5px;
}

#mnuwrapper li a
{
padding: 1px 7px;
color: #666;
background-color: #ffffff;
border: 1px solid #ccc;
text-decoration: none;
font: normal 12px verdana, serif;
}

#mnuwrapper li a:hover
{
color: #000;
border: 1px solid #666;
border-top: 2px solid #666;
border-bottom: 2px solid #666;
background-color: #CACAFF;
}

#mnuwrapper li a#current
{
color: #000;
border: 1px solid #666;
border-top: 2px solid #666;
border-bottom: 2px solid #666;
}
';

$nnmnue = '
#mnuglu
{
padding: 3px 0;
margin-left: 0;
border-bottom: 1px solid #778;
font: bold 12px Verdana, sans-serif;
}

#mnuglu li
{
list-style: none;
margin: 0;
display: inline;
}

#mnuglu li a
{
padding: 3px 0.5em;
margin-left: 3px;
border: 1px solid #778;
border-bottom: none;
background: #CACAFF;
text-decoration: none;
font: normal 12px verdana, serif;
}

#mnuglu li a:link { color: #448; }
#mnuglu li a:visited { color: #667; }

#mnuglu li a:hover
{
color: #000;
background: #AAE;
border-color: #227;
}

#mnuglu li a#current
{
background: white;
border-bottom: 1px solid white;
}
';

$nnmnuf = '
#mnuwrapper
{
margin: 0;
padding: 0 0 0 12px;
}

#mnuwrapper ul
{
list-style: none;
margin: 0;
padding: 0;
border: none;
}

#mnuwrapper li
{
display: block;
margin: 0;
padding: 0;
float: left;
width: auto;
}

#mnuwrapper a
{
color: #444;
display: block;
width: auto;
text-decoration: none;
background: #DDDDDD;
margin: 0;
padding: 2px 10px;
border-left: 1px solid #fff;
border-top: 1px solid #fff;
border-right: 1px solid #aaa;
font: normal 12px verdana, serif;
}

#mnuwrapper a:hover, #mnuwrapper a:active { background: #BBBBBB; }

#mnuwrapper a.active:link, #mnuwrapper a.active:visited
{
position: relative;
z-index: 102;
background: #BBBBBB;
font-weight: bold;
}
';

$nnmnug = '
#mnuwrapper { margin-left: 30px; }

#mnuglu
{
list-style: none;
padding: 0;
margin: 0;
}

#mnuglu li
{
display: inline;
padding: 0;
margin: 0;
}

#mnuglu a
{
font: normal 12px verdana, serif;
}

#mnuglu a:hover
{
font-weight:bold;
}

#mnuglu li:before { content: "| "; }
#mnuglu li:first-child:before { content: ""; }

/*IE workaround*/
/*All IE browsers*/
* html #mnuglu li
{
border-left: 1px solid black;
padding: 0 0.4em 0 0.4em;
margin: 0 0.4em 0 -0.4em;
}

/*Win IE browsers - hide from Mac IE\*/
* html #mnuglu { height: 1%; }

* html #mnuglu li
{
display: block;
float: left;
}

/*End hide*/
/*Mac IE 5*/
* html #mnuglu li:first-child { border-left: 0; }
';

$nnmnuh = '
ul#mnuglu
{
margin-left: 0;
padding-left: 0;
white-space: nowrap;
}

#mnuglu li
{
display: inline;
list-style-type: none;
}

#mnuglu a { 
padding: 3px 10px; 
font: normal 12px verdana, serif;
}

#mnuglu a:link, #mnuglu a:visited
{
color: #fff;
background-color: #036;
text-decoration: none;
}

#mnuglu a:hover
{
color: #fff;
background-color: #369;
text-decoration: none;
}
';

$nnmnui = '
#mnuglu
{
border-bottom: 1px solid #000000;
border-top: 1px solid #000000;
margin: 0px;
margin-bottom: 30px;
padding: 0px;
padding-left: 30px;
background-color: #D6D6D6;
font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
padding-bottom: 3px;
padding-top: 3px;
}

#mnuglu a, #mnuglu a:link, #mnuglu a:visited
{
border: 1px solid #FFFFFF;
padding: 1px;
padding-left: 0.5em;
padding-right: 0.5em;
color: #000000;
font-weight: bold;
text-decoration: none;
}

#mnuglu a:hover, #mnuglu a:active, #mnuglu a:focus
{
border: 1px solid #000000;
background-color: #A5D3CA;
padding: 1px;
padding-left: 0.5em;
padding-right: 0.5em;
text-decoration: none;
}

#mnuglu li
{
padding-right: 1px;
display: inline;
font-size: 0.6em;
}

#mnuglu ul
{
margin: 0px;
padding: 0px;
}

#mnuglu #active a { background-color: #FFFFFF; }
';


//returns css style code stub for top tri-frame menu
function getNNMNU($styltyp)
{
  global $layout;
  $cstub = $layout;
  global $nnmnua; 
  global $nnmnua2;
  global $nnmnub; 
  global $nnmnuc;
  global $nnmnud; 
  global $nnmnue;
  global $nnmnuf; 
  global $nnmnug;
  global $nnmnuh; 
  global $nnmnui;

  if ($styltyp == 'a') { $cstub .= $nnmnua; }	
  else if ($styltyp == 'a2') { $cstub .= $nnmnua2; }
  else if ($styltyp == 'b') { $cstub .= $nnmnub; }
  else if ($styltyp == 'c') { $cstub .= $nnmnuc; }
  else if ($styltyp == 'd') { $cstub .= $nnmnud; }
  else if ($styltyp == 'e') { $cstub .= $nnmnue; }
  else if ($styltyp == 'f') { $cstub .= $nnmnuf; }
  else if ($styltyp == 'g') { $cstub .= $nnmnug; }
  else if ($styltyp == 'h') { $cstub .= $nnmnuh; }
  else if ($styltyp == 'i') { $cstub .= $nnmnui; }
  else { $cstub .= $nnmnua; }  
               
  return $cstub;
}	

?>
