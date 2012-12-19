<?php
/* 
Dynaform CodeGenerator
Initital Code Generated from Template System created by: Eric Matthews
*/
session_start();
import_request_variables('gp', "formval_");
//since this is generating code that can live in a runtime path unknown to the 
//codegen we need to hardcode the path here.
include('/webroot/public_html/zenyan097/eConfig/envref.php');

require($php_applib);
include($php_daclib);
require(~~DBMS~~);  
$status = '';
$logonerror = '';
$_SESSION['loginerr'] = '';
$fullrefpg = $_SERVER['HTTP_REFERER'];
$myDbgateway = new dbgateway;
$retrs = boundQry();

function boundQry()
{
 global $myDbgateway;
 $tmpstr = '';	 
 $lu = "";
 $sqls = 
 "~~QUERY~~";
   if (isset($debugapp) == 'y')
   {
    eDebugLog($sqls);
   } 

~~CONNDBMS~~
~~CONNPARMS~~
 $gridrowstr = $myDbgateway->readSQL($sqls,"grid");
  return $gridrowstr;
}

?>
<!DOCTYPE html>
<html>
<HEAD>
<title>~~PGTITLE~~</title>
<meta HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-8859-1\">
<link rel="stylesheet" type="text/css" href="stylesheet/mntypog.css">
<link rel="stylesheet" type="text/css" href="stylesheet/gridcontrol.css" media="all">
</script><script type="text/javascript" src="eUI/script/gridcontrol.js"></script>

</head>
<body>

</table> 
  </tr>
<!-- page specific content below -->  
  <tr>
    <td>
<h3>~~OBJDESCR~~</h3>   	
    </td>
  </tr>
</table>

<table id="t1" class="example table-autosort 
                              table-autofilter 
                              table-autopage:~~TOTROWS~~ 
                              table-stripeclass:alternate 
                              table-page-number:t1page 
                              table-page-count:t1pages 
                              table-filtered-rowcount:t1filtercount 
                              table-rowcount:t1allcount">
<thead>
 <tr>
~~THSTUB~~
 </tr>
</thead>
<tbody style="cursor:pointer;">
<?php if(isset($retrs)){echo $retrs;} ?>
</tbody>
~~GRIDFOOTERNAV~~
</table>
<!-- End Main Content-->


</body>
</html>
