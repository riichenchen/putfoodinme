<?php
$name = $_POST["name"];
$description = $_POST["description"];
// $long = $_COOKIE["long"];
// $lat = $_COOKIE["lat"];
?>
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
    $sql = "";
    //$conn->query($sql);
    echo "stuff";
}
catch(Exception $e){
    die(print_r($e));
}


// $sql = "INSERT INTO foodinfo (name, description, LocationX, LocationY) VALUES ('$name', '$description', '$long', '$lat')";
// if (mssql_query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error";
// }
// //close the connection
// mssql_close($dbhandle);
?>
</body>
</html>