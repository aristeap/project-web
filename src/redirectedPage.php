<?php
        SESSION_START();
            include("connectionsthBash.php");
            include("functions.php");

            $user_data = check_login($con);

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>The map</title>
    <link rel="stylesheet"
    href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>

    <style>
            #map {
            /* size of map */
            height: 740px;
            width: 500px;
        }
  </style>


  </head>
  <body>

        

        <div id = "map"></div>


  </body>
</html>


<script
    src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js">
  </script>

  <script>
  /* Location & zoom */
    var map = L.map('map').setView([38.2462420, 21.7350847], 16);

    /* Cretate TileLayer*/
    var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  });
  tiles.addTo(map); /*Add layer to map*/


  </script>
