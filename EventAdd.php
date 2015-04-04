<?php
$name = $_POST["name"];
$description = $_POST["description"];
$long = $_COOKIE["long"];
$lat = $_COOKIE["lat"];
?>
<html>
<body>
<?php

//$servername = "localhost";
$host = "tcp:ex84mmt50m.database.windows.net,1433";
$username = "putfoodinme@ex84mmt50m";
$password = "PutF00dInMe";
$db = "food";

// Create connection
//$conn = new mysqli($servername, $username, $password, $db);
try {
    $conn = new PDO ( "sqlsrv:server = tcp:ex84mmt50m.database.windows.net,1433; Database = food", $username, $password);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch ( PDOException $e ) {
    print( "Error connecting to SQL Server." );
    die(print_r($e));
}

// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//} 

$sql = "INSERT INTO foodinfo (name, description, LocationX, LocationY) VALUES ('$name', '$description', '$long', '$lat')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
</body>
</html>