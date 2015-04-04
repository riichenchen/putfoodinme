<html>
<body>
<?php
$host = "tcp:ex84mmt50m.database.windows.net,1433";
$user = "putfoodinme@ex84mmt50m";
$pwd = "PutF00dInMe";
$db = "food";
try{
    $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $sql_insert = "INSERT INTO foodinfo (name, description, LocationX, LocationY) 
                   VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bindValue(1, "Person");
    $stmt->bindValue(2, "Person");
    $stmt->bindValue(3, 10);
    $stmt->bindValue(4, 10);
}
catch(Exception $e){
    die(print_r($e));
}
echo "still works";
?>
</body>
</html>