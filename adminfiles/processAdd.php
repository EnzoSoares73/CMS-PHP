<?php
    
    $tbl_name=$_GET['table'];

    include 'Connect.php';
    
    $connect = new Connect();
    $myConnection = $connect->connection(); //connects to database
    
    $connect->print_rImproved(var_dump($_POST));
   
    $dbname = $connect->getDbname();
    
    $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbl_name'"; //gets all table names from $tbl_name
    
    $result = $connect->query($myConnection, $sql);//gets result from query
    $columnNames = $connect->queryToArray($result);//transform query result into an array
    
    $exceptions = json_decode(file_get_contents('exceptions.json')); //reads the exceptions file
    
    $infos = [];
    
    foreach ($columnNames as $columnname) {
        if ($columnname != "id" and !in_array($columnname, $exceptions->images) and !in_array($columnname, $exceptions->disabled)) {
            if (in_array($columnname, $exceptions->password)) {
                if (isset($_POST['salt'])) {
                    $infos[$columnname] = hash('sha256', $_POST[$columnname].$POST['salt']); 
                } else {
                    $infos[$columnname] = hash('sha256', $_POST[$columnname]); 
                }
            } else {
                $infos[$columnname] = $_POST[$columnname]; //puts every information passed through POST in the $infos array, if that information isn't the id, a declared image or disabled
                
            }
        }
    }
    
    foreach ($_FILES as $image) { //for every file passed through FILES, assign it to a postion in the $infos array where the key is the correspondent database column
        
        $filename = $image["name"];
        $tempname = $image["tmp_name"];
        $folder = "images/".$filename;
        
        if ($filename != null) {
            foreach ($columnNames as $columnname) {
                if ($columnname != "id" and in_array($columnname, $exceptions->images) and !in_array($columnname, $exceptions->disabled)) {
                    if (!array_key_exists($columnname, $infos) and !in_array($filename, $infos)) {
                        $infos[$columnname] = $filename;
                    }
                }
            }
        }
        
        if (move_uploaded_file($tempname, $folder))  {
            echo "Image uploaded successfully";
        }else{
            echo "Failed to upload image";
        }
    }
    
    $columns = implode(', ', array_keys($infos));
    $values = "'".implode("', '", array_values($infos))."'"; //formats the $infos array so it can be used as a query argument
    
    $sql = "INSERT INTO $tbl_name ($columns) VALUES ($values)";
    
    echo $sql;

    $connect->query($myConnection, $sql);// executes query
    
    $myConnection=null;
    
    header('Location: menu.php');
    exit();
   
?>