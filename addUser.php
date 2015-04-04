<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "food";

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


//connection to the database
$dbhandle = mssql_connect($servername, $username, $password)
  or die("Couldn't connect to SQL Server on $myServer"); 

//select a database to work with
$selected = mssql_select_db($db, $dbhandle)
  or die("Couldn't open database $myDB"); 

$sql = "INSERT INTO userdata (fName, lName, Login, Password) VALUES ('$fname', '$lname', '$user', '$pass')";
if (mssql_query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error";
}
//close the connection
mssql_close($dbhandle);

?>
<a href="localhost/login.php">Click here to go to the login page</a>
</body>
</html>