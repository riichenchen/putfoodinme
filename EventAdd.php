
<?php
$name = $_POST["name"];
$description = $_POST["description"];
$long = $_COOKIE["long"];
$lat = $_COOKIE["lat"];
?>
<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "food";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

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