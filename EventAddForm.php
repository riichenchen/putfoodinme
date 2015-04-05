<!DOCTYPE html>
<html>
<head>
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.3.2");</script>
	<script type="text/javascript">
		function addEvent(){
		   $.post( "EventAdd.php", 
            {lat: Math.random(), long: Math.random(), name: $(".name").val(), description: $(".description").val()
            }).done(function(data){
            	alert(data);
            });
		}
	</script>
</head>
<body>
<?php

/*name is your cookie's name
value is cookie's value
$int is time of cookie expires*/
?>


Name of Event: <input type="text" name="name"><br>
Event Description: <input type="text" name="description"><br>
<button onclick="addEvent()">Submit</button>
<div id = "table">
</div>

</body>
</html>