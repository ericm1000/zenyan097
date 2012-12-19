<?php
// Main Left Toc Page
// Initial Writing: ericm
// Date: 1/24/2012
// License: Dual licensed under the MIT and GPL license
/*
Main Left Toc Page
*/
// History/Customizations:
/*
                        
*/


?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet/toc.css"></link>
<script language="JavaScript1.2" type="text/javascript" src="scripts/verticaltree.js"></script>

<script language="javascript">
function getURL(focurl)
{
//tested works with firefox, ie, opera, safari, chrome
   //alert(focurl); 
   parent.cmd.document.getElementById('myurl').innerHTML = focurl; //working  
}
</script>	

<style type="text/css">
/* CSS Tabs */
h2 {
font-family: Cursive, Arial; 
text-align: center; 
font-size: 11pt;
font-weight: normal;
border-style: solid;
border-bottom-width: thin;
border-left: none;
border-right: none;
border-top-width: thin;
border-color: black; 
background-color: none;
margin-left: 0px;
text-transform: uppercase;
}
</style>

<title></title>
</head>
<body bgcolor='#CCCCCC'<p></p>


<h2>Favorites</h2>
<!-- let them have 10 here, setup under the manage men function, remove this comment once done -->
<p><a href="http://www.bing.com" TARGET="main"  onClick=getURL(this);>Bing</a></p>
<p><a href="http://www.linkedin.com" TARGET="_BLANK">LinkedIn</a></p>
<p><a href="http://www.facebook.com" TARGET="_BLANK">Facebook</a></p>
<p><a href="http://www.amazon.com" TARGET="_BLANK">Amazon</a></p>
<p><a href="http://www.imdb.com" TARGET="main"  onClick=getURL(this);>Movie Database</a></p>
<hr />
<p><a href="userguide.html" TARGET="main"  onClick=getURL(this);>User Guide</a></p>
<p><a href="faqs.html" TARGET="main"  onClick=getURL(this);>FAQ's</a></p>

</body>
</html>