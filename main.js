var map;
var myMarker;
var myInfowindow;
var myLat = 46.855141;
var myLong = -96.8372664;
var foodCount = 0;
var foodmarkers = [];
var geocoder = new google.maps.Geocoder();


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
	
	//console.log("Geocode: "+ getAddress(34.062928, -118.272561));
	//changeLocation("2862 Mangin Crescent, Windsor, ON, Canada");
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
            //var events = JSON.parse(data);
            var events = [{noFood: true}];
            var table = "";
            var tableRow = "";

            if(events.shift().noFood){
                $("div.food-locations div.container").replaceWith(
                    "<h5>No Free Food :(</h5>But You Can Change That :)");
            }
            else{
              jQuery.each(events, function() {
                addMarkerToMap(this.latitude, this.longitude, this.eventname, this.description);
                tableRow +=  '<tr id = "$' + this.eventname + '">';
                tableRow +=  '<td><div class = "eventname">' + this.eventname + "</div></td>";
                tableRow +=  '<td><div class = "distance">' + distanceString(this.latitude, this.longitude) + "</div></td>";
                tableRow +=  '<td><div class = "lastvote">' + this.lastvote + "</div></td>";
                tableRow +=  '<td> <div class="progress">  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="';
                tableRow +=  this.upvotes.toString()+'" aria-valuemin="0" aria-valuemax="';
                tableRow +=  this.totalvotes.toString()+'" style="width: ';
                tableRow +=  ((100.0 *  this.upvotes + 1) / (this.totalvotes)+1).toString() + '%"></div></div>';
                tableRow += '<div class = "vote thumbsUp"></div>'
                tableRow += '<div class = "vote thumbsDown"></div></td>'
                tableRow +=  "</tr>";
                $('#FoodTable tr:last').after(tableRow);
                tableRow = "";
             });
            } 
        });

        $(".vote").click(function(){
          alert("WHOA");
        });
}
function distanceString(lat1, lng1){
	lat1 *= Math.PI/180;
	lng1 *= Math.PI/180;
	var lng2 = myMarker.position.lng() * Math.PI/180;
	var lat2 = myMarker.position.lat() * Math.PI/180;
	var dlat = lat2 - lat1;
	var dlng = lng2 - lng1;
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
    var infowindow = new google.maps.InfoWindow({
		maxWidth: 150
	});
    var myLatLng = new google.maps.LatLng(lat, long);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
		visible: true,
        animation: google.maps.Animation.DROP
    });

    //Creates the event listener for clicking the marker
    //and places the marker on the map
	
	
	var infowindow = new google.maps.InfoWindow({
		maxWidth: 150,
		content: "<h3>"+name+"</h3><p>"+description+"</p><p>"+
				 "("+marker.position.lat()+", "+ marker.position.lng()+")</p>"
	});
	geocoder.geocode({'latLng': myLatLng}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				infowindow.setContent("<h3>"+name+"</h3><p>"+description+"</p><p>"+
											results[0].formatted_address+"</p>");
			}
			else if (results[1]) {
				infowindow.setContent("<h3>"+name+"</h3><p>"+description+"</p><p>"+
										results[1].formatted_address+"</p>");
			}
			else if (results[2]) {
				infowindow.setContent("<h3>"+name+"</h3><p>"+description+"</p><p>"+
										results[2].formatted_address+"</p>");
			}
		}
	});
		
	google.maps.event.addListener(marker, 'click', (function (marker) {
		return function () {
			infowindow.open(map, marker);
		}
	})(marker));	
	
 //   google.maps.event.addListener(marker, 'click', (function (marker) {
 //       return function () {
 //           infowindow.setContent("<h3>"+name+"</h3><p>"+description+"</p><p>"+
 //               getAddress(marker.position.lat(), marker.position.lng())+"</p>");
 //           infowindow.open(map, marker);
 //       }
 //   })(marker));
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

function search(){
    var query = $("#search-bar").val();
    alert(query);
    return false;
}

google.maps.event.addDomListener(window, 'load', initialize);

function incrementVote(upvote, name){
  var data;
  if(this.hasClass("upvote")){
      data = {upvote: "true", eventname: name};
  }
  else{
      data = {eventname: name };
  }
  alert("WHOA");
  //$.post( "incrementvote.php", data);
}


function changeLocation(address) {
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			myMarker.setPosition(results[0].geometry.location);
			map.setZoom(15);
			myMarker.setAnimation(null);
			myMarker.setAnimation(google.maps.Animation.BOUNCE);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}
function findAddress(){
    var query = $("#search-bar").val();
    changeLocation(query);
}


$(".thumbsUp").click(function(){
  var mangledName = this.closest("tr").attr('id');
  incrementVote(false, mangledName.slice(1, mangledName.length));
});

$(".thumbsDown").click(function(){
  var mangledName = this.closest("tr").attr('id');
  incrementVote(true, mangledName.slice(1, mangledName.length));
});


