<!DOCTYPE html>
<html>
<head>
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.3.2");</script>
	<script type="text/javascript">
		function submitForm(){
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
<button onclick="submitForm()">Submit</button>
<div id = "table">
</div>

</body>
</html>