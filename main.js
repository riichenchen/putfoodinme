var map;
var myMarker;
var myInfowindow;
var myLat = 46.855141;
var myLong = -96.8372664;
var foodCount = 0;
var foodmarkers = [];

function initialize() {
    var mapOptions = {
        zoom: 6
    };
    map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

    // Try HTML5 geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            myLat = position.coords.latitude;
            myLong = position.coords.longitude;
            myMarker.position = new google.maps.LatLng(myLat, myLong);
            var pos = new google.maps.LatLng(myLat, myLong);
            map.setCenter(pos);
            map.setZoom(16);
        }, function () {
            handleNoGeolocation(true);
        });
    } else {   // Browser doesn't support Geolocation
        handleNoGeolocation(false);
    }
	addMyMarker();
	refreshFood();
}

function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Error: The Geolocation service failed.';
    } else {
        var content = 'Error: Your browser doesn\'t support geolocation.';
    }
    var options = {
        map: map,
        position: new google.maps.LatLng(myLat, myLong),
        content: content
    };

    var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}

function addMyMarker() {
	myMarker = new google.maps.Marker({
        position: new google.maps.LatLng(myLat, myLong),
        map: map,
		visible: true,
        animation: google.maps.Animation.BOUNCE,
        draggable: true
    });
    google.maps.event.addListener(myMarker, 'click', (function (myMarker) {
        return function () {
            myInfowindow = new google.maps.InfoWindow();
            myInfowindow.setContent("<p> Drag to change your position </p><br><p> Use form below to add food event here.</p>");
            myInfowindow.open(map, myMarker);
        }
    })(myMarker));
}


function refreshFood() {
	//Clear old markers
	for (var i = 0; i < foodmarkers.length; i++) {
		window.foodmarkers[i].setMap(null);
	}
	window.foodmarkers = [];
	
	//Add new food locations
	$.post("getEvents.php", function(data){
            var events = JSON.parse(data);
            var table = "";
            var tableRow = "";

            if(events.shift().noFood){
                $("div.food-locations div.container").replaceWith(
                    "<h5>No Free Food :(</h5>But You Can Change That :)");
            }
            console.log(events);
            var i = 0;
            jQuery.each(events, function() {
                console.log(i++);
              addMarkerToMap(this.latitude, this.longitude, this.eventname, this.description);
              tableRow +=  '<tr id = "$' + this.eventname + '>'
              tableRow +=  '<td><div class = "eventname">' + this.eventname + "</div></td>";
              tableRow +=  '<td><div class = "distance">' + distanceString(this.latitude, this.longitude) + "</div></td>";
              tableRow +=  '<td><div class = "lastvote">' + this.lastvote + "</div></td>";
              tableRow +=  '<td> <div class="progress">  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="';
              tableRow +=  this.upvotes.toString()+'" aria-valuemin="0" aria-valuemax="';
              tableRow +=  this.totalvotes.toString()+'" style="width: ';
              tableRow +=  ((100.0 *  this.upvotes) / this.totalvotes).toString() + '%"></div></div>
                    <div class = "thumbsUp"></div><div class = "thumbsDown"></div></td>';
              tableRow +=  "</tr>";
              $('#FoodTable tr:last').after(tableRow);
              tableRow = "";
            });
        });
}
function distanceString(lat1, lng1){
	var lat2 = myMarker.position.lat();
	var dlat = myMarker.position.lat() - lat1;
	var dlng = myMarker.position.lng() - lng1;
	var a = Math.sin(dlat/2) * Math.sin(dlat/2) + Math.cos(lat1) * Math.cos(lat2) * Math.sin(dlng/2) * Math.sin(dlng/2);
	var c = Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
	var distance = c * 3961;
  
	//Distance in miles
	//var distance = 3959 * Math.hypot(dlat, (myMarker.position.lng() - longitude) * Math.cos(dlat / 2));
	if(distance < 1){
		//Convert distance to feet
		distance = distance * 5280;
		distance = distance.toFixed(0);
		distance += " feet";
	}
	else{
		distance = distance.toFixed(2);
		distance += " miles";
	}
	return distance;
}
//This function will add a marker to the map each time it
//is called.  It takes latitude, longitude, and html markup
//for the content you want to appear in the info window
//for the marker.
function addMarkerToMap(lat, long, name, description) {
    var infowindow = new google.maps.InfoWindow();
    var myLatLng = new google.maps.LatLng(lat, long);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
		visible: true,
        animation: google.maps.Animation.DROP
    });

    //Creates the event listener for clicking the marker
    //and places the marker on the map
    google.maps.event.addListener(marker, 'click', (function (marker) {
        return function () {
            infowindow.setContent("<h3>"+name+"</h3><p>"+description+"</p><p>"+
                marker.position.lat()+", "+marker.position.lng()+"</p>");
            infowindow.open(map, marker);
        }
    })(marker));
	var len = window.foodmarkers.push(marker);
}


function addEvent(){
    if($("#event-name").val().length == 0 || $("#description").val().length == 0){
        $(".error-message").html('Please Enter All Form Components');
        return false;
    }
   $.post( "EventAdd.php", 
    {lat: myMarker.position.lat(), long: myMarker.position.lng(), name: $("#event-name").val(), description: $("#description").val()
    }, function(data){
        $("#event-name").val('');
        $("#description").val('');
        $(".error-message").html('');
        $("#events").html(data);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);