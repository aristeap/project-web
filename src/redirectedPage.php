<?php
        SESSION_START();
            include("connectionsthBash.php");
            include("functions.php");

            $user_data = check_login($con);

 ?>

 <!DOCTYPE html>
 <html>

 <head>
   <title>The map</title>
     <meta http-equiv="content-type" content="text/html; charset=utf-8" />

     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
     <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
     <link rel="stylesheet" href="./leaflet-search.src.css"/>

   <style>
         #map {
             /* size of map */
             height: 500px;
             width: 800px;
         }

         .leaflet-marker-pane
         {
           visibility: hidden;
         }
         .leaflet-shadow-pane
         {
           visibility: hidden;
         }
   </style>

 </head>

 <body>
   <div id = "map"></div>

   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
   <script src="./leaflet-search.src.js"></script>

   <!-- Κάναμε copy-paste τα περιεχόμενα του JSON starting_pois.json σε μια μεταβλητή (την const POIs) & με αυτό το script τη φορτώνουμε -->
   <script src="./POIs.js"></script>

   <script>
     // Ο κώδικας μας θα τρέξει μόλις είναι σίγουρο ότι έχει φορτώσει το DOM
     window.addEventListener("DOMContentLoaded", () => {
       //
       // Create map
       //
       var map = new L.Map('map', {zoom: 15, center: [38.2370706, 21.7345796] });            // set view
       map.addLayer(new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'));  // base layer

       //
       // Markers Layers
       //
       var markersLayer = new L.LayerGroup();
       map.addLayer(markersLayer);

       //
       // Search Bar
       //
       var controlSearch = new L.Control.Search({
         position:'topright',
         layer: markersLayer,
         initial: true,
         zoom: 25,
         marker: false,
         autoResize: true
       }).on('search:locationfound', function (e) {
           console.log(e);

           // result
           var title = e.text;
           var marker = e.layer;

           // =====================
           // Marker Contents
           // =====================

           prediction = 0;
           median = 0;

           // βρίσκουμε το POI που αντιστοιχεί στο marker
           for (item in POIs)
           {
             if (POIs[item].name == title)
             {
               console.log('POI: ', POIs[item].name, 'title: ', title);

               populartimes = POIs[item].populartimes;

               const d   = new Date();
               let hour  = d.getHours();
               let day   = d.getDay();

               // populartimes of the current day
               current_populartimes_data = populartimes[day - 1].data;
               // console.log('pop_data: ', current_populartimes_data);

               // όλοι οι επισκέπτες της μέρας
               visitors = 0;
               for (i in current_populartimes_data)
               {
                 visitors += current_populartimes_data[i];
               }

               // Πρόβλεψη
               now = current_populartimes_data[hour - 1];
               p1 = current_populartimes_data[hour];
               p2 = current_populartimes_data[hour + 1];
               prediction = Math.round(p1 + p2 / visitors);

               // Mέσος Όρος
               if (hour >= 3)
               {
                 i = 0;
                 sum = 0;
                 for (; i < hour - 2; i++)
                 {
                   sum += current_populartimes_data[i];
                 }
                 median = Math.round(sum / i);
               }
             }
           }

           // ===================
           // Make marker visible
           // ===================

           marker.on('click', clickMarker);

           function clickMarker(event) {
             // Άνοιξε το popup σε κλικ
             this.getPopup().setLatLng(event.latlng).openPopup();
           }

           // all possible html-elements that are markers
           var markers = document.getElementsByClassName('leaflet-interactive');

           // Αναζήτηση για το marker που έχει τίτλο 'title'
           for (m in markers)
           {
             // αν το βρούμε
             if (markers[m].title == title)
             {
               console.log('MARKERS: ', markers[m].title, ' title: ', title);

               // Δημιουργούμε το περιεχόμενο του popup
               let content = '<b>' + title + '</b><br>' + 'Προβλέπουμε κίνηση: ' + prediction + ' άτομα στις 2 επόμενες ώρες και <br>Μέση Επισκεψιμότητα (έως 2 ώρες πριν): ' + median + ' άτομα';
               let popup = L.popup();
               popup.setContent(content);
               marker.bindPopup(popup);

               // Αλλάζουμε το χρώμα του marker ανάλογα με το prediction
               let myCustomColour;

               if (prediction >= 0 && prediction <= 32)
               {
                 myCustomColour = "green";
               }
               else if (prediction >= 33 && prediction <= 65)
               {
                 myCustomColour = "yellow";
               }
               else if (prediction >= 66 && prediction <= 100)
               {
                 myCustomColour = "red";
               }

               const markerHtmlStyles = `
                 background-color: ${myCustomColour};
                 width: 3rem;
                 height: 3rem;
                 display: block;
                 left: -1.5rem;
                 top: -1.5rem;
                 position: relative;
                 border-radius: 3rem 3rem 0;
                 transform: rotate(45deg);
                 border: 1px solid #FFFFFF`;

               const icon = L.divIcon({
                 // className: "my-custom-pin",
                 iconAnchor: [0, 24],
                 labelAnchor: [-6, 0],
                 popupAnchor: [0, -36],
                 html: `<span style="${markerHtmlStyles}" />`
               })

               // το κάνουμε ορατό
               markers[m].style.visibility = 'visible';

               marker.setIcon(icon);
             }
           }
       });

       map.addControl(controlSearch);

       // =======================
       //    Add markers
       // =======================

       for(i in POIs) {
         var title   = POIs[i].name;                                             // value searched
         var coord   = POIs[i].coordinates;                                      // position found
         var marker  = new L.Marker([coord.lat, coord.lng], {title: title});     // property searched
         markersLayer.addLayer(marker);
       }
     });
   </script>
 </body>
 </html>
