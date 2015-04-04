<!DOCTYPE html>
<html>
<body>
<?php 
$int = 6000;
setcookie("lat",$_GET['lat'],time()+$int);
setcookie("long",$_GET['long'],time()+$int);
/*name is your cookie's name
value is cookie's value
$int is time of cookie expires*/
?>


<form action="EventAdd.php" method="post">
Name of Event: <input type="text" name="name"><br>
Event Description: <input type="text" name="description"><br>
<input type="submit">
</form>


</body>
</html>