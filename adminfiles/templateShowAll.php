<?php //shows all fields from a entry in a table
    $tbl_name=$_GET['table'];
    $id = $_GET['id'];
    
    include 'Connect.php';
    
    $connect = new Connect();
    $myConnection = $connect->connection(); //connects to database
    
    $dbname = $connect->getDbname();
    
    $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbl_name'"; //gets all table names from $tbl_name
    
    $result = $connect->query($myConnection, $sql);//gets result from query
    $columnNames = $connect->queryToArray($result);//transform query result into an array
    
    $sql="SELECT * FROM $tbl_name WHERE id=$id";
    $result = $connect->query($myConnection, $sql);//gets result from query  
    $values = $connect->queryToArray2D($result);//transform query result into an array
    
    $myConnection=null;
?>
    
    <html>
    
        <head>
        <title>Add</title>
        
        </head>
    
    <body>
        
        
            <?php foreach ($columnNames as $columnName) : ?>
    			<h3><?php echo ucwords($columnName); ?></h3>
    			<?php foreach ($values as $value):?>
    				<p><?php echo $value[$columnName];?></p>
    			<?php endforeach;?>
            <?php endforeach; ?>
         	<a href="templateDelete.php?id=<?php echo $id?>&table=<?php echo $tbl_name; ?>" >Delete</a>
    
    </body>
    
</html> 