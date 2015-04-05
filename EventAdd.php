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
    $sql_insert = "INSERT INTO foodinfo (name, description, LocationX, LocationY) 
                   VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bindValue(1, "Hello");
    $stmt->bindValue(2, "World");
    $stmt->bindValue(3, 20);
    $stmt->bindValue(4, 15);
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
	        echo "<tr><td>".$food['name']."</td>";
	        echo "<td>".$food['description']."</td>";
	        echo "<td>".$food['LocationX']."</td>";
	        echo "<td>".$food['LocationY']."</td></tr>";
	    }
	    echo "</table>";
	} else {
	    echo "<h3>No food :(</h3>";
	}

}
catch(Exception $e){
    die(print_r($e));
}
echo "still works";
?>
</body>
</html>