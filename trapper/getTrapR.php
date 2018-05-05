<?php
   include 'config.php';
   $sql =<<<EOF
      SELECT * FROM dest_details;
EOF;
   $ret = $db->query($sql);
   if($ret) {
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
           echo  $row['community']. "@". $row['ip'] . ":". $row['port']  ."\xA" ;
      }   
   }else{
      echo "FALSE";
   }

   
   $db->close();
?>
