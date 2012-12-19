<?php
/* 
Initital Writing: Eric Matthews

NOTE: This example is the same as toycode_datePicker with one exception. This
example maintains context for the dates the user selects. This is oftentimes a
very important and desired feature in a UI.

This control will be unique to each application screen that needs to use it. 
Typical scenarios will be as follows:
- Data Entry where user is asked to enter a date.
- Selection criteria on a screen soliciting a date before or after current date.
- Selection criteria on a screen soliciting a date range.
There can and will be other scenarios for using this control.

*/
session_start();

$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];

?>
<!DOCTYPE html>
<html>
	<head>
<!--  Integrator: Eric Matthews  -->
<!--  Integration into the zenyan framework  -->
<!--  Example: JQuery Date Picker Plugin Example -->	
<!--  License: Dual licensed under the MIT and GPL license  -->               
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>jQuery datePicker example</title>
		
	
        <!-- datepicker -->
		<link rel="stylesheet" type="text/css" media="screen" href="../jquery/stylesheet/jquery-ui191.css">
		<script type="text/javascript" src="../jquery/jquery182.min.js"></script>
 		<script type="text/javascript" src="../jquery/jquery-ui191.js"></script>          
        
        <!-- page specific scripts -->
		<script type="text/javascript" charset="utf-8">
       $(function() {        
           $( ".datepicker" ).datepicker();    
       });
		</script>
		
	</head>
	<body>

			<form name="chooseDateForm" id="chooseDateForm" method="get" action="toycode_ui_datePicker_persistence.php">
					<h2>Date Picker Example</h2>
              <label for="date1">Date 1:&nbsp;</label><input name="date1" class="datepicker" value="<?php echo $_REQUEST['date1']; ?>" /><br /><br />
              <label for="date2">Date 2:&nbsp;</label><input name="date2" class="datepicker" value="<?php echo $_REQUEST['date2']; ?>" /><br /><br />
      <input type="submit" name="submit" value="OK" />
			</form>
 
<br />
        
 <?php echo '$date1 = ' . $date1 . "<br />"; ?>
 <?php echo '$date2 = ' . $date2 . "<br />"; ?>
        
	</body>
</html>