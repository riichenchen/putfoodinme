	<?php
		$EARTHDIAMETER = 12742;
		//The maximum difference in longitude that we wish to find.
		$maxDeltaLong = floatval($_POST['height']) / $EARTHDIAMETER;
		//The maximum difference in latitude that we wish to find.
		$maxDeltaLat = floatval($_POST['width']) / $EARTHDIAMETER;
		$long = floatval($_POST['long']);
		$lat = floatval($_POST['lat']);
		$coslat = cos($lat);
		echo "[";
		for($i = 0; i < 10; i++){
			echo "{";
			echo "lat:";
			echo mt_rand (-($long - $maxDeltaLong)*cos($lat), ($long - $maxDeltaLong)*cos($lat));
			echo ", ";
			echo "long: ";
			echo mt_rand (-($long - $maxDeltaLong)*cos($lat), ($long - $maxDeltaLong)*cos($lat));
			echo ", ";
			echo "description: ";
			echo "'We're Hungry!!!'";
			echo ", ";
			echo "name: ";
			echo "'Random'";
			echo "}, ";
		}
		echo "10";
// 	$servername = "localhost";
// 	$username = "username";
// 	$password = "password";
// 	$dbname = "myDB";
// 	//The maximum difference in longitude that we wish to find.
// 	$maxDeltaLong = floatval($_POST['height']) / 6371;
// 	//The maximum difference in latitude that we wish to find.
// 	$maxDeltaLat = floatval($_POST['width']) / 6371;
// 	$long = floatval($_POST['long']);
// 	$lat = floatval($_POST['lat']);
// 	$coslat = cos($lat);

// 	// Create connection
// 	$conn = new mysqli($servername, $username, $password, $dbname);
// 	// Check connection
// 	if ($conn->connect_error) {
// 	    die("Connection failed: " . $conn->connect_error);
// 	} 

// 	$query = "SELECT * FROM food WHERE (long-$long)*$coslat<$maxDeltaLong AND lat-$lat<$maxDeltaLat";
// 	$result = $conn->query($query);

// 	if ($result->num_rows > 0) {
// 	    // output data of each row
// 	    while($row = $result->fetch_assoc()) {
// 	        echo "[{long:" . $row["long"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
// 	    }
// 	} else {
// 	    echo "0 results";
// 	}
// 	$conn->close();

>