<?php
	$host = "tcp:ex84mmt50m.database.windows.net,1433";
	$user = "putfoodinme@ex84mmt50m";
	$pwd = "PutF00dInMe";
	$db = "food";
	try{
	    $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
	    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	    if(defined($_POST["upvote"])){
	    	$stmt = $conn->prepare("UPDATE foodinfo
						SET Upvotes = Upvotes + 1, Votes = Votes + 1
						WHERE Name =?;");
	    }
	    else{
	    	$stmt = $conn->prepare("UPDATE foodinfo
						SET Votes = Votes + 1
						WHERE Name = ?;");
	    }
		$stmt->execute(array($_POST['name']));
	}
?>