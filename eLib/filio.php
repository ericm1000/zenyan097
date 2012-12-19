<?php
/*
Intial Writing: Eric Matthews
general file library code
*/

//read file return contents in array
function readFileReturnArray($filspec)
{
	$cntr=0;
	$fc_arr;
	$fcontents = fopen($filspec,"r"); //or  print ("Unable to open file!");

  while(!feof($fcontents)){ 
      $fc_arr[$cntr++] = fgets($fcontents); 
  }
  fclose($fcontents);	
  
  return $fc_arr;

}	


//accept path, return array of all files (files only) for all directories and subdirectories
function get_files($dir) {
   $path = '';
   $stack[] = $dir;
   while ($stack) {
       $thisdir = array_pop($stack);
       if ($dircont = scandir($thisdir)) {
           $i=0;
           while (isset($dircont[$i])) {
               if ($dircont[$i] !== '.' && $dircont[$i] !== '..') {
                   $current_file = "{$thisdir}/{$dircont[$i]}";
                   if (is_file($current_file)) {
                       $path[] = "{$thisdir}/{$dircont[$i]}";
                   } elseif (is_dir($current_file)) {
                       $stack[] = $current_file;
                   }
               }
               $i++;
           }
       }
   }
   return $path;
}


// a simple wrapper to native copy command. even though trivial i added for 
// continuity of potential file operations in this api
function copyfile($src,$tgt) {
   $retv = copy($src ,$tgt); //returns true or false, 1=true, 0=false
   return $retv;
}   


// a simple wrapper to native copy command. even though trivial i added for 
// continuity of potential file operations in this api
function appendfile($ln,$fil) {
   $fh = fopen($fil, 'a') or die("can't open file");
   fwrite($fh, $ln);
   fclose($fh);
}   


// a simple wrapper to native copy command. even though trivial i added for 
// continuity of potential file operations in this api
function purgefileContents($fil) {
   $fh = fopen( $fil, 'w' ) or die("can't open file");;  
   fwrite($fh, "");
   fclose($fh);
}  



//this function is used by the search engines index manager, but is generic 
//in scope and can be used elsewhere as well
// the $extlst arg is the hash that represents only the file extensions we want to index
// 
function get_files_hash($dir,$extlst) {
  $filslst = get_files($dir);
  $cnt = count($filslst);
  $filhsh;
  for ($i=0; $i < $cnt; $i++) {
  	$tmphsh = filespecSlicer($filslst[$i]);
  	if ($extlst != "") {
      if (array_key_exists($tmphsh['extension'], $extlst)) {
        $last_mod = filemtime($filslst[$i]);
        $filsz = filesize($filslst[$i]);
        $filhsh[$filslst[$i]] = $last_mod . "|" . $filsz;
      }
    }    
    else {
    // extension arg is empty so go get 'em all	
      $last_mod = filemtime($filslst[$i]);
      $filsz = filesize($filslst[$i]);
      $filhsh[$filslst[$i]] = $last_mod . "|" . $filsz;   
    }	  
  }
  
  return $filhsh;
}


//accept path, return array of all base directories immediately under the root path
function get_base_dirs($dir) 
{
   $rootbasepath = $dir . '/';
   $allarr = scandir($dir);  //getem all
   $fltrarr = array();
   $n=0;
   $allarrcnt = count($allarr);
   for ($i=0; $i < $allarrcnt; $i++) {
   	 $tmpfilspec = $rootbasepath .  $allarr[$i];
   	 if (is_dir($tmpfilspec) && $allarr[$i] != '.' && $allarr[$i] != '..') {
   	 	  //print $allarr[$i] . "<br />";
   	 	  $fltrarr[$n++] =  $allarr[$i];
   	 }	

   	 
   }	
   return $fltrarr;
}

function get_files_basedir($dir) 
{
   $rootbasepath = $dir . '/';
   $allarr = scandir($dir);  //getem all
   $fltrarr = array();
   $n=0;
   $allarrcnt = count($allarr);
   for ($i=0; $i < $allarrcnt; $i++) {
   	 $tmpfilspec = $rootbasepath .  $allarr[$i];
   	 if (is_file($tmpfilspec)) {
   	 	  //print $allarr[$i] . "<br />";
   	 	  $fltrarr[$n++] =  $allarr[$i];
   	 }	
   	 
   }	
   return $fltrarr;
}

//accept path, return array of all directories
function dir_tree($dir) 
{
   $path = '';
   $cnt=0;
   $stack[] = $dir;  
   while ($stack) {
       $thisdir = array_pop($stack);
       //print $thisdir . "<br />";
       $path[$cnt++] = $thisdir;
       if ($dircont = scandir($thisdir)) {
           $i=0;
           while (isset($dircont[$i])) {
               if ($dircont[$i] !== '.' && $dircont[$i] !== '..') {
                   $current_file = "{$thisdir}/{$dircont[$i]}";
                   if (is_dir($current_file)) {
                     $stack[] = $current_file;
                   }
               } 
               $i++;
           }
       }
   }
   return $path;
}


//check to see if a file exists
function checkFileExists($filspec)
{
  //open a file and assign contents to a variable
  if (file_exists($filspec))
  {
  	$retv = "y";
  }
  else
  {	
    $retv = "";
  }
  return $retv;
}	


//accepts a fully qualified file name and returns a hash of the component parts
function filespecSlicer($filespec)
{
	 //a filespec is a fully qualified filename
   $filpath = "";
   $filenm = "";
   $filext = "";
   $fileHash = '';
      
   if (preg_match("/(.+)[.](.+)$/", $filespec, $matches) ) 
   {
   	$filext  = $matches[2];  //file extension
   }
   
   $filpatharr = explode("/",$matches[1]);
   $arrcnt = count($filpatharr);

   $filenm = array_pop($filpatharr);  
   $arrcnt = count($filpatharr);

   if ($arrcnt != 0) { $filpath = implode("/",$filpatharr); $filpath .= "/";}
   $fileHash['path']      = $filpath; 
   $fileHash['prefix']    = $filenm; 
	 $fileHash['extension'] = $filext;
	 $fileHash['filename']  = $filenm . '.' . $filext;
	 $fileHash['filespec']  = $filespec;	 
	 return $fileHash;
}	

//accepts a file name and returns its contents 
// --- For use with CKEditor see oFileMU, oFileMUss 
function getFileContents($txtfil)
{
  //open a file and assign contents to a variable
  if (!file_exists($txtfil))
  {
  	$raw_text = "nofilefound";
  }
  else
  {	
    $raw_text = file_get_contents( $txtfil );
  }
  return $raw_text;
}	

//accepts a file specification and file contents and create a file  
// --- For use with CKEditor see svFile,svFileAs, clsFileNoSave, clsFileSave 
function createFile($filecontents,$filnm)
{
	$iostat = "";
  $Handle = fopen($filnm, 'w') or "could not create file";
  fwrite($Handle, $filecontents);
  $iostat =  "file " . $filnm . " created ";
  fclose($Handle);
  return $iostat;
}	


// following are file io functions for ckeditor
function oFileMU ($fs)
{
  if (file_exists($fs)) {
      $filmu = file_get_contents($fs);
  } else {
       $filmu = "file or path does not exist";
  }         	
 
  return $filmu;	

}


function oFileMUss ($fs)
{
  if (file_exists($fs)) {
      $filmu = file_get_contents($fs);
      if (get_magic_quotes_gpc()) {
      		$dfilmu = htmlspecialchars(stripslashes($filmu)) ;
      } else {
  		    $dfilmu = htmlspecialchars($filmu) ;
      } 
  } else {
       $filmu = "file or path does not exist";
  }         	
 
  return $dfilmu;	

}

function oFile ($fs)
{
//open a file and assign contents to a variable
  if (file_exists($fs)) {
    $filc = file_get_contents($fs);
  } else {
       $filc = "file or path does not exist";
  }         	
      
  return $filc;	

}

function svFile ($fs, $fcntnt)
{
	$status = file_put_contents($fs,$fcntnt);
	
	return $status;
}

function svFileAs ($fs)
{
	
}	

function clsFileSave ($fs)
{
	$status = svFileAs ($fs);
	//clear session var if status succeeds
}	

function clsFileNoSave ($fs)
{
	//clear session var if status succeeds
}		
?>
