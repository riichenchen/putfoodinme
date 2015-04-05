<?php
$host = "tcp:ex84mmt50m.database.windows.net,1433";
$user = "putfoodinme@ex84mmt50m";
$pwd = "PutF00dInMe";
$db = "food";
try{
    $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $sql_insert = "INSERT INTO foodinfo (Name, Description, Longitude, Latitude) 
                   VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bindValue(1, $_POST["name"]);
    $stmt->bindValue(2, $_POST["description"]);
    $stmt->bindValue(3, floatval($_POST["long"]));
    $stmt->bindValue(4, floatval($_POST["lat"]));
    $stmt->execute();
    $sql_select = "SELECT * FROM foodinfo";
	$stmt = $conn->query($sql_select);
	$foods = $stmt->fetchAll(); 
	if(count($foods) > 0) {
	    echo "<h2>Events:</h2>";
	    echo "<table>";
	    echo "<tr><th>Name</th>";
	    echo "<th>Description</th>";
	    echo "<th>Latitude</th>";
	    echo "<th>Longitude</th></tr>";
	    foreach($foods as $food) {
	        echo "<tr><td>".$food['Name']."</td>";
	        echo "<td>".$food['Description']."</td>";
	        echo "<td>".$food['Latitude']."</td>";
	        echo "<td>".$food['Longitude']."</td></tr>";
	    }
	    echo "</table>";
	} else {
	    echo "<h3>No food :(</h3>";
	}

	}
catch(Exception $e){
    die(print_r($e));
}
?>