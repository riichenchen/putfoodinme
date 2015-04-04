<?php
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$user = $_POST["user"];
$pass = $_POST["pass"];
$cpass = $_POST["cpass"];
?>
<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "food";

if($pass != $cpass){
	die("Error: Passwords don't match");
}
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO userdata (fName, lName, Login, Password) VALUES ('$fname', '$lname', '$user', '$pass')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
<a href="localhost/login.php">Click here to go to the login page</a>
</body>
</html>