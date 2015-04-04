<?php
	$servername = "localhost";
	$username = "username";
	$password = "password";
	$dbname = "myDB";
	//The maximum difference in longitude that we wish to find.
	$maxDeltaLong = floatval($_POST['height']) / 6371;
	//The maximum difference in latitude that we wish to find.
	$maxDeltaLat = floatval($_POST['width']) / 6371;
	$long = floatval($_POST['long']);
	$lat = floatval($_POST['lat']);
	$coslat = cos($lat);

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$query = "SELECT * FROM food WHERE (long-$long)*$coslat<$maxDeltaLong AND lat-$lat<$maxDeltaLat";
	$result = $conn->query($query);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
	    }
	} else {
	    echo "0 results";
	}
	$conn->close();

>