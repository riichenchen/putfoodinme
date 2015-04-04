<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
      html, body, #map-canvas { height: 100%; width: 90%; margin: 0; padding: 0;}
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
        var myLat = 46.855141;
        var myLong = -96.8372664;
        var foodCount = 0;

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

                    var infowindow = new google.maps.InfoWindow({
                        map: map,
                        position: pos,
                        content: 'Location found using HTML5.'
                    });

                    map.setCenter(pos);
                    map.setZoom(16);
                }, function () {
                    handleNoGeolocation(true);
                });
            } else {
                // Browser doesn't support Geolocation
                handleNoGeolocation(false);
            }

            var myMarker = new google.maps.Marker({
                position: new google.maps.LatLng(myLat, myLong),
                map: map,
                animation: google.maps.Animation.BOUNCE,
                draggable: true
            });
            var myInfowindow = new google.maps.InfoWindow({
                content: "<p> Add food here </p>"
            });
            google.maps.event.addListener(myMarker, 'click', (function (marker) {
                return function () {
                    myInfowindow.open(map, marker);
                }
            })(myMarker));
            alert("About to do something stupid");
            google.maps.event.addListener(map, 'click', function (event) {
                //window.location.href = "http://localhost/EventAddForm.php?lat=" +event.latLng.lat()+ "&long=" + event.latLng.lng();
                addMarkerToMap(event.latLng.lat(), event.latLng.lng());
            });

            google.maps.event.addListener(map, 'rightclick', function (event) {
                var infowindow = new google.maps.InfoWindow({
                    map: map,
                    position: event.latLng,
                    content: 'Add free food or something'
                });
            });
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
                animation: google.maps.Animation.DROP
            });

            //Creates the event listener for clicking the marker
            //and places the marker on the map
            google.maps.event.addListener(marker, 'click', (function (marker) {
                return function () {
                    infowindow.setContent("<h1>name</h1><br><p>"+description+"</p>");
                    infowindow.open(map, marker);
                }
            })(marker));
        }


        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
  <div id="map-canvas">Stuff</div>
  </body>
</html>