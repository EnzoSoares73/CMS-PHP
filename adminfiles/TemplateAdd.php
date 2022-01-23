<?php
    
    $tbl_name=$_GET['table'];
    
    include 'Connect.php';
    
    $connect = new Connect();
    $myConnection = $connect->connection(); //connects to database
    
    $dbname = $connect->getDbname();
    
    $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tbl_name'"; //gets all table names from $tbl_name
    
    $result = $connect->query($myConnection, $sql);//gets result from query
    $columnNames = $connect->queryToArray($result);//transform query result into an array
    
    $myConnection=null;
    
    $exceptions = json_decode(file_get_contents('exceptions.json')); //reads the exceptions file
    
    function verifyName($name, $exceptions) { //returns form input type based on exceptions.json
        if (in_array($name, $exceptions->images)){
            return "file' accept='image/*'";
        } elseif (in_array($name, $exceptions->password)) {
            return "password";
        } else {
            return "text";
        }
    }
    
    function isRequiredOrDisabled($name, $exceptions) {
        $string = "";
        if (in_array($name, $exceptions->required)){
            $string = $string."required ";
        } 
        if (in_array($name, $exceptions->disabled)){
            $string = $string."disabled ";
        }
        if (in_array($name, $exceptions->salt)){
            $string = $string."readonly value=".bin2hex(random_bytes(10))."";
        }
        
        return $string;
    }

?>

<html> 
    
    <head>
        <title>Adicionar</title>
    
    </head>

	<body>
        <form action="processAdd.php?table=<?php echo $tbl_name;?>" method="post" enctype="multipart/form-data">
            	
                <?php foreach ($columnNames as $columnName) : ?>
                	<?php if ($columnName != "id"):?>
    					<label><?php echo ucwords($columnName); ?></label>
                			<input type='<?php echo verifyName($columnName, $exceptions)?>'
                			name="<?php echo $columnName; ?>" 
                			<?php echo isRequiredOrDisabled($columnName, $exceptions)?>><br>
                	<?php endif; ?>
                <?php endforeach; ?>
            	
            <input type="submit" name=submit value="Submit"/>
        </form>
    
    </body>
    
</html> 