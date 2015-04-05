<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <style type="text/css">
      html, body, #map-canvas { height: 500px; width: 100%; margin: 0; padding: 0;}
    </style>
    <script type="text/javascript"
      src="http://maps.google.com/maps/api/js?sensor=false">
    </script>
    <script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">google.load("jquery", "1.3.2");</script>
    <script type="text/javascript" src="main.js"></script>
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="main.css">

  </head>

<body>
    <div class="header">
        <div class="container">
        <div class="row">
            <div class="navbar-header">
                <!-- <a class="navbar-brand" href="#"> -->
                <!-- <img src="http://i62.tinypic.com/2ike3k2.png"> -->
                <h1>PUTFOODIN.ME</h1>
                <!-- </a> -->
            </div>

                <form class="navbar-right" role="search">
                      <input type="text" class="search-query input-mysize" placeholder="Enter your address to put food in you now.">
                      <input type="submit" class="btn btn-default" value="Search">
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
            <div class="row">
             <h1>Free Food Near Me</h1> 
                <table class="table" id="FoodTable">
                  <tr>
                    <td><h5>EVENT</h5></td>
                    <td><h5>DISTANCE</h5></td>      
                    <td><h5>MOST RECENT FEEDING</h5></td>
                    <td class="bar"><h5>% OF HUNGRY FED</h5></td>
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
    
<!--    <div class="footer">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div> -->
</body>
</html>