<?php
// zenyan Login Module
// Initial Writing: Norm Zemke
// Date: November 15, 2012
//

class dbgateway {
//----------------------------------------------------------------------------//
  public function __construct() {
    global $fw_host;
    global $fw_odbcname;
    global $fw_db;
    global $fw_logon;
    global $fw_password;
    global $fw_delimsymb;
    global $fw_typesql;
  
    $myDbio = '';
    if ($fw_typesql == "MySQL") {
      $myDbio = new dbiomyp();
      $myDbio->host = $fw_host;
      $myDbio->db = $fw_db;
    } else {
      $myDbio = new dbiox();
      $myDbio->odbcname = $fw_odbcname;
    }
    $myDbio->logon = $fw_logon;
    $myDbio->password = $fw_password;
    $myDbio->delimsymb = $fw_delimsymb;
    $this->myDbioObject = $myDbio;
  }
  
//----------------------------------------------------------------------------//
  public function readSQL($query,$typeOfOutput) {
    global $fw_typesql;
    $rs = '';
    if (($fw_typesql != "MySQL") && ($fw_typesql != "ODBC")) {
      $_SESSION['loginerr'] = "Invalid setting in \$fw_typesql: $fw_typesql";
    } elseif (($fw_typesql == "MySQL") && ($typeOfOutput == 'hash')) 
    {
      $temprs = $this->myDbioObject->dbread($query,$typeOfOutput);
      while($row = mysql_fetch_array($temprs, MYSQL_ASSOC)) {
        $rs = $row;
      }
    } elseif ($typeOfOutput == 'grid') 
    {
      $temprs = $this->myDbioObject->dbread($query,'trrow');
      foreach ($temprs as $row) {
        $rs .= $row;
      }
    } else 
    {
      $rs = $this->myDbioObject->dbread($query,$typeOfOutput);
    }
    return $rs;
  }

//----------------------------------------------------------------------------//
  public function writeSQL($query) {
    $rs = $this->myDbioObject->dbwrite($query);
    return $rs;
  }

}
  
?>