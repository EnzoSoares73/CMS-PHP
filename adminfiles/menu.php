<?php

    include 'Connect.php';
    
    $connect = new Connect();
    $myConnection = $connect->connection(); //connects to database
    
    $sql="SHOW tables FROM ".$connect->getDbname();//gets all table names
    
    $result = $connect->query($myConnection, $sql);//gets result from query
    $resultArray = $connect->queryToArray($result);//transform query result into an array
    $myConnection=null;
    
    $exceptions = json_decode(file_get_contents('exceptions.json')); //reads the exceptions file
    

?>

<html lang="pt-br">
    
    <?php include_once "head.html"?>

    <body id="body">
        <div class="loader"></div>
        <div class="center animate-bottom">
            <div class="scrollbox">

                <ul>
                    <?php foreach ($resultArray as $item): ?> <!--  for every database table, verify if it is in the exceptions. If so, it isn't showed -->
                        <?php if (!in_array($item, $exceptions->db_exceptions)):?>
                            <li><a href="templateShow.php?table=<?php echo $item; ?>" ><?php echo $item; ?></a></li><!-- sends the selected table name to templateShow.php-->
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>

            </div>
        </div>
    </body>


    
</html> 