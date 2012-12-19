<?php
// tabs template
// Initial Writing: ericm (integration into navTango)
// Javascript code: Stephen Ostermiller
// Date: 2/19/2012
// License: Dual licensed under the MIT and GPL license
// License for Javascript: GNU2 or greater
/*
skeletal template for tabs
IMPORTANT NOTE: Tab context is coded in this form so you can understand how it
works. You can do whatever you want with the forms below. They are provided 
only so you can see how to implement tab context (the hidden fields)
*/
// History/Customizations:
/*
                        
*/
require('eConfig/envref.php');
include($php_envvars);
include($php_dbms); 
include($php_applib);
include($php_loggers);

session_start();
 

$ioretv = "";

//below used (typically) within each tab
$tab1msg = '';
$tab2msg = '';
$tab3msg = '';
$tab4msg = '';
$tab5msg = '';
$tsttabmsg1 = '';
$tsttabmsg2 = '';
$tsttabmsg3 = '';
$tsttabmsg4 = '';
$tsttabmsg5 = '';

$lasttab = 0; //default to first tab for initial form entry
 
if ($_SESSION['initentry'] != $Scontxttoll) { 
  $_SESSION['loginerr'] = 'Login required to access page';
  header("Location: login.php");  
  exit; 
}

    if ($_REQUEST['p'] == "form1") { 

      $lasttab = $_REQUEST['tabmrkr1'];
    } 
    else  if ($_REQUEST['p'] == "form2") { 

      $lasttab = $_REQUEST['tabmrkr2'];
    } 
    else  if ($_REQUEST['p'] == "form3") { 

      $lasttab = $_REQUEST['tabmrkr3'];
    } 
    else  if ($_REQUEST['p'] == "form4") { 

      $lasttab = $_REQUEST['tabmrkr4'];
    } 
    else  if ($_REQUEST['p'] == "form5") { 

      $lasttab = $_REQUEST['tabmrkr5'];
    } 




?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title>Nav Tango Main Page</title>
		
<link media="print, projection, screen" href="jquery/stylesheet/ui.tabs.css" type=text/css rel=stylesheet>
<script src="jquery/jquery182.min.js" type=text/javascript></script>
<script src="jquery/ui.core16rc5.js" type=text/javascript></script>
<script src="jquery/ui.tabs16rc5.js" type=text/javascript></script>

<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css">

<script src="scripts/calculator.js" type=text/javascript></script>
<link rel="stylesheet" type="text/css" href="stylesheet/calculator.css">

<script type="text/javascript">
   $(function() {
      $('#etabs> ul').tabs({ fx: { opacity: 'toggle' } });
   });

    $(function() {
       $("#etabs").tabs({ selected: <?php echo $lasttab; ?> });
    }); 
</script>


<style type="text/css">
<!--
#showhelpConstants {
	position:absolute;
	width:121px;
	height:28px;
	z-index:1;
	left: 350px;
	top: 275px;
}
#helptxtConstants {
	position:absolute;
	width:373px;
	height:291px;
	z-index:2;
	left: 480px;
	top: 160px;
}

#showhelpFunctions {
	position:absolute;
	width:121px;
	height:28px;
	z-index:1;
	left: 350px;
	top: 320px;
}
#helptxtFunctions {
	position:absolute;
	width:373px;
	height:291px;
	z-index:2;
	left: 700px;
	top: 160px;
}
#showhelpGeneral {
	position:absolute;
	width:121px;
	height:28px;
	z-index:1;
	left: 30px;
	top: 400px;
}
#helptxtGeneral {
	position:absolute;
	width:373px;
	height:291px;
	z-index:2;
	left: 30px;
	top: 420px;
}

-->
</style>

<script language="javascript"> 
function eToggleContants(anctag,darg) 
{
  //MsgBox(darg);
  var ele = document.getElementById(darg);
  var text = document.getElementById(anctag);
  if(ele.style.display == "block") 
  {
    ele.style.display = "none";
	text.innerHTML = "Show Constants Help";
  }
  else 
  {
	ele.style.display = "block";
	text.innerHTML = "Hide Constants Help";
  }
} 

function eToggleFunctions(anctag,darg) 
{
  //MsgBox(darg);
  var ele = document.getElementById(darg);
  var text = document.getElementById(anctag);
  if(ele.style.display == "block") 
  {
    ele.style.display = "none";
	text.innerHTML = "Show Functions Help";
  }
  else 
  {
	ele.style.display = "block";
	text.innerHTML = "Hide Functions Help";
  }
} 

function eToggleGeneral(anctag,darg) 
{
  //MsgBox(darg);
  var ele = document.getElementById(darg);
  var text = document.getElementById(anctag);
  if(ele.style.display == "block") 
  {
    ele.style.display = "none";
	text.innerHTML = "Show General Help";
  }
  else 
  {
	ele.style.display = "block";
	text.innerHTML = "Hide General Help";
  }
} 
</script>

</head>

<body>

<h1>navTango Main Page</h1>
<p>
&nbsp;
</p>	

<!--
Below is section where you implement the tabs. Add or subtract tabs as needed.
The tab name goes between the span tag.  
-->
<div id=etabs>
<ul>
  <li><a
  href="#tab-1"><span>Calendar</span></a> 
  <li><a
  href="#tab-2"><span>Calculator</span></a> 
</ul>
</div>

<!-- TAB1 ------------------------------------------------------------------ -->
<!-- Need to move this function back to being able to register both a user or a group -->
<div id="tab-1">
<h1>Calendar</h1>	
<?php echo $tab1msg; ?>
<?php echo $tsttabmsg1; ?>	
<SCRIPT LANGUAGE="JavaScript">


var bgColr="#FFFFFF"
var fontSz=3

eMonth = new Array("January","February","March","April","May","June","July","August","September","October","November","December");
Dow = new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");

function getCal3mon() {
 todayIs = new Date();
 var dateToday = todayIs.getDate();           
 currMon = todayIs.getMonth();    
 currYear = todayIs.getYear();     
 if (currYear < 2000) currYear = currYear + 1900; 

 yr = yr1 = (currMon==0?currYear-1:currYear); 
 mo = (currMon==0?11:currMon-1);  
 eDate = new Date(eMonth[mo]+" 1,"+yr1); 
 document.write('<table border=0><tr><td valign=top>');
 Calendar(eDate,dateToday,""); // display last month

 document.write('</td><td valign=top>');
 yr = currYear;              
 mo = currMon;              
 eDate = new Date(eMonth[mo]+" 1,"+yr);
 Calendar(eDate,dateToday,"y");           // display current month

 document.write('</td><td valign=top>');
 yr = (currMon==11?currYear+1:currYear); 
 mo = (currMon==11?0:currMon+1); 
 eDate = new Date(eMonth[mo]+" 1,"+yr); 
 Calendar(eDate,dateToday,"");  // display next month

 document.write('</td></tr></table>'); // Finish up
}

function Calendar(dte,dateToday,cmonth){
 day = dte.getDay();
 yr = eval(yr);
 d = "312831303130313130313031";
 if (yr / 4 == Math.floor(yr / 4)) {
 d = d.substring(0, 2) + "29" + d.substring(4, d.length);
 }
 pos = (mo * 2);
 ld = eval(d.substring(pos, pos + 2));
 document.write("<table border=1"
 + " bgcolor='" + bgColr
 + "'><tr><td align=center colspan=7 bgcolor='c8c8c8'>"
 + "<font size=" + fontSz + ">" + eMonth[mo] + " " + yr
 + "</font></td></tr><tr><tr>");
 for (var i = 0;i < 7;i ++) {
 document.write("<td align=center bgcolor='c8c8c8'>"
 +"<font size="+fontSz+">" + Dow[i] + "</font></td>");
 }
 document.write("</tr><tr>");
 ctr = 0;
 for (var i = 0;i < 7; i++){
  if (i < day) {
    document.write("<td align=center>"
    +"<font size=" + fontSz + "> </font>"
    +"</td>");
  }
 else {
 ctr++;

  if (ctr == dateToday && cmonth == 'y') {
   document.write("<td align=center bgcolor='cccccc'>"
   + "<font SIZE=" + fontSz + ">" + ctr + "</font>"
   + "</td>");
  } else {
   document.write("<td align=center>"
   + "<font SIZE=" + fontSz + ">" + ctr + "</font>"
   + "</td>");  	
  }	 

    }
 }
 document.write("</tr><tr>");
 while (ctr < ld) {
  for (var i = 0;i < 7; i++){
   ctr++;
   if (ctr > ld){
     document.write("<td align=center>"
     + " </td>");
   }
   else {

    if (ctr == dateToday && cmonth == 'y') {
     document.write("<td align=center bgcolor='cccccc'>"
     + "<font SIZE=" + fontSz + ">" + ctr + "</font>"
     + "</td>");
    } else {
     document.write("<td align=center>"
     + "<font SIZE=" + fontSz + ">" + ctr + "</font>"
     + "</td>");  	
    }

      }
   }
   document.write("</tr><tr>");
  }
 document.write("</tr></table>");
}

</SCRIPT>

<SCRIPT LANGUAGE="JavaScript">
  getCal3mon();
</SCRIPT>



</div>

<!-- TAB2 ------------------------------------------------------------------ -->
<div id="tab-2">
<h1>Calculator</h1>	

<noscript><p>This scientific calculator requires Javascript.  Please enable Javascript
in your browser's preferences and then reload this page if you wish to use this scientific calculator.</p></noscript>
<form name=calculator onSubmit="do_calculation();return false;">
<input class=line type=text name="line" onChange="line_change();">
<br>
<table summary="Calculator"><tr><td valign=top>
<table class=keypad summary="Button Keypad"><tr>
<td><input type="button" value="C" class="clear" accesskey=c onClick="clear_calc();" title="Clear (Alt-c)"></td>
<td><input type="button" value="(" class="other" onClick="append_calc('(',0);" title="Grouping Parenthesis"></td>
<td><input type="button" value=")" class="other" onClick="append_calc(')',0);" title="Grouping Parenthesis"></td>
<td><input type="button" value="+" class="operand" onClick="append_calc(' + ',1);" title="Addition"></td>
<td rowspan=5>
<input type="button" value="&amp;" class="advanced" onClick="append_calc(' &amp; ',2);" title="Bitwise And"><br>
<input type="button" value="|" class="advanced" onClick="append_calc(' | ',2);" title="Bitwise Or"><br>
<input type="button" value="^" class="advanced" onClick="append_calc(' ^ ',2);" title="Bitwise xOr"><br>
<input type="button" value="~" class="advanced" onClick="append_calc(' ~ ',2);" title="Bitwise Negation"><br>
<input type="button" value="&lt;&lt;" class="advanced" onClick="append_calc(' &lt;&lt; ',2);" title="Bitwise Left Shift"><br>
<input type="button" value="&gt;&gt;" class="advanced" onClick="append_calc(' &gt;&gt; ',2);" title="Bitwise Right Shift"><br>
<input type="button" value="%" class="advanced" onClick="append_calc(' % ',2);" title="Modular Division"><br>
<input type="button" value="," class="advanced" onClick="append_calc(', ',2);" title="Comma for functions"><br>
</td></tr><tr>
<td><input type="button" value="7" class="number" onClick="append_calc('7',0);" title="Seven"></td>
<td><input type="button" value="8" class="number" onClick="append_calc('8',0);" title="Eight"></td>
<td><input type="button" value="9" class="number" onClick="append_calc('9',0);" title="Nine"></td>
<td><input type="button" value="-" class="operand" onClick="append_calc(' - ',1);" title="Subtraction"></td>
</tr><tr>
<td><input type="button" value="4" class="number" onClick="append_calc('4',0);" title="Four"></td>
<td><input type="button" value="5" class="number" onClick="append_calc('5',0);" title="Five"></td>
<td><input type="button" value="6" class="number" onClick="append_calc('6',0);" title="Six"></td>
<td><input type="button" value="*" class="operand" onClick="append_calc(' * ',1);" title="Multiplication"></td>
</tr><tr>
<td><input type="button" value="1" class="number" onClick="append_calc('1',0);" title="One"></td>
<td><input type="button" value="2" class="number" onClick="append_calc('2',0);" title="Two"></td>
<td><input type="button" value="3" class="number" onClick="append_calc('3',0);" title="Three"></td>
<td><input type="button" value="&#247;" class="operand" onClick="append_calc(' / ',1);" title="Division"></td>
</tr><tr>
<td><input type="button" value="EE" class="other" onClick="append_calc('e',2);" title="Scientific Notation Exponent"></td>
<td><input type="button" value="0" class="number" onClick="append_calc('0',0);" title="Zero"></td>
<td><input type="button" value="." class="other" onClick="append_calc('.',2);" title="Decimal Point"></td>
<td><input type="button" value="=" class="equal" accesskey=e onClick="do_calculation();" title="Enter (Alt-e)"></td>
</tr></table>
</td><td valign=top>
<p><small>Display:</small><br>
<select name=display class=display onChange="display_result();save_calc();" title="(Alt-d)">
<option selected>Decimal (Mixed Notation)
<option>Decimal (Scientific Notation)
<option>Decimal (Engineering Notation)
<option>Hexadecimal
<option>Octal
<option>Binary
</select></p>
<p><select name=history class=history onChange="if(this.selectedIndex>0)set_calc(this.options[this.selectedIndex].text);" title="View previous entries (Alt-h)">
<option>History:
<option><option><option><option><option><option><option><option><option>
<option><option><option><option><option><option><option><option><option><option>
</select></p>
<p><select name=mathConstants class=mathConstants onChange="append_calc(this.options[this.selectedIndex].value,0);this.selectedIndex=0;">
<option>Math Constants:
<option value="ans ">last result
<option value="E ">e
<option value="LN10 ">ln(10)
<option value="LN2 ">ln(2)
<option value="LOG10E ">log10(e)
<option value="LOG2E ">log2(e)
<option value="PI ">&pi;
<option value="SQRT1_2 ">sqrt(1/2)
<option value="SQRT2 ">sqrt(2)

</select>&nbsp;</p>
<div id="showhelpConstants">
<a id="atag1" href="javascript:eToggleContants('atag1','helptxtConstants');">Show Constants Help</a>
</div>
<div id="helptxtConstants" style="display: none">
<h2>Constants</h2>
<table border=1 cellspacing=0 cellpadding=2>
<tr><td align=right>ans</td><td>The last calculated result</td></tr>
<tr><td align=right>PI</td><td>pi = 3.14159265...</td></tr>
<tr><td align=right>E</td><td>e = 2.71828182...</td></tr>
<tr><td align=right>LOG2E</td><td>log of e base 2</td></tr>
<tr><td align=right>LOG10E</td><td>log of e base 10</td></tr>
<tr><td align=right>LN2</td><td>log of 2 base e</td></tr>
<tr><td align=right>LN10</td><td>log of 10 base e</td></tr>
<tr><td align=right>SQRT2</td><td>square root of 2</td></tr>
<tr><td align=right>SQRT1_2</td><td>square root of 1/2</td></tr>
</table>  
</div>

<p><select name=mathFunctions class=mathFunctions onChange="append_calc(this.options[this.selectedIndex].value,0);this.selectedIndex=0;">
<option>Math Functions:
<option value="abs(">abs
<option value="acos(">acos
<option value="asin(">asin
<option value="atan(">atan
<option value="atan2(">atan2
<option value="ceil(">ceil
<option value="cos(">cos
<option value="exp(">exp
<option value="floor(">floor
<option value="log(">log
<option value="max(">max
<option value="min(">min
<option value="pow(">pow
<option value="random()">random
<option value="round(">round
<option value="sin(">sin
<option value="sqrt(">sqrt
<option value="tan(">tan

</select>&nbsp;</p>
<div id="showhelpFunctions">
<a id="atag2" href="javascript:eToggleFunctions('atag2','helptxtFunctions');">Show Functions Help</a>
</div>
<div id="helptxtFunctions" style="display: none">
<h2>Functions</h2>
<table border=1 cellspacing=0 cellpadding=2>
<tr><td align=right>abs(a)</td><td>the absolute value of a</td></tr>
<tr><td align=right>acos(a)</td><td>arc cosine of a</td></tr>
<tr><td align=right>asin(a)</td><td>arc sine of a</td></tr>
<tr><td align=right>atan(a)</td><td>arc tangent of a</td></tr>
<tr><td align=right>atan2(a,b)</td><td>arc tangent of a/b</td></tr>
<tr><td align=right>ceil(a)</td><td>integer closest to a and not less than a</td></tr>
<tr><td align=right>cos(a)</td><td>cosine of a</td></tr>
<tr><td align=right>exp(a)</td><td>exponent of a</td></tr>
<tr><td align=right>floor(a)</td><td>integer closest to and not greater than a</td></tr>
<tr><td align=right>log(a)</td><td>log of a base e</td></tr>
<tr><td align=right>max(a,b)</td><td>the maximum of a and b</td></tr>
<tr><td align=right>min(a,b)</td><td>the minimum of a and b</td></tr>
<tr><td align=right>pow(a,b)</td><td>a to the power b</td></tr>
<tr><td align=right>random()</td><td>pseudorandom number in the range 0 to 1</td></tr>
<tr><td align=right>round(a)</td><td>integer closest to a </td></tr>
<tr><td align=right>sin(a)</td><td>sine of a</td></tr>
<tr><td align=right>sqrt(a)</td><td>square root of a</td></tr>
<tr><td align=right>tan(a)</td><td>tangent of a</td></tr>
</table>  
</div>

</select>&nbsp;</p>
<div id="showhelpGeneral">
<a id="atag3" href="javascript:eToggleGeneral('atag3','helptxtGeneral');">Show General Help</a>
</div>
<div id="helptxtGeneral" style="display: none">
<h2>General Information</h2>
<p>Enter an expression into the tan bar and press enter to calculate the results.  </p>

<p>This calculator remembers up to twenty past calculations in history.  To save the history
between visits you must have cookies enabled.</p>

<p>All results are calculated using the Javascript eval() function.  Syntax for expressions
is the same as that for Javascript.</p>

<p>This calculator can handle input numbers in several different bases:</p>
<ul>
<li>Decimal (Base 10): Numbers that do not start with a zero like 15 or 3.14e15.
Decimal numbers can contain digits 0-9, decimals, and scientific notation.</li>
<li>Hexadecimal (Base 16): Integers that start with a zero x like 0x1a5.  Hexadecimal numbers
can contain digits 0-9 and a-f (or A-F) but no decimal or scientific notation.</li>
<li>Octal (Base 8): Integers that start with a zero like 073.  Octal numbers
can contain digits 0-7 but no decimal or scientific notation.</li>
<li>Binary (Base 2): Integers that start with a zero b like 0b101.  Binary numbers
can contain digits 0 and 1 but no decimal or scientific notation.</li>
</ul>

<p>^ is a bitwise xor operation.  To raise a number to a power use pow() function.</p> 
</div>

	
</body>

</html>