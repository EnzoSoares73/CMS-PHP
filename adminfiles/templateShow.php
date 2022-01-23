<?php //shows all entries in a table
    
    $tbl_name=$_GET['table'];
    
    include 'Connect.php';
    
    $connect = new Connect();
    $myConnection = $connect->connection(); //connects to database
    
    $dbname = $connect->getDbname();
    
    $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbl_name'"; //gets all table names from $tbl_name
    
    $result = $connect->query($myConnection, $sql);//gets result from query
    $columnNames = $connect->queryToArray($result);//transform query result into an array

    $sql = "SELECT * FROM $tbl_name";
    $result = $connect->query($myConnection, $sql); //retrieves $tbl_name

    $tableValues = $connect->queryToArray2D($result);
    
    $myConnection=null;
    
?>

<html>

	<head>
		<title>Todas as entradas</title>
	
	</head>

	<body>
		
        	<table border="1">
        	
        		<thead>
                    <tr>
                        <th><?php echo ucwords($columnNames[0])?></th>
                        <th><?php echo ucwords($columnNames[1])?></th>
                    </tr>
                </thead>
            
            
                <?php foreach($tableValues as $tableValue):?> <!-- shows the first two columns of every $tbl_name entry  
                    and, for every one of those, creates a two links: modify and delete, sending through those links the table and entry ids-->
                    <tr>
                    	<td><?php echo $tableValue['id']?></td>
                        <td><?php echo $tableValue['name']?></td>
						<td><a href="templateDelete.php?id=<?php echo $tableValue['id']?>&table=<?php echo $tbl_name; ?>">Deletar</a></td>
						<td><a href="templateShowAll.php?id=<?php echo $tableValue['id']?>&table=<?php echo $tbl_name; ?>">Mostrar</a></td>
						
						
                    </tr>
                <?php endforeach;?>
        	
        	</table>
        	
        	<br>
        	<a href="TemplateAdd.php?table=<?php echo $tbl_name; ?>">Adicionar</a><!-- sends the table id attached to the add link-->
        	<br>

	
	</body>
	
</html>