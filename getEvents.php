<?php
	$host = "tcp:ex84mmt50m.database.windows.net,1433";
	$user = "putfoodinme@ex84mmt50m";
	$pwd = "PutF00dInMe";
	$db = "food";
	try{
	    $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
	    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	    $sql_select = "SELECT * FROM foodinfo";
		$stmt = $conn->query($sql_select);
		$foods = $stmt->fetchAll();
		if(count($foods) > 0) {
			echo '[{"noFood": false}'; 
		    foreach($foods as $food) {
		        echo ', {';
		        echo '"name": "'.$food['Name'].'", ';
		        echo '"description": "'.$food['Description'].'", ';
		        echo '"latitude": '.$food['Latitude'].", ";
		        echo '"longitude": '.$food['Longitude'].", ";
		        echo '"upvotes": '.$food['Upvotes'].", ";
		        echo '"totalvotes": '.$food['Votes'].", ";
		        echo '"lastvote": "'.$food['Lastvote'].'"';
		        echo'}';
		    }
		    echo "]";
		} else {
			echo '[{"noFood": true}]'; 
		}

		}
	catch(Exception $e){
	    die(print_r($e));
	}
?>