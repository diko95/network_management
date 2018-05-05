<?php
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('itsatraperer.db');
      }
   }
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   }
   $sqls =<<<EOF
         CREATE TABLE IF NOT EXISTS raw_details(oid varchar(120),oid_val varchar(120),report_time integer);
EOF;
       
   $sqlm =<<<EOF
        CREATE TABLE IF NOT EXISTS trap_details(id integer primary key autoincrement,devicename varchar(120),status integer,rtime 		integer,oldstatus integer,oldrtime integer);
EOF;
   $sqln =<<<EOF
        CREATE TABLE IF NOT EXISTS dest_details(id integer primary key autoincrement,ip varchar(120),port int,community varchar(120));
EOF;
   $sqlk =<<<EOF
         CREATE TABLE IF NOT EXISTS recv_details(descrip varchar(120),val varchar(120));
EOF;

   
   $rets = $db->exec($sqls);
   if(!$rets){
      echo $db->lastErrorMsg();
   }
   
   $retm = $db->exec($sqlm);
   if(!$retm){
      echo $db->lastErrorMsg();
   }

   $retn = $db->exec($sqln);
   if(!$retn){
      echo $db->lastErrorMsg();
   }
   $retk = $db->exec($sqlk);
   if(!$retk){
      echo $db->lastErrorMsg();
   }
   
   
   

?>
