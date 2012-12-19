<?php
 session_start();
  

 require('eConfig/envref.php');
 include($php_envvars);
 include($php_filsysapi);
 
 $_SESSION['renderedHtml'] = '';
 $_SESSION['render_flg'] = 'y';

//to bust out into lib and config
  $_SESSION['ckpath'] = 'd:/webroot/public_html/zenyan/'; 
  $_SESSION['ckroot'] = 'ckroot/'; 
  $_SESSION['ckio_tie'] = 'file';  //or 'dbms'
  
  $currfile = $_SESSION['ckpath'] . $_SESSION['ckroot'] . "dev/test/testing.html";
////////////////////////////////

  $retv =  svFile ($currfile, $_REQUEST['editor1']);
  $filcontentsMU = $_REQUEST['editor1'];
  $filcontentsMU = oFileMU($currfile);
 
 // note $_POST gives us the text along with the html markup, whereas
 // $_REQUEST['editor1'] will yield us the formatted text and markup. 
 
  if (isset($_POST)) {
  	$_SESSION['htmlpg'] = $_POST ;
  	 if ($_SESSION['render_flg'] != '') {
  	  $_SESSION['renderedHtml'] .= $_REQUEST['editor1'];	
  	 } 
  }
  
  foreach ( $_SESSION['htmlpg'] as $sForm => $value ) {
  	if ( get_magic_quotes_gpc() ) {
  		$_SESSION['htmlpg'] = htmlspecialchars( stripslashes( $value ) ) ;
  	}else
  		$_SESSION['htmlpg'] = htmlspecialchars( $value ) ;
  }


?>
<!DOCTYPE html>
<html>
<head>
	<title>Full Page Editing - CKEditor in zenyan</title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="ck.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" media="screen" href="stylesheet/mncontent.css">
	<link href="stylesheet/ck.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>CKEditor - zenyan Implementation - Full Editor To/From File Example</h1>
	<!-- This <div> holds alert messages to be display in the sample page. -->
	<div id="alerts">
		<noscript>
			<p>
				<strong>CKEditor requires JavaScript to run</strong>. In a browser with no JavaScript
				support, like yours, you should still see the contents (HTML data) and you should
				be able to edit it normally, without a rich editor interface.
			</p>
		</noscript>
	</div>
	<form action="eFullHtmlPg.php" method="post">
<p>
The editor is configured here to edit entire HTML pages, from &lt;html&gt; tag to &lt;/html&gt;.</p>
		<p>
			<textarea cols="80" id="editor1" name="editor1" rows="10"><?php echo $filcontentsMU; ?></textarea>
			<script type="text/javascript">
			//<![CDATA[

				CKEDITOR.replace('editor1',
					{

					});

			//]]>
			</script>
		</p>
		<p>
			<!-- NOTE!!! if value=Submit with form buttons the CKEditor save button 
			     will not WORK!!! -->
			<!-- input type="submit" value="Submit2" / -->
		</p>
	</form>
<br /><br />
<hr />
<p>The HTML Markup</p>
<p><?php echo $_SESSION['htmlpg']; ?></p>	
<hr />
<p>The Rendered Markup</p>
<p><?php echo $_SESSION['renderedHtml']; ?></p>	
<hr />  
</body>
</html>
