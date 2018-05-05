<?php
   include 'config.php'; 
   

   $ch="SELECT count(*) as rownum FROM trap_details";
   $check=$db->query($ch);
   $nb=$check->fetchArray();
   $count=$nb['rownum'];
   if($count>0){ 
      #$sqlx=<<<EOF
       #     delete from trap_details where rowid not in (select max(rowid) from trap_details group by devicename);
#EOF;
 #     $retx = $db->query($sqlx);
      $sql =<<<EOF
      select max(rowid),devicename,status,rtime from trap_details group by devicename;
EOF;

      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
           #echo "\n".'<td>'.$row['id'] . "|";
           #echo  $row['community']. "@". $row['ip'] . ":". $row['port']  ."\xA"
           echo "\n".trim($row['devicename'],'"') ." | ".$row['status'] ." | ".$row['rtime']."\xA";
           #echo "\n".trim($row['devicename'],'"') ."|".$row['status'] ."|".$row['rtime']."|".$row['oldstatus']."|".$row['oldrtime']."\xA";
           #echo "<br />";
         }
       
   }else{
       echo "FALSE";
   }
      
   $db->close();
?>
