<?php
$name = $_POST["name"];
$description = $_POST["description"];
$long = $_COOKIE["long"];
$lat = $_COOKIE["lat"];
?>
<html>
<body>
<?php
$servername = "ex84mmt50m.database.windows.net";
$username = "putfoodinme";
$password = "PutF00dInMe";
$db = "food";

//connection to the database
$dbhandle = mssql_connect($servername, $username, $password)
  or die("Couldn't connect to SQL Server on $myServer");

//select a database to work with
$selected = mssql_select_db($db, $dbhandle)
  or die("Couldn't open database $myDB"); 

$sql = "INSERT INTO foodinfo (name, description, LocationX, LocationY) VALUES ('$name', '$description', '$long', '$lat')";
if (mssql_query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error";
}
//close the connection
mssql_close($dbhandle);
?>
</body>
</html>