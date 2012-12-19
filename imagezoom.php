<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>JQzoom Demo</title>
	<link rel="stylesheet" href="jquery/stylesheet/nestedmenu_a.css" type="text/css" media="screen, projection"/>
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="jquery/stylesheet/nestedmenuie.css" media="screen" />
    <![endif]-->
<script src="jquery/jquery182.min.js" type="text/javascript"></script>
<script src="jquery/jqzoom.pack.1.0.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="stylesheet/jqzoom.css" type="text/css">
<link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
<script type="text/javascript">
$(function() {
	$(".jqzoom").jqzoom();
});
</script>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:463px;
	height:305px;
	z-index:1;
	left: -48px;
	top: 42px;
}
-->
</style>
</head>

<body>

<?php
  include('jquery/topmenu.php');
?> 
<br /><br />	

<div id="Layer1">

<div id="content" style="margin-top:10px;margin-left:100px;">
<a href="images/kawasakigreen.jpg" class="jqzoom" style="" title="Get a Kaw">
		<img src="images/kawasakigreen_small.jpg"  title="Get a Kaw" style="border: 1px solid #666;">
</a>
</div>
</div>
</body>
</html>
