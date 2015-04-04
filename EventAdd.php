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
    echo "still works";
}
catch(Exception $e){
    die(print_r($e));
}
?>
</body>
</html>