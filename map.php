<?php
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Example</title>
    <link rel="stylesheet" href="https://openlayers.org/en/v6.13.0/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v6.13.0/build/ol.js"></script>
    <style>
        #map {
            width: 100%;
            max-width: 800px;
            height: 400px;
            margin:0 auto;

        }
    </style>
</head>
<body>
    <h1>Select Two Points on the Map</h1>
    <div id="map-container">
    <div id="map" class="map"></div>
    </div>
    <button id="calculateDistance">Calculate Distance</button>
    <p id="distanceDisplay"></p>
    <form id="distanceForm" action="process_selection.php" method="POST" style="display: none;">
    <input type="hidden" id="distanceInput" name="distance" value="">
    <input type="hidden" id="carIdInput" name="Car_id" value="<?php echo $_POST['Car_id'];?>">
    </form>


    <script>
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM(),
                }),
            ],
            view: new ol.View({
                center: [0, 0],
                zoom: 2,
            }),
        });

        var source = new ol.source.Vector();
        var vector = new ol.layer.Vector({
            source: source,
        });
        map.addLayer(vector);

        var selectedPoints = [];

        map.on('singleclick', function(event) {
            var coordinates = event.coordinate;
            selectedPoints.push(coordinates);
            source.clear();
            source.addFeature(new ol.Feature(new ol.geom.LineString(selectedPoints)));
        });

        function haversineDistance(coord1, coord2) {
            function toRadians(degrees) {
                return degrees * (Math.PI / 180);
            }

            var lon1 = coord1[0];
            var lat1 = coord1[1];
            var lon2 = coord2[0];
            var lat2 = coord2[1];

            var R = 6371; 
            var dLat = toRadians(lat2 - lat1);
            var dLon = toRadians(lon2 - lon1);

            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c;

            return distance;
        }

        document.getElementById('calculateDistance').addEventListener('click', function() {
            if (selectedPoints.length >= 2) {
                var coord1 = ol.proj.toLonLat(selectedPoints[0]);
                var coord2 = ol.proj.toLonLat(selectedPoints[1]);
                var distance = haversineDistance(coord1, coord2);
                document.getElementById('distanceDisplay').textContent = 'Distance: ' + distance.toFixed(2) + ' km';
                document.getElementById('distanceInput').value = distance.toFixed(2);
                document.getElementById('distanceForm').submit();
                
                


            } else {
                document.getElementById('distanceDisplay').textContent = 'Please select two or more points on the map.';
            }
        });
    </script>
</body>
</html>
