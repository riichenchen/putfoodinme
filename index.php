<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
      html, body, #map-canvas { height: 500px; width: 100%; margin: 0; padding: 0;}
    </style>
    <script type="text/javascript"
      src="http://maps.google.com/maps/api/js?sensor=false">
    </script>
    <script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.3.2");</script>
    <script type="text/javascript">
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see a blank space instead of the map, this
        // is probably because you have denied permission for location sharing.

        var map;
        var myMarker;
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

                    //var infowindow = new google.maps.InfoWindow({
                    //    map: map,
                    //    position: pos
                    //});

                    map.setCenter(pos);
                    map.setZoom(16);
                }, function () {
                    handleNoGeolocation(true);
                });
            } else {   // Browser doesn't support Geolocation
                handleNoGeolocation(false);
            }

            myMarker = new google.maps.Marker({
                position: new google.maps.LatLng(myLat, myLong),
                map: map,
                animation: google.maps.Animation.BOUNCE,
                draggable: true
            });
            
            google.maps.event.addListener(myMarker, 'click', (function (myMarker) {
                return function () {
                    var myInfowindow = new google.maps.InfoWindow();
                    myInfowindow.setContent("<p> Add food at (" + 
                        myMarker.position.lat()+", "+myMarker.position.lng()+")</p>");
                    myInfowindow.open(map, myMarker);
                }
            })(myMarker));
			
			/*
            google.maps.event.addListener(map, 'click', function (event) {
                addMarkerToMap(event.latLng.lat(), event.latLng.lng());
            });

            google.maps.event.addListener(map, 'rightclick', function (event) {
                var infowindow = new google.maps.InfoWindow({
                    map: map,
                    position: event.latLng,
                    content: 'Add free food or something'
                });
            });
			*/
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
                position: new google.maps.LatLng(46.855141, -96.8372664),
                content: content
            };

            var infowindow = new google.maps.InfoWindow(options);
            map.setCenter(options.position);
        }
        function getFoodLocations(latitude, longitude) {
            var spherical = google.maps.geometry.spherical, 
            bounds = map.getBounds(), 
            cor1 = bounds.getNorthEast(), 
            cor2 = bounds.getSouthWest(), 
            cor3 = new google.maps.LatLng(cor2.lat(), cor1.lng()), 
            cor4 = new google.maps.LatLng(cor1.lat(), cor2.lng()), 
            width = spherical.computeDistanceBetween(cor1,cor3), 
            height = spherical.computeDistanceBetween( cor1, cor4);
            $.post( "getEvents.php", 
                {lat: latitude, long: longitude, height: height, width: width
                }).done(function(data){
                    var events = jQuery.parseJSON(data);
                    jQuery.each(events, function() {
                      addMarkerToMap(this.lat, this.long, this.name, this.description);
                    });
                    var infowindow = new google.maps.InfoWindow();
                });
        }
		
		function refreshFood() {
			//Clear old markers
			for (var i = 0; i < foodmarkers.length; i++) {
				foodmarkers[i].setMap(null);
			}
			foodmarkers = [];
			//Add new
			$.post( "getEvents.php", 
                {lat: latitude, long: longitude, height: height, width: width
                }).done(function(data){
                    var events = jQuery.parseJSON(data);
					events.splice(0, 1);
                    jQuery.each(events, function() {
                      addMarkerToMap(this.lat, this.long, this.name, this.description);
                    });
                });
		}


        //This function will add a marker to the map each time it
        //is called.  It takes latitude, longitude, and html markup
        //for the content you want to appear in the info window
        //for the marker.
        function addMarkerToMap(lat, long, name, description) {
            var infowindow = new google.maps.InfoWindow();
            var myLatLng = new google.maps.LatLng(lat, long);
            var marker = new google.maps.Marker({
                id: foodCount++,
                position: myLatLng,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP
            });

            //Creates the event listener for clicking the marker
            //and places the marker on the map
            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent("<h1>"+name+"</h1><br><p>"+description+"</p><br><p>"+
                        marker.position.lat()+", "+marker.position.lng()+"</p>");
                    infowindow.open(map, marker);
                }
            })(marker));
			foodmarkers.push(marker);
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
    </script>

    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed:700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="main.css">

  </head>

<body>
    <div class="header">
        <div class="container">
        <div class="row">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Put Food In Me</a>
            </div>
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                      <input type="text" class="search-query input-mysize" placeholder="Enter your address to put food in you now.">
                      <input type="submit" class="btn btn-default" value="Search">
                    </div>
                </form>
            </div>
            </div>
        </div>

    <div class="map">
        <div class="container-fluid">
            <div class="row">
            <!-- map of free food locations goes here -->
                <div id="map-canvas">Stuff</div>
            </div>
        </div>
    </div>

    <div class="food-locations">
        <div class="container">
             <h1>Free Food Near Me</h1> 
                <div class="row">
                <table class="table">
                  <tr>
                    <td><h5>EVENT</h5></td>
                    <td><h5>DISTANCE</h5></td>      
                    <td><h5>MOST RECENT FEEDING</h5></td>
                    <td class="bar"><h5>% OF HUNGRY FED</h5></td>
                  </tr>
                  <tr>
                    <td>'Event #' Free Tacos</td>
                    <td>1.1 miles</td>      
                    <td>1:00 PM</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            <span class="sr-only">80% Complete (success)</span>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td>'Event #' Free Tacos</td>
                    <td>1.1 miles</td>      
                    <td>1:00 PM</td>
                    <td><div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td>'Event #' Free Tacos</td>
                    <td>1.1 miles</td>      
                    <td>1:00 PM</td>
                    <td><div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                            <span class="sr-only">60% Complete (success)</span>
                            </div>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td>'Event #' Free Tacos</td>
                    <td>1.1 miles</td>      
                    <td>1:00 PM</td>
                    <td><div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                            <span class="sr-only">20% Complete (success)</span>
                            </div>
                        </div>
                    </td>
                  </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="new-event">
        <div class="container">
            <h2> Create an Event </h2>
                <div class="row">
                    <form id = "newEventForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <div class = "error-message"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="event-name">Event Name:</label>
                        <div class="col-sm-6 col-md-4">
                            <input type="event-name" class="form-control" id="event-name" placeholder="Enter event name">
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="description">Event Description:</label>
                        <div class="col-sm-6 col-md-4">          
                            <textarea id="description" class="form-control description" placeholder="Type of food, what will be served, etc."></textarea>
                        </div>
                        </div>
                        <div class="form-group">        
                        </div>
                    </form>
                    <div class="col-sm-6 col-md-offset-4">
                        <button class="btn btn-default" onclick = "addEvent()">Submit</button>
                    </div>
                </div>
        </div>
    </div>
    <div id = "events"></div>
    
    <div class="footer">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
</body>

</html>