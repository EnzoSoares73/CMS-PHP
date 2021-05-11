<?php

    $tbl_name=$_GET['table'];
    $id=$_GET['id'];
    
    include ('Connect.php');
    
    $connect = new Connect();
    $myConnection = $connect->connection(); //connects to database
    
    $sql = "DELETE FROM $tbl_name WHERE id=$id";

    $result = $connect->query($myConnection, $sql);//executes query
    
    $myConnection=null;

    header('Location: menu.php');
    exit();
    
?>