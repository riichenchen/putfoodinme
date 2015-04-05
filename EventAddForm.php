<!DOCTYPE html>
<html>
<head>
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.3.2");</script>
	<script type="text/javascript">
		function addEvent(){
		   $.post( "EventAdd.php", 
            {lat: Math.random(), long: Math.random(), name: $("#name").val(), description: $("#description").val()
            }, function(data){
            	$("#events").html(data);
            	alert(data);
            });
		}
        $("#events").text("Stuff");
	</script>
</head>
<body>
<?php

/*name is your cookie's name
value is cookie's value
$int is time of cookie expires*/
?>


Name of Event: <input type="text" id="name"><br>
Event Description: <input type="text" id="description"><br>
<button onclick="addEvent()">Submit</button>
<div id = "events">
</div>

</body>
</html>