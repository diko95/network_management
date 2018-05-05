<?php
   include 'config.php'; 
  
   if($_GET['ip']&& $_GET['port']&& $_GET['community']){
       $ch="SELECT count(*) as rownum FROM dest_details";
       $check=$db->query($ch);
       $nb=$check->fetchArray();
       $count=$nb['rownum'];
       if($count>0){ 
     
          $sqln ='update dest_details set ip=\''.$_GET['ip'].'\',port=\''.$_GET['port'].'\',community=\''.$_GET['community'].'\' where id =1';
          $retn = $db->exec($sqln);
          if(!$retn) {
             echo $db->lastErrorMsg();
          } else {
             echo "OK";
          }
       }
       else{ 
      
          $sqlm ='INSERT INTO dest_details (ip,port,community) VALUES (\'' . $_GET['ip'] . '\', \'' . $_GET['port']. '\', \'' .$_GET['community']. '\')';
          $retm = $db->exec($sqlm);
          if(!$retm) {
             echo $db->lastErrorMsg();
          } else {
             echo "OK";
          }
       }
      
   }else{
      echo "FALSE";   
   }
   
   $db->close();
?>

    
