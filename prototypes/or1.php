<?php
session_start();

header("Pragma: no-cache");

/* Grab the current server time. */
$gDate = time();
/* Are the seconds shown by default? When changing this, also change the
   JavaScript client code's definition of clockShowsSeconds below to match. */
$gClockShowsSeconds = false;

/*
Our goal here is to take 1d and morph it to add a form that appears as part of
the event trigger. This version introduces the concept of the distributed form.
*/
$_SESSION['tmp'] = '';

$data1AM = "8:00am - Sally  Carver (2390001)";
$data2AM = "8:30am - Mary Meigh (0985574)";
$data3AM = "10:00am - Joseph Franco (977519)";
$data4AM = "11:45am - Arnold Ziffle (8977012)";
//scheduled patient pm patient hotlist
$data1PM = "12:15pm - Joseph L. Dokes (1993201)";
$data2PM = "2:00pm - Allan Together (9880874)";
$data3PM = "3:20pm - Margie Nokia (9786533)";
$data4PM = "3:20pm - Jennie Tonnelson (7800644)";
$data5PM = "4:00pm - Angela Farklemeyer (9086428)";

//visual data container for drop-n-drag operations. simple, but mondo powerful
$_SESSION['vDC1'] = '<p id="vDC1" class="ui-state-default">' . $data1AM . '</p>';
$_SESSION['vDC2'] = '<p id="vDC2" class="ui-state-default">' . $data2AM . '</p>';
$_SESSION['vDC3'] = '<p id="vDC3" class="ui-state-default">' . $data3AM . '</p>';
$_SESSION['vDC4'] = '<p id="vDC4" class="ui-state-default">' . $data4AM . '</p>';
$_SESSION['vDC5'] = '<p id="vDC5" class="ui-state-default">' . $data1PM . '</p>';
$_SESSION['vDC6'] = '<p id="vDC6" class="ui-state-default">' . $data2PM . '</p>';
$_SESSION['vDC7'] = '<p id="vDC7" class="ui-state-default">' . $data3PM . '</p>';
$_SESSION['vDC8'] = '<p id="vDC8" class="ui-state-default">' . $data4PM . '</p>';
$_SESSION['vDC9'] = '<p id="vDC9" class="ui-state-default">' . $data5PM . '</p>';
//-----------------------------------------------------------------------------


//object context management
   if (isset($_SESSION['vObj_init'])) {

     //is ui calling?
     $_SESSION['vObj_init'] = $_SESSION['vObj_init'] + 1;
 
     if ($_REQUEST['ddEvent'] == 'OK') {
        contextKeeper ();
     }	 
    
    } 

   // deal with first time access
   else {
          $_SESSION['vObj_init'] = 0;
        	$_SESSION['vLC1'] = $_SESSION['vDC1'] . $_SESSION['vDC2'] . $_SESSION['vDC3'] . $_SESSION['vDC4'];  	
        	$_SESSION['vLC2'] = $_SESSION['vDC5'] . $_SESSION['vDC6'] . $_SESSION['vDC7'] . $_SESSION['vDC8'] . $_SESSION['vDC9'];
        	$_SESSION['vLC3'] = "";  	
   }	

//_____________FUNCTIONS______________________________________________________//
//-----------------------------------------------------------------------------
function contextKeeper ()
//-----------------------------------------------------------------------------
{
       if (trim($_REQUEST['tb_ddWrap1']) == '' and 
           trim($_REQUEST['tb_ddWrap2']) == '' and
           trim($_REQUEST['tb_ddWrap3']) == '' and
           trim($_REQUEST['tb_ddWrap4']) == '' and
           trim($_REQUEST['tb_ddWrap5']) == '' and
           trim($_REQUEST['tb_ddWrap6']) == '' and                                            
           trim($_REQUEST['tb_ddWrap7']) == '' and
           trim($_REQUEST['tb_ddWrap8']) == '' and
           trim($_REQUEST['tb_ddWrap9']) == '' and
           trim($_REQUEST['tb_ddWrap10']) == '' and 
           trim($_REQUEST['tb_ddWrap11']) == '' and                                            
           trim($_REQUEST['tb_ddWrap12']) == '' and
           trim($_REQUEST['tb_ddWrap13']) == '' and
           trim($_REQUEST['tb_ddWrap14']) == '' and
           trim($_REQUEST['tb_ddWrap15']) == '' and 
           trim($_REQUEST['tb_ddWrap16']) == '') {
          // status quo, do nothing      	
        }    	
        else {
        // process each vObj
           if (trim($_REQUEST['tb_ddWrap1'] != '')) {
               $_SESSION['vLC1'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap1']);
               set_vDC_ObjectContext($rHsh,'vLC1');
           } else { $_SESSION['vLC1'] = "";}  	

           if (trim($_REQUEST['tb_ddWrap2'] != '')) {
               $_SESSION['vLC2'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap2']);
               set_vDC_ObjectContext($rHsh,'vLC2');
           } else { $_SESSION['vLC2'] = "";} 

           if (trim($_REQUEST['tb_ddWrap3'] != '')) {
               $_SESSION['vLC3'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap3']);
               set_vDC_ObjectContext($rHsh,'vLC3');
           } else { $_SESSION['vLC3'] = "";} 

           if (trim($_REQUEST['tb_ddWrap4'] != '')) {
               $_SESSION['vLC4'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap4']);
               set_vDC_ObjectContext($rHsh,'vLC4');
           } else { $_SESSION['vLC4'] = "";} 

           if (trim($_REQUEST['tb_ddWrap5'] != '')) {
               $_SESSION['vLC5'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap5']);
               set_vDC_ObjectContext($rHsh,'vLC5');
           } else { $_SESSION['vLC5'] = "";} 

           if (trim($_REQUEST['tb_ddWrap6'] != '')) {
               $_SESSION['vLC6'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap6']);
               set_vDC_ObjectContext($rHsh,'vLC6');
           } else { $_SESSION['vLC6'] = "";} 

           if (trim($_REQUEST['tb_ddWrap7'] != '')) {
               $_SESSION['vLC7'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap7']);
               set_vDC_ObjectContext($rHsh,'vLC7');
           } else { $_SESSION['vLC7'] = "";} 

           if (trim($_REQUEST['tb_ddWrap8'] != '')) {
               $_SESSION['vLC8'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap8']);
               set_vDC_ObjectContext($rHsh,'vLC8');
           } else { $_SESSION['vLC8'] = "";} 

           if (trim($_REQUEST['tb_ddWrap9'] != '')) {
               $_SESSION['vLC9'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap9']);
               set_vDC_ObjectContext($rHsh,'vLC9');
           } else { $_SESSION['vLC9'] = "";}

           if (trim($_REQUEST['tb_ddWrap10'] != '')) {
               $_SESSION['vLC10'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap10']);
               set_vDC_ObjectContext($rHsh,'vLC10');
           } else { $_SESSION['vLC10'] = "";}

           if (trim($_REQUEST['tb_ddWrap11'] != '')) {
               $_SESSION['vLC11'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap11']);
               set_vDC_ObjectContext($rHsh,'vLC11');
           } else { $_SESSION['vLC11'] = "";}

           if (trim($_REQUEST['tb_ddWrap12'] != '')) {
               $_SESSION['vLC12'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap12']);
               set_vDC_ObjectContext($rHsh,'vLC12');
           } else { $_SESSION['vLC12'] = "";}

           if (trim($_REQUEST['tb_ddWrap13'] != '')) {
               $_SESSION['vLC13'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap13']);
               set_vDC_ObjectContext($rHsh,'vLC13');
           } else { $_SESSION['vLC13'] = "";}

           if (trim($_REQUEST['tb_ddWrap14'] != '')) {
               $_SESSION['vLC14'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap14']);
               set_vDC_ObjectContext($rHsh,'vLC14');
           } else { $_SESSION['vLC14'] = "";}

           if (trim($_REQUEST['tb_ddWrap15'] != '')) {
               $_SESSION['vLC15'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap15']);
               set_vDC_ObjectContext($rHsh,'vLC15');
           } else { $_SESSION['vLC15'] = "";}

           if (trim($_REQUEST['tb_ddWrap16'] != '')) {
               $_SESSION['vLC16'] = '';
               $rHsh = vObjDetectorDecoupler ($_REQUEST['tb_ddWrap16']);
               set_vDC_ObjectContext($rHsh,'vLC16');
           } else { $_SESSION['vLC16'] = "";}

        }

}	

//-----------------------------------------------------------------------------
function set_vDC_ObjectContext ($hsh,$vLC)
//-----------------------------------------------------------------------------
{
   foreach( $hsh as $k => $v) {
     $s = preg_split("/##/", $k);
     if (preg_match('/vDC1/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC1'];}  
     if (preg_match('/vDC2/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC2'];} 
     if (preg_match('/vDC3/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC3'];}                  
     if (preg_match('/vDC4/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC4'];} 
     if (preg_match('/vDC5/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC5'];}                 
     if (preg_match('/vDC6/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC6'];} 
     if (preg_match('/vDC7/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC7'];}     
     if (preg_match('/vDC8/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC8'];} 
     if (preg_match('/vDC9/', $s[1])){$_SESSION[$vLC] .= $_SESSION['vDC9'];} 
   }	
}	


//-----------------------------------------------------------------------------
function vObjDetectorDecoupler ($objStr)
//-----------------------------------------------------------------------------
/*
role: determine atomicity of string and decouple and return as a hash. we will
potentially encounter: 0 objects; 1 object within a container; multiple objects
within a container. how we determine if we have 1 or multiple is by the 
presence of ~~ which is our object delimiter. The atomicity of an object
itself is determined by the ## delimiter.  
*/
{
  $vObjHash;
  //first, am i single or plural
  // i am plural, further slicing, then hash me
  if (preg_match('/~~/', $objStr)) { 
     //slash me 
     $s = preg_split("/~~/", $objStr);
     //hash me 
     $cntr = 0;
     foreach ($s as $kvp) { 
       // $_SESSION['tmp'] .= "<br />counter outside loops is" . $cntr++ . "<br />";
       if (preg_match('/##/', $kvp))	{
       	  // $_SESSION['tmp'] .= "counter inside loops is" . $cntr++ . "<br />";
          $v = preg_split("/``/", $kvp);
          // $_SESSION['tmp'] .= $v[0] . $v[1]; 
          $vObjHash[$v[0]] = $v[1];
       }    	 
     }		
  }
  else {  // i am singular, hash me
    if (preg_match('/##/', $objStr))	{
      $v = preg_split("/``/", $objStr);
      $vObjHash[$v[0]] = $v[1];
    }
  }		

//returned hash matches pattern key= ddWrap<ltr><n>##vDC<ltr><n> value= $data<n>	
	return $vObjHash;
	
}	

//-----------------------------------------------------------------------------
function getServerDateItems($inDate) {
//-----------------------------------------------------------------------------
	return date('Y,n,j,G,',$inDate).intval(date('i',$inDate)).','.intval(date('s',$inDate));
	// year (4-digit),month,day,hours (0-23),minutes,seconds
	// use intval to strip leading zero from minutes and seconds
	//   so JavaScript won't try to interpret them in octal
	//   (use intval instead of ltrim, which translates '00' to '')
}

//-----------------------------------------------------------------------------
function clockDateString($inDate) {
//-----------------------------------------------------------------------------
    return date('l, F j, Y',$inDate);    // eg "Monday, January 1, 2002"
}

//-----------------------------------------------------------------------------
function clockTimeString($inDate, $showSeconds) {
//-----------------------------------------------------------------------------	
    return date($showSeconds ? 'g:i:s' : 'g:i',$inDate).' ';
}


?>
<!DOCTYPE html>
<html>
<head>
<title>Drop & Drag on to div Event</title>
<meta content="text/html; charset=windows-1252" http-equiv=Content-Type>

<link rel="stylesheet" type="text/css" href="stylesheet/mncontent.css" />
<link rel=stylesheet type=text/css href="jquery/stylesheet/uidropdragcustom.css">
<script language=JavaScript type=text/javascript src="jquery/jquery.min132.js"></script>
<script language=JavaScript type=text/javascript src="jquery/jquery-ui.min172.js"></script>

<script language="JavaScript" type="text/javascript">
<!--
/* set up variables used to init clock in BODY's onLoad handler;
   should be done as early as possible */
var clockLocalStartTime = new Date();
var clockServerStartTime = new Date(<?php echo(getServerDateItems($gDate))?>);

/* stub functions for older browsers;
   will be overridden by next JavaScript1.2 block */
function clockInit() {
}
//-->
</script>
<script language="JavaScript1.2" type="text/javascript">
<!--
/*** simpleFindObj, by Andrew Shearer

Efficiently finds an object by name/id, using whichever of the IE,
classic Netscape, or Netscape 6/W3C DOM methods is available.
The optional inLayer argument helps Netscape 4 find objects in
the named layer or floating DIV. */
function simpleFindObj(name, inLayer) {
	return document[name] || (document.all && document.all[name])
		|| (document.getElementById && document.getElementById(name))
		|| (document.layers && inLayer && document.layers[inLayer].document[name]);
}

var clockIncrementMillis = 60000;
var localTime;
var clockOffset;
var clockExpirationLocal;
var clockShowsSeconds = false;
var clockTimerID = null;

function clockInit(localDateObject, serverDateObject)
{
    var origRemoteClock = parseInt(clockGetCookieData("remoteClock"));
    var origLocalClock = parseInt(clockGetCookieData("localClock"));
    var newRemoteClock = serverDateObject.getTime();
    // May be stale (WinIE); will check against cookie later
    // Can't use the millisec. ctor here because of client inconsistencies.
    var newLocalClock = localDateObject.getTime();
    var maxClockAge = 60 * 60 * 1000;   // get new time from server every 1hr

    if (newRemoteClock != origRemoteClock) {
        // new clocks are up-to-date (newer than any cookies)
        document.cookie = "remoteClock=" + newRemoteClock;
        document.cookie = "localClock=" + newLocalClock;
        clockOffset = newRemoteClock - newLocalClock;
        clockExpirationLocal = newLocalClock + maxClockAge;
        localTime = newLocalClock;  // to keep clockUpdate() happy
    }
    else if (origLocalClock != origLocalClock) {
        // error; localClock cookie is invalid (parsed as NaN)
        clockOffset = null;
        clockExpirationLocal = null;
    }
    else {
        // fall back to clocks in cookies
        clockOffset = origRemoteClock - origLocalClock;
        clockExpirationLocal = origLocalClock + maxClockAge;
        localTime = origLocalClock;
        // so clockUpdate() will reload if newLocalClock
        // is earlier (clock was reset)
    }
    /* Reload page at server midnight to display the new date,
       by expiring the clock then */
    var nextDayLocal = (new Date(serverDateObject.getFullYear(),
            serverDateObject.getMonth(),
            serverDateObject.getDate() + 1)).getTime() - clockOffset;
    if (nextDayLocal < clockExpirationLocal) {
        clockExpirationLocal = nextDayLocal;
    }
}

function clockOnLoad()
{
    clockUpdate();
}

function clockOnUnload() {
    clockClearTimeout();
}

function clockClearTimeout() {
    if (clockTimerID) {
        clearTimeout(clockTimerID);
        clockTimerID = null;
    }
}

function clockToggleSeconds()
{
    clockClearTimeout();
    if (clockShowsSeconds) {
        clockShowsSeconds = false;
        clockIncrementMillis = 60000;
    }
    else {
        clockShowsSeconds = true;
        clockIncrementMillis = 1000;
    }
    clockUpdate();
}

function clockTimeString(inHours, inMinutes, inSeconds) {
    return inHours == null ? "-:--" : ((inHours == 0
                   ? "12" : (inHours <= 12 ? inHours : inHours - 12))
                + (inMinutes < 10 ? ":0" : ":") + inMinutes
                + (clockShowsSeconds
                   ? ((inSeconds < 10 ? ":0" : ":") + inSeconds) : "")
                + (inHours < 12 ? " AM" : " PM"));
}

function clockDisplayTime(inHours, inMinutes, inSeconds) {
    
    clockWriteToDiv("ClockTime", clockTimeString(inHours, inMinutes, inSeconds));
}

function clockWriteToDiv(divName, newValue) // APS 6/29/00
{
    var divObject = simpleFindObj(divName);
    newValue = '<p>' + newValue + '<' + '/p>';
    if (divObject && divObject.innerHTML) {
        divObject.innerHTML = newValue;
    }
    else if (divObject && divObject.document) {
        divObject.document.writeln(newValue);
        divObject.document.close();
    }
    // else divObject wasn't found; it's only a clock, so don't bother complaining
}

function clockGetCookieData(label) {
    /* find the value of the specified cookie in the document's
    semicolon-delimited collection. For IE Win98 compatibility, search
    from the end of the string (to find most specific host/path) and
    don't require "=" between cookie name & empty cookie values. Returns
    null if cookie not found. One remaining problem: Under IE 5 [Win98],
    setting a cookie with no equals sign creates a cookie with no name,
    just data, which is indistinguishable from a cookie with that name
    but no data but can't be overwritten by any cookie with an equals
    sign. */
    var c = document.cookie;
    if (c) {
        var labelLen = label.length, cEnd = c.length;
        while (cEnd > 0) {
            var cStart = c.lastIndexOf(';',cEnd-1) + 1;
            /* bug fix to Danny Goodman's code: calculate cEnd, to
            prevent walking the string char-by-char & finding cookie
            labels that contained the desired label as suffixes */
            // skip leading spaces
            while (cStart < cEnd && c.charAt(cStart)==" ") cStart++;
            if (cStart + labelLen <= cEnd && c.substr(cStart,labelLen) == label) {
                if (cStart + labelLen == cEnd) {                
                    return ""; // empty cookie value, no "="
                }
                else if (c.charAt(cStart+labelLen) == "=") {
                    // has "=" after label
                    return unescape(c.substring(cStart + labelLen + 1,cEnd));
                }
            }
            cEnd = cStart - 1;  // skip semicolon
        }
    }
    return null;
}

/* Called regularly to update the clock display as well as onLoad (user
   may have clicked the Back button to arrive here, so the clock would need
   an immediate update) */
function clockUpdate()
{
    var lastLocalTime = localTime;
    localTime = (new Date()).getTime();
    
    /* Sanity-check the diff. in local time between successive calls;
       reload if user has reset system clock */
    if (clockOffset == null) {
        clockDisplayTime(null, null, null);
    }
    else if (localTime < lastLocalTime || clockExpirationLocal < localTime) {
        /* Clock expired, or time appeared to go backward (user reset
           the clock). Reset cookies to prevent infinite reload loop if
           server doesn't give a new time. */
        document.cookie = 'remoteClock=-';
        document.cookie = 'localClock=-';
        location.reload();      // will refresh time values in cookies
    }
    else {
        // Compute what time would be on server 
        var serverTime = new Date(localTime + clockOffset);
        clockDisplayTime(serverTime.getHours(), serverTime.getMinutes(),
            serverTime.getSeconds());
        
        // Reschedule this func to run on next even clockIncrementMillis boundary
        clockTimerID = setTimeout("clockUpdate()",
            clockIncrementMillis - (serverTime.getTime() % clockIncrementMillis));
    }
}
/*** End of Clock ***/
//-->
</script>

<script language=JavaScript type=text/javascript>
  $(document).ready(function()  {
     clockInit(clockLocalStartTime, clockServerStartTime);
     clockOnLoad(); 
     clockOnUnload();

        $('#vLC16_form').hide();

		$( "#ddWrap16" ).droppable({
			drop: function( event, ui ) {
             $('#vLC16_form').fadeIn(50);
			}
		});
  });

	$(function() {
		
		$("td.droptrue").sortable({  
			 connectWith: 'td', 				
			 opacity: 0.6,      				
			 update : updateLocs 
		});

	});
	
  function updateLocs() {
		updLoc1();
		updLoc2();
		updLoc3();				
		updLoc4();
		updLoc5();
		updLoc6();				
		updLoc7();
		updLoc8();
		updLoc9();
		updLoc10();
		updLoc11();
		updLoc12();		
		updLoc13();
		updLoc14();
		updLoc15();
		updLoc16();
  }	

	function updLoc1() { 
		var arr = [];
		var ddW = $("#ddWrap1").attr('id');
		var vObj;
	  $("#ddWrap1 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap1').val(arr.join('~~'));
  }	

	function updLoc2() { 
		var arr = [];
		var ddW = $("#ddWrap2").attr('id');
		var vObj;
	  $("#ddWrap2 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap2').val(arr.join('~~'));
  }	

	function updLoc3() { 
		var arr = [];
		var ddW = $("#ddWrap3").attr('id');
		var vObj;
	  $("#ddWrap3 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap3').val(arr.join('~~'));
  }	

	function updLoc4() { 
		var arr = [];
		var ddW = $("#ddWrap4").attr('id');
		var vObj;
	  $("#ddWrap4 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap4').val(arr.join('~~'));
  }	
  
	function updLoc5() { 
		var arr = [];
		var ddW = $("#ddWrap5").attr('id');
		var vObj;
	  $("#ddWrap5 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap5').val(arr.join('~~'));
  }	  

	function updLoc6() { 
		var arr = [];
		var ddW = $("#ddWrap6").attr('id');
		var vObj;
	  $("#ddWrap6 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap6').val(arr.join('~~'));
  }	 
  
	function updLoc7() { 
		var arr = [];
		var ddW = $("#ddWrap7").attr('id');
		var vObj;
	  $("#ddWrap7 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap7').val(arr.join('~~'));
  }	   
 
	function updLoc8() { 
		var arr = [];
		var ddW = $("#ddWrap8").attr('id');
		var vObj;
	  $("#ddWrap8 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap8').val(arr.join('~~'));
  }	
 
 	function updLoc9() { 
		var arr = [];
		var ddW = $("#ddWrap9").attr('id');
		var vObj;
	  $("#ddWrap9 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap9').val(arr.join('~~'));
  }	  

 	function updLoc10() { 
		var arr = [];
		var ddW = $("#ddWrap10").attr('id');
		var vObj;
	  $("#ddWrap10 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap10').val(arr.join('~~'));
  }	 
  
  	function updLoc11() { 
		var arr = [];
		var ddW = $("#ddWrap11").attr('id');
		var vObj;
	  $("#ddWrap11 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap11').val(arr.join('~~'));
  }	  
 
  	function updLoc12() { 
		var arr = [];
		var ddW = $("#ddWrap12").attr('id');
		var vObj;
	  $("#ddWrap12 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap12').val(arr.join('~~'));
  }	
  
  	function updLoc13() { 
		var arr = [];
		var ddW = $("#ddWrap13").attr('id');
		var vObj;
	  $("#ddWrap13 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap13').val(arr.join('~~'));
  }	   
 
  	function updLoc14() { 
		var arr = [];
		var ddW = $("#ddWrap14").attr('id');
		var vObj;
	  $("#ddWrap14 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap14').val(arr.join('~~'));
  }	 

  	function updLoc15() { 
		var arr = [];
		var ddW = $("#ddWrap15").attr('id');
		var vObj;
	  $("#ddWrap15 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap15').val(arr.join('~~'));
  }	    
  
	function updLoc16() { 
		var arr = [];
		var ddW = $("#ddWrap16").attr('id');
		var vObj;
		var dischPat;
	  $("#ddWrap16 p").each(function(){
	  	vObj = ddW + '##' + $(this).attr('id') + '``' + $(this).html();
		dischPat = $(this).html();
		$('#discharged_patient').val(dischPat);
	    arr.push(vObj);
	  });
	  $('#tb_ddWrap16').val(arr.join('~~'));

    if ($("#td_ddWrap16").val() === '') {
    	 $('#vLC16_form').hide();
    } 
  }	  
  
 
</script>

<style type=text/css>
.ui-state-default { margin-top: 0px; margin-bottom: 5px; }

.tblVessel table {
	width: 200px;
}

.tblVessel td {
	 background-color: #CCCCCC;	
	 height: 30px;
	 width: 150px;
}
	
	
#vLC1 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:1;
	left: 17px;
	top: 325px;
}
#vLC2 {
	cursor: pointer;
	position:absolute;
	width:175px;
	z-index:1;
	left: 211px;
	top: 325px;
}
#vLC3 {
	cursor: pointer;
	position:absolute;
	width:177px;
	z-index:10;
	left: 35px;
	top: 14px;
}
#vLC4 {
	cursor: pointer;
	position:absolute;
	width:177px;
	z-index:10;
	left: 34px;
	top: 87px;
}
#vLC5 {
	cursor: pointer;
	position:absolute;
	width:174px;
	z-index:10;
	left: 36px;
	top: 159px;
}
#vLC6 {
	cursor: pointer;
	position:absolute;
	width:177px;
	z-index:10;
	left: 34px;
	top: 225px;
}
#vLC7 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 828px;
	top: 12px;
}
#vLC8 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 829px;
	top: 82px;
}
#vLC9 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 828px;
	top: 149px;
}
#vLC10 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 827px;
	top: 222px;
}
#vLC11 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 301px;
	top: 88px;
}
#vLC12 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 581px;
	top: 87px;
}
#vLC13 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 298px;
	top: 257px;
}
#vLC14 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 583px;
	top: 259px;
}
#vLC15 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 486px;
	top: 334px;
}
#vLC16 {
	cursor: pointer;
	position:absolute;
	width:180px;
	z-index:10;
	left: 792px;
	top: 347px;
}
#vObjConsole {
	cursor: pointer;
	position:absolute;
	width:400px;
	z-index:1;
	left: 35px;
	top: 760px;
}

#vDC1 {  }
#vDC2 {  }
#vDC3 {  }
#vDC4 {  }
#vDC5 {  }
#vDC6 {  }
#vDC7 {  }
#vDC8 {  }
#vDC9 {  }

#vLC16_form {
	position:absolute;
	width:729px;
	height:377px;
	z-index:50;
	left: 16px;
	top: 234px;
	background-color: #9CF
}
#frm_btn {
	position:absolute;
	width:50px;
	height:35px;
	z-index:15;
	left: 514px;
	top: 500px;
}
#preop {
	position:absolute;
	width:184px;
	height:294px;
	z-index:5;
	left: 26px;
	top: 9px;
}
#oprooms {
	position:absolute;
	width:375px;
	height:215px;
	z-index:5;
	left: 330px;
	top: 89px;
}
#recovery {
	position:absolute;
	width:175px;
	height:294px;
	z-index:5;
	left: 819px;
	top: 6px;
}
#dischfolder {
	position:absolute;
	width:35px;
	height:30px;
	z-index:11;
	left: 754px;
	top: 349px;
}
#noshowfolder {
	position:absolute;
	width:35px;
	height:30px;
	z-index:11;
	left: 448px;
	top: 337px;
}
#facility {
	position:absolute;
	width:446px;
	height:26px;
	z-index:16;
	left: 230px;
	top: 5px;
}
#dept {
	position:absolute;
	width:132px;
	height:26px;
	z-index:17;
	left: 228px;
	top: 23px;
}
#currdate {
	position:absolute;
	width:193px;
	height:26px;
	z-index:18;
	left: 366px;
	top: 46px;
}
#currtime {
	position:absolute;
	width:118px;
	height:26px;
	z-index:19;
	left: 563px;
	top: 46px;
}
#noshowlist {
	position:absolute;
	width:207px;
	height:31px;
	z-index:20;
	left: 447px;
	top: 295px;
}
#dischlist {
	position:absolute;
	width:201px;
	height:25px;
	z-index:21;
	left: 749px;
	top: 307px;
}
#preop_lbl {
	position:absolute;
	width:119px;
	height:20px;
	z-index:22;
	left: 28px;
	top: 298px;
}
#recovery_lbl {
	position:absolute;
	width:65px;
	height:21px;
	z-index:23;
	left: 933px;
	top: 296px;
}
</style>

</head>

<body>
<!-- Scheduled List -->
<div id="vLC1">
<h2>Scheduled - AM</h2>
<table class="tblVessel">
 <tr><td class="droptrue" id="ddWrap1" name="ddWrap1">
<?php echo $_SESSION['vLC1']; ?>
 </td></tr>
  </table> 
</div>

<div id="vLC2">
<h2>Scheduled - PM</h2>
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap2" name="ddWrap2">
<?php echo $_SESSION['vLC2']; ?>  	
</td></tr>
</table> 
</div>
<!-- Pre-Op Beds-->
<div id="vLC3">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap3" name="ddWrap3">  
<?php echo $_SESSION['vLC3']; ?>&nbsp;PO1
</td></tr>
</table> 
</div>

<div id="vLC4">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap4" name="ddWrap4">  
<?php echo $_SESSION['vLC4']; ?>&nbsp;PO2
</td></tr>
</table> 
</div>

<div id="vLC5">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap5" name="ddWrap5"> 
<?php echo $_SESSION['vLC5']; ?> &nbsp;PO3 
</td></tr>
</table> 
</div>

<div id="vLC6">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap6" name="ddWrap6">
<?php echo $_SESSION['vLC6']; ?> &nbsp;PO4
</td></tr>
</table> 
</div>
<!-- Operating Rooms -->
<div id="vLC7">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap7" name="ddWrap7">
<?php echo $_SESSION['vLC7']; ?> &nbsp;RCV1
</td></tr>
</table> 
</div>

<div id="vLC8">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap8" name="ddWrap8">
<?php echo $_SESSION['vLC8']; ?> &nbsp;RCV2
</td></tr>
</table> 
</div>

<div id="vLC9">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap9" name="ddWrap9">
<?php echo $_SESSION['vLC9']; ?> &nbsp;RCV3
</td></tr>
</table> 
</div>

<div id="vLC10">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap10" name="ddWrap10">
<?php echo $_SESSION['vLC10']; ?> &nbsp;RCV4
</td></tr>
</table> 
</div>
<!-- Recovery Rooms -->
<div id="vLC11">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap11" name="ddWrap11">
<?php echo $_SESSION['vLC11']; ?>
</td></tr>
</table> 
</div>

<div id="vLC12">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap12" name="ddWrap12">
<?php echo $_SESSION['vLC12']; ?>
</td></tr>
</table> 
</div>

<div id="vLC13">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap13" name="ddWrap13">
<?php echo $_SESSION['vLC13']; ?>
</td></tr>
</table> 
</div>

<div id="vLC14">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap14" name="ddWrap14">
<?php echo $_SESSION['vLC14']; ?>
</td></tr>
</table> 
</div>

<!-- Discharges -->
<div id="vLC15">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap15" name="ddWrap15">
<?php echo $_SESSION['vLC15']; ?>
</td></tr>
</table> 
</div>

<!-- No Shows -->
<div id="vLC16">
<table class="tblVessel">
<tr><td class="droptrue" id="ddWrap16" name="ddWrap16">
<!-- ?php echo $_SESSION['vLC16']; ? -->
</td></tr>
</table> 
</div>

<div id="vLC16_form">
<form name="form3" method="POST" action="or1.php">
  <table width="627" height="254" border="0" cellpadding="0" cellspacing="5">
    <tr>
      <td colspan="4" scope="col"><h1>Patient Discharge Form</h1></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="top">
  <input name="discharged_patient" type="text" id="discharged_patient" size="60" maxlength="60" readonly="readonly">    
      </td>
      </tr>
    <tr>
      <td width="100" align="right"><p>Admit Type:</p>
      <td width="232"><p>Day Surgery</p></td>
      <td width="90" align="right" valign="top">Disposition:</td>
      <td width="180">
     <p><select name="dischdispo">
        <option>Home</option>
        <option>Admitted as Patient</option>
        <option>Discharged Other Facility</option>
        <option>Expired - OR</option>
        <option>Expired - Recovery</option>
        <option>Expired - Pre-Op</option>        
        <option>Long Term Care</option>  
      </select>
    </p>     
      </td>
    </tr>
    <tr>
      <td width="100" align="right">Disch Date:</td>
      <td>
</p><input type="text" name="ddate" id="ddate" size="30" value="<?php echo(clockDateString($gDate));?>"></p>      
      </td>
      <td width="90" align="right">Disch Time:</td>
      <td>
</p><input type="text" name="dtime" id="dtime" value="<?php echo(clockTimeString($gDate,$gClockShowsSeconds));?>"></p>      
      </td>
    </tr>
    <tr>
      <td colspan="4">Discharge Notes:</td>
    </tr>
    <tr>
      <td colspan="4"><textarea name="dnotes" id="dnotes" cols="80" rows="5"></textarea></td>
    </tr>
    <tr>
      <td colspan="4">
<input name="ddEvent" id="ddEvent" type="submit" value="OK" >&nbsp;<input name="dischcancel" id="dischcancel" type="submit" value="Cancel" >      
      </td>
    </tr>
  </table>
<input id="tb_ddWrap1" size="90" type="hidden" name="tb_ddWrap1">
<input id="tb_ddWrap2" size="90" type="hidden" name="tb_ddWrap2">
<input id="tb_ddWrap3" size="90" type="hidden" name="tb_ddWrap3">
<input id="tb_ddWrap4" size="90" type="hidden" name="tb_ddWrap4">
<input id="tb_ddWrap5" size="90" type="hidden" name="tb_ddWrap5">
<input id="tb_ddWrap6" size="90" type="hidden" name="tb_ddWrap6">
<input id="tb_ddWrap7" size="90" type="hidden" name="tb_ddWrap7">
<input id="tb_ddWrap8" size="90" type="hidden" name="tb_ddWrap8">
<input id="tb_ddWrap9" size="90" type="hidden" name="tb_ddWrap9">
<input id="tb_ddWrap10" size="90" type="hidden" name="tb_ddWrap10">
<input id="tb_ddWrap11" size="90" type="hidden" name="tb_ddWrap11">
<input id="tb_ddWrap12" size="90" type="hidden" name="tb_ddWrap12">
<input id="tb_ddWrap13" size="90" type="hidden" name="tb_ddWrap13">
<input id="tb_ddWrap14" size="90" type="hidden" name="tb_ddWrap14">
<input id="tb_ddWrap15" size="90" type="hidden" name="tb_ddWrap15">
<input id="tb_ddWrap16" size="90" type="hidden" name="tb_ddWrap16">
</form>
</div>
<!-- image overlays -->
<div id="preop"><img src="images/roomsWopening-Blk4-205X270.gif" width="180" height="290" alt="preop"></div>
<div id="oprooms"><img src="images/v-surgery_center375x213.jpg" width="375" height="213" alt="or"></div>
<div id="recovery"><img src="images/roomsEopening-Blk4-205X270.gif" width="174" height="293" alt="recovery"></div>
<div id="dischfolder"><img src="images/blue-folder-horizontal.png" width="32" height="32" alt="folder"></div>
<div id="noshowfolder"><img src="images/blue-folder-horizontal.png" width="32" height="32" alt="folder"></div>
<div id="facility"><h1>zenyan Medical Center</h1></div>
<div id="dept"><h2>Surgical Center</h2></div>
<div id="currdate"><p><?php echo(clockDateString($gDate));?></p></div>
<div id="currtime">
    <div id="ClockTime" style="cursor: pointer" onClick="clockToggleSeconds()">
         <p><?php echo(clockTimeString($gDate,$gClockShowsSeconds));?></p>
    </div>
</div>
<div id="noshowlist"><h2>No Show List</h2></div>
<div id="dischlist">
  <h2>Discharge Patient</h2></div>
<div id="preop_lbl"><p>Pre-Op</p></div>
<div id="recovery_lbl"><p>Recovery</p></div>
</body>
</html>
