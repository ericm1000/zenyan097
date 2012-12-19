<?php

$webrooturl = 'http://127.0.0.1/';

//set root at server so as to not expose full path in client-side code
$rootpath = '/webroot/public_html/zenyan097/croot/LIBRARY/zenyan/';
/* note: since we are running within web server infrastructure you need to
create a directory path that is recognized by your webserver configuration.
*/

// trivial test as debuggers are for folks much smarter than me
 $tst = '';
 if ($tst != '')
 {
 	echo '$_POST[\'dir\']  =' . $_POST['dir'];
 }	

/* in a nutshell, we are leaving the html root setting blank. the overall goal 
is to establish a root directory that is the sandbox we wish to keep the users
in. this prevents someone from modifying the connector html code and trying 
to find unsecured areas of our server. this IS NOT the only means by which 
you need to maintain backend security to your filesystem. you also need to
have os file system security as well as webserver filesystem security 
implemented as a means of hardening your backend. */
 if ($_POST['dir'] == '')
 {
   $_POST['dir'] = $rootpath;
   procDir();
 }
 // validate that we are matching on our root. you will need to modify this regex to reflect your rootpath
 // intentionally hardcoded to further twart hackers.
 else if (preg_match("/^\/webroot\/public_html\/zenyan097\/croot\/LIBRARY\/zenyan\//", $_POST['dir']))
 {
 	//$_POST['dir'] = urldecode($_POST['dir']);
 	procDir();
 }
 else //we explicitly set POST value to bubkus, though should probably redirect them to Interpol or FBI site :-)
 {
 	$_POST['dir'] = '';
 	//procDir();
 }		

  	
function procDir()
{
 global $webrooturl;
 if( file_exists($root . $_POST['dir']) ) 
 {
 	$files = scandir($root . $_POST['dir']);
 	natcasesort($files);
 	if( count($files) > 2 )  /* The 2 accounts for . and .. */
 	{
 		echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
 		// All dirs
 		foreach( $files as $file ) 
 		{
 			if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
 				echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
 			}
 		}
 		// here is where we process file urls to zenyan cms rules ...which are very simple
 		  // * for display name _ gets translated into a space. If preserving underscore is desired in display name (example: mod_perl) use two (__).
 		  // * url is preserved to actual filename
 		foreach( $files as $file ) 
 		{
 			if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) 
 			{
        $urlspec = $webrooturl;
        $scrubfilepath = $_POST['dir'];
        $urlspec .= $scrubfilepath;
        //$urlspec = preg_replace('/[/]webroot[/]public_html[/]/', '', $urlspec);
        $urlspec .= $file;
        $scrubfile = $file;
        $scrubfile = preg_replace('/__/', "_", $scrubfile);  //not working, not sure why      
        $scrubfile = preg_replace('/[_]{1,1}/', ' ', $scrubfile);
        $scrubfile = preg_replace('/\.[a-zA-Z0-9]{3,4}$/', '', $scrubfile); //bag extension
        $urlspec = preg_replace('/\/webroot\//', '', $urlspec);
        $urlspec = preg_replace('/public_html\//', '', $urlspec);
 				$ext = preg_replace('/^.*\./', '', $file);
 				echo "<li class=\"file ext_$ext\"><a href=\"" . $urlspec . "\"  target=\"main\" >" . $scrubfile . "</a></li>";
 			  $urlspec = '';
 			  $scrubfilepath = '';
 			  
 			}
 		}
 		echo "</ul>";	
 	}
}

}
?>