<?php
    
    $db_server = "127.0.0.1";
    $db_user="root";
    $db_pass="";
    $db_name="car";
    $conn="";
    $connectionMessage = "";
    try{
    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
     if($conn){
        $connectionMessage = "Connection Successful";
     }else{
        $connectionMessage = "Connection Failed";
     }
    }catch(mysqli_sql_exception ){
      $connectionMessage="Could not connect!";
    }
    echo '<div style="position: absolute; top: 20px; right: 20px; background-color: green; color: white; padding: 5px;">' . $connectionMessage . '</div>';
 ?>
 